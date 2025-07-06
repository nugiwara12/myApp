<!-- Your Blade Components -->
<x-indigency.table />
<x-form-modal />

<!-- Script Section -->
<script>
    let confirmCallback = null;

    // Global Modal Control
    window.openModal = function(id) {
        document.getElementById(id)?.classList.remove('hidden');
    };

    // Global Closed Modal Control
    window.closeModal = function(id) {
        const modal = document.getElementById(id);
        if (!modal) return;
        modal.classList.add('hidden');
        modal.removeAttribute('data-userid');
        const form = modal.querySelector('form');
        if (form) form.reset();
    };

    // Form submission handler
    function submitIndigency(event) {
        window.indigencyModal.submit(event);
    }

    // Toast Notification
    function showToast(message, type = 'success') {
        let toastContainer = document.getElementById('toast-container');
        if (!toastContainer) {
            toastContainer = document.createElement('div');
            toastContainer.id = 'toast-container';
            toastContainer.className = 'fixed top-4 right-4 z-50 space-y-2';
            document.body.appendChild(toastContainer);
        }

        while (toastContainer.firstChild) {
            toastContainer.removeChild(toastContainer.firstChild);
        }

        const toast = document.createElement('div');
        toast.className = `flex items-center px-4 py-3 rounded-lg shadow-lg max-w-xs transition-opacity duration-300 ${
            type === 'success' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'
        }`;

        toast.innerHTML = `
            <div class="flex items-center">
                <svg class="w-6 h-6 mr-2 ${
                    type === 'success' ? 'text-green-500' : 'text-red-500'
                }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="${
                        type === 'success'
                            ? 'M9 12l2 2l4 -4m7 8a9 9 0 1 1 -18 0a9 9 0 0 1 18 0z'
                            : 'M12 9v2m0 4h.01m6.938 4h-13.856c-1.344 0-2.402-1.066-2.122-2.387l1.721-9.215A2 2 0 0 1 6.667 4h10.666a2 2 0 0 1 1.957 2.398l-1.721 9.215c-.28 1.321-1.338 2.387-2.682 2.387z'
                    }" />
                </svg>
                <span class="text-black">${message}</span>
            </div>
        `;

        toastContainer.appendChild(toast);

        setTimeout(() => {
            toast.classList.add('opacity-0');
            toast.addEventListener('transitionend', () => toast.remove());
        }, 2000);
    }

    // Open Add indigency
    function openAddIndigency() {
        // Reset edit mode
        window.indigencyModal.editId = null;

        // Clear form fields manually
        window.indigencyModal.fieldIds.forEach(field => {
            const input = document.getElementById(field);
            if (input) input.value = '';
        });

        openModal(window.indigencyModal.modalId);
    }

    // Indigency Modal Handler
    window.indigencyModal = {
        modalId: 'certificationModal',
        fieldIds: ['parent_name', 'address', 'purpose', 'childs_name', 'age', 'date'],
        editId: null,

        submit(event) {
            event.preventDefault();

            const data = {};
            this.fieldIds.forEach(field => {
                data[field] = document.getElementById(field)?.value || '';
            });

            const method = this.editId ? 'put' : 'post';
            const url = this.editId ?
                `/updateIndigency/${this.editId}` :
                `{{ route('addIndigency') }}`;

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

        fetchList() {
            axios.get(`{{ route('getIndigencies') }}`)
                .then(response => {
                    const data = response.data.data;
                    const tbody = document.getElementById('indigencyTableBody');
                    tbody.innerHTML = data.length ? '' : `
                        <tr>
                            <td colspan="8" class="text-center text-gray-500 py-4">No records found.</td>
                        </tr>
                    `;
                    data.forEach(item => {
                        const row = this.createTableRow(item);
                        tbody.appendChild(row);
                    });
                })
                .catch(() => showToast('Failed to fetch records.', 'error'));
        },

        createTableRow(item) {
            const row = document.createElement('tr');
            const statusText = item.status === 1 ? 'Active' : 'Deleted';

            // Determine if item is pending approval (age 1-20 and not yet approved)
            const isForApproval = item.status === 1 && item.age >= 1 && item.age <= 17 && !item.purpose.includes(
                'APPROVAL ACCEPT');

            // Add searchable data
            row.setAttribute('data-search', `
                ${item.parent_name} ${item.address} ${item.purpose}
                ${item.childs_name} ${item.age} ${statusText} ${item.date}
            `.toLowerCase());

            // Apply row styling based on status
            if (item.status === 0) {
                row.classList.add('bg-red-100');
            } else if (isForApproval) {
                row.classList.add('bg-yellow-100'); // For approval
            } else {
                row.classList.add('hover:bg-gray-50');
            }

            row.classList.add('cursor-pointer');

            // Build the row content
            row.innerHTML = `
                <td class="px-4 py-2">
                    ${item.status === 1 ? `<input type="checkbox" class="selectCheckbox" data-id="${item.id}">` : ``}
                </td>
                <td class="px-4 py-2">${item.parent_name}</td>
                <td class="px-4 py-2">${item.address}</td>
                <td class="px-4 py-2">${item.purpose}</td>
                <td class="px-4 py-2">${item.childs_name}</td>
                <td class="px-4 py-2">${item.age}</td>
                <td class="px-4 py-2">${item.date}</td>
                <td class="px-4 py-2">
                    ${isForApproval
                        ? '<span class="inline-block px-2 py-1 text-xs font-semibold text-yellow-700 bg-yellow-100 rounded">Pending</span>'
                        : item.status === 1
                        ? '<span class="inline-block px-2 py-1 text-xs font-semibold text-green-600 bg-green-100 rounded">Active</span>'
                        : '<span class="inline-block px-2 py-1 text-xs font-semibold text-red-600 bg-red-100 rounded">Deleted</span>'
                    }
                </td>
                <td class="px-4 py-2 d-flex gap-2" id="actions-${item.id}">
                    ${isForApproval
                        ? `
                        <button onclick="event.stopPropagation(); approveIndigency(${item.id})"
                            class="btn btn-success border bg-green-500 rounded p-1.5 d-flex align-items-center justify-content-center"
                            title="Approve">
                            <i class="bi bi-check-circle text-white text-md"></i>
                        </button>`
                        : item.status === 1
                        ? `
                        <button onclick="event.stopPropagation(); editIndigency(${item.id})"
                            class="btn btn-light border rounded p-2 d-flex align-items-center justify-content-center"
                            title="Edit">
                            <i class="bi bi-pencil-square text-black"></i>
                        </button>
                        <button onclick="event.stopPropagation(); deleteIndigency(${item.id})"
                            class="btn btn-light border rounded p-2 d-flex align-items-center justify-content-center"
                            title="Delete">
                            <i class="bi bi-trash-fill text-red-500"></i>
                        </button>
                        <button onclick="window.open('/indigency/pdf/${item.id}', '_blank')"
                            class="btn btn-light border rounded p-2 d-flex align-items-center justify-content-center"
                            title="View PDF">
                            <i class="bi bi-file-earmark-pdf text-red-600"></i>
                        </button>`
                        : `
                        <button onclick="event.stopPropagation(); restoreIndigency(${item.id})"
                            class="bg-green-500 border rounded p-2 d-flex align-items-center justify-content-center"
                            title="Restore">
                            <i class="bi bi-arrow-counterclockwise text-white text-md"></i>
                        </button>`
                    }
                </td>
            `;

            // Enable row click to toggle checkbox
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
        }


    };

    // Approved the legal Age
    function approveIndigency(id) {
        axios.put(`/indigency/${id}`, {
                approve: true
            })
            .then(res => {
                showToast('Approved successfully.', 'success');
                window.indigencyModal.fetchList();
            })
            .catch(() => showToast('Failed to approve.', 'error'));
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

    // Function for the search
    function filterTableRows() {
        const query = document.getElementById('searchInput').value.toLowerCase();
        const rows = document.querySelectorAll('#indigencyTableBody tr');

        rows.forEach(row => {
            const searchableText = row.getAttribute('data-search') || '';
            row.style.display = searchableText.includes(query) ? '' : 'none';
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
</script>
