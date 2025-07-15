<div>
    <x-slot name="header">
        <div class="flex items-center space-x-2">
            <div class="p-3 bg-white rounded-md shadow-md">
                <i class="bi bi-door-open-fill text-[#1B76B5] text-xl"></i>
            </div>
            <div>
                <h1 class="text-lg font-semibold">Activity Logs</h1>
                <p class="text-sm text-gray-500">Monitor user actions and system activities for transparency and auditing
                </p>
            </div>
        </div>
    </x-slot>

    <div class="text-gray-800 px-4 sm:px-6 lg:px-8 py-6">
        <div class="max-w-full mx-auto">
            <div class="overflow-x-auto shadow-md rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr class="uppercase whitespace-nowrap text-xs font-medium text-gray-500">
                            <th class="w-[100px] px-6 py-3 text-left">ID</th>
                            <th class="w-[100px] px-6 py-3 text-left">User ID</th>
                            <th class="w-[100px] px-6 py-3 text-left">Name</th>
                            <th class="w-[100px] px-6 py-3 text-left">Description</th>
                            <th class="w-[100px] px-6 py-3 text-left">Role</th>
                            <th class="w-[100px] px-6 py-3 text-left">Email verify</th>
                            <th class="w-[100px] px-6 py-3 text-left">Created At</th>
                            <th class="w-[100px] px-6 py-3 text-left">Updated At</th>
                        </tr>
                    </thead>
                    <tbody id="activityTable" class="divide-y divide-gray-200 uppercase whitespace-nowrap">
                        <!-- JS will inject rows -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @push('scripts')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            fetch('/activity-logs', {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(json => {
                const data = json.data;
                const tableBody = document.getElementById('activityTable');
                tableBody.innerHTML = '';

                data.sort((a, b) => a.id - b.id);

                data.forEach(log => {
                    const description = log.description?.toLowerCase().trim();
                    const isLogin = description === 'logged in';
                    const isLogout = description === 'logged out';
                    const isRegister = description === 'registered';

                    const statusSpan = `
                        <span class="${
                            isLogin
                                ? 'bg-green-400 text-white border border-green-500'
                                : isLogout
                                    ? 'bg-red-400 text-white border border-red-500'
                                    : isRegister
                                        ? 'bg-blue-400 text-white border border-blue-500'
                                        : 'bg-gray-200 text-gray-700 border border-gray-300'
                        } px-3 py-1 rounded-md text-sm font-medium inline-block">
                            ${log.description ?? '—'}
                        </span>
                    `;

                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td class="px-6 py-4 text-sm text-white">${log.id}</td>
                        <td class="px-6 py-4 text-sm text-white">${log.user_id}</td>
                        <td class="px-6 py-4 text-sm text-white">${log.name}</td>
                        <td class="px-6 py-4 text-sm">${statusSpan}</td>
                        <td class="px-6 py-4 text-sm text-white">${log.role}</td>
                        <td class="px-6 py-4 text-sm text-white">
                        ${
                            log.email_verified_at
                                ? `
                                    <div class="inline-block">
                                        <span class="inline-block bg-green-500 text-white text-xs font-semibold px-3 py-1 rounded-md">
                                            Verified
                                        </span>
                                        <div class="text-[11px] text-white mt-1">
                                            ${new Date(log.email_verified_at).toLocaleString()}
                                        </div>
                                    </div>
                                `
                                : `
                                    <span class="inline-block bg-red-500 text-white text-xs font-semibold px-3 py-1 rounded-md">
                                        Not Verified
                                    </span>
                                `
                        }
                        </td>
                        <td class="px-6 py-4 text-sm text-white">${new Date(log.created_at).toLocaleString()}</td>
                        <td class="px-6 py-4 text-sm text-white">${new Date(log.updated_at).toLocaleString()}</td>
                    `;

                    tableBody.appendChild(row);
                });
            })
            .catch(error => {
                console.error('Error fetching activity logs:', error);
            });
        });
    </script>
    @endpush
</div>
