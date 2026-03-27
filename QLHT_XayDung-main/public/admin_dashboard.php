<?php
session_start();
require_once __DIR__ . '/../app/Controllers/AccountController.php';
require_once __DIR__ . '/../app/Core/Database.php';

$controller = new AccountController();

// 1. Bảo mật
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: dangnhap.php");
    exit();
}

// 2. Định nghĩa Mô tả Vai trò
$role_info = [
    'admin'   => [
        'label' => 'Quản trị viên',
        'desc'  => 'Quản lý tài khoản, cấu hình hệ thống, sao lưu dữ liệu. Không can thiệp sâu vào chuyên môn.',
        'class' => 'badge-admin'
    ],
    'manager' => [
        'label' => 'Quản lý',
        'desc'  => 'Điều hành dự án, phân công nhiệm vụ và duyệt báo cáo tiến độ công trình.',
        'class' => 'badge-manager'
    ],
    'user'    => [
        'label' => 'Người dùng',
        'desc'  => 'Thực hiện nhiệm vụ được giao, cập nhật tiến độ và báo cáo vật tư hằng ngày.',
        'class' => 'badge-user'
    ]
];

// 3. Xử lý lưu dữ liệu (Thêm hoặc Sửa)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST['user_id'])) {
        $controller->handleEdit();
    } else {
        $controller->handleAdd();
    }
}

$data = $controller->index();
$page_title = "Quản lý hệ thống";

include __DIR__ . '/../resources/views/layouts/admin/admin_header.php';
include __DIR__ . '/../resources/views/layouts/admin/admin_sidebar.php';
?>

<main class="content-area">
    <header class="main-header">
        <div class="header-title">
            <h1>QUẢN LÝ NGƯỜI DÙNG</h1>
            <p>Hệ thống hiện có <strong><?php echo $data['total_acc']; ?></strong> tài khoản.</p>
        </div>
    </header>

    <section class="dashboard-grid">
        
        <div class="stat-card" onclick="filterByRole('user')" id="card-user" style="cursor: pointer;">
            <div class="stat-icon icon-user"><i class="fas fa-user"></i></div>
            <div>
                <h4>Người dùng</h4>
                <span class="number"><?php echo $data['total_user']; ?></span>
            </div>
        </div>
        <div class="stat-card" onclick="filterByRole('manager')" id="card-manager" style="cursor: pointer;">
            <div class="stat-icon icon-manager"><i class="fas fa-user-tie"></i></div>
            <div>
                <h4>Quản lý</h4>
                <span class="number"><?php echo $data['total_manager']; ?></span>
            </div>
        </div>
        <div class="stat-card" onclick="filterByRole('admin')" id="card-admin" style="cursor: pointer;">
            <div class="stat-icon icon-admin"><i class="fas fa-user-shield"></i></div>
            <div>
                <h4>Quản trị viên</h4>
                <span class="number"><?php echo $data['total_admin']; ?></span>
            </div>
        </div>
    </section>

    <div class="admin-toolbar">
        <button class="btn-add-account" onclick="openAddModal()">
            <i class="fas fa-plus"></i> Thêm tài khoản mới
        </button>

        <div class="search-box">
            <i class="fas fa-search"></i>
            <input type="text" id="searchInput" onkeyup="searchUser()" placeholder="Tìm tên hoặc tên đăng nhập...">
        </div>
    </div>

    <div class="table-container">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Họ và Tên</th>
                    <th>Tên đăng nhập</th>
                    <th width="35%">Vai trò & Chức năng</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody id="accountTableBody">
                <?php if ($data['accounts'] && $data['accounts']->num_rows > 0): ?>
                    <?php while ($row = $data['accounts']->fetch_assoc()): ?>
                        <tr class="account-row" data-role="<?php echo $row['role']; ?>">
                            <td>#<?php echo $row['id']; ?></td>
                            <td class="fullname-cell"><strong><?php echo htmlspecialchars($row['fullname']); ?></strong></td>
                            <td class="username-cell"><code><?php echo htmlspecialchars($row['username']); ?></code></td>
                            <td>
                                <span class="badge <?php echo $role_info[$row['role']]['class'] ?? ''; ?>">
                                    <?php echo $role_info[$row['role']]['label'] ?? $row['role']; ?>
                                </span>
                                <p class="role-description"><?php echo $role_info[$row['role']]['desc'] ?? ''; ?></p>
                            </td>
                            <td><?php echo date('d/m/Y', strtotime($row['created_at'])); ?></td>
                            <td>
                                <button class="btn-edit" onclick="openEditModal({
                                        id: '<?php echo $row['id']; ?>', 
                                        fullname: '<?php echo addslashes($row['fullname']); ?>', 
                                        username: '<?php echo addslashes($row['username']); ?>', 
                                        role: '<?php echo $row['role']; ?>'
                                    })">
                                    <i class="fas fa-edit"></i> Sửa
                                </button>
                                <a href="delete_account.php?id=<?php echo $row['id']; ?>" class="btn-delete" onclick="return confirm('Bạn có chắc chắn muốn xóa tài khoản này?')">
                                    <i class="fas fa-trash-alt"></i> Xóa
                                </a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</main>

