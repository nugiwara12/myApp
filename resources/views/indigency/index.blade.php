<!-- Your Blade Components -->
<x-indigency.table />
<x-form-modal />
<x-pagination-function />
<x-toast />

<!-- Script Section -->
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

    // Generated the Indigency refereal code
    function generateIndigencyNumber() {
        const now = new Date();
        const datePart = now.toISOString().slice(0, 10).replace(/-/g, ''); // e.g., 20250713
        const randomPart = Math.floor(1000 + Math.random() * 9000); // 4-digit random number
        return `IND-${datePart}-${randomPart}`;
    }

    // Form submission handler
    function submitIndigency(event) {
        window.indigencyModal.submit(event);
    }

    // Open Add indigency
    function openAddIndigency() {
        // Reset edit mode
        window.indigencyModal.editId = null;

        // Set modal title & button
        document.getElementById('modalTitle').innerText = 'Add Indigency';
        document.getElementById('btnSubmitIndigency').innerText = 'Submit';

        // Clear form fields manually
        window.indigencyModal.fieldIds.forEach(field => {
            const input = document.getElementById(field);
            if (input) input.value = '';
        });

         // ✅ Auto-generate the generated_number
        const genNumInput = document.querySelector('[name="generated_number"]');
        if (genNumInput) {
            genNumInput.value = generateIndigencyNumber();
        }

        // ✅ Set the value here
        const generatedNumber = generateIndigencyNumber();
        document.getElementById('indigency_generated_number').value = generatedNumber;

        openModal(window.indigencyModal.modalId);
    }

    // Indigency Modal Handler
    window.indigencyModal = {
        modalId: 'certificationModal',
        fieldIds: ['parent_name', 'indigency_email', 'address', 'purpose', 'childs_name', 'age', 'indigency_generated_number', 'date'],
        editId: null,
        currentPage: 1,
        perPage: 10,

        submit(event) {
            event.preventDefault();

            const data = {};
            this.fieldIds.forEach(field => {
                data[field] = document.getElementById(field)?.value || '';
            });

            const method = this.editId ? 'put' : 'post';
            const url = this.editId
                ? `/updateIndigency/${this.editId}`
                : `{{ route('addIndigency') }}`;

            axios[method](url, data)
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
            axios.get(`{{ route('getIndigencies') }}?per_page=${this.perPage}&page=${this.currentPage}`)
                .then(response => {
                    const { data, total, current_page, last_page } = response.data;
                    const tbody = document.getElementById('indigencyTableBody');
                    tbody.innerHTML = data.length ? '' : `
                        <tr>
                            <td colspan="12" class="text-center bg-gray-200 text-gray-500 py-4">No records found.</td>
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
                        namespace: 'indigency'
                    });
                })
                .catch(() => showToast('Failed to fetch records.', 'error'));
        },

        createTableRow(item) {
            // Your existing row generation logic here
            const row = document.createElement('tr');
            const statusText = item.status === 1 ? 'Active' : 'Deleted';

            // ✅ INSERT HERE
            if (item.status === 0) {
                row.classList.add('bg-red-100');
            } else if (item.age >= 1 && item.age <= 17) {
                row.classList.add('bg-yellow-100', 'cursor-pointer');
            } else {
                row.classList.add('cursor-pointer');
            }

            row.setAttribute('data-search', `${item.parent_name} ${item.address} ${item.purpose} ${item.childs_name} ${item.age} ${statusText} ${item.date}`.toLowerCase());
            row.classList.add(item.status === 0 ? 'bg-red-100' : 'cursor-pointer');

            const isForApproval = item.status === 1 && item.age >= 1 && item.age <= 17 && item.approved != 1;

            row.innerHTML = `
                <td class="px-4 py-2">${item.status === 1 ? `<input type="checkbox" class="selectCheckbox" data-id="${item.id}">` : ''}</td>
                <td class="px-4 py-2">${item.parent_name}</td>
                <td class="px-4 py-2">${item.indigency_email}</td>
                <td class="px-4 py-2">${item.address}</td>
                <td class="px-4 py-2">${item.purpose}</td>
                <td class="px-4 py-2">${item.childs_name || 'N/A'}</td>
                <td class="px-4 py-2">${item.age}</td>
                <td class="px-4 py-2">${item.indigency_generated_number}</td>
                <td class="px-4 py-2">${new Date(item.date).toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' })}</td>
                <td class="px-4 py-2">
                    ${isForApproval
                        ? '<span class="inline-block px-2 py-1 text-xs font-semibold text-yellow-700 bg-yellow-100 rounded">Pending</span>'
                        : item.status === 1
                        ? '<span class="inline-block px-2 py-1 text-xs font-semibold text-green-600 bg-green-100 rounded">Active</span>'
                        : '<span class="inline-block px-2 py-1 text-xs font-semibold text-red-600 bg-red-100 rounded">Deleted</span>'
                    }
                </td>
                <td class="px-4 py-2">
                    ${
                        item.status === 0
                            ? '<span class="inline-block px-2 py-1 text-xs font-semibold text-red-700 bg-red-100 rounded">Deleted</span>'
                            : item.approved === 1
                            ? '<span class="inline-block px-2 py-1 text-xs font-semibold text-green-700 bg-green-100 rounded">Approved</span>'
                            : '<span class="inline-block px-2 py-1 text-xs font-semibold text-yellow-700 bg-yellow-100 rounded">Not Approved</span>'
                    }
                </td>
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

            if (isAdmin) {
                // ✅ Only show Approve button if NOT approved
                if (item.status === 1 && !isApproved) {
                    buttons += `
                        <button onclick="event.stopPropagation(); approveIndigency(${item.id})"
                            class="bg-green-500 border white rounded p-2 d-flex align-items-center justify-content-center"
                            title="Approve">
                            <i class="bi bi-check-circle-fill text-white text-md"></i>
                        </button>
                    `;
                }

                // ✅ If approved, show Edit, Delete, PDF
                if (item.status === 1 && isApproved) {
                    buttons += `
                        <button onclick="event.stopPropagation(); editIndigency(${item.id})"
                            class="btn btn-light border rounded p-2 d-flex align-items-center justify-content-center" title="Edit">
                            <i class="bi bi-pencil-square text-black"></i>
                        </button>
                        <button onclick="event.stopPropagation(); deleteIndigency(${item.id})"
                            class="btn btn-light border rounded p-2 d-flex align-items-center justify-content-center" title="Delete">
                            <i class="bi bi-trash-fill text-red-500"></i>
                        </button>
                        <button onclick="event.stopPropagation(); window.open('/indigency/pdf/${item.id}', '_blank')"
                            class="btn btn-light border rounded p-2 d-flex align-items-center justify-content-center" title="View PDF">
                            <i class="bi bi-file-earmark-pdf text-red-600"></i>
                        </button>
                    `;
                }
            } else {
                // ✅ For regular users: show only if approved
                if (item.status === 1 && isApproved) {
                    buttons += `
                        <button onclick="event.stopPropagation(); editIndigency(${item.id})"
                            class="btn btn-light border rounded p-2 d-flex align-items-center justify-content-center" title="Edit">
                            <i class="bi bi-pencil-square text-black"></i>
                        </button>
                        <button onclick="event.stopPropagation(); window.open('/indigency/pdf/${item.id}', '_blank')"
                            class="btn btn-light border rounded p-2 d-flex align-items-center justify-content-center" title="View PDF">
                            <i class="bi bi-file-earmark-pdf text-red-600"></i>
                        </button>
                    `;
                }
            }

            return buttons;
        }
    };

    window.currentUser = {
        isAdmin: @hasrole('admin') true @else false @endhasrole
    };

    // approved modal
    window.approveIndigency = function(id) {
        selectedResidenceId = id;
        openModal('approveIndigencyModal');
    };

    // approved the data
    window.confirmApproveIndigency = function () {
        if (!selectedResidenceId) return;

        axios.post(`/barangay-indigency/${selectedResidenceId}/approve`)
            .then(response => {
                showToast('Barangay Indigency approved successfully!', 'success');
                indigencyModal.fetchList();
                closeModal('approveIndigencyModal');
            })
            .catch(error => {
                console.error("Approval error:", error);
                showToast('Failed to approve Barangay Indigency.', 'error');
                closeModal('approveIndigencyModal');
            })
            .finally(() => {
                closeModal('approveIndigencyModal');
                selectedResidenceId = null;
            });
    };

    // Approved the legal Age
    function approveIndigency(id) {
        axios.post(`/indigency/${id}/approve`, { approve: true })
            .then(response => {
                showToast(response.data.message, 'success');
                window.indigencyModal.fetchList(); // Refresh list
            })
            .catch(error => {
                const message = error.response?.data?.message || 'Approval failed.';
                showToast(message, 'error');
            });
    }

    // Function to fetch a single record and open modal
    function editIndigency(id) {
        document.getElementById('modalTitle').innerText = 'Edit Indigency';
        document.getElementById('btnSubmitIndigency').innerText = 'Update';
        openModal(window.indigencyModal.modalId);

        // Clear form
        window.indigencyModal.fieldIds.forEach(field => {
            const input = document.getElementById(field);
            if (input) input.value = '';
        });

        axios.put(`/updateIndigency/${id}`) // use GET, not PUT, to fetch
            .then(response => {
                const data = response.data.data;
                window.indigencyModal.editId = data.id;

                window.indigencyModal.fieldIds.forEach(field => {
                    const input = document.getElementById(field);
                    if (!input) return;

                    // Format the date field properly
                    if (field === 'date' && data.date) {
                        input.value = data.date.split('T')[0]; // Only 'YYYY-MM-DD'
                    } else {
                        input.value = data[field] ?? '';
                    }
                });
            })
            .catch(() => {
                showToast('Failed to load record.', 'error');
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

    // Update "Select All" checkbox
    function updateSelectAllCheckbox() {
        const checkboxes = document.querySelectorAll('.selectCheckbox');
        const selectAll = document.getElementById('selectAll');
        if (!selectAll) return;

        const allChecked = [...checkboxes].length > 0 && [...checkboxes].every(cb => cb.checked);
        selectAll.checked = allChecked;
    }

    // Enable/Disable "Delete Selected" button
    function updateDeleteButtonState() {
        const selectedCount = document.querySelectorAll('.selectCheckbox:checked').length;
        const deleteSelectedBtn = document.getElementById('deleteSelectedBtn');

        // Enable only if more than 1 item is selected
        deleteSelectedBtn.disabled = selectedCount < 2;
    }

    // Delete single
    function deleteIndigency(id) {
        showConfirmation({
            title: 'Delete Record',
            message: 'Are you sure you want to delete this record?',
            confirmText: 'Delete',
            onConfirm: () => {
                axios.post(`/indigency/${id}/delete`)
                    .then(() => {
                        showToast('Record deleted.', 'success');
                        window.indigencyModal.fetchList();
                    })
                    .catch(() => {
                        showToast('Failed to delete record.', 'error');
                    });
            }
        });
    }

    // Delete multiple
    function deleteSelectedIndigencies() {
        const selected = [...document.querySelectorAll('.selectCheckbox:checked')];
        const ids = selected.map(cb => cb.dataset.id);

        if (ids.length === 0) return;

        showConfirmation({
            title: 'Multiple Delete Records',
            message: `Are you sure you want to delete ${ids.length} selected record(s)?`,
            confirmText: 'Delete All',
            onConfirm: () => {
                axios.post(`{{ route('deleteSelectedIndigencies') }}`, {
                        ids
                    })
                    .then(() => {
                        showToast('Selected records deleted.', 'success');
                        window.indigencyModal.fetchList();
                    })
                    .catch(() => {
                        showToast('Failed to delete selected records.', 'error');
                    });
            }
        });
    }

    // Restore single
    function restoreIndigency(id) {
        showConfirmation({
            title: 'Restore Record',
            message: 'Do you want to restore this record?',
            confirmText: 'Restore',
            onConfirm: () => {
                axios.post("{{ route('restoreIndigencies') }}", {
                        ids: [id]
                    })
                    .then(() => {
                        showToast('Record restored.', 'success');
                        window.indigencyModal.fetchList();
                    })
                    .catch(() => {
                        showToast('Failed to restore record.', 'error');
                    });
            }
        });
    }

    // Function for the search
    function filterTableRows() {
        const query = document.getElementById('searchInput').value.toLowerCase();
        const rows = document.querySelectorAll('#indigencyTableBody tr');

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
        window.indigencyModal.fetchList();

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
