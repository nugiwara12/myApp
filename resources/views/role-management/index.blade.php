<x-user-management.table />
<x-user-management.modal />


<script>
    // Modal Functions
    window.openModal = function (id) {
        const modal = document.getElementById(id);
        if (modal) modal.classList.remove('hidden');
    };

    // Closed modal with reset the all content when it closed
    function closeModal(id) {
        const modal = document.getElementById(id);
        if (!modal) return;
        modal.classList.add('hidden');
        modal.removeAttribute('data-userid');
    }

    // Toast Notification Function
    function showToast(message, type = 'success') {
        let toastContainer = document.getElementById('toast-container');
        if (!toastContainer) {
            toastContainer = document.createElement('div');
            toastContainer.id = 'toast-container';
            toastContainer.className = 'fixed top-4 right-4 z-50 space-y-2';
            document.body.appendChild(toastContainer);
        }

        // Clear existing toast
        while (toastContainer.firstChild) {
            toastContainer.removeChild(toastContainer.firstChild);
        }

        const toast = document.createElement('div');
        toast.className = `flex items-center px-4 py-3 rounded-lg shadow-lg max-w-xs transition-opacity duration-300 ${
            type === 'success' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'
        }`;

        toast.innerHTML = `
            <div class="flex items-center">
                <svg class="w-6 h-6 mr-2 ${
                    type === 'success' ? 'text-green-500' : 'text-red-500'
                }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="${
                        type === 'success'
                            ? 'M9 12l2 2l4 -4m7 8a9 9 0 1 1 -18 0a9 9 0 0 1 18 0z'
                            : 'M12 9v2m0 4h.01m6.938 4h-13.856c-1.344 0-2.402-1.066-2.122-2.387l1.721-9.215A2 2 0 0 1 6.667 4h10.666a2 2 0 0 1 1.957 2.398l-1.721 9.215c-.28 1.321-1.338 2.387-2.682 2.387z'
                    }" />
                </svg>
                <span class="text-black">${message}</span>
            </div>
        `;

        toastContainer.appendChild(toast);

        setTimeout(() => {
            toast.classList.add('opacity-0');
            toast.addEventListener('transitionend', () => toast.remove());
            toast.remove();
        }, 2000);
    }

    document.addEventListener('DOMContentLoaded', function () {
        let userIdToDelete = null; // Delete Users but its soft delete

        // Dynamic role
        window.loadRoles = async function () {
            try {
                const response = await axios.get('/getRoles');
                const roles = response.data;

                const roleSelect = document.querySelector('#role');
                if (!roleSelect) {
                    console.error('Role dropdown not found');
                    return;
                }

                roleSelect.innerHTML = '<option value="">-- Select Role --</option>';
                roles.forEach(role => {
                    roleSelect.innerHTML += `<option value="${role.name}">${role.name}</option>`;
                });
            } catch (error) {
                console.error('Failed to load roles:', error);
            }
        };


        // Add user && Edit Users
        window.submitAddUser = async function () {
            const userId = document.getElementById('addUserModal').dataset.userid;
            const name = document.querySelector('#name').value.trim();
            const email = document.querySelector('#email').value.trim();
            const role = document.querySelector('#role').value;
            const password = document.querySelector('#password').value;
            const password_confirmation = document.querySelector('#password_confirmation').value;

            const payload = { name, email, role };
            if (password || password_confirmation) {
                payload.password = password;
                payload.password_confirmation = password_confirmation;
            }

            const url = userId ? `/updateUser/${userId}` : '/addUser';
            const method = userId ? 'put' : 'post';

            try {
                const response = await axios({
                    method,
                    url,
                    data: payload,
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                    },
                });

                if (response.data.status) {
                    showToast(response.data.message, 'success');

                    // Clear fields
                    document.querySelector('#name').value = '';
                    document.querySelector('#email').value = '';
                    document.querySelector('#role').value = '';
                    document.querySelector('#password').value = '';
                    document.querySelector('#password_confirmation').value = '';

                    // Reset modal state
                    document.getElementById('modalTitle').textContent = 'Add New User';
                    document.getElementById('modalActionBtn').textContent = 'Add User';
                    document.getElementById('addUserModal').removeAttribute('data-userid');

                    // Refresh user list
                    window.loadUsers();

                    // Close modal
                    closeModal('addUserModal');
                }
            } catch (error) {
                if (error.response && error.response.status === 422) {
                    const errors = error.response.data.errors;
                    for (let field in errors) {
                        showToast(`${field}: ${errors[field].join(', ')}`, 'error');
                    }
                } else {
                    showToast('Something went wrong.', 'error');
                    console.error('Unexpected error:', error);
                }
            }
        }

        // Get Users
        window.loadUsers = async function () {
            try {
                const response = await axios.get('/userDetails');
                const users = response.data.users;

                const tbody = document.getElementById('tableBody');
                tbody.innerHTML = ''; // Clear previous rows

                if (users.length === 0) {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td colspan="6" class="text-center py-4 text-gray-500">No data available</td>
                    `;
                    tbody.appendChild(row);
                    return; // Exit early
                }

                users.forEach(user => {
                    const row = document.createElement('tr');
                    const isDeleted = user.status === 0;

                    row.classList.add('whitespace-nowrap', 'border-b');
                    if (isDeleted) {
                        row.classList.add('bg-red-100', 'text-red-700'); // Highlight deleted user
                    }

                    row.innerHTML = `
                        <td class="px-4 py-2">${user.id}</td>
                        <td class="px-4 py-2">${user.name}</td>
                        <td class="px-4 py-2">${user.email}</td>
                        <td class="px-4 py-2 capitalize">${user.roles && user.roles.length > 0 ? user.roles[0].name : 'No role'}</td>
                        <td class="px-4 py-2">
                            <span class="${user.status === 1
                                ? 'bg-green-400 text-white border border-green-500'
                                : 'bg-red-400 text-white border border-gray-400'}
                                px-3 py-1 rounded-md text-sm font-medium">
                                ${user.status === 1 ? 'Active' : 'Inactive'}
                            </span>
                        </td>
                        <td class="px-4 py-2">
                            ${isDeleted
                                ? `<button
                                        onclick="restoreUser(${user.id})"
                                        class="bg-green-500 text-white p-2 rounded-lg hover:bg-green-600 transition duration-200"
                                        title="Restore"
                                    >
                                        <i class="bi bi-arrow-clockwise"></i>
                                    </button>`
                                : `<button
                                        class="bg-blue-500 text-white p-2 rounded-lg hover:bg-blue-600 transition duration-200"
                                        title="Edit"
                                        onclick='editUser(${JSON.stringify(user)})'
                                    >
                                        <i class="bi bi-pencil-fill"></i>
                                    </button>
                                    <button
                                        onclick="deleteUser(${user.id})"
                                        class="bg-red-500 text-white p-2 rounded-lg hover:bg-red-600 transition duration-200 ml-2"
                                        title="Delete"
                                    >
                                        <i class="bi bi-trash-fill"></i>
                                    </button>`
                            }
                        </td>
                    `;

                    tbody.appendChild(row);
                });

            } catch (error) {
                console.error('Error fetching users:', error);
                showToast('Failed to load users.', 'error');
            }
        };

        // Call it on page load
        window.addEventListener('DOMContentLoaded', window.loadUsers);

        // Edit Functiuon
        window.editUser = async function (user) {
            // Load roles into the dropdown first
            await window.loadRoles();

            // Set form field values
            document.getElementById('name').value = user.name || '';
            document.getElementById('email').value = user.email || '';
            document.getElementById('password').value = '';
            document.getElementById('password_confirmation').value = '';

            // Safely assign role after dropdown options are loaded
            const role = user.roles && user.roles.length > 0 ? user.roles[0].name : '';
            document.getElementById('role').value = role;

            // Set modal to edit mode
            const modal = document.getElementById('addUserModal');
            modal.dataset.userid = user.id;

            document.getElementById('modalTitle').textContent = 'Edit User';
            document.getElementById('modalActionBtn').textContent = 'Update User';

            // Show the modal
            openModal('addUserModal');
        };

        // Add Functiuon
        window.openAddUser = function () {
            document.getElementById('modalTitle').textContent = 'Add New User';
            document.getElementById('modalActionBtn').textContent = 'Add User';

            document.getElementById('name').value = '';
            document.getElementById('email').value = '';
            document.getElementById('role').value = '';
            document.getElementById('password').value = '';
            document.getElementById('password_confirmation').value = '';

            const modal = document.getElementById('addUserModal');
            modal.removeAttribute('data-userid');

            openModal('addUserModal');
        };

        // Open the modal and store the user ID
        window.deleteUser = function (id) {
            userIdToDelete = id;
            openModal('deleteUserModal');
        };

        // Confirm button click handler
        document.getElementById('confirmDeleteBtn').addEventListener('click', async function () {
            if (!userIdToDelete) return;

            try {
                const response = await axios.delete(`/deleteUser/${userIdToDelete}`);

                if (response.data.status) {
                    showToast(response.data.message, 'success');
                    window.loadUsers();
                } else {
                    showToast('Failed to delete user.', 'error');
                }
            } catch (error) {
                showToast('Error deleting user.', 'error');
                console.error(error);
            } finally {
                closeModal('deleteUserModal');
                userIdToDelete = null;
            }
        });

        // Restore the data
        window.restoreUser = async function (id) {
            try {
                const response = await axios.post(`/restoreUser/${id}`);
                if (response.data.status) {
                    showToast(response.data.message, 'success');
                    // ✅ Reload users to get updated status and re-render UI
                    window.loadUsers();
                } else {
                    showToast('Restore failed.', 'error');
                }
            } catch (error) {
                showToast('Something went wrong while restoring.', 'error');
                console.error(error);
            }
        };

        // Search Input
        document.getElementById('searchInput').addEventListener('input', function () {
            const searchTerm = this.value.toLowerCase();
            const rows = document.querySelectorAll('#tableBody tr');
            const noDataMessage = document.getElementById('noDataMessage'); // element for "No data found"
            let visibleCount = 0;

            rows.forEach(row => {
                const name = row.children[1]?.textContent.toLowerCase();
                const email = row.children[2]?.textContent.toLowerCase();
                const role = row.children[3]?.textContent.toLowerCase();

                const matches = name.includes(searchTerm) || email.includes(searchTerm) || role.includes(searchTerm);
                row.style.display = matches ? '' : 'none';
                if (matches) visibleCount++;
            });

            // Toggle visibility of the "No data found" message
            if (noDataMessage) {
                noDataMessage.style.display = visibleCount === 0 ? 'table-row' : 'none';
            }
        });
    });
</script>
