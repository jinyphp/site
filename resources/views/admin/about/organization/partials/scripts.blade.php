<!-- SortableJS for drag and drop -->
<script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>

<script>
let isTreeViewActive = false;

// 트리 뷰 토글
function toggleTreeView() {
    const treeView = document.getElementById('tree-view');
    const tableView = document.getElementById('table-view');

    if (isTreeViewActive) {
        // 테이블 뷰로 전환
        treeView.style.display = 'none';
        tableView.style.display = 'block';
        isTreeViewActive = false;
    } else {
        // 트리 뷰로 전환
        treeView.style.display = 'block';
        tableView.style.display = 'none';
        isTreeViewActive = true;
        initializeSortable();
    }
}

// Sortable 초기화
function initializeSortable() {
    // 테이블 리스트의 Sortable
    const sortableList = document.getElementById('sortable-list');
    if (sortableList) {
        new Sortable(sortableList, {
            handle: '.drag-handle',
            animation: 150,
            ghostClass: 'sortable-ghost',
            chosenClass: 'sortable-chosen',
            onEnd: function(evt) {
                updateTableOrder();
            }
        });
    }

    // 트리 뷰의 Sortable
    const sortableTree = document.getElementById('sortable-tree');
    if (sortableTree) {
        new Sortable(sortableTree, {
            handle: '.drag-handle',
            animation: 150,
            ghostClass: 'sortable-ghost',
            chosenClass: 'sortable-chosen',
            onEnd: function(evt) {
                updateTreeOrder();
            }
        });
    }
}

// 테이블 정렬 순서 업데이트
function updateTableOrder() {
    const rows = document.querySelectorAll('#sortable-list tr[data-id]');
    const orders = [];

    rows.forEach((row, index) => {
        const id = row.getAttribute('data-id');
        orders.push({
            id: parseInt(id),
            sort_order: index + 1
        });
    });

    updateOrderOnServer(orders);
}

// 트리 정렬 순서 업데이트
function updateTreeOrder() {
    const nodes = document.querySelectorAll('.tree-node[data-id]');
    const orders = [];

    nodes.forEach((node, index) => {
        const id = node.getAttribute('data-id');
        orders.push({
            id: parseInt(id),
            sort_order: index + 1
        });
    });

    updateOrderOnServer(orders);
}

// 서버에 정렬 순서 업데이트 요청
function updateOrderOnServer(orders) {
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

    if (!csrfToken) {
        console.error('CSRF 토큰을 찾을 수 없습니다.');
        return;
    }

    fetch('{{ route("admin.cms.about.organization.update-order") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            orders: orders
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // 성공 메시지 표시
            showMessage('정렬 순서가 성공적으로 업데이트되었습니다.', 'success');
        } else {
            showMessage('정렬 순서 업데이트에 실패했습니다: ' + data.message, 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showMessage('정렬 순서 업데이트 중 오류가 발생했습니다.', 'error');
    });
}

// 메시지 표시
function showMessage(message, type = 'info') {
    // Bootstrap toast 또는 alert 사용
    const alertClass = type === 'success' ? 'alert-success' :
                      type === 'error' ? 'alert-danger' : 'alert-info';

    const alertHtml = `
        <div class="alert ${alertClass} alert-dismissible fade show" role="alert">
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    `;

    // 페이지 상단에 메시지 표시
    const container = document.querySelector('.container-fluid');
    if (container) {
        const tempDiv = document.createElement('div');
        tempDiv.innerHTML = alertHtml;
        container.insertBefore(tempDiv.firstElementChild, container.firstElementChild);

        // 3초 후 자동 제거
        setTimeout(() => {
            const alert = container.querySelector('.alert');
            if (alert) {
                alert.remove();
            }
        }, 3000);
    }
}

// 페이지 로드 시 초기화
document.addEventListener('DOMContentLoaded', function() {
    // 테이블 뷰에서도 드래그 앤 드롭 활성화
    initializeSortable();

    // 드래그 핸들 스타일 추가
    const style = document.createElement('style');
    style.textContent = `
        .sortable-ghost {
            opacity: 0.4;
        }
        .sortable-chosen {
            background-color: #f8f9fa;
        }
        .drag-handle {
            cursor: move;
        }
        .drag-handle:hover {
            color: #007bff;
        }
    `;
    document.head.appendChild(style);
});

// 확인 대화상자
function confirmDelete(organizationName) {
    return confirm(`정말로 '${organizationName}' 조직을 삭제하시겠습니까?\n\n주의: 하위 조직이나 팀 멤버가 있는 경우 삭제할 수 없습니다.`);
}

// 검색 폼 자동 제출 (디바운스 적용)
let searchTimeout;
function debounceSearch() {
    clearTimeout(searchTimeout);
    searchTimeout = setTimeout(function() {
        document.querySelector('form').submit();
    }, 500);
}

// 검색 입력 필드에 이벤트 리스너 추가
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.querySelector('input[name="search"]');
    if (searchInput) {
        searchInput.addEventListener('input', debounceSearch);
    }
});
</script>