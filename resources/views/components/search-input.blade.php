@props(['disabled' => false])

<div x-data="{
    showClear: false,
    check() {
        this.showClear = this.$refs.searchInput.value.length > 0;
    }
}" class="relative w-full">
    <input type="text" autocomplete="off" @disabled($disabled) x-ref="searchInput" x-on:input="check()"
        x-on:focus="check()" x-on:blur="setTimeout(() => showClear = false, 150)" {{-- delay hide to allow button click --}}
        {{ $attributes->merge([
            'class' =>
                'border border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm px-3 py-1.5 text-sm w-full pr-10',
        ]) }} />

    <!-- Clear button -->
    <button type="button" x-show="showClear" x-ref="clearBtn"
        @click="$refs.searchInput.value=''; $refs.searchInput.dispatchEvent(new Event('input')); showClear = false"
        class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400 text-sm hover:text-gray-600 focus:outline-none"
        title="Clear">
        X
    </button>
</div>
