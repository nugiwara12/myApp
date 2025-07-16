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

    <div class="py-6">
        <div class="max-w-full mx-auto">
            <div class="overflow-hidden shadow-sm sm:rounded-lg">
                <div class="rounded-lg shadow-sm p-6">
                    <div class="flex justify-between mb-4 flex-wrap gap-2">
                        <!-- Left: Search -->
                        <div class="text-left">
                            <input
                                id="searchInput"
                                type="text"
                                placeholder="Search Indigency"
                                class="w-full sm:w-60 px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-800 dark:text-white"
                            />
                        </div>

                        <!-- Right: Buttons -->
                        <div class="text-right space-x-2">
                           <!-- Multiple Delete Button (styled like Filament's danger button) -->
                            <button
                                id="deleteSelectedBtn"
                                onclick="deleteSelectedIndigencies()"
                                disabled
                                class="px-4 py-2 bg-primary-600 text-white rounded-md disabled:opacity-50 hover:bg-primary-700 transition"
                            >
                                Multiple Delete
                            </button>

                            <!-- Add Indigency Button (styled like Filament's primary button) -->
                            <button
                                onclick="openAddIndigency()"
                                class="px-4 py-2 bg-primary-600 text-white rounded-md hover:bg-primary-700 transition"
                            >
                                Add Indigency
                            </button>

                        </div>
                    </div>

                    <!-- Table -->
                    <div class="h-full overflow-y-auto rounded">
                        <table class="w-full text-sm text-left">
                            <thead class="bg-gray-100 dark:bg-gray-800 dark:text-white uppercase sticky top-0 z-10 whitespace-nowrap">
                                <tr>
                                    <th class="px-4 py-2"><input type="checkbox" id="selectAll"
                                            onchange="toggleSelectAll(this)"></th>
                                    <th class="px-4 py-2">Name</th>
                                    <th class="px-4 py-2">Email Address</th>
                                    <th class="px-4 py-2">Address</th>
                                    <th class="px-4 py-2">Purpose</th>
                                    <th class="px-4 py-2">Childs Name</th>
                                    <th class="px-4 py-2">Age</th>
                                    <th class="px-4 py-2">Referal Number</th>
                                    <th class="px-4 py-2">Date</th>
                                    <th class="px-4 py-2">Status</th>
                                    <th class="px-4 py-2">Approved</th>
                                    <th class="px-4 py-2">Action</th>
                                </tr>
                            </thead>
                            <tbody id="indigencyTableBody" class="divide-y divide-gray-200 dark:divide-gray-700 whitespace-nowrap text-gray-800 dark:text-gray-100"></tbody>
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
    <div id="certificationModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden"
        style="
            position: fixed;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 50;
            align-items: center;
            justify-content: center;
        ">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-xl p-6 relative">
            <h2 id="modalTitle" class="text-xl font-bold mb-4 text-black" style="color: black;">Add Indigency</h2>

            <form id="indigencyForm" onsubmit="submitIndigency(event)" class="space-y-4" style="color: black;">
                @csrf

                <!-- Parent Name -->
                <div>
                    <label for="parent_name" class="block text-sm font-medium text-gray-700">Name:</label>
                    <input type="text" id="parent_name" name="parent_name"
                        class="mt-1 block w-full rounded-md border-gray-300 text-black shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        required />
                </div>

                <!-- Email Address -->
                <div>
                    <label for="indigency_email" class="block text-sm font-medium text-gray-700">Email Address:</label>
                    <input type="email" id="indigency_email" name="indigency_email"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
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

                {{-- Indigency Generator --}}
                <div>
                    <label class="block mb-1 font-medium text-sm text-gray-700">Referal Number:</label>
                    <input type="text" id="indigency_generated_number" name="indigency_generated_number" class="w-full border border-gray-300 rounded p-2 bg-gray-100 cursor-not-allowed" readonly>
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
    <div id="confirmationModal" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50 hidden"
        style="
            position: fixed;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 50;
            align-items: center;
            justify-content: center;
        ">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full p-6">
            <h2 id="confirmationTitle" class="text-lg font-semibold mb-2" style="color: black;">Confirm Action</h2>
            <p id="confirmationMessage" class="text-sm text-gray-600 mb-4">Are you sure you want to perform this action?</p>
            <div class="flex justify-end space-x-2">
                <button id="cancelConfirmBtn" class="px-4 py-2 text-gray-600 hover:text-black bg-gray-200 rounded">
                    Cancel
                </button>
                <button id="confirmActionBtn" class="px-4 py-2 text-white bg-primary-600 hover:bg-primary-700 rounded" style="margin-left: 8px;">
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
            const title = document.getElementById('modalTitle');
            if (title) title.innerText = 'Add Indigency';

            const submitBtn = document.getElementById('btnSubmitIndigency');
            if (submitBtn) submitBtn.innerText = 'Submit';

            // Clear form fields manually
            window.indigencyModal.fieldIds.forEach(field => {
                const input = document.getElementById(field);
                if (input) input.value = '';
            });

            // Auto-generate the generated_number safely
            const generatedNumber = generateIndigencyNumber();

            const genNumInput = document.querySelector('[name="generated_number"]');
            if (genNumInput) {
                genNumInput.value = generatedNumber;
            }

            const finalGenInput = document.getElementById('indigency_generated_number');
            if (finalGenInput) {
                finalGenInput.value = generatedNumber;
            }

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
                                <td colspan="11" class="text-center bg-gray-200 text-gray-500 py-4">No records found.</td>
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
                    row.classList.add('bg-primary-500', 'cursor-pointer');
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
                    <td class="px-4 py-2">${item.childs_name}</td>
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
                const isNotApproved = item.approved_by == 0 || item.approved_by === '0' || item.approved_by === null || item.approved_by === undefined || item.approved_by === '' || item.approved_by === 'NULL';

                if (item.status === 1 && isNotApproved) {
                    return `
                        <button onclick="event.stopPropagation(); approveIndigency(${item.id})"
                            class="bg-green-500 border white rounded p-2 d-flex align-items-center justify-content-center"
                            title="Approve">
                            <i class="bi bi-check-circle-fill dark:text-white text-md"></i>
                        </button>
                    `;
                }

                if (item.status === 1) {
                    return `
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

                // If soft deleted or other cases
                return `
                    <button onclick="event.stopPropagation(); restoreIndigency(${item.id})"
                        class="bg-green-500 border white rounded p-2 d-flex align-items-center justify-content-center" title="Restore">
                        <i class="bi bi-arrow-counterclockwise dark:text-white text-md"></i>
                    </button>
                `;
            }
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

        // Pagination component
        function Pagination({ currentPage, totalPages, totalData, perPage, namespace }) {
            const pagesPerGroup = 5;
            const startPage = Math.floor((currentPage - 1) / pagesPerGroup) * pagesPerGroup + 1;
            const endPage = Math.min(startPage + pagesPerGroup - 1, totalPages);
            const nextSetStart = Math.min(startPage + pagesPerGroup, totalPages);
            const prevSetStart = Math.max(startPage - pagesPerGroup, 1);
            const perPageId = `${namespace}_per_page`;

            return `
                <div class="flex flex-col sm:flex-row items-center justify-between gap-4 px-4 py-2">
                    <div class="flex items-center text-sm text-black dark:text-white">
                        <label for="${perPageId}" class="mr-2">Show</label>
                        <select id="${perPageId}" class="border border-gray-300 rounded px-6 py-1 text-black dark:text-white bg-white dark:bg-gray-800" data-namespace="${namespace}" style="margin-left: 6px; margin-right: 6px;">
                            <option value="10" ${perPage == 10 ? 'selected' : ''}>10</option>
                            <option value="25" ${perPage == 25 ? 'selected' : ''}>25</option>
                            <option value="50" ${perPage == 50 ? 'selected' : ''}>50</option>
                            <option value="100" ${perPage == 100 ? 'selected' : ''}>100</option>
                        </select>
                        <span class="ml-2">entries</span>
                    </div>

                    <div class="flex flex-wrap items-center justify-center gap-1">
                        ${startPage > 1
                            ? `<button onclick="changePage('${namespace}', ${prevSetStart})" class="px-3 py-1 border rounded-md text-gray-700 bg-white hover:bg-gray-100 text-lg">«</button>`
                            : `<span class="px-3 py-1 text-gray-400 border rounded-md cursor-not-allowed text-lg">«</span>`}

                        ${currentPage > 1
                            ? `<button onclick="changePage('${namespace}', ${currentPage - 1})" class="px-3 py-1 border rounded-md text-gray-700 bg-white hover:bg-gray-100 text-lg">‹</button>`
                            : `<span class="px-3 py-1 text-gray-400 border rounded-md cursor-not-allowed text-lg">‹</span>`}

                        ${Array.from({ length: endPage - startPage + 1 }, (_, i) => {
                            const pageNum = startPage + i;
                            return `
                                <button onclick="changePage('${namespace}', ${pageNum})"
                                    class="px-3 py-2 text-sm rounded-md border shadow-sm transition-all duration-200 ${
                                        currentPage === pageNum ? 'bg-primary-500 text-white' : 'text-gray-700 bg-white hover:bg-primary-500'
                                    }">
                                    ${pageNum}
                                </button>
                            `;
                        }).join('')}

                        ${currentPage < totalPages
                            ? `<button onclick="changePage('${namespace}', ${currentPage + 1})" class="px-3 py-1 border rounded-md text-gray-700 bg-white hover:bg-gray-100 text-lg">›</button>`
                            : `<span class="px-3 py-1 text-gray-400 border rounded-md cursor-not-allowed text-lg">›</span>`}

                        ${endPage < totalPages
                            ? `<button onclick="changePage('${namespace}', ${nextSetStart})" class="px-3 py-1 border rounded-md text-gray-700 bg-white hover:bg-gray-100 text-lg">»</button>`
                            : `<span class="px-3 py-1 text-gray-400 border rounded-md cursor-not-allowed text-lg">»</span>`}
                    </div>
                </div>
            `;
        }
    </script>
    @endpush
</div>
