<?php
// 1. Cấu hình kết nối Cơ sở dữ liệu bằng MySQLi
$host = 'localhost';
$username = 'root';
$password = '';
$dbname = 'qlht_xaydung_vlute';

$conn = new mysqli($host, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Lỗi kết nối cơ sở dữ liệu: " . $conn->connect_error);
}
$conn->set_charset("utf8");

// ==========================================
// XỬ LÝ ĐẶC BIỆT: TẢI TOÀN BỘ THƯ MỤC DỰ ÁN DƯỚI DẠNG FILE .ZIP
// ==========================================
if (isset($_GET['action']) && $_GET['action'] == 'download_folder' && !empty($_GET['ma_da'])) {
    $ma_da_zip = $conn->real_escape_string($_GET['ma_da']);

    // Lấy tên dự án để đặt tên cho file ZIP
    $res_da = $conn->query("SELECT ten_du_an FROM duan WHERE ma_da = '$ma_da_zip' LIMIT 1");
    $ten_zip = "Thu_muc_" . $ma_da_zip;
    if ($res_da && $res_da->num_rows > 0) {
        $row_da = $res_da->fetch_assoc();
        // Chuyển đổi tên dự án thành ký tự không dấu, gạch dưới để tránh lỗi hệ thống file
        $ten_zip = preg_replace('/[^A-Za-z0-9\-]/', '_', $row_da['ten_du_an']);
    }

    // Lấy toàn bộ file thuộc mã dự án này
    $res_files = $conn->query("SELECT ten_tai_lieu, duong_dan FROM tai_lieu WHERE ma_du_an = '$ma_da_zip'");

    if ($res_files && $res_files->num_rows > 0) {
        if (class_exists('ZipArchive')) {
            $zip = new ZipArchive();

            // Đảm bảo thư mục lưu trữ tạm thời tồn tại trên server
            $temp_dir = "uploads/documents/";
            if (!is_dir($temp_dir)) {
                mkdir($temp_dir, 0777, true);
            }

            $zip_filename = $temp_dir . $ten_zip . "_" . time() . ".zip";

            if ($zip->open($zip_filename, ZipArchive::CREATE) === TRUE) {
                $has_file = false;

                while ($f_row = $res_files->fetch_assoc()) {
                    $file_path = $f_row['duong_dan'];

                    // Sửa lỗi đường dẫn tương đối/tuyệt đối nếu chạy file ở cấp thư mục khác nhau
                    if (!file_exists($file_path)) {
                        $alternative_path = $_SERVER['DOCUMENT_ROOT'] . '/' . $file_path;
                        if (file_exists($alternative_path)) {
                            $file_path = $alternative_path;
                        }
                    }

                    // Nếu file có tồn tại thực tế trên ổ đĩa server thì đưa vào ZIP
                    if (file_exists($file_path)) {
                        $zip->addFile($file_path, $f_row['ten_tai_lieu']);
                        $has_file = true;
                    }
                }
                $zip->close();

                // Nếu có ít nhất 1 file được nén thành công thì đẩy về trình duyệt
                if ($has_file && file_exists($zip_filename)) {
                    // Xóa sạch bộ đệm đầu ra của PHP để tránh lỗi corrupt file nén (File 0 KB hoặc hỏng)
                    if (ob_get_level()) {
                        ob_end_clean();
                    }

                    header('Content-Type: application/zip');
                    header('Content-Disposition: attachment; filename="' . $ten_zip . '.zip"');
                    header('Content-Length: ' . filesize($zip_filename));
                    header('Pragma: no-cache');
                    header('Expires: 0');

                    readfile($zip_filename);
                    unlink($zip_filename); // Xóa file zip tạm trên server sau khi user tải xong
                    exit;
                } else {
                    echo "<script>alert('Lỗi: Hệ thống tìm thấy thông tin trên DB nhưng các tệp tin vật lý không tồn tại thực tế trong thư mục uploads/documents/!'); window.location.href='manager_dashboard.php?p=luutru_hoso';</script>";
                    exit;
                }
            } else {
                echo "<script>alert('Không thể tạo tệp nén ZIP tạm thời.'); window.location.href='manager_dashboard.php?p=luutru_hoso';</script>";
                exit;
            }
        } else {
            echo "<script>alert('Server PHP của bạn chưa bật tiện ích mở rộng ZipArchive!'); window.location.href='manager_dashboard.php?p=luutru_hoso';</script>";
            exit;
        }
    } else {
        echo "<script>alert('Thư mục này hiện tại đang trống (0 tài liệu), không có gì để tải về!'); window.location.href='manager_dashboard.php?p=luutru_hoso';</script>";
        exit;
    }
}

