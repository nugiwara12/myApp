<div>
    <x-slot name="header">
        <div class="flex items-center space-x-2">
            <div class="p-3 bg-white rounded-md shadow-md">
                <i class="bi bi-file-earmark-text text-[#1B76B5] text-xl"></i>
            </div>
            <div>
                <h1 class="text-lg font-semibold">Indigency Certification</h1>
                <p class="text-sm text-gray-500">View submitted indigency requests</p>
            </div>
        </div>
    </x-slot>

    <div class="">
        <div class="max-w-full mx-auto">
            <div class="overflow-hidden shadow-sm sm:rounded-lg">
                <div class="rounded-lg shadow-sm p-6">
                    <div class="flex justify-between mb-4 flex-wrap gap-2">
                        <!-- Left: Search -->
                        <div class="text-left">
                            <x-search-input id="searchInput" placeholder="Search indigency" class="w-full sm:w-60 text-black" />
                        </div>

                        <!-- Right: Buttons -->
                        <div class="text-right space-x-2">
                           <!-- Multiple Delete Button (styled like Filament's danger button) -->
                            <button
                                id="deleteSelectedBtn"
                                onclick="deleteSelectedIndigencies()"
                                disabled
                                class="custom-danger-button"
                            >
                                Multiple Delete
                            </button>

                            <!-- Add Indigency Button (styled like Filament's primary button) -->
                            <button
                                onclick="openAddIndigency()"
                                class="inline-flex items-center justify-center whitespace-nowrap rounded-lg border border-transparent bg-primary-600 px-4 py-2 text-sm font-medium text-white shadow transition-colors duration-200 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500"
                            >
                                Add Indigency
                            </button>

                        </div>
                    </div>

                    <!-- Table -->
                    <div class="max-h-[730px] overflow-y-auto rounded">
                        <table class="w-full text-sm text-left">
                            <thead class="bg-gray-100 text-gray-600 uppercase sticky top-0 z-10">
                                <tr>
                                    <th class="px-4 py-2"><input type="checkbox" id="selectAll"
                                            onchange="toggleSelectAll(this)"></th>
                                    <th class="px-4 py-2">Parent Name</th>
                                    <th class="px-4 py-2">Address</th>
                                    <th class="px-4 py-2">Purpose</th>
                                    <th class="px-4 py-2">Childs Name</th>
                                    <th class="px-4 py-2">Age</th>
                                    <th class="px-4 py-2">Date</th>
                                    <th class="px-4 py-2">Status</th>
                                    <th class="px-4 py-2">Approved</th>
                                    <th class="px-4 py-2">Action</th>
                                </tr>
                            </thead>
                            <tbody id="indigencyTableBody" class="divide-y divide-gray-200"></tbody>
                        </table>
                    </div>
                    <div id="paginationControls" class="mt-4"></div>
                </div>
            </div>
        </div>
    </div>
    <!-- Toast Container -->
    <div id="toast-container" class="fixed top-4 right-4 z-50 space-y-2"></div>

    {{-- Modal --}}
    <!-- Indigency Modal -->
    <div id="certificationModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-xl p-6 relative">
            <h2 id="modalTitle" class="text-xl font-bold mb-4 text-black">Add Indigency</h2>

            <form id="indigencyForm" onsubmit="submitIndigency(event)" class="space-y-4">
                @csrf

                <!-- Parent Name -->
                <div>
                    <label for="parent_name" class="block text-sm font-medium text-gray-700">Parent Name:</label>
                    <input type="text" id="parent_name" name="parent_name"
                        class="mt-1 block w-full rounded-md border-gray-300 text-black shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        required />
                </div>

                <!-- Address -->
                <div>
                    <label for="address" class="block text-sm font-medium text-gray-700">Address:</label>
                    <input type="text" id="address" name="address"
                        class="mt-1 block w-full rounded-md border-gray-300 text-black shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        required />
                </div>

                <!-- Purpose -->
                <div>
                    <label for="purpose" class="block text-sm font-medium text-gray-700">Purpose:</label>
                    <input type="text" id="purpose" name="purpose"
                        class="mt-1 block w-full rounded-md border-gray-300 text-black shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        required />
                </div>

                <!-- Child Name -->
                <div>
                    <label for="childs_name" class="block text-sm font-medium text-gray-700">Child Name:</label>
                    <input type="text" id="childs_name" name="childs_name"
                        class="mt-1 block w-full rounded-md border-gray-300 text-black shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        required />
                </div>

                <!-- Age -->
                <div>
                    <label for="age" class="block text-sm font-medium text-gray-700">Age:
                        <span class="italic text-gray-500 text-xs">(150 maximum age range)</span>
                    </label>
                    <input type="number" id="age" name="age" min="1" max="150"
                        oninput="if (this.value > 150) this.value = 150; if (this.value < 1) this.value = '';"
                        class="mt-1 block w-full rounded-md border-gray-300 text-black shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        required />
                </div>

                <!-- Date -->
                <div>
                    <label for="date" class="block text-sm font-medium text-gray-700">Date:</label>
                    <input type="date" id="date" name="date"
                        class="mt-1 block w-full rounded-md border-gray-300 text-black shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        required />
                </div>

                <!-- Buttons -->
                <div class="pt-4 flex justify-end space-x-2">
                    <button type="button" onclick="closeModal('certificationModal')" style="margin-right: 3px;"
                        class="rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-100">
                        Cancel
                    </button>
                    <button type="submit"
                        class="rounded-md bg-primary-500 px-4 py-2 text-sm font-semibold text-white shadow-sm transition duration-150 hover:bg-primary-500"
                        id="btnSubmitIndigency">
                        Submit
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Confirmation Modal -->
    <div id="confirmationModal" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full p-6">
            <h2 id="confirmationTitle" class="text-lg font-semibold mb-2">Confirm Action</h2>
            <p id="confirmationMessage" class="text-sm text-gray-600 mb-4">Are you sure you want to perform this action?</p>
            <div class="flex justify-end space-x-2">
                <button id="cancelConfirmBtn" class="px-4 py-2 text-gray-600 hover:text-black bg-gray-200 rounded">
                    Cancel
                </button>
                <button id="confirmActionBtn" class="custom-danger-button">
                    Confirm
                </button>
            </div>
        </div>
    </div>

    @push('scripts')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

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

            // Set modal title & button
            document.getElementById('modalTitle').innerText = 'Add Indigency';
            document.getElementById('btnSubmitIndigency').innerText = 'Submit';

            // Clear form fields manually
            window.indigencyModal.fieldIds.forEach(field => {
                const input = document.getElementById(field);
                if (input) input.value = '';
            });

            openModal(window.indigencyModal.modalId);
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

        // Indigency Modal Handler
        window.indigencyModal = {
            modalId: 'certificationModal',
            fieldIds: ['parent_name', 'address', 'purpose', 'childs_name', 'age', 'date'],
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

            fetchList(page = 1) {
                this.currentPage = page;
                axios.get(`{{ route('getIndigencies') }}?per_page=${this.perPage}&page=${this.currentPage}`)
                    .then(response => {
                        const { data, total, current_page, last_page } = response.data;
                        const tbody = document.getElementById('indigencyTableBody');
                        tbody.innerHTML = data.length ? '' : `
                            <tr>
                                <td colspan="10" class="text-center bg-gray-200 text-gray-500 py-4">No records found.</td>
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
                const row = document.createElement('tr');
                const statusText = item.status === 1 ? 'Active' : 'Deleted';
                const approved = Number(item.approved);
                const isForApproval = item.status === 1 && item.age >= 1 && item.age <= 17 && approved !== 1;

                // 🔁 Clean classList
                row.className = 'cursor-pointer';

                // ✅ Apply background + text color conditionally
                if (item.status === 0) {
                    row.classList.add('bg-red-100', 'text-red-900', 'hover:bg-red-200');
                } else if (item.age >= 1 && item.age <= 17) {
                    row.classList.add('bg-yellow-100', 'text-yellow-900', 'hover:bg-yellow-200');
                } else {
                    row.classList.add('hover:bg-gray-100', 'text-gray-900', 'dark:hover:bg-gray-700', 'dark:text-gray-100');
                }

                row.setAttribute('data-search', `${item.parent_name} ${item.address} ${item.purpose} ${item.childs_name} ${item.age} ${statusText} ${item.date}`.toLowerCase());

                row.innerHTML = `
                    <td class="px-4 py-2">${item.status === 1 ? `<input type="checkbox" class="selectCheckbox" data-id="${item.id}">` : ''}</td>
                    <td class="px-4 py-2">${item.parent_name}</td>
                    <td class="px-4 py-2">${item.address}</td>
                    <td class="px-4 py-2">${item.purpose}</td>
                    <td class="px-4 py-2">${item.childs_name}</td>
                    <td class="px-4 py-2">${item.age}</td>
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
                        ${item.status === 0
                            ? '<span class="inline-block px-2 py-1 text-xs font-semibold text-red-700 bg-red-100 rounded">Deleted</span>'
                            : approved === 1
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
                const isMinor = item.age >= 1 && item.age <= 17;
                const iconTextColor = isMinor
                    ? 'text-gray-800' // Good contrast on yellow
                    : 'text-black dark:text-white';

                if (isForApproval) {
                    return `
                        <button onclick="event.stopPropagation(); approveIndigency(${item.id})"
                            class="btn btn-success border bg-green-500 rounded p-1.5 d-flex align-items-center justify-content-center" title="Approve">
                            <i class="bi bi-check-circle text-white text-md"></i>
                        </button>`;
                } else if (item.status === 1) {
                    return `
                        <button onclick="event.stopPropagation(); editIndigency(${item.id})"
                            class="btn btn-light border rounded p-2 d-flex align-items-center justify-content-center" title="Edit">
                            <i class="bi bi-pencil-square ${iconTextColor}"></i>
                        </button>
                        <button onclick="event.stopPropagation(); deleteIndigency(${item.id})"
                            class="btn btn-light border rounded p-2 d-flex align-items-center justify-content-center" title="Delete">
                            <i class="bi bi-trash-fill ${isMinor ? 'text-gray-800' : 'text-red-600 dark:text-red-400'}"></i>
                        </button>
                        <button onclick="window.open('/indigency/pdf/${item.id}', '_blank')"
                            class="btn btn-light border rounded p-2 d-flex align-items-center justify-content-center" title="View PDF">
                            <i class="bi bi-file-earmark-pdf ${isMinor ? 'text-gray-800' : 'text-red-600 dark:text-red-400'}"></i>
                        </button>`;
                } else {
                    return `
                        <button onclick="event.stopPropagation(); restoreIndigency(${item.id})"
                            class="bg-green-500 border rounded p-2 d-flex align-items-center justify-content-center" title="Restore">
                            <i class="bi bi-arrow-counterclockwise text-white text-md"></i>
                        </button>`;
                }
            }
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

        // {agination}
        document.addEventListener('DOMContentLoaded', () => {
            window.indigencyModal.fetchList();

            const perPageSelect = document.getElementById('per_page');
            if (perPageSelect) {
                perPageSelect.addEventListener('change', function () {
                    window.indigencyModal.perPage = parseInt(this.value);
                    window.indigencyModal.fetchList(1);
                });
            }
        });

        // Pagination
        function Pagination({ currentPage, totalPages, totalData }) {
            const perPage = 5;
            const startPage = Math.floor((currentPage - 1) / perPage) * perPage + 1;
            const endPage = Math.min(startPage + perPage - 1, totalPages);
            const nextSetStart = Math.min(startPage + perPage, totalPages);
            const prevSetStart = Math.max(startPage - perPage, 1);

            return `
                <div class="flex flex-col sm:flex-row items-center justify-between gap-4 px-4 py-2">
                    <!-- Show Entries Dropdown -->
                    <div class="flex items-center text-sm">
                        <label for="per_page" class="mr-2">Show</label>
                        <select id="per_page" class="border border-gray-300 rounded px-6 py-1 text-black">
                            <option value="10">10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>
                        <span class="ml-2">entries</span>
                    </div>

                    <!-- Pagination Buttons -->
                    <div class="flex flex-wrap items-center justify-center gap-1">
                        ${startPage > 1
                            ? `<button onclick="changePage(${prevSetStart})" class="px-3 py-1 border rounded-md text-gray-700 bg-white hover:bg-gray-100 text-lg">«</button>`
                            : `<span class="px-3 py-1 text-gray-400 border rounded-md cursor-not-allowed text-lg">«</span>`}

                        ${currentPage > 1
                            ? `<button onclick="changePage(${currentPage - 1})" class="px-3 py-1 border rounded-md text-gray-700 bg-white hover:bg-gray-100 text-lg">‹</button>`
                            : `<span class="px-3 py-1 text-gray-400 border rounded-md cursor-not-allowed text-lg">‹</span>`}

                        ${Array.from({ length: endPage - startPage + 1 }, (_, i) => {
                            const pageNum = startPage + i;
                            return `
                                <button onclick="changePage(${pageNum})"
                                    class="px-3 py-2 text-sm rounded-md border shadow-sm transition-all duration-200 ${
                                        currentPage === pageNum ? 'bg-primary-500 text-white' : 'text-gray-700 bg-white hover:bg-gray-100'
                                    }">
                                    ${pageNum}
                                </button>
                            `;
                        }).join('')}

                        ${currentPage < totalPages
                            ? `<button onclick="changePage(${currentPage + 1})" class="px-3 py-1 border rounded-md text-gray-700 bg-white hover:bg-gray-100 text-lg">›</button>`
                            : `<span class="px-3 py-1 text-gray-400 border rounded-md cursor-not-allowed text-lg">›</span>`}

                        ${endPage < totalPages
                            ? `<button onclick="changePage(${nextSetStart})" class="px-3 py-1 border rounded-md text-gray-700 bg-white hover:bg-gray-100 text-lg">»</button>`
                            : `<span class="px-3 py-1 text-gray-400 border rounded-md cursor-not-allowed text-lg">»</span>`}
                    </div>
                </div>
            `;
        }

        // Handle page change
        function changePage(page) {
            window.indigencyModal.fetchList(page);
        }

        // Handle per page dropdown change
        document.addEventListener('DOMContentLoaded', () => {
            document.addEventListener('change', function (e) {
                if (e.target && e.target.id === 'per_page') {
                    window.indigencyModal.perPage = parseInt(e.target.value);
                    window.indigencyModal.fetchList(1);
                }
            });
        });
    </script>
    @endpush
</div>
