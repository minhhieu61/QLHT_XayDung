<?php
/** @var mysqli $conn */
include 'ketnoi.php';

// 1. Lấy từ khóa tìm kiếm từ URL
$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';

// 2. Cập nhật truy vấn SQL để lọc theo tên công ty hoặc mã số thầu
$sql = "SELECT * FROM chuthau 
        WHERE ten_don_vi LIKE '%$search%' 
        OR ma_ct LIKE '%$search%' 
        OR nguoi_dai_dien LIKE '%$search%'
        ORDER BY id DESC";
        
$result = mysqli_query($conn, $sql);
?>

<link rel="stylesheet" href="css/danhsachchuthau.css">

<div class="chuthau-container">
    <div class="chuthau-header">
        <!-- FORM TÌM KIẾM -->
        <form method="GET" action="trangchu.php" class="search-box">
            <input type="hidden" name="p" value="danhsachchuthau">
            <i class="fas fa-search"></i>
            <input type="text" name="search" id="searchInput" 
                   placeholder="Tìm tên công ty, mã số thầu..." 
                   value="<?php echo htmlspecialchars($search); ?>">
            <button type="submit" style="display:none;">Tìm</button>
        </form>
        
        <a href="trangchu.php?p=themchuthau" class="btn-add-ct" style="text-decoration: none;">
            <i class="fas fa-plus-circle"></i> THÊM CHỦ THẦU
        </a>
    </div>

    <table class="chuthau-table" id="chuthauTable">
        <thead>
            <tr>
                <th>ĐƠN VỊ THẦU</th>
                <th>NGƯỜI ĐẠI DIỆN</th>
                <th>LIÊN HỆ</th>
                <th>TỔNG VỐN</th>
                <th>TRẠNG THÁI</th>
                <th>THAO TÁC</th>
            </tr>
        </thead>
        <tbody>
            <?php if (mysqli_num_rows($result) > 0): ?>
                <?php while($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td>
                        <div class="unit-info">
                            <div class="unit-logo">CT</div>
                            <div class="unit-text">
                                <div class="unit-name"><?php echo $row['ten_don_vi']; ?></div>
                                <div class="unit-id">Mã: <?php echo $row['ma_ct']; ?></div>
                            </div>
                        </div>
                    </td>
                    <td class="bold-text"><?php echo $row['nguoi_dai_dien']; ?></td>
                    <td>
                        <div class="contact-info">
                            <div class="phone"><i class="fas fa-phone-alt"></i> <?php echo $row['so_dien_thoai']; ?></div>
                            <div class="email-text"><?php echo $row['email']; ?></div>
                        </div>
                    </td>
                    <td class="price-text"><?php echo number_format($row['tong_von'], 0, ',', '.'); ?></td>
                    <td>
                        <?php 
                            $status_class = ($row['trang_thai'] == 'Đang hợp tác') ? 'status-active' : 'status-empty';
                        ?>
                        <span class="status-badge <?php echo $status_class; ?>">
                            <?php echo $row['trang_thai']; ?>
                        </span>
                    </td>
                    <td>
                        <div class="action-buttons">
                            <a href="trangchu.php?p=suachuthau&id=<?php echo $row['id']; ?>" class="btn-edit"><i class="fas fa-edit"></i></a>
                            <button class="btn-delete" onclick="confirmDelete(<?php echo $row['id']; ?>)"><i class="fas fa-trash"></i></button>
                        </div>
                    </td>
                </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="6" style="text-align:center; padding: 20px;">Không tìm thấy chủ thầu nào khớp với từ khóa.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- JAVASCRIPT TÌM KIẾM NHANH (LIVE SEARCH) -->
<script>
document.getElementById('searchInput').addEventListener('keyup', function() {
    let filter = this.value.toLowerCase();
    let rows = document.querySelectorAll('#chuthauTable tbody tr');

    rows.forEach(row => {
        // Lấy toàn bộ văn bản trong dòng (tên, mã, người đại diện)
        let text = row.innerText.toLowerCase();
        if (text.includes(filter)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
});

function confirmDelete(id) {
    if(confirm('Bạn có chắc chắn muốn xóa chủ thầu này?')) {
        window.location.href = 'xuly_xoachuthau.php?id=' + id;
    }
}
</script>