// ==========================================
// XỬ LÝ 1: TẠO THƯ MỤC DỰ ÁN THỦ CÔNG
// ==========================================
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action_create_folder'])) {
    $ma_da = trim($_POST['ma_da']);
    $ten_du_an = trim($_POST['ten_du_an']);

    if (!empty($ma_da) && !empty($ten_du_an)) {
        $ma_da_safe = $conn->real_escape_string($ma_da);
        $ten_da_safe = $conn->real_escape_string($ten_du_an);

        $check = $conn->query("SELECT id FROM duan WHERE ma_da = '$ma_da_safe'");
        if ($check->num_rows > 0) {
            echo "<script>alert('Lỗi: Mã thư mục/dự án này đã tồn tại!');</script>";
        } else {
            $sql_ins_folder = "INSERT INTO duan (ma_da, ten_du_an) VALUES ('$ma_da_safe', '$ten_da_safe')";
            if ($conn->query($sql_ins_folder)) {
                echo "<script>alert('Tạo thư mục dự án thành công!'); window.location.href='manager_dashboard.php?p=luutru_hoso';</script>";
            } else {
                echo "<script>alert('Lỗi khi tạo thư mục: " . $conn->error . "');</script>";
            }
        }
    }
}

// ==========================================
// XỬ LÝ 2: TẢI TÀI LIỆU VÀ ĐƯA VÀO FOLDER ĐÃ CHỌN
// ==========================================
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action_upload_file'])) {
    $ma_du_an = trim($_POST['target_ma_da']);
    $loai_tai_lieu = trim($_POST['loai_tai_lieu']);

    if (isset($_FILES['file_upload']) && $_FILES['file_upload']['error'] == 0) {
        $file_name = $_FILES['file_upload']['name'];
        $file_tmp = $_FILES['file_upload']['tmp_name'];
        $file_size_bytes = $_FILES['file_upload']['size'];

        if ($file_size_bytes >= 1048576) {
            $kich_thuoc = round($file_size_bytes / 1048576, 2) . ' MB';
        } else {
            $kich_thuoc = round($file_size_bytes / 1024, 2) . ' KB';
        }

        $upload_dir = 'uploads/documents/';
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        // Tạo tên file ngẫu nhiên bằng hàm time() để tránh trùng lặp đè file cũ
        $duong_dan = $upload_dir . time() . '_' . basename($file_name);

        if (move_uploaded_file($file_tmp, $duong_dan)) {
            $file_name_safe = $conn->real_escape_string($file_name);
            $loai_safe = $conn->real_escape_string($loai_tai_lieu);
            $ma_da_safe = $conn->real_escape_string($ma_du_an);
            $ngay_tai = date('Y-m-d H:i:s');

            $sql_ins_file = "INSERT INTO tai_lieu (ma_du_an, ten_tai_lieu, loai_tai_lieu, duong_dan, ngay_tai, kich_thuoc, ai_status) 
                             VALUES ('$ma_da_safe', '$file_name_safe', '$loai_safe', '$duong_dan', '$ngay_tai', '$kich_thuoc', 'Chưa phân tích')";

            if ($conn->query($sql_ins_file)) {
                echo "<script>alert('Tải lên tài liệu thành công!'); window.location.href='manager_dashboard.php?p=luutru_hoso';</script>";
            } else {
                echo "<script>alert('Lỗi lưu thông tin file vào CSDL: " . $conn->error . "');</script>";
            }
        } else {
            echo "<script>alert('Lỗi khi tải file lên hệ thống lưu trữ server.');</script>";
        }
    }
}

// Xử lý bộ lọc tìm kiếm hồ sơ tài liệu
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$filter_type = isset($_GET['type']) ? trim($_GET['type']) : '';

// Lấy danh sách thư mục dự án và đếm số lượng tài liệu bên trong mỗi thư mục đó
$sql_folders = "SELECT d.id, d.ten_du_an, d.ma_da,
                (SELECT COUNT(*) FROM tai_lieu WHERE ma_du_an = d.ma_da) AS so_tai_lieu 
                FROM duan d 
                ORDER BY d.id DESC";
