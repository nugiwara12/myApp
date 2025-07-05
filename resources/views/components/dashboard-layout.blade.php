<div>
    <x-app-layout>
        <x-slot name="header">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                {{ $title ?? 'Dashboard' }}
            </h2>
        </x-slot>

        <div class="py-6">
            <div class="w-full mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </x-app-layout>
</div>
