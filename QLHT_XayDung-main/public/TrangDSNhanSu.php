<?php
    include 'ketnoi.php'; 
    /** @var mysqli $conn */ 
    
    // Câu lệnh truy vấn lấy danh sách nhân sự
    $sql = "SELECT * FROM nhan_su ORDER BY id DESC";
    $result = mysqli_query($conn, $sql);
?>

<link rel="stylesheet" href="css/danhsachnhansu.css">

<div class="duan-container" style="width: 100%; max-width: 100% !important; padding: 20px 40px;">
    <div class="header-top-ql" style="background: #1e3c72; padding: 25px 30px; border-radius: 12px; margin-bottom: 25px; color: white;">
        <div class="header-title-ql">
            <h1><i class="fas fa-users-cog"></i> HỆ THỐNG QUẢN LÝ NHÂN SỰ</h1>
            <p style="margin-top: 8px; opacity: 0.9;">Quản lý hồ sơ cán bộ, kỹ sư và đội ngũ thi công VLUTE</p>
        </div>
    </div>

    <div class="action-bar" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <div class="search-box-custom" style="position: relative; width: 450px; background: #fff; border: 1px solid #ddd; border-radius: 25px; padding: 10px 20px; display: flex; align-items: center; box-shadow: 0 2px 5px rgba(0,0,0,0.05);">
            <i class="fas fa-search" style="color: #aaa;"></i>
            <input type="text" id="searchStaff" placeholder="Tìm tên, mã nhân viên, chuyên ngành hoặc chức vụ..." 
                   style="border: none; outline: none; width: 100%; margin-left: 10px; font-size: 14px;">
        </div>
        
        <a href="trangchu.php?p=themnhansu" class="btn-add-project" style="text-decoration: none; background: #28a745; color: white; padding: 12px 25px; border-radius: 8px; font-weight: bold; display: flex; align-items: center; gap: 8px;">
            <i class="fas fa-user-plus"></i> Thêm nhân sự mới
        </a>
    </div>

    <div class="table-card-custom" style="background: white; padding: 20px; border-radius: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.05);">
        <table class="main-table" id="staffTable" style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="text-align: left; border-bottom: 2px solid #f0f0f0;">
                    <th style="padding: 15px; width: 22%;">Họ và Tên</th>
                    <th style="padding: 15px; width: 10%;">Năm sinh</th>
                    <th style="padding: 15px; width: 15%;">Chức vụ</th>
                    <th style="padding: 15px; width: 15%;">Chuyên ngành</th>
                    <th style="padding: 15px; width: 15%;">Đơn vị công tác</th>
                    <th style="padding: 15px; width: 13%;">Số điện thoại</th>
                    <th style="padding: 15px; width: 10%; text-align: center;">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                if(mysqli_num_rows($result) > 0) {
                    while($row = mysqli_fetch_assoc($result)) { 
                ?>
                <tr class="staff-row" style="border-bottom: 1px solid #eee;">
                    <td style="padding: 15px;">
                        <div class="project-cell" style="display: flex; align-items: center; gap: 12px;">
                            <div class="project-icon-box" style="width: 40px; height: 40px; background: #f0f4f8; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #1e3c72;">
                                <i class="fas <?php echo ($row['chuc_vu'] == 'Kế toán trưởng' || $row['chuc_vu'] == 'Kế toán') ? 'fa-user-shield' : 'fa-user-tie'; ?>"></i>
                            </div>
                            <div>
                                <div style="font-weight: bold; color: #333;"><?php echo $row['ho_ten']; ?></div>
                                <div style="font-size: 12px; color: #888;">Mã NV: #<?php echo $row['ma_nv']; ?></div>
                            </div>
                        </div>
                    </td>
                    <td style="padding: 15px;"><?php echo $row['nam_sinh']; ?></td>
                    <td style="padding: 15px; font-weight: 600;"><?php echo $row['chuc_vu']; ?></td>
                    <td style="padding: 15px;"><?php echo $row['chuyen_nganh']; ?></td>
                    <td style="padding: 15px;"><?php echo $row['don_vi']; ?></td>
                    <td style="padding: 15px; font-weight: 600;"><?php echo $row['so_dien_thoai']; ?></td>
                    <td style="padding: 15px;">
                        <div class="action-btns" style="display: flex; gap: 8px; justify-content: center;">
                            <a href="trangchu.php?p=suanhansu&id=<?php echo $row['id']; ?>" class="btn-circle btn-edit" style="color: #fb8c00; background: #fff3e0; width: 35px; height: 35px; border-radius: 8px; display: flex; align-items: center; justify-content: center; text-decoration: none;">
                                <i class="fas fa-pen"></i>
                            </a>
                            <button class="btn-circle btn-del" onclick="confirmDelete(<?php echo $row['id']; ?>)" style="color: #e53935; background: #ffebee; border: none; width: 35px; height: 35px; border-radius: 8px; display: flex; align-items: center; justify-content: center; cursor: pointer;">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                <?php 
                    } 
                } else {
                    echo "<tr><td colspan='7' style='text-align:center; padding: 30px; color: #999;'>Chưa có dữ liệu nhân sự.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<script>
// 1. Chức năng Xóa
function confirmDelete(id) {
    if(confirm('Bạn có chắc chắn muốn xóa nhân sự này khỏi hệ thống?')) {
        window.location.href = 'xuly_xoanhansu.php?id=' + id;
    }
}

// 2. CHỨC NĂNG TÌM KIẾM HOÀN CHỈNH
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchStaff');
    const tableRows = document.querySelectorAll('.staff-row');

    searchInput.addEventListener('input', function() {
        const query = this.value.toLowerCase().trim();

        tableRows.forEach(row => {
            // Lấy text từ các cột quan trọng để tìm kiếm
            const rowText = row.innerText.toLowerCase();
            
            // Nếu nội dung hàng chứa từ khóa tìm kiếm
            if (rowText.includes(query)) {
                row.style.display = ''; // Hiện hàng
                row.style.animation = 'fadeIn 0.3s ease';
            } else {
                row.style.display = 'none'; // Ẩn hàng
            }
        });

        // Hiển thị thông báo nếu không tìm thấy kết quả nào
    });
});
</script>

<style>
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(5px); }
    to { opacity: 1; transform: translateY(0); }
}
</style>