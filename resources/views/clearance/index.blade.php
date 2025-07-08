<!-- Your Blade Components -->
<x-clearance.table />
<x-form-modal />
<x-pagination-function />
<x-toast />

<script>
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

    window.openAddClearance = function () {
        // Reset edit mode
        window.clearanceModal.editId = null;

        // Set modal title & button
        document.getElementById('modalTitle').innerText = 'Barangay Clearance Application Form';
        document.getElementById('btnSubmitClearance').innerText = 'Submit Application';

        // Clear form fields
        window.clearanceModal.fieldIds.forEach(field => {
            const input = document.getElementById(field);
            if (input) {
                input.value = '';
            }
        });

        openModal(window.clearanceModal.modalId);
    }

    // add and edit function for getand post
    window.clearanceModal = {
        modalId: 'clearancenModal',
        fieldIds: [
            'full_name', 'birthdate', 'clearance_age', 'gender', 'civil_status', 'citizenship', 'occupation',
            'contact', 'house_no', 'purok', 'barangay', 'municipality', 'province', 'clearance_purpose', 'approved'
        ],
        editId: null,
        currentPage: 1,
        perPage: 10,

        submit(event) {
            event.preventDefault();

            const form = document.getElementById('clearanceForm');
            const formData = new FormData(form);

            // Append _method if editing
            if (this.editId) {
                formData.append('_method', 'PUT');
            }

            const url = this.editId
                ? `/updateClearance/${this.editId}`
                : `{!! route('addClearance') !!}`;

            axios.post(url, formData, {
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
                    const errors = error.response.data.errors;
                    for (const field in errors) {
                        const errorEl = document.getElementById(`error-${field}`);
                        if (errorEl) {
                            errorEl.textContent = errors[field][0];
                        }
                    }
                    const firstError = Object.values(errors)[0][0];
                    showToast(firstError, 'error');
                } else {
                    showToast('Submission failed.', 'error');
                    console.error(error);
                }
            });
        },

        fetchList(page = 1) {
            this.currentPage = page;

            axios.get(`{{ route('getIndClearance') }}?per_page=${this.perPage}&page=${this.currentPage}`)
                .then(response => {
                    const { data, total, current_page, last_page } = response.data;
                    const tbody = document.getElementById('clearanceTableBody');

                    tbody.innerHTML = data.length
                        ? ''
                        : `<tr><td colspan="17" class="text-center bg-gray-200 text-gray-500 py-4">No records found.</td></tr>`;

                    data.forEach(item => {
                        const row = this.createTableRow(item);
                        tbody.appendChild(row);
                    });

                    document.getElementById('paginationControls').innerHTML = Pagination({
                        currentPage: current_page,
                        totalPages: last_page,
                        totalData: total,
                        perPage: this.perPage,
                        namespace: 'clearance'
                    });
                })
                .catch(() => {
                    showToast('Failed to fetch records.', 'error');
                });
        },

        createTableRow(item) {
            const row = document.createElement('tr');
            const statusText = item.status === 1 ? 'Active' : 'Deleted';

            // ✅ INSERT HERE
            if (item.status === 0) {
                row.classList.add('bg-red-100');
            } else if (item.clearance_age >= 1 && item.clearance_age <= 17) {
                row.classList.add('bg-yellow-100', 'cursor-pointer');
            } else {
                row.classList.add('hover:bg-gray-50', 'cursor-pointer');
            }


            row.setAttribute('data-search', `
                ${item.full_name}
                ${item.birthdate}
                ${item.clearance_age}
                ${item.gender}
                ${item.civil_status}
                ${item.citizenship}
                ${item.occupation}
                ${item.contact}
                ${item.house_no}
                ${item.purok}
                ${item.barangay}
                ${item.municipality}
                ${item.province}
                ${item.clearance_purpose}
                ${item.approved}
                ${statusText}
            `.toLowerCase());
            row.classList.add(item.status === 0 ? 'bg-red-100' : 'hover:bg-gray-50', 'cursor-pointer');

            const isForApproval = item.status === 1 && item.clearance_age >= 1 && item.clearance_age <= 17 && item.approved != 1;

            row.innerHTML = `
                <td class="px-4 py-2">${item.status === 1 ? `<input type="checkbox" class="selectCheckbox" data-id="${item.id}">` : ''}</td>
                <td class="px-4 py-2">${item.full_name}</td>
                <td class="px-4 py-2">${item.birthdate}</td>
                <td class="px-4 py-2">${item.clearance_age}</td>
                <td class="px-4 py-2">${item.gender}</td>
                <td class="px-4 py-2">${item.civil_status}</td>
                <td class="px-4 py-2">${item.citizenship}</td>
                <td class="px-4 py-2">${item.occupation}</td>
                <td class="px-4 py-2">${item.contact}</td>
                <td class="px-4 py-2">${item.house_no}</td>
                <td class="px-4 py-2">${item.purok}</td>
                <td class="px-4 py-2">${item.barangay}</td>
                <td class="px-4 py-2">${item.municipality}</td>
                <td class="px-4 py-2">${item.province}</td>
                <td class="px-4 py-2">${item.clearance_purpose}</td>
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

        getActionButtons(item, isForApproval) {
            if (isForApproval) {
                return `
                    <button onclick="event.stopPropagation(); approveClearance(${item.id})" class="btn btn-success border bg-green-500 rounded p-1.5 d-flex align-items-center justify-content-center" title="Approve">
                        <i class="bi bi-check-circle text-white text-md"></i>
                    </button>`;
            } else if (item.status === 1) {
                return `
                    <button onclick="event.stopPropagation(); editClearance(${item.id})" class="btn btn-light border rounded p-2 d-flex align-items-center justify-content-center" title="Edit">
                        <i class="bi bi-pencil-square text-black"></i>
                    </button>
                    <button onclick="event.stopPropagation(); deleteClearance(${item.id})" class="btn btn-light border rounded p-2 d-flex align-items-center justify-content-center" title="Delete">
                        <i class="bi bi-trash-fill text-red-500"></i>
                    </button>
                    <button onclick="window.open('/clearance/pdf/${item.id}', '_blank')" class="btn btn-light border rounded p-2 d-flex align-items-center justify-content-center" title="View PDF">
                        <i class="bi bi-file-earmark-pdf text-red-600"></i>
                    </button>`;
            } else {
                return `
                    <button onclick="event.stopPropagation(); restoreClearance(${item.id})" class="bg-green-500 border rounded p-2 d-flex align-items-center justify-content-center" title="Restore">
                        <i class="bi bi-arrow-counterclockwise text-white text-md"></i>
                    </button>`;
            }
        }
    };

    // Function to fetch a single record and open modal
    function editClearance(id) {
        document.getElementById('modalTitle').innerText = 'Edit Barangay Clearance';
        document.getElementById('btnSubmitClearance').innerText = 'Update';
        openModal(window.clearanceModal.modalId);

        // Clear form fields first
        window.clearanceModal.fieldIds.forEach(field => {
            const input = document.getElementById(field);
            if (input) input.value = '';
        });

        // Correct: Use GET to fetch record by ID
        axios.get(`/getClearanceById/${id}`)
            .then(response => {
                const data = response.data.data;
                window.clearanceModal.editId = data.id;

                window.clearanceModal.fieldIds.forEach(field => {
                    const input = document.getElementById(field);
                    if (!input) return;

                    if (field === 'birthdate' && data.birthdate) {
                        input.value = data.birthdate.split('T')[0]; // Ensure proper format for input type="date"
                    } else if (field === 'clearance_age') {
                        input.value = data.clearance_age ?? '';
                    } else if (field === 'clearance_purpose') {
                        input.value = data.clearance_purpose ?? '';
                    } else {
                        input.value = data[field] ?? '';
                    }
                });
            })
            .catch(() => {
                showToast('Failed to load record.', 'error');
        });
    }

    // Approved the legal Age
    function approveClearance(id) {
        axios.post(`/clearance/${id}/approve`, { approve: true })
            .then(response => {
                showToast(response.data.message, 'success');
                window.clearanceModal.fetchList(); // Refresh list
            })
            .catch(error => {
                const message = error.response?.data?.message || 'Approval failed.';
                showToast(message, 'error');
            });
    }

    // for search
    function filterTableRows() {
        const query = document.getElementById('searchInput').value.toLowerCase();
        const rows = document.querySelectorAll('#clearanceTableBody tr');

        rows.forEach(row => {
            const searchableText = row.getAttribute('data-search') || '';
            row.style.display = searchableText.includes(query) ? '' : 'none';
        });
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

    // Remove dissabled of the multi button
    function updateDeleteButtonState() {
        const selected = document.querySelectorAll('.selectCheckbox:checked');
        const deleteBtn = document.getElementById('multiDeleteBtn');

        if (deleteBtn) {
            deleteBtn.disabled = selected.length === 1;
        }
    }

    // Delete single
    function deleteClearance(id) {
        showConfirmation({
            title: 'Delete Record',
            message: 'Are you sure you want to delete this record?',
            confirmText: 'Delete',
            onConfirm: () => {
                axios.post(`/clearance/${id}/delete`)
                    .then(() => {
                        showToast('Record deleted.', 'success');
                        window.clearanceModal.fetchList();
                    })
                    .catch(() => {
                        showToast('Failed to delete record.', 'error');
                    });
            }
        });
    }

    // Delete multiple
    function deleteSelectedClearance() {
        const selected = [...document.querySelectorAll('.selectCheckbox:checked')];
        const ids = selected.map(cb => cb.dataset.id);

        if (ids.length === 0) return;

        showConfirmation({
            title: 'Multiple Delete Records',
            message: `Are you sure you want to delete ${ids.length} selected record(s)?`,
            confirmText: 'Delete All',
            onConfirm: () => {
                axios.post(`{{ route('deleteSelectedClearance') }}`, {
                        ids
                    })
                    .then(() => {
                        showToast('Selected records deleted.', 'success');
                        window.clearanceModal.fetchList();
                    })
                    .catch(() => {
                        showToast('Failed to delete selected records.', 'error');
                    });
            }
        });
    }

    // Restore single
    function restoreClearance(id) {
        showConfirmation({
            title: 'Restore Record',
            message: 'Do you want to restore this record?',
            confirmText: 'Restore',
            onConfirm: () => {
                axios.post("{{ route('restoreClearance') }}", {
                        ids: [id]
                    })
                    .then(() => {
                        showToast('Record restored.', 'success');
                        window.clearanceModal.fetchList();
                    })
                    .catch(() => {
                        showToast('Failed to restore record.', 'error');
                    });
            }
        });
    }

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

    document.getElementById('cancelConfirmBtn').addEventListener('click', () => {
        document.getElementById('confirmationModal').classList.add('hidden');
        confirmCallback = null;
    });

    document.getElementById('confirmActionBtn').addEventListener('click', () => {
        if (confirmCallback) confirmCallback();
        document.getElementById('confirmationModal').classList.add('hidden');
    });

    // Fetch list on page load
    document.addEventListener('DOMContentLoaded', function() {
        window.clearanceModal.fetchList();

        const searchInput = document.getElementById('searchInput');
        if (searchInput) {
            searchInput.addEventListener('input', filterTableRows);
        }
    });

    // Pagination}
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
