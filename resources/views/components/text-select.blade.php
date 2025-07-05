@props([
    'disabled' => false,
])

<select
    @disabled($disabled)
    {{ $attributes->merge(['class' => 'border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm px-3 py-2 w-full text-sm']) }}>
    {{ $slot }}
</select>
