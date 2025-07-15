<div>
    <x-slot name="header">
        <div class="flex items-center space-x-2">
            <div class="p-3 bg-white rounded-md shadow-md">
                <i class="bi bi-file-earmark-text text-[#1B76B5] text-xl"></i>
            </div>
            <div>
                <h1 class="text-lg font-semibold">Barangay Clearance</h1>
                <p class="text-sm text-gray-500">View submitted Clearance requests</p>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden shadow-sm sm:rounded-lg">
                <div class="rounded-lg shadow-sm p-6">
                    <div class="flex justify-between mb-4 flex-wrap gap-2">
                        <!-- Left: Search -->
                        <div class="text-left">
                            <x-search-input id="searchInput" placeholder="Search indigency" class="w-full sm:w-60 text-black" />
                        </div>

                        <!-- Right: Buttons -->
                        <div class="text-right space-x-2">
                            <x-danger-button id="multiDeleteBtn" class="whitespace-nowrap disabled:opacity-50"
                                onclick="deleteSelectedClearance()" disabled>
                                Multiple Delete
                            </x-danger-button>

                            <x-primary-button onclick="openAddClearance()">
                                Add Clearance
                            </x-primary-button>
                        </div>
                    </div>

                    <!-- Table -->
                    <div class="h-full overflow-y-auto rounded">
                        <table class="w-full text-sm text-left">
                            <thead class="bg-gray-100 text-gray-600 uppercase sticky top-0 z-10 whitespace-nowrap">
                                <tr>
                                    <th class="px-4 py-2"><input type="checkbox" id="selectAll" onchange="toggleSelectAll(this)"></th>
                                    <th class="px-4 py-2">Full Name</th>
                                    <th class="px-4 py-2">Birthdate</th>
                                    <th class="px-4 py-2">Age</th>
                                    <th class="px-4 py-2">Gender</th>
                                    <th class="px-4 py-2">Civil Status</th>
                                    <th class="px-4 py-2">Citizenship</th>
                                    <th class="px-4 py-2">Occupation</th>
                                    <th class="px-4 py-2">Contact</th>
                                    <th class="px-4 py-2">House No.</th>
                                    <th class="px-4 py-2">Purok</th>
                                    <th class="px-4 py-2">Barangay</th>
                                    <th class="px-4 py-2">Municipality</th>
                                    <th class="px-4 py-2">Province</th>
                                    <th class="px-4 py-2">Purpose</th>
                                    <th class="px-4 py-2">Status</th>
                                    <th class="px-4 py-2">Approval</th>
                                    <th class="px-4 py-2">Action</th>
                                </tr>
                            </thead>
                            <tbody id="clearanceTableBody" class="divide-y divide-gray-200 whitespace-nowrap"></tbody>
                        </table>
                    </div>
                    <div id="paginationControls" class="mt-4"></div>
                </div>
            </div>
        </div>
    </div>
    <!-- Toast Container -->
    <div id="toast-container" class="fixed top-4 right-4 z-50 space-y-2"></div>

    {{-- Momdal --}}
    <!-- Confirmation Modal -->
    <div id="confirmationModal" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full p-6">
            <h2 id="confirmationTitle" class="text-lg font-semibold mb-2">Confirm Action</h2>
            <p id="confirmationMessage" class="text-sm text-gray-600 mb-4">Are you sure you want to perform this action?</p>
            <div class="flex justify-end space-x-2">
                <button id="cancelConfirmBtn" class="px-4 py-2 text-gray-600 hover:text-black bg-gray-200 rounded">
                    Cancel
                </button>
                <button id="confirmActionBtn" class="px-4 py-2 text-white bg-red-600 hover:bg-red-700 rounded">
                    Confirm
                </button>
            </div>
        </div>
    </div>

    {{-- Barangay Clearance --}}
    <div id="clearancenModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden">
        <div class="bg-white w-full max-w-4xl rounded-lg shadow-lg flex flex-col max-h-[90vh]">
            <!-- Header -->
            <div class="px-6 pt-6">
                <h2 id="modalTitle" class="text-start text-xl font-bold text-gray-800">
                    Barangay Clearance Application Form
                </h2>
            </div>

            <!-- Scrollable Body -->
            <div class="overflow-y-auto px-6 py-4 space-y-6 flex-1 text-black">
                <form id="clearanceForm" class="space-y-6">
                    @csrf
                    <!-- Personal Information -->
                    <div>
                        <h3 class="mb-4 border-b pb-2 text-lg font-semibold text-gray-700">Personal Information</h3>
                        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                            <!-- Inputs -->
                            <div>
                                <label for="full_name" class="block font-medium">Full Name</label>
                                <input type="text" id="full_name" name="full_name"
                                    class="mt-1 w-full rounded border px-3 py-2" required />
                            </div>
                            <div>
                                <label for="birthdate" class="block font-medium">Date of Birth</label>
                                <input type="date" id="birthdate" name="birthdate"
                                    class="mt-1 w-full rounded border px-3 py-2" required />
                            </div>
                            <div>
                                <label for="age" class="block font-medium">Age:
                                    <span class="italic text-gray-500 text-xs">(150 maximum age range)</span>
                                </label>
                                <input type="number" id="clearance_age" name="clearance_age" min="1" max="150"
                                    oninput="if (this.value > 150) this.value = 150; if (this.value < 1) this.value = '';"
                                    class="mt-1 w-full rounded border px-3 py-2"
                                    required />
                            </div>
                            <div>
                                <label for="gender" class="block font-medium">Sex / Gender</label>
                                <select id="gender" name="gender"
                                    class="mt-1 w-full rounded border px-3 py-2" required>
                                    <option value="">Select Gender</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </div>
                            <div>
                                <label for="civil_status" class="block font-medium">Civil Status</label>
                                <select id="civil_status" name="civil_status"
                                    class="mt-1 w-full rounded border px-3 py-2">
                                    <option value="">Select Status</option>
                                    <option value="Single">Single</option>
                                    <option value="Married">Married</option>
                                    <option value="Widowed">Widowed</option>
                                    <option value="Separated">Separated</option>
                                </select>
                            </div>
                            <div>
                                <label for="citizenship" class="block font-medium">Citizenship</label>
                                <input type="text" id="citizenship" name="citizenship"
                                    class="mt-1 w-full rounded border px-3 py-2" />
                            </div>
                            <div>
                                <label for="occupation" class="block font-medium">Occupation</label>
                                <input type="text" id="occupation" name="occupation"
                                    class="mt-1 w-full rounded border px-3 py-2" />
                            </div>
                            <div>
                                <label for="contact" class="block font-medium">Contact Number</label>
                                <input type="text" id="contact" name="contact"
                                    class="mt-1 w-full rounded border px-3 py-2" />
                            </div>
                        </div>
                    </div>

                    <!-- Address -->
                    <div>
                        <h3 class="mb-4 border-b pb-2 text-lg font-semibold text-gray-700">Address</h3>
                        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                            <div>
                                <label for="house_no" class="block font-medium">House No. / Street</label>
                                <input type="text" id="house_no" name="house_no"
                                    class="mt-1 w-full rounded border px-3 py-2" />
                            </div>
                            <div>
                                <label for="purok" class="block font-medium">Purok / Zone</label>
                                <input type="text" id="purok" name="purok"
                                    class="mt-1 w-full rounded border px-3 py-2" />
                            </div>
                            <div>
                                <label for="barangay" class="block font-medium">Barangay</label>
                                <input type="text" id="barangay" name="barangay"
                                    class="mt-1 w-full rounded border px-3 py-2" value="Panipuan" />
                            </div>
                            <div>
                                <label for="municipality" class="block font-medium">City / Municipality</label>
                                <input type="text" id="municipality" name="municipality"
                                    class="mt-1 w-full rounded border px-3 py-2" value="San Fernando" />
                            </div>
                            <div>
                                <label for="province" class="block font-medium">Province</label>
                                <input type="text" id="province" name="province"
                                    class="mt-1 w-full rounded border px-3 py-2" value="Pampanga" />
                            </div>
                        </div>
                    </div>

                    <!-- Purpose -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-700">Purpose</h3>
                        <textarea id="clearance_purpose" name="clearance_purpose" rows="4"
                            class="w-full rounded border px-3 py-2 resize-none"
                            placeholder="State the reason for requesting the Barangay Clearance..." required></textarea>
                    </div>
                </form>
            </div>

            <!-- Footer -->
            <div class="border-t px-6 py-4 flex justify-end gap-2">
                <button type="button" id="btnCancelClearance" onclick="closeModal('clearancenModal')"
                    class="rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-100">
                    Cancel
                </button>
                <button type="button" id="btnSubmitClearance" onclick="window.clearanceModal.submit(event)"
                    class="rounded-md bg-[#1B76B5] px-4 py-2 text-sm font-semibold text-white shadow-sm transition duration-150 hover:bg-[#225981]">
                    Submit Application
                </button>
            </div>
        </div>
    </div>

    @push('scripts')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
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
                            : `<tr><td colspan="18" class="text-center bg-gray-200 text-gray-500 py-4">No records found.</td></tr>`;

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

                // Determine background and text color
                let bgColor = '';
                let textColor = 'text-black'; // Default

                if (item.status === 0) {
                    bgColor = 'bg-red-100';
                    textColor = 'text-red-800';
                } else if (item.clearance_age >= 1 && item.clearance_age <= 17) {
                    bgColor = 'bg-yellow-100';
                    textColor = 'text-gray-800';
                } else {
                    bgColor = 'hover:bg-gray-700';
                    textColor = 'text-black dark:text-white';
                }

                row.className = `${bgColor} ${textColor} cursor-pointer`;
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
                        ${item.status === 0
                            ? '<span class="inline-block px-2 py-1 text-xs font-semibold text-red-700 bg-red-100 rounded">Deleted</span>'
                            : item.approved === 1
                            ? '<span class="inline-block px-2 py-1 text-xs font-semibold text-green-700 bg-green-100 rounded">Approved</span>'
                            : '<span class="inline-block px-2 py-1 text-xs font-semibold text-yellow-700 bg-yellow-100 rounded">Not Approved</span>'
                        }
                    </td>
                    <td class="px-4 py-2 d-flex gap-2 whitespace-nowrap" id="actions-${item.id}">
                        ${this.getActionButtons(item, isForApproval, textColor)}
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

            getActionButtons(item, isForApproval, textColor = 'text-black') {
                if (isForApproval) {
                    return `
                        <button onclick="event.stopPropagation(); approveClearance(${item.id})"
                            class="btn btn-success border bg-green-500 rounded p-1.5 d-flex align-items-center justify-content-center" title="Approve">
                            <i class="bi bi-check-circle text-white text-md"></i>
                        </button>`;
                } else if (item.status === 1) {
                    return `
                        <button onclick="event.stopPropagation(); editClearance(${item.id})"
                            class="btn btn-light border rounded p-2 d-flex align-items-center justify-content-center" title="Edit">
                            <i class="bi bi-pencil-square ${textColor}"></i>
                        </button>
                        <button onclick="event.stopPropagation(); deleteClearance(${item.id})"
                            class="btn btn-light border rounded p-2 d-flex align-items-center justify-content-center" title="Delete">
                            <i class="bi bi-trash-fill ${textColor.includes('gray') ? 'text-gray-800' : 'text-red-600'}"></i>
                        </button>
                        <button onclick="window.open('/clearance/pdf/${item.id}', '_blank')"
                            class="btn btn-light border rounded p-2 d-flex align-items-center justify-content-center" title="View PDF">
                            <i class="bi bi-file-earmark-pdf ${textColor.includes('gray') ? 'text-gray-800' : 'text-red-600'}"></i>
                        </button>`;
                } else {
                    return `
                        <button onclick="event.stopPropagation(); restoreClearance(${item.id})"
                            class="bg-green-500 border rounded p-2 d-flex align-items-center justify-content-center" title="Restore">
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

        // Pagination format
        function Pagination({ currentPage, totalPages, totalData, perPage, namespace }) {
            const pagesPerGroup = 5;
            const startPage = Math.floor((currentPage - 1) / pagesPerGroup) * pagesPerGroup + 1;
            const endPage = Math.min(startPage + pagesPerGroup - 1, totalPages);
            const nextSetStart = Math.min(startPage + pagesPerGroup, totalPages);
            const prevSetStart = Math.max(startPage - pagesPerGroup, 1);
            const perPageId = `${namespace}_per_page`;

            return `
                <div class="flex flex-col sm:flex-row items-center justify-between gap-4 px-4 py-2 text-white">
                    <div class="flex items-center text-sm">
                        <label for="${perPageId}" class="mr-2">Show</label>
                        <select id="${perPageId}" class="border border-gray-300 rounded px-6 py-1 text-black" data-namespace="${namespace}">
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
                                        currentPage === pageNum ? 'bg-[#1B76B5] text-white' : 'text-gray-700 bg-white hover:bg-gray-100'
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
    @endpush
</div>
