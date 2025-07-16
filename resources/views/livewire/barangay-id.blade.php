<div>
    <x-slot name="header">
        <div class="flex items-center space-x-2">
            <div class="p-3 bg-white dark:bg-gray-800 rounded-md shadow-md">
                <i class="bi bi-file-earmark-text text-[#1B76B5] text-xl dark:text-white"></i>
            </div>
            <div>
                <h1 class="text-lg font-semibold text-gray-800 dark:text-white">Barangay ID</h1>
                <p class="text-sm text-gray-500 dark:text-gray-300">View submitted Barangay ID requests</p>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-900 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="bg-white dark:bg-gray-900 rounded-lg shadow-sm p-6">
                    <div class="flex justify-between mb-4 flex-wrap gap-2">
                        <!-- Left: Search -->
                        <div class="text-left">
                            <input
                                id="searchInput"
                                type="text"
                                placeholder="Search residence"
                                class="w-full sm:w-60 px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-800 dark:text-white"
                            />
                        </div>

                        <!-- Right: Buttons -->
                        <div class="text-right space-x-2">
                            <button id="multiDeleteBtn"
                                class="px-4 py-2 bg-primary-600 text-white rounded-md disabled:opacity-50 hover:bg-primary-700 transition"
                                onclick="deleteSelectedBarangayId()" disabled>
                                Multiple Delete
                            </button>

                            <button onclick="openAddBarangayId()"
                                class="px-4 py-2 bg-primary-600 text-white rounded-md hover:bg-primary-700 transition">
                                Add Barangay ID
                            </button>
                        </div>
                    </div>

                    <!-- Table -->
                    <div class="h-full overflow-y-auto rounded">
                        <table class="w-full text-sm text-left">
                            <thead class="bg-gray-100 dark:bg-gray-800 dark:text-white uppercase sticky top-0 z-10 whitespace-nowrap">
                                <tr>
                                    <th class="px-4 py-2">
                                        <input type="checkbox" id="selectAll" onchange="toggleSelectAll(this)">
                                    </th>
                                    <th class="px-4 py-2">Full Name</th>
                                    <th class="px-4 py-2">Email Address</th>
                                    <th class="px-4 py-2">Address</th>
                                    <th class="px-4 py-2">Birthdate</th>
                                    <th class="px-4 py-2">Place of Birth</th>
                                    <th class="px-4 py-2">Age</th>
                                    <th class="px-4 py-2">Citizenship</th>
                                    <th class="px-4 py-2">Gender</th>
                                    <th class="px-4 py-2">Civil Status</th>
                                    <th class="px-4 py-2">Contact No.</th>
                                    <th class="px-4 py-2">Guardian</th>
                                    <th class="px-4 py-2">Referal Number</th>
                                    <th class="px-4 py-2">Approval</th>
                                    <th class="px-4 py-2">Approved By</th>
                                    <th class="px-4 py-2">Status</th>
                                    <th class="px-4 py-2">Action</th>
                                </tr>
                            </thead>
                            <tbody id="barangayIdTableBody" class="divide-y divide-gray-200 dark:divide-gray-700 whitespace-nowrap text-gray-800 dark:text-gray-100">
                            </tbody>
                        </table>
                    </div>

                    <div id="paginationControls" class="mt-4 border-t dark:border-gray-700"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Toast Container -->
    <div id="toast-container" class="fixed top-4 right-4 z-50 space-y-2"></div>

    {{-- Modal --}}
    <!-- Barangay ID Form Modal -->
    <div id="barangayIdModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center"
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
        <div class="bg-white border border-gray-300 rounded-lg shadow-lg w-full max-w-2xl flex flex-col max-h-[90vh] overflow-hidden"
            style="overflow: auto;
            display: flex;
            flex-direction: column;
            flex: 1 1 0%;
            height: 90vh;
            margin-top: 1rem; ">

            <!-- Header -->
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold uppercase">Barangay ID Form</h2>
            </div>

            <!-- Form Body -->
            <form id="barangayIdForm" onsubmit="submitBarangayIdForm(event)" class="overflow-y-auto px-6 py-4 flex-1 white" style="color: black;">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block mb-1 font-medium text-sm text-gray-700">Full Name</label>
                        <input type="text" name="barangayId_full_name" class="w-full border border-gray-300 rounded p-2" required>
                    </div>
                    <div>
                        <label for="barangayId_email" class="block text-sm font-medium text-gray-700">Email Address:</label>
                        <input type="email" id="barangayId_email" name="barangayId_email"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            required />
                    </div>
                    <div>
                        <label class="block mb-1 font-medium text-sm text-gray-700">Address</label>
                        <input type="text" name="barangayId_address" class="w-full border border-gray-300 rounded p-2" required>
                    </div>
                    <div>
                        <label class="block mb-1 font-medium text-sm text-gray-700">Birthdate</label>
                        <input type="date" id="barangayId_birthdate" name="barangayId_birthdate" class="w-full border border-gray-300 rounded p-2" required>
                    </div>
                    <div>
                        <label class="block mb-1 font-medium text-sm text-gray-700">Place of Birth</label>
                        <input type="text" name="barangayId_place_of_birth" class="w-full border border-gray-300 rounded p-2" required>
                    </div>
                    <div>
                        <label class="block mb-1 font-medium text-sm text-gray-700">Age
                            <span class="italic text-gray-500 text-xs">(150 maximum age range)</span>
                        </label>
                        <input type="number" id="barangayId_age" name="barangayId_age" min="1" max="150"
                        oninput="if (this.value > 150) this.value = 150; if (this.value < 1) this.value = '';" name="barangayId_age" class="w-full border border-gray-300 rounded p-2" required>
                    </div>
                    <div>
                        <label class="block mb-1 font-medium text-sm text-gray-700">Citizenship</label>
                        <input type="text" name="barangayId_citizenship" class="w-full border border-gray-300 rounded p-2" required>
                    </div>
                    <div>
                        <label class="block mb-1 font-medium text-sm text-gray-700">Gender</label>
                        <select name="barangayId_gender" class="w-full border border-gray-300 rounded p-2" required>
                            <option value="">Select Gender</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                    <div>
                        <label class="block mb-1 font-medium text-sm text-gray-700">Civil Status</label>
                        <input type="text" name="barangayId_civil_status" class="w-full border border-gray-300 rounded p-2" required>
                    </div>

                    <div>
                        <label class="block mb-1 font-medium text-sm text-gray-700">Contact No.</label>
                        <input
                            type="tel"
                            name="barangayId_contact_no"
                            id="barangayId_contact_no"
                            class="w-full border border-gray-300 rounded p-2"
                            required
                            maxlength="11"
                            pattern="[0-9]*"
                            inputmode="numeric"
                            oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                            placeholder="Enter numbers only"
                        >
                    </div>

                    <div>
                        <label class="block mb-1 font-medium text-sm text-gray-700">Guardian
                            <span class="italic text-gray-500 text-xs">(If age > 17, make the field editable.)</span>
                        </label>
                        <input type="text" id="barangayId_guardian" name="barangayId_guardian" class="w-full border border-gray-300 rounded p-2 bg-gray-100 cursor-not-allowed" readonly required>
                    </div>
                    <div>
                        <label class="block mb-1 font-medium text-sm text-gray-700">Referal Number</label>
                        <input type="text" id="barangayId_generated_number" name="barangayId_generated_number" class="w-full border border-gray-300 rounded p-2 bg-gray-100 cursor-not-allowed" readonly>
                    </div>
                    <div>
                        <label class="block mb-1 font-medium text-sm text-gray-700">Image</label>
                        <input type="file" name="barangayId_image" accept="image/*" class="w-full border border-gray-300 rounded p-2" required>

                        <!-- Preview for existing image -->
                        <div id="imagePreviewContainer" class="mt-2">
                            <img id="imagePreview" src="" alt="Current Image" class="w-24 h-24 object-cover rounded hidden">
                        </div>
                    </div>
                </div>
            </form>

            <!-- Footer -->
            <div class="px-6 py-4 border-t border-gray-200 flex justify-end space-x-2">
                <button type="button" onclick="closeModal('barangayIdModal')" class="px-4 py-2 text-gray-600 hover:text-black bg-gray-200 rounded">Cancel</button>
                <button type="submit" form="barangayIdForm" id="btnSubmitBarangayId" class="px-4 py-2 bg-primary-600 text-white rounded hover:bg-primary-700" style="margin-left: 8px;">Submit</button>
            </div>
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

    <!-- Approval Confirmation Modal for approved ID -->
    <div id="approvedIdModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center"
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
        <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6 relative">
            <h2 class="text-lg font-semibold mb-4" style="color: black;">Approve Barangay ID</h2>
            <p class="mb-6 text-gray-700">Are you sure you want to approve this Barangay ID?</p>
            <div class="flex justify-end space-x-2" style="margin-top: 12px;">
                <button onclick="closeModal('approvedIdModal')" class="px-4 py-2 text-gray-600 hover:text-black bg-gray-200 rounded">Cancel</button>
                <button onclick="confirmApproveBarangayId()" class="px-4 py-2 bg-primary-600 text-white rounded hover:bg-primary-700" style="margin-left: 8px;">Approve</button>
            </div>
        </div>
    </div>

    {{-- Scripts --}}
    @push('scripts')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
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

                if (!isNaN(age) && age <= 17) {
                    guardianInput.readOnly = true;
                    guardianInput.classList.add('bg-gray-100', 'cursor-not-allowed');
                    guardianInput.value = ''; // Optional clear
                } else if (!isNaN(age) && age > 17) {
                    guardianInput.readOnly = false;
                    guardianInput.classList.remove('bg-gray-100', 'cursor-not-allowed');
                }
            };

            // Remove old listener before adding new one (if reusing modal)
            ageInput.removeEventListener('input', handleGuardianField);
            ageInput.addEventListener('input', handleGuardianField);

            handleGuardianField(); // run on load
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
                axios.get(`/getBarangayIdList?per_page=${this.perPage}&page=${this.currentPage}`)
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
                    row.classList.add('cursor-pointer');
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
                    <td class="px-4 py-2">${item.generated_number}</td>
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
                const isNotApproved = item.approved_by == 0 || item.approved_by === '0' || item.approved_by === null || item.approved_by === undefined || item.approved_by === '' || item.approved_by === 'NULL';

                if (item.status === 1 && isNotApproved) {
                    return `
                        <button onclick="event.stopPropagation(); approveBarangayId(${item.id})"
                            class="bg-green-500 border white rounded p-2 d-flex align-items-center justify-content-center"
                            title="Approve">
                            <i class="bi bi-check-circle-fill dark:text-white text-md"></i>
                        </button>
                    `;
                }

                if (item.status === 1) {
                    return `
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

                // If soft deleted or other cases
                return `
                    <button onclick="event.stopPropagation(); restoreBarangayId(${item.id})"
                        class="bg-green-500 border white rounded p-2 d-flex align-items-center justify-content-center" title="Restore">
                        <i class="bi bi-arrow-counterclockwise dark:text-white text-md"></i>
                    </button>
                `;
            }
        };

        // Edit for residency
        function editBarangayId(id) {
            axios.get(`/getBarangayIdInformation/${id}`)
                .then(response => {
                    const data = response.data;
                    const form = document.getElementById('barangayIdForm');

                    // Clear any previous error classes
                    form.querySelectorAll('.border-red-500').forEach(el => {
                        el.classList.remove('border-red-500');
                    });

                    // Populate form fields
                    window.barangayIdModal.fieldIds.forEach(field => {
                        const input = form.querySelector(`[name="${field}"]`);
                        if (!input) return;

                        if (input.type === 'file') {
                            // Skip file input
                        } else if (input.type === 'date' && data[field]) {
                            input.value = new Date(data[field]).toISOString().split('T')[0];
                        } else {
                            input.value = data[field] || '';
                        }
                    });

                    // Handle image preview
                    const imagePreview = document.getElementById('imagePreview');
                    if (imagePreview && data.barangayId_image) {
                        imagePreview.src = `/barangayId/${data.barangayId_image}`;
                        imagePreview.classList.remove('hidden');
                    }

                    // Make image input not required for edits
                    const imageInput = form.querySelector('[name="barangayId_image"]');
                    if (imageInput) {
                        imageInput.removeAttribute('required');
                    }

                    // Set edit ID and update UI
                    window.barangayIdModal.editId = id;
                    document.getElementById('btnSubmitBarangayId').textContent = 'Update';
                    setupGuardianReadonly();
                    openModal('barangayIdModal');
                })
                .catch(error => {
                    console.error('Error fetching data:', error);
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
    </script>
    @endpush
</div>
