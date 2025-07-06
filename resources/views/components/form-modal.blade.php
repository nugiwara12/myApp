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
