<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-2">
            <div class="p-3 bg-white rounded-md shadow-md">
                <i class="bi bi-people text-[#1B76B5] text-xl"></i>
            </div>
            <div>
                <h1 class="text-lg font-semibold">User Management</h1>
                <p class="text-sm text-gray-500">Manage Your Employees</p>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <!-- Card -->
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <div class="flex justify-between mb-4">
                        <!-- Left: Title -->
                        <div class="text-left">
                            <x-search-input id="searchInput" placeholder="Search users" class="w-full sm:w-full" />
                        </div>

                        <!-- Right: Button -->
                        <div class="text-right">
                            <x-primary-button onclick="openAddUser()">
                                Add User
                            </x-primary-button>
                        </div>
                    </div>

                    <!-- Scrollable Table -->
                    <div id="scrollContainer" class="max-h-[730px] overflow-y-auto rounded">
                        <div class="min-w-[1024px]">
                            <table id="userTable" class="w-full text-sm text-left">
                                <thead class="bg-gray-100 text-gray-600 uppercase sticky top-0 z-10">
                                    <tr class="whitespace-nowrap">
                                        <th class="px-4 py-2">User ID</th>
                                        <th class="px-4 py-2">Username</th>
                                        <th class="px-4 py-2">Email Address</th>
                                        <th class="px-4 py-2">Role</th>
                                        <th class="px-4 py-2">Status</th>
                                        <th class="px-4 py-2">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="tableBody" class="divide-y divide-gray-200">
                                    <!-- Rows inserted via JavaScript -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
