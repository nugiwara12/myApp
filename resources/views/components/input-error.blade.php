@props(['for' => ''])

<label for="{{ $for }}" class="block text-sm font-medium text-gray-700">
    {{ $slot }}
</label>
