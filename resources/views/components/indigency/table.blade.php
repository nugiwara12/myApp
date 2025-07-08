<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-2">
            <div class="p-3 bg-white rounded-md shadow-md">
                <i class="bi bi-file-earmark-text text-[#1B76B5] text-xl"></i>
            </div>
            <div>
                <h1 class="text-lg font-semibold">Indigency Certification</h1>
                <p class="text-sm text-gray-500">View submitted indigency requests</p>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <div class="flex justify-between mb-4 flex-wrap gap-2">
                        <!-- Left: Search -->
                        <div class="text-left">
                            <x-search-input id="searchInput" placeholder="Search indigency" class="w-full sm:w-60" />
                        </div>

                        <!-- Right: Buttons -->
                        <div class="text-right space-x-2">
                            <x-danger-button id="deleteSelectedBtn" class="whitespace-nowrap disabled:opacity-50"
                                onclick="deleteSelectedIndigencies()" disabled>
                                Multiple Delete
                            </x-danger-button>

                            <x-primary-button onclick="openAddIndigency()">
                                Add Indigency
                            </x-primary-button>
                        </div>
                    </div>

                    <!-- Table -->
                    <div class="h-full overflow-y-auto rounded">
                        <table class="w-full text-sm text-left">
                            <thead class="bg-gray-100 text-gray-600 uppercase sticky top-0 z-10">
                                <tr>
                                    <th class="px-4 py-2"><input type="checkbox" id="selectAll"
                                            onchange="toggleSelectAll(this)"></th>
                                    <th class="px-4 py-2">Parent Name</th>
                                    <th class="px-4 py-2">Address</th>
                                    <th class="px-4 py-2">Purpose</th>
                                    <th class="px-4 py-2">Childs Name</th>
                                    <th class="px-4 py-2">Age</th>
                                    <th class="px-4 py-2">Date</th>
                                    <th class="px-4 py-2">Status</th>
                                    <th class="px-4 py-2">Approved</th>
                                    <th class="px-4 py-2">Action</th>
                                </tr>
                            </thead>
                            <tbody id="indigencyTableBody" class="divide-y divide-gray-200"></tbody>
                        </table>
                        <div id="paginationControls" class="mt-4 border-t"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Toast Container -->
    <div id="toast-container" class="fixed top-4 right-4 z-50 space-y-2"></div>
</x-app-layout>
