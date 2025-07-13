<!-- Indigency Modal -->
<div id="certificationModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-xl p-6 relative">
        <h2 id="modalTitle" class="text-xl font-bold mb-4">Add Indigency</h2>
        <form id="indigencyForm" onsubmit="submitIndigency(event)" class="space-y-4">
            @csrf

            <!-- Parent Name -->
            <div>
                <label for="parent_name" class="block text-sm font-medium text-gray-700">Parent Name:</label>
                <input type="text" id="parent_name" name="parent_name"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                    required />
            </div>

            <!-- Address -->
            <div>
                <label for="address" class="block text-sm font-medium text-gray-700">Address:</label>
                <input type="text" id="address" name="address"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                    required />
            </div>

            <!-- Purpose -->
            <div>
                <label for="purpose" class="block text-sm font-medium text-gray-700">Purpose:</label>
                <input type="text" id="purpose" name="purpose"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                    required />
            </div>

            <!-- Child Name -->
            <div>
                <label for="childs_name" class="block text-sm font-medium text-gray-700">Child Name:</label>
                <input type="text" id="childs_name" name="childs_name"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                    required />
            </div>

            <!-- Age -->
            <div>
                <label for="age" class="block text-sm font-medium text-gray-700">Age:
                    <span class="italic text-gray-500 text-xs">(150 maximum age range)</span>
                </label>
                <input type="number" id="age" name="age" min="1" max="150"
                    oninput="if (this.value > 150) this.value = 150; if (this.value < 1) this.value = '';"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                    required />
            </div>

            <!-- Date -->
            <div>
                <label for="date" class="block text-sm font-medium text-gray-700">Date:</label>
                <input type="date" id="date" name="date"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                    required />
            </div>

            <!-- Buttons -->
            <div class="pt-4 flex justify-end space-x-2">
                <button type="button" onclick="closeModal('certificationModal')"
                    class="rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-100">
                    Cancel
                </button>
                <button type="submit"
                    class="rounded-md bg-[#1B76B5] px-4 py-2 text-sm font-semibold text-white shadow-sm transition duration-150 hover:bg-[#225981]"
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
        <div class="overflow-y-auto px-6 py-4 space-y-6 flex-1">
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

<!-- Residency Certificate Modal -->
<div id="residencyModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-2xl h-[90vh] flex flex-col relative">

        <!-- Modal Header -->
        <div class="p-6 border-b flex-shrink-0">
            <h2 id="modalTitle" class="text-xl font-bold">Certificate of Residency</h2>
        </div>

        <!-- Scrollable Form Body -->
        <form id="residencyForm" onsubmit="submitResidency(event)" class="overflow-y-auto px-6 py-4 space-y-4 flex-1">
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
                    class="mt-1 block w-full rounded-md bg-gray-100 border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 cursor-not-allowed"
                    required />
            </div>

            <!-- Municipality -->
            <div>
                <label for="municipality" class="block text-sm font-medium text-gray-700">Municipality:</label>
                <input type="text" id="municipality" name="municipality" value="Sanfernando" readonly
                    class="mt-1 block w-full rounded-md bg-gray-100 border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 cursor-not-allowed"
                    required />
            </div>

            <!-- Province -->
            <div>
                <label for="province" class="block text-sm font-medium text-gray-700">Province:</label>
                <input type="text" id="province" name="province" value="Pampanga" readonly
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
                class="rounded-md bg-[#1B76B5] px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-[#225981]"
                id="btnSubmitResidency">
                Submit
            </button>
        </div>
    </div>
</div>

<!-- Approval Confirmation Modal -->
<div id="approveModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6 relative">
        <h2 class="text-lg font-semibold mb-4">Approve Residence</h2>
        <p class="mb-6 text-gray-700">Are you sure you want to approve this residence?</p>
        <div class="flex justify-end space-x-2">
            <button onclick="closeModal('approveModal')" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Cancel</button>
            <button onclick="confirmApprove()" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">Approve</button>
        </div>
    </div>
</div>

<!-- Barangay ID Form Modal -->
<div id="barangayIdModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center">
    <div class="bg-white border border-gray-300 rounded-lg shadow-lg w-full max-w-2xl flex flex-col max-h-[90vh] overflow-hidden">

        <!-- Header -->
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold uppercase">Barangay ID Form</h2>
        </div>

        <!-- Form Body -->
        <form id="barangayIdForm" onsubmit="submitBarangayIdForm(event)" class="overflow-y-auto px-6 py-4 flex-1 white">
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
            <button type="button" onclick="closeModal('barangayIdModal')" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Cancel</button>
            <button type="submit" form="barangayIdForm" id="btnSubmitBarangayId" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Submit</button>
        </div>
    </div>
</div>

<!-- Approval Confirmation Modal for approved ID -->
<div id="approvedIdModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6 relative">
        <h2 class="text-lg font-semibold mb-4">Approve Barangay ID</h2>
        <p class="mb-6 text-gray-700">Are you sure you want to approve this Barangay ID?</p>
        <div class="flex justify-end space-x-2">
            <button onclick="closeModal('approvedIdModal')" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Cancel</button>
            <button onclick="confirmApproveBarangayId()" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">Approve</button>
        </div>
    </div>
</div>
