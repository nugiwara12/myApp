<x-feedback.table />
<x-feedback.modal />

<script>
    let allFeedbacks = [];
    let selectedBulkIds = [];

    window.fetchFeedbacks = function() {
        axios.get('/getFeedback')
            .then(res => {
                allFeedbacks = res.data;
                renderFeedbacks(allFeedbacks);
            });
    };

    function renderFeedbacks(data) {
        const tbody = document.getElementById("feedbackTableBody");
        tbody.innerHTML = "";

        if (data.length === 0) {
            tbody.innerHTML =
                `<tr><td colspan="5" class="px-4 py-4 text-center text-gray-400">No feedback found.</td></tr>`;
            return;
        }

        data.forEach(item => {
            const tr = document.createElement("tr");
            tr.innerHTML = `
                <td class="px-4 py-2"><input type="checkbox" class="rowCheckbox" value="${item.id}" onchange="toggleCheckbox()"></td>
                <td class="px-4 py-2 whitespace-nowrap">${item.name}</td>
                <td class="px-4 py-2 text-gray-600">${item.message}</td>
                <td class="px-4 py-2 text-gray-500">${new Date(item.created_at).toLocaleString()}</td>
                <td class="px-4 py-2">
                    <button onclick="showConfirmModal(${item.id})"
                        class="bg-red-600 hover:bg-red-700 text-white text-xs px-3 py-1 rounded">
                        Delete
                    </button>
                </td>
            `;
            tbody.appendChild(tr);
        });

        document.getElementById('selectAll').checked = false;
        document.getElementById('deleteSelectedBtn').disabled = true;
    }

    function toggleSelectAll(source) {
        document.querySelectorAll('.rowCheckbox').forEach(cb => {
            cb.checked = source.checked;
        });
        toggleCheckbox();
    }

    function toggleCheckbox() {
        const selected = document.querySelectorAll('.rowCheckbox:checked');
        document.getElementById('deleteSelectedBtn').disabled = selected.length === 0;
    }

    window.deleteSelectedFeedbacks = function() {
        selectedBulkIds = Array.from(document.querySelectorAll('.rowCheckbox:checked')).map(cb => cb.value);
        if (selectedBulkIds.length === 0) return;

        document.getElementById('bulkConfirmText').innerText =
            `Are you sure you want to delete ${selectedBulkIds.length} selected feedback(s)?`;

        const modal = document.getElementById('bulkConfirmModal');
        const modalContent = document.getElementById('bulkConfirmModalContent');

        modal.classList.remove('hidden');
        setTimeout(() => {
            modalContent.classList.remove('scale-95', 'opacity-0');
            modalContent.classList.add('scale-100', 'opacity-100');
        }, 10);
    };

    window.closeBulkConfirmModal = function() {
        const modal = document.getElementById('bulkConfirmModal');
        const modalContent = document.getElementById('bulkConfirmModalContent');

        modalContent.classList.remove('scale-100', 'opacity-100');
        modalContent.classList.add('scale-95', 'opacity-0');
        setTimeout(() => modal.classList.add('hidden'), 200);
    };

    document.getElementById('confirmBulkDeleteBtn').addEventListener('click', function() {
        axios.post('/feedback/bulk-delete', {
            ids: selectedBulkIds
        }).then(() => {
            showToast("Selected feedbacks deleted", "success");
            fetchFeedbacks();
        }).catch(() => {
            showToast("Failed to delete selected feedbacks", "error");
        }).finally(() => {
            closeBulkConfirmModal();
        });
    });

    function showToast(message, type = 'success') {
        let container = document.getElementById('toast-container');
        const toast = document.createElement('div');
        toast.className = `flex items-center px-4 py-3 rounded shadow max-w-xs text-sm ${
            type === 'success' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'
        }`;
        toast.innerHTML = `
            <svg class="w-5 h-5 mr-2 ${type === 'success' ? 'text-green-500' : 'text-red-500'}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="${
                    type === 'success' ? 'M5 13l4 4L19 7' : 'M6 18L18 6M6 6l12 12'
                }" />
            </svg>
            <span>${message}</span>
        `;
        container.appendChild(toast);

        setTimeout(() => {
            toast.classList.add('opacity-0');
            toast.addEventListener('transitionend', () => toast.remove());
            toast.remove();
        }, 3000);
    }

    // Search filter
    document.addEventListener('DOMContentLoaded', function() {
        fetchFeedbacks();

        document.getElementById('searchInput').addEventListener('input', function(e) {
            const keyword = e.target.value.toLowerCase();
            const filtered = allFeedbacks.filter(fb =>
                fb.name.toLowerCase().includes(keyword) || fb.message.toLowerCase().includes(
                    keyword)
            );
            renderFeedbacks(filtered);
        });
    });
</script>
