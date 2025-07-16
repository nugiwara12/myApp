{{-- Indigency --}}
<div id="IndigencyModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-xl p-6 relative">
        <h2 id="modalTitle" class="text-xl font-bold mb-4">Add Indigency</h2>
        <form id="indigencyForm" class="space-y-4">
            @csrf

            <!-- Parent Name -->
            <div>
                <label for="parent_name" class="block text-sm font-medium text-gray-700">Name:</label>
                <input type="text" id="parent_name" name="parent_name"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
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

            {{-- Indigency Generator --}}
            <div>
                <label class="block mb-1 font-medium text-sm text-gray-700">Referal Number:</label>
                <input type="text" id="indigency_generated_number" name="indigency_generated_number" class="w-full border border-gray-300 rounded p-2 bg-gray-100 cursor-not-allowed" readonly>
            </div>

            <!-- Date -->
            <div>
                <label for="date" class="block text-sm font-medium text-gray-700">Date:</label>
                <input type="date" id="date" name="date"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                    required />
            </div>

            <!-- Buttons -->
            <div class="pt-4 flex justify-end space-x-2 whitespace-nowrap">
                <button type="button" onclick="closeModal('IndigencyModal')"
                    class="rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-100">
                    Cancel
                </button>
                <button type="submit"
                    class="flex items-center gap-2 rounded-md bg-[#1B76B5] whitespace-nowrap px-4 py-2 text-sm font-semibold text-white shadow-sm transition duration-150 hover:bg-[#225981]"
                    id="btnSubmitIndigency">
                    <svg id="submitSpinner" class="hidden animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path>
                    </svg>
                    <span id="submitText">Submit</span>
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Residence --}}
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
                    class="mt-1 block w-full rounded-md bg-gray-100 border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 cursor-not-allowed"
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
                <svg id="submitResidenceSpinner" class="hidden animate-spin h-5 w-5 text-white inline-block mr-2"
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path>
                </svg>
                <span id="submitText">Submit</span>
            </button>
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
                    <label for="barangayId_citizenship" class="block text-sm font-medium text-gray-700">Citizenship:</label>
                    <select id="barangayId_citizenship" name="barangayId_citizenship"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        required>
                        <option value="" selected>Select Citizenship</option>
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
                    <label for="barangayId_civil_status" class="block text-sm font-medium text-gray-700">Civil Status:</label>
                    <select id="barangayId_civil_status" name="barangayId_civil_status"
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

            <button type="submit" form="barangayIdForm"
                class="flex items-center gap-2 rounded-md bg-[#1B76B5] whitespace-nowrap px-4 py-2 text-sm font-semibold text-white shadow-sm transition duration-150 hover:bg-[#225981]"
                id="btnSubmitBarangayId">

                <!-- ✅ Corrected ID -->
                <svg id="submitBarangayIdSpinner" class="hidden animate-spin h-5 w-5 text-white"
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path>
                </svg>

                <!-- ✅ Corrected ID -->
                <span id="submitBarangayIdText">Submit</span>
            </button>
        </div>
    </div>
</div>


{{-- Modal for tracking with table --}}
<div id="trackingModal" class="fixed inset-0 z-50 bg-black bg-opacity-50 hidden flex items-center justify-center px-4">
    <div class="bg-white w-full max-w-3xl p-6 rounded-xl shadow-xl relative">
        <!-- Title -->
        <h2 class="text-2xl font-semibold text-gray-800 mb-4">Track Your Request</h2>

        <!-- Input Row -->
        <div class="flex flex-col md:flex-row items-stretch gap-3">
            <input type="text" id="tracking_number_input"
                class="border border-gray-300 rounded-md px-4 py-2 w-full focus:ring-2 focus:ring-blue-500 focus:outline-none"
                placeholder="e.g. IND-20250716-1234" />

            <div class="flex gap-2">
                <button id="btnSubmitTracking" onclick="window.submitTrackingNumber(event)"
                    class="bg-blue-600 text-white px-5 py-2 rounded-md hover:bg-blue-700 flex items-center gap-2 transition">
                    <span id="submitTrackingText">Search</span>
                    <svg id="submitTrackingSpinner" class="w-4 h-4 animate-spin hidden"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10"
                            stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor"
                            d="M4 12a8 8 0 018-8v8z"></path>
                    </svg>
                </button>

                <button onclick="window.closeTrackingModal()"
                    class="bg-gray-200 text-gray-700 px-5 py-2 rounded-md hover:bg-gray-300 transition">
                    Close
                </button>
            </div>
        </div>

        <!-- Results -->
        <div id="trackingResultContainer" class="mt-6 hidden">
            <h3 class="text-lg font-semibold mb-2 text-gray-700">Results</h3>
            <div class="overflow-x-auto rounded-lg border border-gray-200">
                <table class="min-w-full text-sm text-gray-700">
                    <thead class="bg-gray-100 text-left">
                        <tr>
                            <th class="px-4 py-3 border-b">Name</th>
                            <th class="px-4 py-3 border-b">Service Type</th>
                            <th class="px-4 py-3 border-b">Date Requested</th>
                            <th class="px-4 py-3 border-b">Description</th>
                            <th class="px-4 py-3 border-b">Status</th>
                        </tr>
                    </thead>
                    <tbody id="trackingResultRow" class="bg-white divide-y divide-gray-100">
                        <!-- Populated by JS -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

