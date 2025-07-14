<script>
function Pagination({ currentPage, totalPages, totalData, perPage, namespace }) {
    const pagesPerGroup = 5;
    const startPage = Math.floor((currentPage - 1) / pagesPerGroup) * pagesPerGroup + 1;
    const endPage = Math.min(startPage + pagesPerGroup - 1, totalPages);
    const nextSetStart = Math.min(startPage + pagesPerGroup, totalPages);
    const prevSetStart = Math.max(startPage - pagesPerGroup, 1);
    const perPageId = `${namespace}_per_page`;

    return `
        <div class="flex flex-col sm:flex-row items-center justify-between gap-4 px-4 py-2">
            <div class="flex items-center text-sm">
                <label for="${perPageId}" class="mr-2">Show</label>
                <select id="${perPageId}" class="border border-gray-300 rounded px-6 py-1" data-namespace="${namespace}">
                    <option value="10" ${perPage == 10 ? 'selected' : ''}>10</option>
                    <option value="25" ${perPage == 25 ? 'selected' : ''}>25</option>
                    <option value="50" ${perPage == 50 ? 'selected' : ''}>50</option>
                    <option value="100" ${perPage == 100 ? 'selected' : ''}>100</option>
                </select>
                <span class="ml-2">entries</span>
            </div>

            <div class="flex flex-wrap items-center justify-center gap-1">
                ${startPage > 1
                    ? `<button onclick="changePage('${namespace}', ${prevSetStart})" class="px-3 py-1 border rounded-md text-gray-700 bg-white hover:bg-gray-100 text-lg">«</button>`
                    : `<span class="px-3 py-1 text-gray-400 border rounded-md cursor-not-allowed text-lg">«</span>`}

                ${currentPage > 1
                    ? `<button onclick="changePage('${namespace}', ${currentPage - 1})" class="px-3 py-1 border rounded-md text-gray-700 bg-white hover:bg-gray-100 text-lg">‹</button>`
                    : `<span class="px-3 py-1 text-gray-400 border rounded-md cursor-not-allowed text-lg">‹</span>`}

                ${Array.from({ length: endPage - startPage + 1 }, (_, i) => {
                    const pageNum = startPage + i;
                    return `
                        <button onclick="changePage('${namespace}', ${pageNum})"
                            class="px-3 py-2 text-sm rounded-md border shadow-sm transition-all duration-200 ${
                                currentPage === pageNum ? 'bg-[#1B76B5] text-white' : 'text-gray-700 bg-white hover:bg-gray-100'
                            }">
                            ${pageNum}
                        </button>
                    `;
                }).join('')}

                ${currentPage < totalPages
                    ? `<button onclick="changePage('${namespace}', ${currentPage + 1})" class="px-3 py-1 border rounded-md text-gray-700 bg-white hover:bg-gray-100 text-lg">›</button>`
                    : `<span class="px-3 py-1 text-gray-400 border rounded-md cursor-not-allowed text-lg">›</span>`}

                ${endPage < totalPages
                    ? `<button onclick="changePage('${namespace}', ${nextSetStart})" class="px-3 py-1 border rounded-md text-gray-700 bg-white hover:bg-gray-100 text-lg">»</button>`
                    : `<span class="px-3 py-1 text-gray-400 border rounded-md cursor-not-allowed text-lg">»</span>`}
            </div>
        </div>
    `;
}
</script>
