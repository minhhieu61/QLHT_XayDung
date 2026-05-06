<?php
    include 'ketnoi.php'; // Đảm bảo file này chứa kết nối $conn
    /** @var mysqli $conn */ // Dòng này giúp VS Code nhận diện biến $conn
    // Câu lệnh truy vấn lấy danh sách nhân sự
    $sql = "SELECT * FROM nhan_su ORDER BY id DESC";
    $result = mysqli_query($conn, $sql);
?>

<link rel="stylesheet" href="css/danhsachnhansu.css">

<div class="duan-container">
    <div class="header-top-ql">
        <div class="header-title-ql">
            <h1><i class="fas fa-users-cog"></i> HỆ THỐNG QUẢN LÝ NHÂN SỰ</h1>
            <p>Quản lý hồ sơ cán bộ, kỹ sư và đội ngũ thi công VLUTE CMS</p>
        </div>
    </div>

    <div class="action-bar">
        <div class="search-box-custom">
            <i class="fas fa-search" style="color: #ccc;"></i>
            <input type="text" id="searchStaff" placeholder="Tìm tên nhân viên, chuyên ngành...">
        </div>
        
        <a href="trangchu.php?p=themnhansu" class="btn-add-project" style="text-decoration: none;">
            <i class="fas fa-user-plus"></i> Thêm nhân sự mới
        </a>
    </div>

    <div class="table-card-custom">
        <table class="main-table">
            <thead>
                <tr>
                    <th style="width: 22%;">Họ và Tên</th>
                    <th style="width: 10%;">Năm sinh</th>
                    <th style="width: 15%;">Chức vụ</th>
                    <th style="width: 15%;">Chuyên ngành</th>
                    <th style="width: 15%;">Đơn vị công tác</th>
                    <th style="width: 13%;">Số điện thoại</th>
                    <th style="width: 10%;">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                if(mysqli_num_rows($result) > 0) {
                    while($row = mysqli_fetch_assoc($result)) { 
                ?>
                <tr>
                    <td>
                        <div class="project-cell">
                            <div class="project-icon-box">
                                <i class="fas <?php echo ($row['chuc_vu'] == 'Kế toán trưởng' || $row['chuc_vu'] == 'Kế toán') ? 'fa-user-shield' : 'fa-user-tie'; ?>"></i>
                            </div>
                            <div>
                                <span class="text-bold"><?php echo $row['ho_ten']; ?></span>
                                <span class="text-sub">Mã NV: #<?php echo $row['ma_nv']; ?></span>
                            </div>
                        </div>
                    </td>
                    <td><?php echo $row['nam_sinh']; ?></td>
                    <td><span class="text-bold"><?php echo $row['chuc_vu']; ?></span></td>
                    <td><?php echo $row['chuyen_nganh']; ?></td>
                    <td><?php echo $row['don_vi']; ?></td>
                    <td><span class="text-bold"><?php echo $row['so_dien_thoai']; ?></span></td>
                    <td>
                        <div class="action-btns">
                            <a href="trangchu.php?p=chitietnhansu&id=<?php echo $row['id']; ?>" class="btn-circle btn-view" title="Xem">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="trangchu.php?p=suanhansu&id=<?php echo $row['id']; ?>" class="btn-circle btn-edit" title="Sửa">
                                <i class="fas fa-pen"></i>
                            </a>
                            <button class="btn-circle btn-del" onclick="confirmDelete(<?php echo $row['id']; ?>)" title="Xóa">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                <?php 
                    } 
                } else {
                    echo "<tr><td colspan='7' style='text-align:center;'>Chưa có dữ liệu nhân sự.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<script>
function confirmDelete(id) {
    if(confirm('Bạn có chắc chắn muốn xóa nhân sự này khỏi hệ thống?')) {
        window.location.href = 'xuly_xoanhansu.php?id=' + id;
    }
}
</script>