$result_folders = $conn->query($sql_folders);

// Lấy danh sách tài liệu chi tiết
$sql_files = "SELECT t.id, t.ma_du_an, t.ten_tai_lieu, t.loai_tai_lieu, t.duong_dan, t.ai_status, t.ai_score, t.ngay_tai, t.kich_thuoc, d.ten_du_an 
              FROM tai_lieu t
              LEFT JOIN duan d ON t.ma_du_an = d.ma_da
              WHERE 1=1";

if (!empty($search)) {
    $search_safe = $conn->real_escape_string($search);
    $sql_files .= " AND (t.ten_tai_lieu LIKE '%$search_safe%' OR d.ten_du_an LIKE '%$search_safe%' OR t.ma_du_an LIKE '%$search_safe%' OR t.loai_tai_lieu LIKE '%$search_safe%')";
}

if (!empty($filter_type)) {
    $type_safe = $conn->real_escape_string($filter_type);
    $sql_files .= " AND t.loai_tai_lieu = '$type_safe'";
}

$sql_files .= " ORDER BY t.ngay_tai DESC";
$result_files = $conn->query($sql_files);
?>

<link rel="stylesheet" href="css/manager_luutru_hoso.css">
<style>
    /* CSS bổ trợ giao diện Modal đồng nhất */
    .custom-modal {
        display: none;
        position: fixed;
        z-index: 9999;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        align-items: center;
        justify-content: center;
    }

    .modal-content {
        background: #fff;
        padding: 25px;
        border-radius: 8px;
        width: 100%;
        max-width: 450px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        position: relative;
    }

    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        border-bottom: 1px solid #eee;
        padding-bottom: 10px;
    }

    .modal-header h3 {
        margin: 0;
        font-size: 18px;
        color: #2c3e50;
    }

    .close-btn {
        background: none;
        border: none;
        font-size: 20px;
        cursor: pointer;
        color: #aaa;
    }

    .close-btn:hover {
        color: #000;
    }

    .form-group {
        margin-bottom: 15px;
        display: flex;
        flex-direction: column;
        gap: 5px;
    }

    .form-group label {
        font-weight: bold;
        font-size: 14px;
        color: #34495e;
    }

    .form-control {
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
        font-size: 14px;
        width: 100%;
        box-sizing: border-box;
    }

    .modal-footer {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        margin-top: 20px;
    }

    .btn-download-folder {
        background: none;
        border: none;
        color: #3498db;
        padding: 5px 8px;
        border-radius: 4px;
        cursor: pointer;
        transition: 0.2s;
    }

    .btn-download-folder:hover {
        background: #ecf0f1;
        color: #2980b9;
    }
</style>

