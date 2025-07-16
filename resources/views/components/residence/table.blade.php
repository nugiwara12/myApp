<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-2">
            <div class="p-3 bg-white rounded-md shadow-md">
                <i class="bi bi-file-earmark-text text-[#1B76B5] text-xl"></i>
            </div>
            <div>
                <h1 class="text-lg font-semibold">Reisdence Certification</h1>
                <p class="text-sm text-gray-500">View submitted Residence requests</p>
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
                            <x-search-input id="searchInput" placeholder="Search residence" class="w-full sm:w-60" />
                        </div>

                        @php
                            $user = Auth::user();
                            $dashboardRoute = match (true) {
                                $user->hasRole('admin') => 'admin.dashboard',
                                $user->hasRole('user') => 'user.dashboard',
                                // $user->hasRole('staff') => 'staff.dashboard',
                                // $user->hasRole('encoder') => 'encoder.dashboard',
                                default => 'dashboard',
                            };
                        @endphp

                        @hasrole('admin')
                        <!-- Right: Buttons -->
                        <div class="text-right space-x-2">
                            <x-danger-button id="deleteSelectedBtn" class="whitespace-nowrap disabled:opacity-50"
                                onclick="deleteSelectedResidencies()" disabled>
                                Multiple Delete
                            </x-danger-button>

                            <x-primary-button onclick="openAddResidency()">
                                Add Residence
                            </x-primary-button>
                        </div>
                        @endhasrole
                    </div>

                    <!-- Table -->
                    <div class="h-full overflow-y-auto rounded">
                        <table class="w-full text-sm text-left">
                            <thead class="bg-gray-100 text-gray-600 uppercase sticky top-0 z-10 whitespace-nowrap">
                                <tr>
                                    <th class="px-4 py-2"><input type="checkbox" id="selectAll" onchange="toggleSelectAll(this)"></th>
                                    <th class="px-4 py-2 text-left">Parent Name</th>
                                    <th class="px-4 py-2 text-left">Email Address</th>
                                    <th class="px-4 py-2 text-left">Age</th>
                                    <th class="px-4 py-2 text-left">Civil Status</th>
                                    <th class="px-4 py-2 text-left">Nationality</th>
                                    <th class="px-4 py-2 text-left">Address</th>
                                    <th class="px-4 py-2 text-left">Criminal Record</th>
                                    <th class="px-4 py-2 text-left">Approved By</th>
                                    <th class="px-4 py-2 text-left">Purpose</th>
                                    <th class="px-4 py-2 text-left">Certificate #</th>
                                    <th class="px-4 py-2 text-left">Zip Code</th>
                                    <th class="px-4 py-2 text-left">Precinct Number</th>
                                    <th class="px-4 py-2 text-left">Status</th>
                                    <th class="px-4 py-2 text-left">Issued Dtate</th>
                                    <th class="px-4 py-2 text-left">Barangay</th>
                                    <th class="px-4 py-2 text-left">Municipality</th>
                                    <th class="px-4 py-2 text-left">Province</th>
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
