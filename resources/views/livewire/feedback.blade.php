<div>
    <x-slot name="header">
        <div class="flex items-center space-x-2">
            <div class="p-3 bg-white rounded-md shadow-md">
                <i class="bi bi-chat-dots text-[#1B76B5] text-xl"></i>
            </div>
            <div>
                <h1 class="text-lg font-semibold">Feedback Management</h1>
                <p class="text-sm text-gray-500">View Resident Feedbacks</p>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden shadow-sm sm:rounded-lg">
                <div class="rounded-lg shadow-sm p-6">
                    <div class="flex justify-between mb-4 items-center">
                        <!-- Search input with clear button -->
                        <div class="relative w-full sm:w-60">
                            <input id="searchInput" type="text" placeholder="Search feedbacks"
                                class="w-96 sm:w-60 px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-800 dark:text-white" />
                            <button id="clearSearchBtn"
                                class="absolute right-2 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 hidden">
                                &times;
                            </button>
                        </div>

                        <button onclick="deleteSelectedFeedbacks()" id="deleteSelectedBtn"
                            class="px-4 py-2 bg-primary-600 text-white rounded-md disabled:opacity-50 hover:bg-primary-700 transition whitespace-nowrap"
                            disabled>
                            Delete Selected
                        </button>
                    </div>

                    <!-- Table -->
                    <div class="h-full overflow-y-auto rounded">
                        <table class="w-full text-sm text-left">
                            <thead class="bg-gray-100 dark:bg-gray-800 dark:text-white uppercase sticky top-0 z-10 whitespace-nowrap">
                                <tr>
                                    <th class="px-4 py-2"><input type="checkbox" id="selectAll"
                                            onchange="toggleSelectAll(this)"></th>
                                    <th class="px-4 py-2">Name</th>
                                    <th class="px-4 py-2">Message</th>
                                    <th class="px-4 py-2">Submitted At</th>
                                    <th class="px-4 py-2">Action</th>
                                </tr>
                            </thead>
                            <tbody id="feedbackTableBody" class="divide-y divide-gray-200"></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Toast Container -->
    <div id="toast-container" class="fixed top-4 right-4 z-50 space-y-2"></div>

    {{-- MOdal --}}
    <!-- Confirm Delete Modal -->
    <div id="confirmModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-40 hidden z-50"
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
        <div id="confirmModalContent"
            class="bg-white p-6 rounded-lg shadow-md w-full max-w-sm transform transition-all scale-95 opacity-0">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-semibold text-gray-800">Confirm Deletion</h2>
            </div>
            <p class="text-sm text-gray-600 mb-6">Are you sure you want to delete this feedback?</p>
            <div class="flex justify-end gap-2" style="margin-top: 8px">
                <button onclick="closeConfirmModal()"
                    class="px-4 py-2 rounded-md bg-gray-200 hover:bg-gray-300 text-sm text-gray-700">Cancel</button>
                <button id="confirmDeleteBtn"
                    class="px-4 py-2 rounded-md bg-primary-600 hover:bg-primary-700 text-sm text-white">Delete</button>
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
                    class="px-4 py-2 rounded-md bg-primary-600 hover:bg-primary-700 text-sm dark:text-white">Delete</button>
            </div>
        </div>
    </div>

    @push('scripts')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        let allFeedbacks = [];
        let selectedBulkIds = [];

        window.fetchFeedbacks = function() {
            axios.get('/getFeedback')
                .then(res => {
                    allFeedbacks = res.data;
                    renderFeedbacks(allFeedbacks);
                });
        };

        // Render Table
        function renderFeedbacks(data) {
            const tbody = document.getElementById("feedbackTableBody");
            tbody.innerHTML = "";

            if (data.length === 0) {
                tbody.innerHTML =
                    `<tr><td colspan="5" class="px-4 py-4 text-center text-gray-400">No feedback found.</td></tr>`;
                return;
            }

            data.forEach(item => {
                const tr = document.createElement("tr");
                tr.classList.add("cursor-pointer", "hover:bg-gray-700");

                tr.innerHTML = `
                <td class="px-4 py-2">
                    <input type="checkbox" class="rowCheckbox" value="${item.id}" onchange="toggleCheckbox()" />
                </td>
                <td class="px-4 py-2 whitespace-nowrap">${item.name}</td>
                <td class="px-4 py-2">${item.message}</td>
                <td class="px-4 py-2">${new Date(item.created_at).toLocaleString()}</td>
                <td class="px-4 py-2">
                    <button onclick="event.stopPropagation(); showConfirmModal(${item.id})"
                        class="bg-primary-600 hover:bg-primary-700 text-white text-xs px-3 py-1 rounded">
                        Delete
                    </button>
                </td>
            `;

                // Add click event to row to toggle the checkbox
                tr.addEventListener("click", (e) => {
                    const checkbox = tr.querySelector(".rowCheckbox");
                    checkbox.checked = !checkbox.checked;
                    toggleCheckbox(); // Call the update handler
                });

                // Prevent checkbox click from triggering the row click again
                tr.querySelector(".rowCheckbox").addEventListener("click", (e) => {
                    e.stopPropagation();
                });

                tbody.appendChild(tr);
            });

            document.getElementById('selectAll').checked = false;
            document.getElementById('deleteSelectedBtn').disabled = true;
        }

        function toggleSelectAll(source) {
            document.querySelectorAll('.rowCheckbox').forEach(cb => {
                cb.checked = source.checked;
            });
            toggleCheckbox();
        }

        function toggleCheckbox() {
            const selected = document.querySelectorAll('.rowCheckbox:checked');
            document.getElementById('deleteSelectedBtn').disabled = selected.length === 0;
        }

        window.deleteSelectedFeedbacks = function() {
            selectedBulkIds = Array.from(document.querySelectorAll('.rowCheckbox:checked')).map(cb => cb.value);
            if (selectedBulkIds.length === 0) return;

            document.getElementById('bulkConfirmText').innerText =
                `Are you sure you want to delete ${selectedBulkIds.length} selected feedback(s)?`;

            const modal = document.getElementById('bulkConfirmModal');
            const modalContent = document.getElementById('bulkConfirmModalContent');

            modal.classList.remove('hidden');
            setTimeout(() => {
                modalContent.classList.remove('scale-95', 'opacity-0');
                modalContent.classList.add('scale-100', 'opacity-100');
            }, 10);
        };

        window.showConfirmModal = function(id) {
            deleteId = id;
            const modal = document.getElementById('confirmModal');
            const content = document.getElementById('confirmModalContent');
            modal.classList.remove('hidden');
            setTimeout(() => {
                content.classList.remove('scale-95', 'opacity-0');
                content.classList.add('scale-100', 'opacity-100');
            }, 10);
        }

        // Close modal
        window.closeConfirmModal = function() {
            const modal = document.getElementById('confirmModal');
            const modalContent = document.getElementById('confirmModalContent');

            modalContent.classList.add('scale-95', 'opacity-0');
            modalContent.classList.remove('scale-100', 'opacity-100');
            setTimeout(() => modal.classList.add('hidden'), 200);
            deleteId = null;
        };

        document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
            if (!deleteId) return;
            axios.delete(`/feedback/${deleteId}`)
                .then(() => {
                    showToast("Feedback deleted");
                    fetchFeedbacks();
                })
                .finally(() => closeConfirmModal());
        });

        window.closeBulkConfirmModal = function() {
            const modal = document.getElementById('bulkConfirmModal');
            const modalContent = document.getElementById('bulkConfirmModalContent');

            modalContent.classList.remove('scale-100', 'opacity-100');
            modalContent.classList.add('scale-95', 'opacity-0');
            setTimeout(() => modal.classList.add('hidden'), 200);
        };

        document.getElementById('confirmBulkDeleteBtn').addEventListener('click', function() {
            axios.post('/feedback/bulk-delete', {
                ids: selectedBulkIds
            }).then(() => {
                showToast("Selected feedbacks deleted", "success");
                fetchFeedbacks();
            }).catch(() => {
                showToast("Failed to delete selected feedbacks", "error");
            }).finally(() => {
                closeBulkConfirmModal();
            });
        });

        function showToast(message, type = 'success') {
            let container = document.getElementById('toast-container');
            const toast = document.createElement('div');
            toast.className = `flex items-center px-4 py-3 rounded shadow max-w-xs text-sm ${
                type === 'success' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'
            }`;
            toast.innerHTML = `
                <svg class="w-5 h-5 mr-2 ${type === 'success' ? 'text-green-500' : 'text-red-500'}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="${
                        type === 'success' ? 'M5 13l4 4L19 7' : 'M6 18L18 6M6 6l12 12'
                    }" />
                </svg>
                <span>${message}</span>
            `;
            container.appendChild(toast);

            setTimeout(() => {
                toast.classList.add('opacity-0');
                toast.addEventListener('transitionend', () => toast.remove());
                toast.remove();
            }, 3000);
        }

        // Search filter
        document.addEventListener('DOMContentLoaded', function() {
            fetchFeedbacks();

            document.getElementById('searchInput').addEventListener('input', function(e) {
                const keyword = e.target.value.toLowerCase();
                const filtered = allFeedbacks.filter(fb =>
                    fb.name.toLowerCase().includes(keyword) || fb.message.toLowerCase().includes(
                        keyword)
                );
                renderFeedbacks(filtered);
            });
        });
    </script>
    @endpush
</div>