<div class="archive-wrapper">
    <div class="archive-header">
        <div class="header-title">
            <h2><i class="fas fa-folder-open"></i> Lưu trữ Hồ sơ & Tài liệu</h2>
            <p>Quản lý bản vẽ, hợp đồng và biên bản nghiệm thu tập trung</p>
        </div>
        <div class="header-actions">
            <button class="btn-outline" onclick="toggleModal('folderModal', true)">
                <i class="fas fa-folder-plus"></i> Tạo thư mục mới
            </button>
            <button class="btn-primary" onclick="toggleModal('uploadModal', true)">
                <i class="fas fa-upload"></i> Tải tài liệu mới
            </button>
        </div>
    </div>

    <div class="archive-filter-bar">
        <form action="" method="GET" style="display: flex; width: 100%; gap: 15px; align-items: center;">
            <input type="hidden" name="p" value="luutru_hoso">
            <div class="search-input" style="flex: 1; display: flex; align-items: center; background: #fff; padding: 0 10px; border: 1px solid #ccc; border-radius: 4px;">
                <i class="fas fa-search" style="color: #7f8c8d;"></i>
                <input type="text" name="search" value="<?php echo htmlspecialchars($search); ?>" placeholder="Tìm tên hồ sơ, mã dự án, loại tài liệu..." style="border: none; width: 100%; padding: 8px; outline: none;">
            </div>
            <div class="filter-group">
                <select name="type" onchange="this.form.submit()" style="padding: 8px; border: 1px solid #ccc; border-radius: 4px; min-width: 180px;">
                    <option value="">Tất cả loại hồ sơ</option>
                    <option value="Bản vẽ" <?php echo ($filter_type == 'Bản vẽ') ? 'selected' : ''; ?>>Bản vẽ kỹ thuật</option>
                    <option value="Hợp đồng" <?php echo ($filter_type == 'Hợp đồng') ? 'selected' : ''; ?>>Hợp đồng thầu</option>
                    <option value="Nghiệm thu" <?php echo ($filter_type == 'Nghiệm thu') ? 'selected' : ''; ?>>Biên bản nghiệm thu</option>
                </select>
            </div>
            <?php if (!empty($search) || !empty($filter_type)): ?>
                <a href="manager_dashboard.php?p=luutru_hoso" style="font-size: 13px; color: #e74c3c; text-decoration: none;"><i class="fas fa-times"></i> Xóa bộ lọc</a>
            <?php endif; ?>
        </form>
    </div>

    <div class="folder-section">
        <h3>Thư mục dự án hệ thống</h3>
        <div class="folder-grid">
            <?php if ($result_folders && $result_folders->num_rows > 0): ?>
                <?php
                $folders_data = [];
                while ($folder = $result_folders->fetch_assoc()):
                    $folders_data[] = $folder;
                ?>
                    <div class="folder-card" style="cursor: pointer; display: flex; justify-content: space-between; align-items: center;" onclick="window.location.href='manager_dashboard.php?p=luutru_hoso&search=<?php echo urlencode($folder['ma_da']); ?>'">
                        <div style="display: flex; align-items: center; gap: 12px;">
                            <i class="fas fa-folder" style="color: #f39c12; font-size: 24px;"></i>
                            <div class="folder-info">
                                <strong><?php echo htmlspecialchars($folder['ten_du_an']); ?></strong>
                                <span><?php echo $folder['so_tai_lieu'] > 0 ? $folder['so_tai_lieu'] . ' tài liệu' : 'Thư mục trống'; ?> (<?php echo htmlspecialchars($folder['ma_da']); ?>)</span>
                            </div>
                        </div>

                        <?php if ($folder['so_tai_lieu'] > 0): ?>
                            <button class="btn-download-folder" title="Tải xuống toàn bộ thư mục (.zip)"
                                onclick="event.stopPropagation(); window.location.href='manager_dashboard.php?p=luutru_hoso&action=download_folder&ma_da=<?php echo urlencode($folder['ma_da']); ?>'">
                                <i class="fas fa-download" style="font-size: 16px;"></i>
                            </button>
                        <?php endif; ?>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p style="color: #95a5a6; font-style: italic;">Chưa có dữ liệu thư mục dự án.</p>
            <?php endif; ?>
        </div>
    </div>

    <div class="file-list-section">
        <h3>Tài liệu mới cập nhật</h3>
        <table class="file-table">
            <thead>
                <tr>
                    <th>Tên tài liệu</th>
                    <th>Loại</th>
                    <th>Dự án (Mã)</th>
                    <th>Ngày tải</th>
                    <th>Kích thước</th>
                    <th style="text-align: center;">Đánh giá AI</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result_files && $result_files->num_rows > 0): ?>
                    <?php while ($file = $result_files->fetch_assoc()):
                        $file_ext = strtolower(pathinfo($file['ten_tai_lieu'], PATHINFO_EXTENSION));
                        $icon_class = 'fa-file-alt';
                        if ($file_ext == 'pdf') $icon_class = 'fa-file-pdf pdf-icon';
                        elseif (in_array($file_ext, ['doc', 'docx'])) $icon_class = 'fa-file-word word-icon';
                        elseif (in_array($file_ext, ['xls', 'xlsx'])) $icon_class = 'fa-file-excel excel-icon';

                        $ai_badge_color = '#7f8c8d';
                        if ($file['ai_status'] == 'completed' || $file['ai_status'] == 'Thành công') $ai_badge_color = '#2ecc71';
                        elseif ($file['ai_status'] == 'processing' || $file['ai_status'] == 'Đang xử lý') $ai_badge_color = '#f39c12';
                    ?>
                        <tr>
                            <td><i class="fas <?php echo $icon_class; ?>"></i> <strong><?php echo htmlspecialchars($file['ten_tai_lieu']); ?></strong></td>
                            <td><?php echo htmlspecialchars($file['loai_tai_lieu']); ?></td>
                            <td>
                                <?php if (!empty($file['ten_du_an'])): ?>
                                    <span><?php echo htmlspecialchars($file['ten_du_an']); ?></span> <small style="color: #7f8c8d;">(<?php echo htmlspecialchars($file['ma_du_an']); ?>)</small>
                                <?php else: ?>
                                    <span style="color: #95a5a6; font-style: italic;">Hệ thống chung</span>
                                <?php endif; ?>
                            </td>
                            <td><?php echo !empty($file['ngay_tai']) ? date('d/m/Y', strtotime($file['ngay_tai'])) : '---'; ?></td>
                            <td><?php echo htmlspecialchars($file['kich_thuoc'] ?: '---'); ?></td>
                            <td style="text-align: center;">
                                <span style="display: inline-block; padding: 3px 8px; font-size: 11px; background: <?php echo $ai_badge_color; ?>; color: #fff; border-radius: 12px; font-weight: bold;">
                                    <?php echo htmlspecialchars($file['ai_status']); ?>
                                </span>
                            </td>
                            <td class="file-actions">
                                <a href="<?php echo htmlspecialchars($file['duong_dan']); ?>" download title="Tải xuống" style="color: inherit; margin-right: 8px;"><i class="fas fa-download"></i></a>
                                <a href="<?php echo htmlspecialchars($file['duong_dan']); ?>" target="_blank" title="Xem trực tiếp" style="color: inherit; margin-right: 8px;"><i class="fas fa-eye"></i></a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" style="text-align: center; padding: 20px; color: #7f8c8d;">Không tìm thấy tài liệu phù hợp.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<div id="folderModal" class="custom-modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3><i class="fas fa-folder-plus"></i> Tạo thư mục dự án mới</h3>
            <button class="close-btn" onclick="toggleModal('folderModal', false)">&times;</button>
        </div>
        <form action="" method="POST">
            <input type="hidden" name="action_create_folder" value="1">
            <div class="form-group">
                <label>Mã thư mục (Mã dự án):</label>
                <input type="text" name="ma_da" class="form-control" placeholder="Ví dụ: DA_VLUTE_01" required>
            </div>
            <div class="form-group">
                <label>Tên thư mục (Tên dự án):</label>
                <input type="text" name="ten_du_an" class="form-control" placeholder="Ví dụ: Xây dựng nhà đa năng tòa B" required>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-outline" style="padding: 8px 15px;" onclick="toggleModal('folderModal', false)">Hủy</button>
                <button type="submit" class="btn-primary" style="padding: 8px 15px;">Tạo thư mục</button>
            </div>
        </form>
    </div>
