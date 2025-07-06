<script>
function Pagination({ currentPage, totalPages, totalData }) {
    const perPage = 5;
    const startPage = Math.floor((currentPage - 1) / perPage) * perPage + 1;
    const endPage = Math.min(startPage + perPage - 1, totalPages);
    const nextSetStart = Math.min(startPage + perPage, totalPages);
    const prevSetStart = Math.max(startPage - perPage, 1);

    return `
        <div class="flex flex-col sm:flex-row items-center justify-between gap-4 px-4 py-2">
            <!-- Show Entries Dropdown -->
            <div class="flex items-center text-sm">
                <label for="per_page" class="mr-2">Show</label>
                <select id="per_page" class="border border-gray-300 rounded px-6 py-1">
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
                <span class="ml-2">entries</span>
            </div>

            <!-- Pagination Buttons -->
            <div class="flex flex-wrap items-center justify-center gap-1">
                ${startPage > 1
                    ? `<button onclick="changePage(${prevSetStart})" class="px-3 py-1 border rounded-md text-gray-700 bg-white hover:bg-gray-100 text-lg">«</button>`
                    : `<span class="px-3 py-1 text-gray-400 border rounded-md cursor-not-allowed text-lg">«</span>`}

                ${currentPage > 1
                    ? `<button onclick="changePage(${currentPage - 1})" class="px-3 py-1 border rounded-md text-gray-700 bg-white hover:bg-gray-100 text-lg">‹</button>`
                    : `<span class="px-3 py-1 text-gray-400 border rounded-md cursor-not-allowed text-lg">‹</span>`}

                ${Array.from({ length: endPage - startPage + 1 }, (_, i) => {
                    const pageNum = startPage + i;
                    return `
                        <button onclick="changePage(${pageNum})"
                            class="px-3 py-2 text-sm rounded-md border shadow-sm transition-all duration-200 ${
                                currentPage === pageNum ? 'bg-[#1B76B5] text-white' : 'text-gray-700 bg-white hover:bg-gray-100'
                            }">
                            ${pageNum}
                        </button>
                    `;
                }).join('')}

                ${currentPage < totalPages
                    ? `<button onclick="changePage(${currentPage + 1})" class="px-3 py-1 border rounded-md text-gray-700 bg-white hover:bg-gray-100 text-lg">›</button>`
                    : `<span class="px-3 py-1 text-gray-400 border rounded-md cursor-not-allowed text-lg">›</span>`}

                ${endPage < totalPages
                    ? `<button onclick="changePage(${nextSetStart})" class="px-3 py-1 border rounded-md text-gray-700 bg-white hover:bg-gray-100 text-lg">»</button>`
                    : `<span class="px-3 py-1 text-gray-400 border rounded-md cursor-not-allowed text-lg">»</span>`}
            </div>
        </div>
    `;
}

// Handle page change
function changePage(page) {
    window.indigencyModal.fetchList(page);
}

// Handle per page dropdown change
document.addEventListener('DOMContentLoaded', () => {
    document.addEventListener('change', function (e) {
        if (e.target && e.target.id === 'per_page') {
            window.indigencyModal.perPage = parseInt(e.target.value);
            window.indigencyModal.fetchList(1);
        }
    });
});
</script>