<div id="accountModal" class="modal" style="display: none; position: fixed; z-index: 1000; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5);">
    <div class="modal-content" style="background-color: #fff; margin: 10% auto; padding: 20px; border-radius: 8px; width: 400px; position: relative;">
        <span class="close-btn" onclick="closeModal()" style="position: absolute; right: 20px; cursor: pointer; font-size: 24px;">&times;</span>
        <h2 id="modalTitle">Thêm Tài Khoản</h2>
        <form id="accountForm" method="POST" action="">
            <input type="hidden" name="user_id" id="modal_user_id">
            <div style="margin-bottom: 15px;">
                <label>Họ và Tên</label><br>
                <input type="text" name="fullname" id="modal_fullname" required style="width: 100%; padding: 8px; border: 1px solid #ddd;">
            </div>
            <div style="margin-bottom: 15px;" id="usernameGroup">
                <label>Tên đăng nhập</label><br>
                <input type="text" name="username" id="modal_username" required style="width: 100%; padding: 8px; border: 1px solid #ddd;">
            </div>
            <div style="margin-bottom: 15px;">
                <label id="passLabel">Mật khẩu</label><br>
                <input type="password" name="password" id="modal_password" style="width: 100%; padding: 8px; border: 1px solid #ddd;">
            </div>
            <div style="margin-bottom: 15px;">
                <label>Vai trò</label><br>
                <select name="role" id="modal_role" style="width: 100%; padding: 8px;">
                    <option value="user">Người dùng</option>
                    <option value="manager">Quản lý</option>
                    <option value="admin">Quản trị viên</option>
                </select>
            </div>
            <button type="submit" name="btn_save_account" id="submitBtn" class="btn-save-confirm" style="width: 100%; padding: 10px; background: #3498db; color: white; border: none; border-radius: 5px; cursor: pointer;">XÁC NHẬN</button>
        </form>
    </div>
</div>

<style>
    .admin-toolbar {
        display: flex;
        align-items: center;
        gap: 20px;
        margin: 20px 0;
    }

    .search-box {
        position: relative;
        flex: 1;
        max-width: 400px;
    }

    .search-box i {
        position: absolute;
        left: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: #999;
    }

    .search-box input {
        width: 100%;
        padding: 10px 10px 10px 40px;
        border: 1px solid #ddd;
        border-radius: 25px;
        outline: none;
        transition: 0.3s;
    }

    .search-box input:focus {
        border-color: #3498db;
        box-shadow: 0 0 8px rgba(52, 152, 219, 0.2);
    }

    .role-description {
        font-size: 12px;
        color: #777;
        margin-top: 4px;
    }

    .badge-admin {
        background: #ff4757;
        color: white;
        padding: 3px 8px;
        border-radius: 4px;
    }

    .badge-manager {
        background: #ffa502;
        color: white;
        padding: 3px 8px;
        border-radius: 4px;
    }

    .badge-user {
        background: #2ed573;
        color: white;
        padding: 3px 8px;
        border-radius: 4px;
    }

    .icon-admin {
        color: #ff4757;
    }

    .icon-manager {
        color: #ffa502;
    }

    .icon-user {
        color: #2ed573;
    }
</style>

<!-- <script>
    let currentRole = 'all';

    // Hàm mở Modal thêm
    function openAddModal() {
        document.getElementById('modalTitle').innerText = "Thêm Tài Khoản Mới";
        document.getElementById('accountForm').reset();
        document.getElementById('modal_user_id').value = "";
        document.getElementById('accountModal').style.display = "block";
    }

    // Hàm mở Modal sửa
    function openEditModal(row) {
        document.getElementById('modalTitle').innerText = "Sửa Tài Khoản";
        document.getElementById('modal_user_id').value = row.id;
        document.getElementById('modal_fullname').value = row.fullname;
        document.getElementById('modal_username').value = row.username;
        document.getElementById('modal_role').value = row.role;
        document.getElementById('modal_password').placeholder = "Để trống nếu không đổi";
        document.getElementById('accountModal').style.display = "block";
    }

    function closeModal() {
        document.getElementById('accountModal').style.display = "none";
    }

    function filterByRole(role) {
        currentRole = role;
        searchUser();
    }

    function searchUser() {
        const input = document.getElementById('searchInput').value.toLowerCase();
        const rows = document.querySelectorAll('.account-row');
        rows.forEach(row => {
            const fullname = row.querySelector('.fullname-cell').innerText.toLowerCase();
            const username = row.querySelector('.username-cell').innerText.toLowerCase();
            const role = row.getAttribute('data-role');
            const matchesRole = (currentRole === 'all' || role === currentRole);
            const matchesSearch = (fullname.includes(input) || username.includes(input));
            row.style.display = (matchesRole && matchesSearch) ? "" : "none";
        });
    }

    // Đóng modal khi click ra ngoài
    window.onclick = function(event) {
        let modal = document.getElementById('accountModal');
        if (event.target == modal) {
            closeModal();
        }
    }
</script> -->
<?php include __DIR__ . '/../resources/views/layouts/admin/admin_footer.php'; ?>