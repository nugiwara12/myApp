<x-filament::page>
    <form wire:submit.prevent="submit">
        {{ $this->form }}

        <x-filament::button type="submit">
            Update Password
        </x-filament::button>
    </form>
</x-filament::page>
