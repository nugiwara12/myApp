<!-- Add User Modal -->
<div id="addUserModal"
    class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50 px-4">
    <div class="bg-white rounded-lg w-full max-w-md p-6 shadow-xl overflow-y-auto max-h-[90vh]">
        <h2 id="modalTitle" class="text-lg font-semibold text-gray-800 text-start mb-2">Add New User</h2>
        <p class="text-sm text-gray-500 text-start mb-6">Fill in the details to create a new user account.</p>

        <!-- Form Fields -->
        <div class="space-y-4">
            <!-- Name -->
            <div>
                <x-input-label for="name" :value="__('Name')" />
                <x-text-input id="name" class="block w-full mt-1" type="text" name="name" required autofocus />
                <x-input-error :messages="$errors->get('name')" class="mt-1" />
            </div>

            <!-- Email -->
            <div>
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="block w-full mt-1" type="email" name="email" required />
                <x-input-error :messages="$errors->get('email')" class="mt-1" />
            </div>

            {{-- <!-- Role -->
            <div>
                <x-input-label for="role" :value="__('Role')" />

                <x-text-select id="role" name="role" required>
                    <option value="user" selected>User</option>
                </x-text-select>

                <x-input-error :messages="$errors->get('role')" class="mt-1" />
            </div> --}}
            
            <!-- Hidden Role Input -->
            <input type="hidden" id="role" name="role" value="user" />


            <!-- Password -->
            <div>
                <x-input-label for="password" :value="__('Password')" />
                <x-text-input id="password" class="block w-full mt-1" type="password" name="password" required />
                <x-input-error :messages="$errors->get('password')" class="mt-1" />
            </div>

            <!-- Confirm Password -->
            <div>
                <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                <x-text-input id="password_confirmation" class="block w-full mt-1" type="password" name="password_confirmation" required />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1" />
            </div>
        </div>

        <!-- Buttons -->
        <div class="flex justify-end gap-4 mt-6">
            <button onclick="closeModal('addUserModal')"
                class="border border-gray-400 text-gray-600 px-4 py-2 rounded-md text-sm">
                Cancel
            </button>
            <button id="modalActionBtn" onclick="submitAddUser()"
                class="bg-[#1B76B5] text-white px-4 py-2 rounded-md text-sm hover:bg-[#166799]">
                Add User
            </button>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteUserModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
    <div class="bg-white rounded-lg p-6 w-full max-w-md text-center shadow-lg">
        <h2 class="text-lg font-semibold text-gray-800 mb-4">Confirm Delete</h2>
        <p class="text-gray-600 mb-6">Are you sure you want to delete this user?</p>
        <div class="flex justify-center gap-4">
            <button onclick="closeModal('deleteUserModal')" class="px-4 py-2 rounded-md border text-gray-700">Cancel</button>
            <button id="confirmDeleteBtn" class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600">Delete</button>
        </div>
    </div>
</div>
