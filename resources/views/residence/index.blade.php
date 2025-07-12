<x-residence.table />
<x-form-modal />
<x-pagination-function />
<x-toast />

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

    // Trigger add mode
    function openAddResidency() {
        window.residencyModal.openAdd();
    }

    // Submit form binding
    function submitResidency(event) {
        window.residencyModal.submit(event);
    }

    // Residency Modal Handler
    window.residencyModal = {
        modalId: 'residencyModal',
        fieldIds: [
            'resident_name',
            'resident_age',
            'civil_status',
            'nationality',
            'address',
            'has_criminal_record',
            'zip_code',
            'voters_id_pre_number',
            'approved_by',
            'resident_purpose',
            'certificate_number',
            'issue_date',
            'barangay_name',
            'municipality',
            'province'
        ],
        editId: null,
        currentPage: 1,
        perPage: 10,

        submit(event) {
            event.preventDefault();

            const form = document.getElementById('residencyForm');
            const formData = new FormData(form);
            const data = {};

            // ✅ Always include the checkbox value manually (0 or 1)
            data['has_criminal_record'] = document.getElementById('has_criminal_record').checked ? 1 : 0;

            // Populate the rest of the fields
            formData.forEach((value, key) => {
                if (key !== 'has_criminal_record') {
                    data[key] = value;
                }
            });

            const isEdit = !!this.editId;
            const method = isEdit ? 'put' : 'post';
            const url = isEdit
                ? `/updateResidence/${this.editId}`
                : `{{ route('addResidence') }}`;

            axios({
                method,
                url,
                data,
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                },
            })
                .then(() => {
                    showToast(isEdit ? 'Updated successfully.' : 'Submitted successfully.', 'success');
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

        openAdd() {
            this.editId = null;
            document.getElementById('modalTitle').innerText = 'Add Residency Certificate';
            document.getElementById('btnSubmitResidency').innerText = 'Submit';

            this.fieldIds.forEach(field => {
                const input = document.getElementById(field);
                if (!input) return;

                if (field === 'certificate_number') {
                    const now = new Date();
                    const yyyymmdd = now.toISOString().split('T')[0].replace(/-/g, '');
                    const random = Math.floor(1000 + Math.random() * 9000);
                    input.value = `RES-${yyyymmdd}-${random}`;
                } else if (field === 'barangay_name') {
                    return; // keep current value if set elsewhere
                } else if (field === 'zip_code') {
                    input.value = '2000'; // default zip code
                } else if (input.type === 'checkbox') {
                    input.checked = false;
                } else if (input.type === 'date') {
                    input.value = new Date().toISOString().split('T')[0];
                } else {
                    input.value = '';
                }
            });

            openModal(this.modalId);
        },

        fetchList(page = 1) {
            this.currentPage = page;

            axios.get(`{{ route('getResidenceInformation') }}?page=${page}&per_page=${this.perPage}`)
                .then(response => {
                    const { data, current_page, last_page, total } = response.data;

                    const tbody = document.getElementById('residenceTableBody');
                    if (!tbody) {
                        console.error('Table body element #residenceTableBody not found.');
                        return;
                    }

                    tbody.innerHTML = data.length ? '' : `
                        <tr>
                            <td colspan="19" class="text-center bg-gray-200 text-gray-500 py-4">No records found.</td>
                        </tr>
                    `;

                    data.forEach(item => {
                        const row = this.createTableRow(item);
                        tbody.appendChild(row);
                    });

                    const pagination = document.getElementById('paginationControls');
                    if (pagination) {
                        pagination.innerHTML = Pagination({
                            currentPage: current_page,
                            totalPages: last_page,
                            totalData: total,
                            perPage: this.perPage,
                            namespace: 'residency'
                        });
                    }
                })
                .catch(() => showToast('Failed to fetch residency records.', 'error'));
        },

        createTableRow(item) {
            const row = document.createElement('tr');
            const statusText = item.status === 1 ? 'Active' : 'Deleted';
            const isForApproval = item.status === 1 && item.resident_age >= 1 && item.resident_age <= 17 && item.approved != 1;

            if (item.status === 0) {
                row.classList.add('bg-red-100');
            } else if (item.resident_age >= 1 && item.resident_age <= 17) {
                row.classList.add('bg-yellow-100', 'cursor-pointer');
            } else {
                row.classList.add('hover:bg-gray-50', 'cursor-pointer');
            }

            row.setAttribute(
                'data-search',
                `${item.resident_name} ${item.address} ${item.resident_purpose} ${item.resident_age} ${statusText} ${item.issue_date}`.toLowerCase()
            );

            row.innerHTML = `
                <td class="px-4 py-2">
                    ${item.status === 1 ? `<input type="checkbox" class="selectCheckbox" data-id="${item.id}">` : ''}
                </td>
                <td class="px-4 py-2">${item.resident_name}</td>
                <td class="px-4 py-2">${item.resident_email_address}</td>
                <td class="px-4 py-2">${item.resident_age}</td>
                <td class="px-4 py-2">${item.civil_status}</td>
                <td class="px-4 py-2">${item.nationality}</td>
                <td class="px-4 py-2 capitalize">${item.address}</td>
                <td class="px-4 py-2">
                    <span class="${item.has_criminal_record == 1
                        ? 'bg-red-100 border border-red-500 text-red-700 px-2 py-1 rounded text-sm'
                        : 'bg-gray-100 border border-gray-400 text-gray-700 px-2 py-1 rounded text-sm'}">
                        ${item.has_criminal_record == 1 ? 'Criminal Record' : 'No Criminal Records'}
                    </span>
                </td>
                <td class="px-4 py-4">
                    ${
                        item.approved_by && item.approved_by !== '0' && item.approved_by !== 0
                            ? `<span class="bg-green-100 text-green-700 border border-green-300 px-3 py-1 rounded-md text-sm font-medium">
                                    ${item.approved_by}
                            </span>`
                            : `<span class="bg-gray-200 text-gray-600 border border-gray-300 px-3 py-1 rounded-md text-sm font-medium">
                                    Waiting for Approval
                            </span>`
                    }
                </td>
                <td class="px-4 py-2">${item.resident_purpose}</td>
                <td class="px-4 py-2">${item.certificate_number}</td>
                <td class="px-4 py-2">${item.zip_code || 'N/A'}</td>
                <td class="px-4 py-2">${item.voters_id_pre_number}</td>
                <td class="px-4 py-2">
                    ${
                        isForApproval
                            ? '<span class="inline-block px-2 py-1 text-xs font-semibold text-yellow-700 bg-yellow-100 rounded">Pending</span>'
                            : item.status === 1
                            ? '<span class="inline-block px-2 py-1 text-xs font-semibold text-green-600 bg-green-100 rounded">Active</span>'
                            : '<span class="inline-block px-2 py-1 text-xs font-semibold text-red-600 bg-red-100 rounded">Deleted</span>'
                    }
                </td>
                <td class="px-4 py-2">
                    ${item.issue_date ? new Date(item.issue_date).toLocaleDateString('en-US', {
                        year: 'numeric',
                        month: 'long',
                        day: 'numeric'
                    }) : 'N/A'}
                </td>
                <td class="px-4 py-2">${item.barangay_name}</td>
                <td class="px-4 py-2">${item.municipality}</td>
                <td class="px-4 py-2">${item.province}</td>
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
            const isNotApproved = item.approved_by == 0 || item.approved_by === '0' || item.approved_by === null || item.approved_by === undefined || item.approved_by === '' || item.approved_by === 'NULL';

            if (item.status === 1 && isNotApproved) {
                return `
                    <button onclick="event.stopPropagation(); approveResidence(${item.id})"
                        class="bg-green-500 border white rounded p-2 d-flex align-items-center justify-content-center"
                        title="Approve">
                        <i class="bi bi-check-circle-fill text-white text-md"></i>
                    </button>
                `;
            }

            if (item.status === 1) {
                return `
                    <button onclick="event.stopPropagation(); editResidency(${item.id})"
                        class="btn btn-light border rounded p-2 d-flex align-items-center justify-content-center" title="Edit">
                        <i class="bi bi-pencil-square text-black"></i>
                    </button>
                    <button onclick="event.stopPropagation(); deleteResidency(${item.id})"
                        class="btn btn-light border rounded p-2 d-flex align-items-center justify-content-center" title="Delete">
                        <i class="bi bi-trash-fill text-red-500"></i>
                    </button>
                    <button onclick="event.stopPropagation(); window.open('/residencePdf/${item.id}', '_blank')"
                        class="btn btn-light border rounded p-2 d-flex align-items-center justify-content-center" title="View PDF">
                        <i class="bi bi-file-earmark-pdf text-red-600"></i>
                    </button>
                `;
            }

            // If soft deleted or other cases
            return `
                <button onclick="event.stopPropagation(); restoreResidency(${item.id})"
                    class="bg-green-500 border white rounded p-2 d-flex align-items-center justify-content-center" title="Restore">
                    <i class="bi bi-arrow-counterclockwise text-white text-md"></i>
                </button>
            `;
        }

    };

    // Edit for residency
    function editResidency(id) {
        axios.get(`/getResidenceInformation/${id}`)
            .then(response => {
                const data = response.data;
                const form = document.getElementById('residencyForm');
                const elements = form.elements;

                for (let i = 0; i < elements.length; i++) {
                    const input = elements[i];
                    const name = input.name;

                    if (!name || !data.hasOwnProperty(name)) continue;

                    if (input.type === 'checkbox') {
                        input.checked = !!data[name];
                    } else if (input.type === 'date') {
                        input.value = data[name]
                            ? new Date(data[name]).toISOString().split('T')[0]
                            : '';
                    } else {
                        input.value = data[name] ?? '';
                    }
                }

                // Optional: Update modal title & button text
                residencyModal.editId = id;
                document.getElementById('modalTitle').innerText = 'Edit Residency Certificate';
                document.getElementById('btnSubmitResidency').innerText = 'Update';

                // Show the modal
                openModal(residencyModal.modalId);
            })
            .catch(() => {
                showToast('Failed to fetch residency data.', 'error');
            });
    }

    // approved modal
    window.approveResidence = function(id) {
        selectedResidenceId = id;
        openModal('approveModal'); // Show your confirmation modal here
    };

    // approved the data
    window.confirmApprove = function() {
        if (!selectedResidenceId) return;

        axios.post(`/approvedFIle/${selectedResidenceId}`)
            .then(response => {
                showToast('Residence approved successfully!', 'success');
                residencyModal.fetchList();
                closeModal('approveModal');
            })
            .catch(error => {
                console.error("Approval error:", error);
                showToast('Failed to approve residence.', 'error');
            })
            .finally(() => {
                closeModal('approveModal');
                selectedResidenceId = null;
            });
    };

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

    // Function for the search
    function filterTableRows() {
        const query = document.getElementById('searchInput').value.toLowerCase();
        const rows = document.querySelectorAll('#indigencyTableBody tr');

        rows.forEach(row => {
            const searchableText = row.getAttribute('data-search') || '';
            row.style.display = searchableText.includes(query) ? '' : 'none';
        });
    }

    // Approve a Residency record
    function approveResidency(id) {
        axios.post(`/residency/${id}/approve`, {
            approve: true
        }, {
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => {
            showToast(response.data.message, 'success');
            if (window.residencyModal && typeof window.residencyModal.fetchList === 'function') {
                window.residencyModal.fetchList();
            }
        })
        .catch(error => {
            const message = error.response?.data?.message || 'Approval failed.';
            showToast(message, 'error');
        });
    }

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
        const deleteSelectedBtn = document.getElementById('deleteSelectedBtn');
        deleteSelectedBtn.disabled = selectedCount < 2;
    }

    // Delete a single Residency record
    function deleteResidency(id) {
        showConfirmation({
            title: 'Delete Record',
            message: 'Are you sure you want to delete this record?',
            confirmText: 'Delete',
            onConfirm: () => {
                axios.post(`/residency/${id}/delete`)
                    .then(() => {
                        showToast('Record deleted.', 'success');
                        window.residencyModal.fetchList();
                    })
                    .catch(() => {
                        showToast('Failed to delete record.', 'error');
                    });
            }
        });
    }

    // Delete multiple Residency records
    function deleteSelectedResidencies() {
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
                        window.residencyModal.fetchList();
                    })
                    .catch(() => {
                        showToast('Failed to delete selected records.', 'error');
                    });
            }
        });
    }

    // Restore single Residency record
    function restoreResidency(id) {
        showConfirmation({
            title: 'Restore Record',
            message: 'Do you want to restore this record?',
            confirmText: 'Restore',
            onConfirm: () => {
                axios.post('/residency/restore', { ids: [id] })
                    .then(() => {
                        showToast('Record restored.', 'success');
                        window.residencyModal.fetchList();
                    })
                    .catch(() => {
                        showToast('Failed to restore record.', 'error');
                    });
            }
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
        window.residencyModal.fetchList();

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
