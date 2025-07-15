<div>
    <x-slot name="header">
        <div class="flex items-center space-x-2">
            <div class="p-3 bg-white dark:bg-gray-800 rounded-md shadow-md">
                <i class="bi bi-file-earmark-text text-[#1B76B5] text-xl"></i>
            </div>
            <div>
                <h1 class="text-lg font-semibold text-gray-800 dark:text-white">Residence Certification</h1>
                <p class="text-sm text-gray-500 dark:text-gray-400">View submitted Residence requests</p>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-900 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="bg-white dark:bg-gray-900 rounded-lg shadow-sm p-6">
                    <div class="flex justify-between mb-4 flex-wrap gap-2">
                        <!-- Left: Search Input -->
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
                            <button
                                id="deleteSelectedBtn"
                                onclick="deleteSelectedResidencies()"
                                disabled
                                class="px-4 py-2 bg-primary-600 text-white rounded-md disabled:opacity-50 hover:bg-primary-700 transition"
                                >
                                Multiple Delete
                            </button>

                            <button
                                onclick="openAddResidency()"
                                class="px-4 py-2 bg-primary-600 text-white rounded-md hover:bg-primary-700 transition"
                            >
                                Add Residence
                            </button>
                        </div>
                    </div>

                    <!-- Table -->
                    <div class="h-full overflow-y-auto rounded">
                        <table class="w-full text-sm text-left">
                            <thead class="bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-300 uppercase sticky top-0 z-10 whitespace-nowrap">
                                <tr>
                                    <th class="px-4 py-2"><input type="checkbox" id="selectAll" onchange="toggleSelectAll(this)"></th>
                                    <th class="px-4 py-2">Parent Name</th>
                                    <th class="px-4 py-2">Email Address</th>
                                    <th class="px-4 py-2">Age</th>
                                    <th class="px-4 py-2">Civil Status</th>
                                    <th class="px-4 py-2">Nationality</th>
                                    <th class="px-4 py-2">Address</th>
                                    <th class="px-4 py-2">Criminal Record</th>
                                    <th class="px-4 py-2">Approved By</th>
                                    <th class="px-4 py-2">Purpose</th>
                                    <th class="px-4 py-2">Certificate #</th>
                                    <th class="px-4 py-2">Zip Code</th>
                                    <th class="px-4 py-2">Precinct Number</th>
                                    <th class="px-4 py-2">Status</th>
                                    <th class="px-4 py-2">Issued Date</th>
                                    <th class="px-4 py-2">Barangay</th>
                                    <th class="px-4 py-2">Municipality</th>
                                    <th class="px-4 py-2">Province</th>
                                    <th class="px-4 py-2">Action</th>
                                </tr>
                            </thead>
                            <tbody id="residenceTableBody" class="divide-y divide-gray-200 dark:divide-gray-700 whitespace-nowrap text-gray-800 dark:text-gray-100">
                                <!-- Populated by JS -->
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div id="paginationControls" class="mt-4 border-t dark:border-gray-700"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Toast Container -->
    <div id="toast-container" class="fixed top-4 right-4 z-50 space-y-2"></div>

    {{-- Modal --}}
    <!-- Residency Certificate Modal -->
    <div id="residencyModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden"
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
        <div class="bg-white rounded-lg shadow-xl w-full max-w-2xl h-[90vh] flex flex-col relative"
            style="overflow: auto;
            display: flex;
            flex-direction: column;
            flex: 1 1 0%;
            height: 90vh;
            margin-top: 1rem; ">

            <!-- Modal Header -->
            <div class="p-6 border-b flex-shrink-0">
                <h2 id="modalTitle" class="text-xl font-bold">Certificate of Residency</h2>
            </div>

            <!-- Scrollable Form Body -->
            <form id="residencyForm" onsubmit="submitResidency(event)" class="overflow-y-auto px-6 py-4 space-y-4 flex-1" style="color: black;">
                @csrf

                <!-- Resident Name -->
                <div>
                    <label for="resident_name" class="block text-sm font-medium text-gray-700">Resident Name:</label>
                    <input type="text" id="resident_name" name="resident_name"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        required />
                </div>

                <!-- Email Address -->
                <div>
                    <label for="resident_email_address" class="block text-sm font-medium text-gray-700">Email Address:</label>
                    <input type="email" id="resident_email_address" name="resident_email_address"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        required />
                </div>

                <!-- Voters Number -->
                <div>
                    <label for="voters_id_pre_number" class="block text-sm font-medium text-gray-700">
                        Voter's ID / Present Number:
                    </label>
                    <input type="text" id="voters_id_pre_number" name="voters_id_pre_number"
                        pattern="[A-Za-z0-9]+" title="Letters and numbers only"
                        oninput="this.value = this.value.replace(/[^a-zA-Z0-9]/g, '')"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        required />
                </div>

                <!-- Zip Code -->
                <div>
                    <label for="zip_code" class="block text-sm font-medium text-gray-700">
                        Zip Code
                    </label>
                <input type="text" name="zip_code" id="zip_code" value="2000"
                        oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                        style="cursor: not-allowed;""
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 cursor-not-allowed bg-gray-100"
                        required readonly />
                </div>

                <!-- Resident Age -->
                <div>
                    <label for="resident_age" class="block text-sm font-medium text-gray-700">Age:
                        <span class="italic text-gray-500 text-xs">(150 maximum age range)</span>
                    </label>
                    <input type="number" id="resident_age" name="resident_age" min="1" max="150"
                        oninput="if (this.value > 150) this.value = 150; if (this.value < 1) this.value = '';"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        required />
                </div>

                <!-- Civil Status -->
                <div>
                    <label for="civil_status" class="block text-sm font-medium text-gray-700">Civil Status:</label>
                    <select id="civil_status" name="civil_status"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        required>
                        <option value="" disabled selected>Select Civil Status</option>
                        <option value="single">Single</option>
                        <option value="married">Married</option>
                        <option value="widowed">Widowed</option>
                        <option value="divorced">Divorced</option>
                        <option value="separated">Separated</option>
                        <option value="annulled">Annulled</option>
                    </select>
                </div>

                <!-- Nationality -->
                <div>
                    <label for="nationality" class="block text-sm font-medium text-gray-700">Nationality:</label>
                    <select id="nationality" name="nationality"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        required>
                        <option value="" selected>Select Nationality</option>
                        <option value="Filipino">Filipino</option>
                        <option value="American">American</option>
                        <option value="Chinese">Chinese</option>
                        <option value="Japanese">Japanese</option>
                        <option value="Korean">Korean</option>
                        <option value="Indian">Indian</option>
                        <option value="British">British</option>
                        <option value="German">German</option>
                        <option value="Australian">Australian</option>
                        <option value="Other">Other</option>
                    </select>
                </div>

                <!-- Address -->
                <div>
                    <label for="address" class="block text-sm font-medium text-gray-700">Address:</label>
                    <input type="text" id="address" name="address"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        required />
                </div>

                <!-- Criminal Record -->
                <div class="flex items-center">
                    <input type="checkbox" id="has_criminal_record" name="has_criminal_record"
                        class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                    <label for="has_criminal_record" class="ml-2 block text-sm text-gray-700">
                        Check if resident has criminal record
                    </label>
                </div>

                <!-- Purpose -->
                <div>
                    <label for="resident_purpose" class="block text-sm font-medium text-gray-700">Purpose:</label>
                    <textarea id="resident_purpose" name="resident_purpose" rows="3"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        required></textarea>
                </div>

                <!-- Certificate Number -->
                <div>
                    <label for="certificate_number" class="block text-sm font-medium text-gray-700">Certificate Number:</label>
                    <input type="text" id="certificate_number" name="certificate_number" readonly
                        style="cursor: not-allowed;"
                        class="mt-1 block w-full rounded-md bg-gray-100 border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 cursor-not-allowed"
                        required />
                </div>

                <!-- Issue Date -->
                <div>
                    <label for="issue_date" class="block text-sm font-medium text-gray-700">Issue Date:</label>
                    <input type="date" id="issue_date" name="issue_date"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        required />
                </div>

                <!-- Barangay Name -->
                <div>
                    <label for="barangay_name" class="block text-sm font-medium text-gray-700">Barangay Name:</label>
                    <input type="text" id="barangay_name" name="barangay_name" value="Panipuan"
                        style="cursor: not-allowed;"
                        class="mt-1 block w-full rounded-md bg-gray-100 border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 cursor-not-allowed"
                        required />
                </div>

                <!-- Municipality -->
                <div>
                    <label for="municipality" class="block text-sm font-medium text-gray-700">Municipality:</label>
                    <input type="text" id="municipality" name="municipality" value="Sanfernando" readonly
                        style="cursor: not-allowed;"
                        class="mt-1 block w-full rounded-md bg-gray-100 border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 cursor-not-allowed"
                        required />
                </div>

                <!-- Province -->
                <div>
                    <label for="province" class="block text-sm font-medium text-gray-700">Province:</label>
                    <input type="text" id="province" name="province" value="Pampanga" readonly
                        style="cursor: not-allowed;"
                        class="mt-1 block w-full rounded-md bg-gray-100 border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 cursor-not-alloweds"
                        required />
                </div>
            </form>

            <!-- Modal Footer -->
            <div class="border-t px-6 py-4 flex justify-end space-x-2 flex-shrink-0">
                <button type="button" onclick="closeModal('residencyModal')"
                    class="rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-100">
                    Cancel
                </button>
                <button type="submit" form="residencyForm"
                    class="rounded-md bg-primary-500 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-primary-600"
                    style="margin-left: 8px;"
                    id="btnSubmitResidency">
                    Submit
                </button>
            </div>
        </div>
    </div>

    <!-- Approval Confirmation Modal -->
    <div id="approveModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center"
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
            <h2 class="text-lg font-semibold mb-4">Approve Residence</h2>
            <p class="mb-6 text-gray-700">Are you sure you want to approve this residence?</p>
            <div class="flex justify-end space-x-2" style="margin-top: 8px;">
                <button onclick="closeModal('approveModal')" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Cancel</button>
                <button onclick="confirmApprove()" class="px-4 py-2 bg-primary-600 text-white rounded hover:bg-primary-700" style="margin-left: 8px;">Approve</button>
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
            <h2 id="confirmationTitle" class="text-lg font-semibold mb-2">Confirm Action</h2>
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
    <script>
        let confirmCallback = null;
        let selectedResidenceId = null;

        // Fetch table
        document.addEventListener('DOMContentLoaded', function () {
            // Automatically load residency data on page load
            if (window.residencyModal && typeof window.residencyModal.fetchList === 'function') {
                window.residencyModal.fetchList(); // ✅ Load table on refresh or first load
            }
        });

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

                    // 🛑 Skip resetting these values so they retain HTML-defined defaults
                    if (['barangay_name', 'municipality', 'province'].includes(field)) {
                        return;
                    }

                    if (field === 'certificate_number') {
                        const now = new Date();
                        const yyyymmdd = now.toISOString().split('T')[0].replace(/-/g, '');
                        const random = Math.floor(1000 + Math.random() * 9000);
                        input.value = `RES-${yyyymmdd}-${random}`;
                    } else if (field === 'zip_code') {
                        input.value = '2000'; // Default ZIP
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
                    row.classList.add('bg-primary-500', 'cursor-pointer');
                } else {
                    row.classList.add('cursor-pointer');
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
                            class="bg-success-500 border white rounded p-2 d-flex align-items-center justify-content-center"
                            title="Approve">
                            <i class="bi bi-check-circle-fill dark:text-white text-md"></i>
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
                        <i class="bi bi-arrow-counterclockwise dark:text-white text-md"></i>
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

        // Select All Toggle
        function toggleSelectAll(source) {
            const checkboxes = document.querySelectorAll('.selectCheckbox');
            checkboxes.forEach(cb => cb.checked = source.checked);
            updateDeleteButtonState();
        }

        // Function for the search
        function filterTableRows() {
            const query = document.getElementById('searchInput').value.toLowerCase();
            const rows = document.querySelectorAll('#residenceTableBody tr');

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

        // Pagination layout function
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
                                        currentPage === pageNum ? 'bg-primary-500 text-white' : 'text-gray-700 bg-white hover:bg-gray-100'
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
                type === 'success' ? 'bg-primary-400 dark:text-white' : 'bg-red-100 text-red-800'
            }`;

            toast.innerHTML = `
                <div class="flex items-center">
                    <svg class="w-6 h-6 mr-2 ${
                        type === 'success' ? 'text-primary-500' : 'text-red-500'
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
