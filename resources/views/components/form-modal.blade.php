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
                            <label for="age" class="block font-medium">Age</label>
                            <input type="number" id="age" name="age"
                                class="mt-1 w-full rounded border px-3 py-2" required />
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
                    <h3 class="mb-4 border-b pb-2 text-lg font-semibold text-gray-700">Purpose</h3>
                    <textarea id="purpose" name="purpose" rows="4"
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
