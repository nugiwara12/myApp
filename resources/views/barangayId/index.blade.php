<x-bgryId.table />
<x-form-modal />
<x-pagination-function />
<x-toast />


{{-- Scripts --}}
<script>
    let confirmCallback = null;
    let selectedResidenceId = null;

    // Global Modal Control
    window.openModal = function(id) {
        document.getElementById(id)?.classList.remove('hidden');
    };

    // Global Closed Modal Control
    window.closeModal = function(id) {
        const modal = document.getElementById(id);
        if (!modal) return;
        modal.classList.add('hidden');
        const form = modal.querySelector('form');
        if (form) form.reset();
    };

    // Generated the barangayId refereal code
    function generateBarangayIdNumber() {
        const now = new Date();
        const datePart = now.toISOString().slice(0, 10).replace(/-/g, ''); // e.g., 20250713
        const randomPart = Math.floor(1000 + Math.random() * 9000); // 4-digit random number
        return `BRGY-${datePart}-${randomPart}`;
    }

    // Disabled the guardian if the data of age is 1 to 17 only
    window.setupGuardianReadonly = function () {
        const ageInput = document.getElementById('barangayId_age');
        const guardianInput = document.getElementById('barangayId_guardian');

        if (!ageInput || !guardianInput) return;

        const handleGuardianField = () => {
            const age = parseInt(ageInput.value, 10);

            if (!isNaN(age) && age >= 1 && age <= 17) {
                guardianInput.readOnly = true;
                guardianInput.required = false; // ✅ Not required if age 1-17
                guardianInput.classList.add('bg-gray-100', 'cursor-not-allowed');
                guardianInput.value = ''; // Optional clear
            } else if (!isNaN(age) && age > 17) {
                guardianInput.readOnly = false;
                guardianInput.required = true; // ✅ Required if age > 17
                guardianInput.classList.remove('bg-gray-100', 'cursor-not-allowed');
            } else {
                // Reset default state if age is invalid
                guardianInput.readOnly = false;
                guardianInput.required = false;
                guardianInput.classList.remove('bg-gray-100', 'cursor-not-allowed');
            }
        };

        ageInput.removeEventListener('input', handleGuardianField);
        ageInput.addEventListener('input', handleGuardianField);

        handleGuardianField(); // Run on initial load
    };

    // Form submission handler
    function submitBarangayIdForm(event) {
        window.barangayIdModal.submit(event);
    }

    // Open Add Barangay ID
    function openAddBarangayId() {
        window.barangayIdModal.editId = null;

        const form = document.getElementById('barangayIdForm');
        if (form) {
            form.reset(); // Reset all inputs

            // Clear error borders
            form.querySelectorAll('.border-red-500').forEach(el => el.classList.remove('border-red-500'));

            // Clear file input preview
            const imagePreview = document.getElementById('imagePreview');
            if (imagePreview) {
                imagePreview.src = '';
                imagePreview.classList.add('hidden');
            }

            // Ensure file input is cleared (for some browsers reset doesn't clear file input)
            const fileInput = form.querySelector('[name="barangayId_image"]');
            if (fileInput) {
                fileInput.value = '';
                fileInput.setAttribute('required', 'required'); // Re-add required for add mode
            }
        }

        // Set title and button text
        const title = document.getElementById('modalTitle');
        if (title) title.innerText = 'Add Barangay ID';

        const submitBtn = document.getElementById('btnSubmitBarangayId');
        if (submitBtn) submitBtn.innerText = 'Submit';

        // Generate new Barangay ID number
        const genNumber = generateBarangayIdNumber();
        const genNumInput = document.querySelector('[name="generated_number"]');
        if (genNumInput) genNumInput.value = genNumber;

        const finalGenInput = document.getElementById('barangayId_generated_number');
        if (finalGenInput) finalGenInput.value = genNumber;

        // Setup guardian field logic
        setupGuardianReadonly();

        // Open the modal
        openModal(window.barangayIdModal.modalId);
    }

    // Barangay ID Modal Handler
    window.barangayIdModal = {
        modalId: 'barangayIdModal',
        fieldIds: [
            'barangayId_full_name', 'barangayId_email', 'barangayId_address', 'barangayId_birthdate', 'barangayId_place_of_birth',
            'barangayId_age', 'barangayId_citizenship', 'barangayId_gender', 'barangayId_civil_status',
            'barangayId_contact_no', 'barangayId_guardian', 'barangayId_generated_number', 'barangayId_image'
        ],
        editId: null,
        currentPage: 1,
        perPage: 10,

        submit(event) {
            event.preventDefault();

            let hasError = false;
            const data = new FormData();

            // Auto-generate the number only if creating new
            if (!this.editId) {
                const genNumber = generateBarangayIdNumber();
                document.getElementById('barangayId_generated_number').value = genNumber;
            }

            this.fieldIds.forEach(field => {
                const input = document.querySelector(`[name=${field}]`);
                if (input) {
                    const value = input.type === 'file' ? input.files[0] : input.value.trim();

                    // Check required fields (you can refine this logic based on your needs)
                    const isRequired = input.hasAttribute('required') || ['barangayId_full_name', 'barangayId_email', 'barangayId_address', 'barangayId_birthdate', 'barangayId_generated_number'].includes(field);

                    if (isRequired && !value) {
                        hasError = true;
                        input.classList.add('border-red-500');
                    } else {
                        input.classList.remove('border-red-500');
                        if (input.type === 'file') {
                            data.append(field, input.files[0] || '');
                        } else {
                            data.append(field, input.value);
                        }
                    }
                }
            });

            if (hasError) {
                showToast('Please fill out all required fields.', 'error');
                return;
            }

            const method = this.editId ? 'post' : 'post';
            const url = this.editId ? `/barangay-id/update/${this.editId}` : `/addBarangayId`;

            axios({
                method,
                url,
                data,
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            })
            .then(() => {
                showToast(this.editId ? 'Updated successfully.' : 'Submitted successfully.', 'success');
                closeModal(this.modalId);
                this.editId = null;
                this.fetchList();
            })
            .catch(error => {
                if (error.response?.status === 422) {
                    const firstError = Object.values(error.response.data.errors)[0][0];
                    showToast(firstError, 'error');
                } else {
                    showToast('Submission failed.', 'error');
                }
            });
        },

        fetchList(page = 1) {
            this.currentPage = page;
            axios.get(`/list?per_page=${this.perPage}&page=${this.currentPage}`)
                .then(response => {
                    const { data, total, current_page, last_page } = response.data;
                    const tbody = document.getElementById('barangayIdTableBody');
                    tbody.innerHTML = data.length ? '' : `
                        <tr>
                            <td colspan="17" class="text-center bg-gray-200 text-gray-500 py-4">No records found.</td>
                        </tr>
                    `;

                    data.forEach(item => {
                        const row = this.createTableRow(item);
                        tbody.appendChild(row);
                    });

                    document.getElementById('paginationControls').innerHTML = Pagination({
                        currentPage: current_page,
                        totalPages: last_page,
                        totalData: total,
                        perPage: this.perPage,
                        namespace: 'barangayId'
                    });
                })
                .catch(() => showToast('Failed to fetch records.', 'error'));
        },

        createTableRow(item) {
            const row = document.createElement('tr');
            const statusText = item.status === 1 ? 'Active' : 'Deleted';

            if (item.status === 0) {
                row.classList.add('bg-red-100');
            } else if (item.barangayId_age >= 1 && item.barangayId_age <= 17) {
                row.classList.add('bg-yellow-100', 'cursor-pointer');
            } else {
                row.classList.add('hover:bg-gray-50', 'cursor-pointer');
            }

            row.setAttribute('data-search', `${item.barangayId_full_name} ${item.barangayId_address} ${statusText}`.toLowerCase());

            const isForApproval = item.status === 1 && item.barangayId_age >= 1 && item.barangayId_age <= 17 && item.approved != 1;

            row.innerHTML = `
                <td class="px-4 py-2">${item.status === 1 ? `<input type="checkbox" class="selectCheckbox" data-id="${item.id}">` : ''}</td>
                <td class="px-4 py-2">
                    <div class="flex flex-wrap sm:flex-nowrap items-center gap-2 sm:gap-3">
                        <img
                            src="/barangayId/${item.barangayId_image}"
                            alt="Photo"
                            class="w-10 h-10 rounded-full object-cover shrink-0"
                        >
                        <span class="text-sm sm:text-base font-medium text-gray-800 break-words">
                            ${item.barangayId_full_name}
                        </span>
                    </div>
                </td>
                <td class="px-4 py-2">${item.barangayId_email}</td>
                <td class="px-4 py-2">${item.barangayId_address}</td>
                <td class="px-4 py-2">${new Date(item.barangayId_birthdate).toLocaleDateString('en-US', {
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                })}</td>
                <td class="px-4 py-2">${item.barangayId_place_of_birth}</td>
                <td class="px-4 py-2">${item.barangayId_age}</td>
                <td class="px-4 py-2">${item.barangayId_citizenship}</td>
                <td class="px-4 py-2">${item.barangayId_gender}</td>
                <td class="px-4 py-2">${item.barangayId_civil_status}</td>
                <td class="px-4 py-2">${item.barangayId_contact_no}</td>
                <td class="px-4 py-2">${item.barangayId_guardian}</td>
                <td class="px-4 py-2">${item.barangayId_generated_number}</td>
                <td class="px-4 py-2">${item.approved == 1
                    ? '<span class="text-green-600 bg-green-100 px-2 py-1 rounded text-xs font-semibold">Approved</span>'
                    : '<span class="text-yellow-600 bg-yellow-100 px-2 py-1 rounded text-xs font-semibold">Pending</span>'}</td>
                <td class="px-4 py-2">${item.approved_by || 'N/A'}</td>
                <td class="px-4 py-2">${item.status === 1
                    ? '<span class="text-green-600 bg-green-100 px-2 py-1 rounded text-xs font-semibold">Active</span>'
                    : '<span class="text-red-600 bg-red-100 px-2 py-1 rounded text-xs font-semibold">Deleted</span>'}</td>
                <td class="px-4 py-2 d-flex gap-2 whitespace-nowrap" id="actions-${item.id}">
                    ${this.getActionButtons(item, isForApproval)}
                </td>
            `;

            if (item.status === 1) {
                row.addEventListener('click', (e) => {
                    if (e.target.closest('button')) return;
                    const checkbox = row.querySelector('.selectCheckbox');
                    if (checkbox) {
                        checkbox.checked = !checkbox.checked;
                        updateSelectAllCheckbox();
                        updateDeleteButtonState();
                    }
                });

                row.querySelector('.selectCheckbox')?.addEventListener('change', () => {
                    updateDeleteButtonState();
                    updateSelectAllCheckbox();
                });
            }

            return row;
        },

        getActionButtons(item) {
            const isAdmin = window.currentUser?.isAdmin;
            const isApproved = !(item.approved_by == 0 || item.approved_by === '0' || item.approved_by === null || item.approved_by === undefined || item.approved_by === '' || item.approved_by === 'NULL');

            let buttons = '';

            if (item.status === 1) {
                if (isAdmin) {
                    // ✅ If not approved → show Approve button only
                    if (!isApproved) {
                        buttons += `
                            <button onclick="event.stopPropagation(); approveBarangayId(${item.id})"
                                class="bg-green-500 border white rounded p-2 d-flex align-items-center justify-content-center"
                                title="Approve">
                                <i class="bi bi-check-circle-fill text-white text-md"></i>
                            </button>
                        `;
                    }

                    // ✅ If approved → show Edit, Delete, PDF
                    if (isApproved) {
                        buttons += `
                            <button onclick="event.stopPropagation(); editBarangayId(${item.id})"
                                class="btn btn-light border rounded p-2 d-flex align-items-center justify-content-center" title="Edit">
                                <i class="bi bi-pencil-square text-black"></i>
                            </button>
                            <button onclick="event.stopPropagation(); deleteBarangayId(${item.id})"
                                class="btn btn-light border rounded p-2 d-flex align-items-center justify-content-center" title="Delete">
                                <i class="bi bi-trash-fill text-red-500"></i>
                            </button>
                            <button onclick="event.stopPropagation(); window.open('/barangayPdf/${item.id}', '_blank')"
                                class="btn btn-light border rounded p-2 d-flex align-items-center justify-content-center" title="View PDF">
                                <i class="bi bi-file-earmark-pdf text-red-600"></i>
                            </button>
                        `;
                    }

                } else {
                    // ✅ Regular user: show Edit and PDF only if approved
                    if (isApproved) {
                        buttons += `
                            <button onclick="event.stopPropagation(); editBarangayId(${item.id})"
                                class="btn btn-light border rounded p-2 d-flex align-items-center justify-content-center" title="Edit">
                                <i class="bi bi-pencil-square text-black"></i>
                            </button>
                            <button onclick="event.stopPropagation(); window.open('/barangayPdf/${item.id}', '_blank')"
                                class="btn btn-light border rounded p-2 d-flex align-items-center justify-content-center" title="View PDF">
                                <i class="bi bi-file-earmark-pdf text-red-600"></i>
                            </button>
                        `;
                    }
                }
            }

            // ✅ Handle soft-deleted items
            if (item.status !== 1) {
                buttons = `
                    <button onclick="event.stopPropagation(); restoreBarangayId(${item.id})"
                        class="bg-green-500 border white rounded p-2 d-flex align-items-center justify-content-center" title="Restore">
                        <i class="bi bi-arrow-counterclockwise text-white text-md"></i>
                    </button>
                `;
            }

            return buttons;
        }
    };

    // Admin condition
    window.currentUser = {
        isAdmin: @hasrole('admin') true @else false @endhasrole
    };

    // Edit for residency
    function editBarangayId(id) {
        axios.get(`/getBarangayIdInformation/${id}`)
            .then(response => {
                const data = response.data;
                const form = document.getElementById('barangayIdForm');
                const elements = form.elements;

                for (let i = 0; i < elements.length; i++) {
                    const input = elements[i];
                    const name = input.name;

                    if (!name || !data.hasOwnProperty(name)) continue;

                    if (input.type === 'checkbox') {
                        input.checked = !!data[name];
                    } else if (input.type === 'date') {
                        input.value = data[name] ? new Date(data[name]).toISOString().split('T')[0] : '';
                    } else if (input.type === 'file') {
                        continue; // Don't prefill file input
                    } else {
                        input.value = data[name] ?? '';
                    }
                }

                // ✅ Show existing image preview
                const imagePreview = document.getElementById('imagePreview');
                const imagePreviewContainer = document.getElementById('imagePreviewContainer');

                if (imagePreview && imagePreviewContainer) {
                    if (data.barangayId_image) {
                        imagePreview.src = `/barangayId/${data.barangayId_image}`;
                        imagePreview.classList.remove('hidden');
                    } else {
                        imagePreview.src = '';
                        imagePreview.classList.add('hidden');
                    }
                }

                // ✅ Disable required on image input (not required during edit)
                const imageInput = form.querySelector('[name="barangayId_image"]');
                if (imageInput) {
                    imageInput.removeAttribute('required');
                }

                // Set edit ID
                barangayIdModal.editId = id;

                // Update UI
                document.getElementById('modalTitle').innerText = 'Edit Barangay ID';
                document.getElementById('btnSubmitBarangayId').innerText = 'Update';

                // ✅ Reapply guardian logic based on age
                setupGuardianReadonly();

                // ✅ Open the modal
                openModal(barangayIdModal.modalId);
            })
            .catch(() => {
                showToast('Failed to fetch Barangay ID data.', 'error');
            });
    }

    // approved modal
    window.approveBarangayId = function(id) {
        selectedBarangayId = id;
        openModal('approvedIdModal');
    };

    // approved the data
    window.confirmApproveBarangayId = function () {
        if (!selectedBarangayId) return;

        axios.post(`/barangay-id/${selectedBarangayId}/approve`)
            .then(response => {
                showToast('Barangay ID approved successfully!', 'success');
                barangayIdModal.fetchList();
                closeModal('approvedIdModal');
            })
            .catch(error => {
                console.error("Approval error:", error);
                showToast('Failed to approve Barangay ID.', 'error');
                closeModal('approvedIdModal');
            })
            .finally(() => {
                closeModal('approveModal');
                selectedBarangayId = null;
            });
    };

    // Update "Select All" checkbox
    function updateSelectAllCheckbox() {
        const checkboxes = document.querySelectorAll('.selectCheckbox');
        const selectAll = document.getElementById('selectAll');
        if (!selectAll) return;

        const allChecked = [...checkboxes].length > 0 && [...checkboxes].every(cb => cb.checked);
        selectAll.checked = allChecked;
    }

    // Enable/Disable Delete Selected button
    function updateDeleteButtonState() {
        const selectedCount = document.querySelectorAll('.selectCheckbox:checked').length;
        const deleteSelectedBtn = document.getElementById('multiDeleteBtn');
        deleteSelectedBtn.disabled = selectedCount < 2;
    }

    // Delete a single Residency record
    function deleteBarangayId(id) {
        showConfirmation({
            title: 'Delete Barangay ID',
            message: 'Are you sure you want to delete this record?',
            confirmText: 'Delete',
            onConfirm: () => {
                axios.post(`/barangay-id/delete/${id}`)
                    .then(() => {
                        showToast('Record deleted.', 'success');
                        barangayIdModal.fetchList();
                    })
                    .catch(() => {
                        showToast('Failed to delete record.', 'error');
                    });
            }
        });
    }

    // Delete multiple Residency records
    function deleteSelectedBarangayId() {
        const selected = [...document.querySelectorAll('.selectCheckbox:checked')];
        const ids = selected.map(cb => cb.dataset.id);

        if (ids.length === 0) return;

        showConfirmation({
            title: 'Delete Selected Records',
            message: `Are you sure you want to delete ${ids.length} selected record(s)?`,
            confirmText: 'Delete All',
            onConfirm: () => {
                axios.post('/residency/delete-selected', { ids })
                    .then(() => {
                        showToast('Selected records deleted.', 'success');
                        window.barangayIdModal.fetchList();
                    })
                    .catch(() => {
                        showToast('Failed to delete selected records.', 'error');
                    });
            }
        });
    }

    // Restore single Residency record
    function restoreBarangayId(id) {
        showConfirmation({
            title: 'Restore Barangay ID',
            message: 'Do you want to restore this record?',
            confirmText: 'Restore',
            onConfirm: () => {
                axios.post('/barangay-id/restore', { ids: [id] })
                    .then(() => {
                        showToast('Record restored.', 'success');
                        barangayIdModal.fetchList();
                    })
                    .catch(() => {
                        showToast('Failed to restore record.', 'error');
                    });
            }
        });
    }

    // Show the modal for different function
    function showConfirmation({
        title,
        message,
        confirmText = 'Confirm',
        onConfirm
    }) {
        document.getElementById('confirmationTitle').textContent = title;
        document.getElementById('confirmationMessage').textContent = message;
        document.getElementById('confirmActionBtn').textContent = confirmText;
        document.getElementById('confirmationModal').classList.remove('hidden');

        confirmCallback = onConfirm;
    }

    // Select All Toggle
    function toggleSelectAll(source) {
        const checkboxes = document.querySelectorAll('.selectCheckbox');
        checkboxes.forEach(cb => cb.checked = source.checked);
        updateDeleteButtonState();
    }

    // Function for the search
    function filterTableRows() {
        const query = document.getElementById('searchInput').value.toLowerCase();
        const rows = document.querySelectorAll('#barangayIdTableBody tr');

        rows.forEach(row => {
            const searchableText = row.getAttribute('data-search') || '';
            row.style.display = searchableText.includes(query) ? '' : 'none';
        });
    }

    document.getElementById('cancelConfirmBtn').addEventListener('click', () => {
        document.getElementById('confirmationModal').classList.add('hidden');
        confirmCallback = null;
    });

    document.getElementById('confirmActionBtn').addEventListener('click', () => {
        if (confirmCallback) confirmCallback();
        document.getElementById('confirmationModal').classList.add('hidden');
    });

    // ✅ Unified initial fetch and search binding
    document.addEventListener('DOMContentLoaded', function() {
        window.barangayIdModal.fetchList();

        const searchInput = document.getElementById('searchInput');
        if (searchInput) {
            searchInput.addEventListener('input', filterTableRows);
        }
    });

    function changePage(namespace, page) {
        const modal = window[`${namespace}Modal`];
        if (modal) {
            modal.fetchList(page);
        }
    }

    // pagination}
    document.addEventListener('change', function (e) {
        if (e.target && e.target.matches('select[id$="_per_page"]')) {
            const namespace = e.target.getAttribute('data-namespace');
            const modal = window[`${namespace}Modal`];
            if (modal) {
                modal.perPage = parseInt(e.target.value);
                modal.fetchList(1);
            }
        }
    });
</script>
