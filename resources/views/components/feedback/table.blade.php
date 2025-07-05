<x-app-layout>
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

    <div class="py-12">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <div class="flex justify-between mb-4 items-center">
                        <!-- Search input with clear button -->
                        <div class="relative w-full sm:w-60">
                            <input id="searchInput" type="text" placeholder="Search feedbacks"
                                class="border border-gray-300 rounded-md py-2 px-4 pr-10 w-full focus:outline-none focus:ring focus:border-blue-300" />
                            <button id="clearSearchBtn"
                                class="absolute right-2 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 hidden">
                                &times;
                            </button>
                        </div>

                        <button onclick="deleteSelectedFeedbacks()" id="deleteSelectedBtn"
                            class="ml-4 whitespace-nowrap bg-red-600 hover:bg-red-700 text-white text-sm px-4 py-2 rounded disabled:opacity-50"
                            disabled>
                            Delete Selected
                        </button>
                    </div>

                    <!-- Table -->
                    <div class="max-h-[730px] overflow-y-auto rounded">
                        <table class="w-full text-sm text-left">
                            <thead class="bg-gray-100 text-gray-600 uppercase sticky top-0 z-10">
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
</x-app-layout>
