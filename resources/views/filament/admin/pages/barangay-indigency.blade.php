<style>
.custom-danger-button {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    white-space: nowrap;
    border: none;
    border-radius: 0.5rem; /* rounded-lg */
    background-color: #dc2626; /* bg-danger-600 (red) */
    color: white;
    padding: 0.5rem 1rem; /* py-2 px-4 */
    font-size: 0.875rem; /* text-sm */
    font-weight: 500; /* medium */
    box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
    transition: background-color 0.2s ease, box-shadow 0.2s ease;
    cursor: pointer;
}

.custom-danger-button:hover:not(:disabled) {
    background-color: #b91c1c; /* bg-danger-700 */
}

.custom-danger-button:focus {
    outline: none;
    box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.5); /* focus:ring-danger-500 */
}

.custom-danger-button:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}
</style>


<x-filament-panels::page>
    <livewire:indigency />
</x-filament-panels::page>
