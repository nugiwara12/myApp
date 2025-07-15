<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-2">
            <div class="p-3 bg-white rounded-md shadow-md">
                <i class="bi bi-file-earmark-text text-[#1B76B5] text-xl"></i>
            </div>
            <div>
                <h1 class="text-lg font-semibold">User Dashboard</h1>
                <p class="text-sm text-gray-500">View Your Request Service</p>
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
                            <x-search-input id="searchInput" placeholder="Search request" class="w-full sm:w-60" />
                        </div>

                        <!-- Right: Buttons -->
                        <div class="text-right space-x-2 hidden">
                            <x-danger-button id="deleteSelectedBtn" class="whitespace-nowrap disabled:opacity-50"
                                onclick="deleteSelectedResidencies()" disabled>
                                Multiple Delete
                            </x-danger-button>

                            <x-primary-button onclick="openAddResidency()">
                                Add Residence
                            </x-primary-button>
                        </div>
                    </div>

                    <!-- Table -->
                    <div class="h-full overflow-y-auto rounded">
                        <table class="w-full text-sm text-left">
                            <thead class="bg-gray-100 text-gray-600 uppercase sticky top-0 z-10 whitespace-nowrap">
                                <tr>
                                    <th class="px-4 py-2 text-left">Name</th>
                                    <th class="px-4 py-2 text-left">Service Type</th>
                                    <th class="px-4 py-2 text-left">Pick up Date</th>
                                    <th class="px-4 py-2 text-left">Date Requested</th>
                                    <th class="px-4 py-2 text-left">Status</th>
                                    <th class="px-4 py-2 text-left">Action</th>
                                </tr>
                            </thead>
                            <tbody id="residenceTableBody" class="divide-y divide-gray-200 whitespace-nowrap"></tbody>
                        </table>
                    </div>
                    <div id="paginationControls" class="mt-4 border-t"></div>
                </div>
            </div>
        </div>
    </div>
    <!-- Toast Container -->
    <div id="toast-container" class="fixed top-4 right-4 z-50 space-y-2"></div>
</x-app-layout>
