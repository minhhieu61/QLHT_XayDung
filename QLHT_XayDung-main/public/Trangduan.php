<?php
include 'ketnoi.php';
/** @var mysqli $conn */

// Lấy từ khóa tìm kiếm từ URL (nếu có)
$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';

// Truy vấn có điều kiện lọc
$sql = "SELECT id, ma_da, ten_du_an, chu_dau_tu, vi_tri, ngay_tao 
        FROM duan 
        WHERE ma_da LIKE '%$search%' 
           OR ten_du_an LIKE '%$search%' 
           OR chu_dau_tu LIKE '%$search%' 
           OR vi_tri LIKE '%$search%'
        ORDER BY ngay_tao DESC";

$result = mysqli_query($conn, $sql);
?>

<link rel="stylesheet" href="css/danhsachduan.css">

<div class="duan-container">
    <div class="header-top-ql">
        <div class="header-title-ql">
            <h1><i class="fas fa-layer-group"></i> QUẢN LÝ DỰ ÁN</h1>
            <p>Tìm kiếm và theo dõi các dự án hệ thống VLUTE</p>
        </div>
    </div>

    <div class="action-bar">
        <!-- Form tìm kiếm -->
        <form method="GET" action="trangchu.php" class="search-box-custom">
            <input type="hidden" name="p" value="danhsachduan">
            <i class="fas fa-search" style="color: #ccc;"></i>
            <input type="text" name="search" id="searchInput" 
                   placeholder="Tìm mã, tên dự án, vị trí..." 
                   value="<?php echo htmlspecialchars($search); ?>">
            <button type="submit" style="display:none;">Tìm</button>
        </form>
        
        <a href="trangchu.php?p=themduan" class="btn-add-project" style="text-decoration: none;">
            <i class="fas fa-plus-circle"></i> Thêm dự án
        </a>
    </div>

    <div class="table-card-custom">
        <table class="table-custom" id="projectTable">
            <thead>
                <tr>
                    <th>Mã dự án</th>
                    <th>Tên dự án</th>
                    <th>Chủ đầu tư</th>
                    <th>Vị trí</th>
                    <th>Ngày tạo</th>
                    <th style="text-align:center;">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                ?>
                <tr>
                    <td><strong><?php echo $row['ma_da']; ?></strong></td>
                    <td><?php echo $row['ten_du_an']; ?></td>
                    <td><?php echo $row['chu_dau_tu']; ?></td>
                    <td><i class="fas fa-map-marker-alt"></i> <?php echo $row['vi_tri']; ?></td>
                    <td><?php echo date('d/m/Y', strtotime($row['ngay_tao'])); ?></td>
                    <td style="text-align:center;">
                        <a href="trangchu.php?p=chitietduan&id=<?php echo $row['id']; ?>" class="btn-edit"><i class="fas fa-edit"></i></a>
                        <a href="xoaduan.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Xóa dự án này?')" class="btn-delete"><i class="fas fa-trash"></i></a>
                    </td>
                </tr>
                <?php 
                    } 
                } else {
                    echo "<tr><td colspan='6' style='text-align:center; padding: 20px;'>Không tìm thấy dự án nào khớp với từ khóa.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
    <script>
        document.getElementById('searchInput').addEventListener('keyup', function() {
            let filter = this.value.toLowerCase();
            let rows = document.querySelectorAll('#projectTable tbody tr');

            rows.forEach(row => {
                let text = row.innerText.toLowerCase();
                if (text.includes(filter)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
        </script>
</div>