</div>

<div id="uploadModal" class="custom-modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3><i class="fas fa-upload"></i> Tải tài liệu vào hệ thống</h3>
            <button class="close-btn" onclick="toggleModal('uploadModal', false)">&times;</button>
        </div>
        <form action="" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="action_upload_file" value="1">

            <div class="form-group">
                <label>Chọn thư mục mục tiêu:</label>
                <select name="target_ma_da" class="form-control" required>
                    <option value="">-- Chọn thư mục dự án --</option>
                    <?php foreach ($folders_data as $f): ?>
                        <option value="<?php echo htmlspecialchars($f['ma_da']); ?>">
                            <?php echo htmlspecialchars($f['ten_du_an']); ?> (<?php echo htmlspecialchars($f['ma_da']); ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label>Loại tài liệu:</label>
                <select name="loai_tai_lieu" class="form-control" required>
                    <option value="Bản vẽ">Bản vẽ kỹ thuật</option>
                    <option value="Hợp đồng">Hợp đồng thầu</option>
                    <option value="Nghiệm thu">Biên bản nghiệm thu</option>
                </select>
            </div>

            <div class="form-group">
                <label>Chọn tệp tin từ thiết bị:</label>
                <input type="file" name="file_upload" class="form-control" required>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn-outline" style="padding: 8px 15px;" onclick="toggleModal('uploadModal', false)">Đóng</button>
                <button type="submit" class="btn-primary" style="padding: 8px 15px;">Bắt đầu tải lên</button>
            </div>
        </form>
    </div>
</div>

<script src="js/manager_luutru_hoso.js"></script>

<?php
$conn->close();
?>