<!-- Confirm Delete Modal -->
<div id="confirmModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-40 hidden z-50">
    <div id="confirmModalContent"
        class="bg-white p-6 rounded-lg shadow-md w-full max-w-sm transform transition-all scale-95 opacity-0">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg font-semibold text-gray-800">Confirm Deletion</h2>
            <button onclick="closeConfirmModal()" class="text-gray-500 hover:text-gray-700 text-lg">&times;</button>
        </div>
        <p class="text-sm text-gray-600 mb-6">Are you sure you want to delete this feedback?</p>
        <div class="flex justify-end gap-2">
            <button onclick="closeConfirmModal()"
                class="px-4 py-2 rounded-md bg-gray-200 hover:bg-gray-300 text-sm text-gray-700">Cancel</button>
            <button id="confirmDeleteBtn"
                class="px-4 py-2 rounded-md bg-red-600 hover:bg-red-700 text-sm text-white">Delete</button>
        </div>
    </div>
</div>


<!-- Bulk Delete Confirmation Modal -->
<div id="bulkConfirmModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-40 hidden z-50">
    <div id="bulkConfirmModalContent"
        class="bg-white p-6 rounded-lg shadow-md w-full max-w-sm transform transition-all scale-95 opacity-0">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg font-semibold text-gray-800">Confirm Bulk Deletion</h2>
            <button onclick="closeBulkConfirmModal()" class="text-gray-500 hover:text-gray-700 text-lg">&times;</button>
        </div>
        <p id="bulkConfirmText" class="text-sm text-gray-600 mb-6">
            Are you sure you want to delete selected feedbacks?
        </p>
        <div class="flex justify-end gap-2">
            <button onclick="closeBulkConfirmModal()"
                class="px-4 py-2 rounded-md bg-gray-200 hover:bg-gray-300 text-sm text-gray-700">Cancel</button>
            <button id="confirmBulkDeleteBtn"
                class="px-4 py-2 rounded-md bg-red-600 hover:bg-red-700 text-sm text-white">Delete</button>
        </div>
    </div>
</div>
