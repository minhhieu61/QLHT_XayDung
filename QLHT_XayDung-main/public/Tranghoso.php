<?php
// 1. Kết nối cơ sở dữ liệu
include_once 'ketnoi.php';

/** @var mysqli $conn */
if (!$conn) {
    die("Lỗi kết nối cơ sở dữ liệu. Vui lòng kiểm tra file ketnoi.php");
}

// ==========================================
// 1. XỬ LÝ ĐẶC BIỆT: TẢI TOÀN BỘ THƯ MỤC DỰ ÁN DƯỚI DẠNG FILE .ZIP
// ==========================================
if (isset($_GET['action']) && $_GET['action'] == 'download_folder' && !empty($_GET['ma_da'])) {
    $ma_da_zip = mysqli_real_escape_string($conn, $_GET['ma_da']);

    // Tìm tên dự án để đặt tên cho file ZIP
    $res_da = mysqli_query($conn, "SELECT ten_du_an FROM duan WHERE ma_da = '$ma_da_zip' LIMIT 1");
    $ten_zip = "Thu_muc_" . $ma_da_zip;
    if ($res_da && mysqli_num_rows($res_da) > 0) {
        $row_da = mysqli_fetch_assoc($res_da);
        $ten_zip = preg_replace('/[^A-Za-z0-9\-]/', '_', $row_da['ten_du_an']);
    }

    // Lấy toàn bộ file thuộc mã dự án này
    $res_files = mysqli_query($conn, "SELECT ten_tai_lieu, duong_dan FROM tai_lieu WHERE ma_du_an = '$ma_da_zip'");

    if ($res_files && mysqli_num_rows($res_files) > 0) {
        if (class_exists('ZipArchive')) {
            $zip = new ZipArchive();

            // Định vị đường dẫn tuyệt đối lùi 1 cấp từ thư mục public/ ra thư mục gốc dự án
            $base_project_dir = dirname(__DIR__) . '/';
            $temp_dir = __DIR__ . "/uploads/documents/";
            if (!is_dir($temp_dir)) {
                mkdir($temp_dir, 0777, true);
            }

            $zip_filename = $temp_dir . $ten_zip . "_" . time() . ".zip";

            if ($zip->open($zip_filename, ZipArchive::CREATE) === TRUE) {
                $has_file = false;

                while ($f_row = mysqli_fetch_assoc($res_files)) {
                    $db_path = $f_row['duong_dan'];
                    $file_path = "";

                    if (file_exists($base_project_dir . $db_path)) {
                        $file_path = $base_project_dir . $db_path;
                    } elseif (file_exists(__DIR__ . '/' . $db_path)) {
                        $file_path = __DIR__ . '/' . $db_path;
                    } elseif (file_exists($db_path)) {
                        $file_path = $db_path;
                    }

                    if (!empty($file_path)) {
                        $zip->addFile($file_path, $f_row['ten_tai_lieu']);
                        $has_file = true;
                    }
                }
                $zip->close();

                if ($has_file && file_exists($zip_filename)) {
                    if (ob_get_level()) {
                        ob_end_clean();
                    }

                    header('Content-Type: application/zip');
                    header('Content-Disposition: attachment; filename="' . $ten_zip . '.zip"');
                    header('Content-Length: ' . filesize($zip_filename));
                    header('Pragma: no-cache');
                    header('Expires: 0');

                    readfile($zip_filename);
                    unlink($zip_filename);
                    exit;
                } else {
                    echo "<script>alert('Lỗi: Tìm thấy thông tin trên hệ thống nhưng các file gốc vật lý không tồn tại trên server!'); window.location.href='trangchu.php?p=hoso';</script>";
                    exit;
                }
            } else {
                echo "<script>alert('Không thể tạo tệp nén ZIP tạm thời.'); window.location.href='trangchu.php?p=hoso';</script>";
                exit;
            }
        } else {
            echo "<script>alert('Server PHP chưa bật tiện ích mở rộng ZipArchive!'); window.location.href='trangchu.php?p=hoso';</script>";
            exit;
        }
    } else {
        echo "<script>alert('Dự án này hiện tại chưa có tài liệu nào để nén tải về!'); window.location.href='trangchu.php?p=hoso';</script>";
        exit;
    }
}

// ==========================================
// 2. XỬ LÝ: TẠO THƯ MỤC DỰ ÁN THỦ CÔNG (TỪ POPUP)
// ==========================================
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action_create_folder'])) {
    $ma_da = trim($_POST['ma_da']);
    $ten_du_an = trim($_POST['ten_du_an']);

    if (!empty($ma_da) && !empty($ten_du_an)) {
        $ma_da_safe = mysqli_real_escape_string($conn, $ma_da);
        $ten_da_safe = mysqli_real_escape_string($conn, $ten_du_an);

        $check = mysqli_query($conn, "SELECT id FROM duan WHERE ma_da = '$ma_da_safe'");
        if (mysqli_num_rows($check) > 0) {
            echo "<script>alert('Lỗi: Mã thư mục/dự án này đã tồn tại trên hệ thống!');</script>";
        } else {
            $sql_ins_folder = "INSERT INTO duan (ma_da, ten_du_an) VALUES ('$ma_da_safe', '$ten_da_safe')";
            if (mysqli_query($conn, $sql_ins_folder)) {
                echo "<script>alert('Tạo thư mục dự án thành công!'); window.location.href='trangchu.php?p=hoso';</script>";
                exit;
            } else {
                echo "<script>alert('Lỗi khi tạo thư mục: " . mysqli_error($conn) . "');</script>";
            }
        }
    }
}

// ==========================================
// 3. XỬ LÝ: TẢI TÀI LIỆU VÀ ĐƯA VÀO FOLDER ĐÃ CHỌN (TỪ POPUP)
// ==========================================
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action_upload_popup'])) {
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

        $duong_dan = $upload_dir . time() . '_' . basename($file_name);

        if (move_uploaded_file($file_tmp, $duong_dan)) {
            $file_name_safe = mysqli_real_escape_string($conn, $file_name);
            $loai_safe = mysqli_real_escape_string($conn, $loai_tai_lieu);
            $ma_da_safe = mysqli_real_escape_string($conn, $ma_du_an);
            $ngay_tai = date('Y-m-d H:i:s');

            $sql_ins_file = "INSERT INTO tai_lieu (ma_du_an, ten_tai_lieu, loai_tai_lieu, duong_dan, ngay_tai, kich_thuoc, ai_status, ai_score) 
                             VALUES ('$ma_da_safe', '$file_name_safe', '$loai_safe', '$duong_dan', '$ngay_tai', '$kich_thuoc', 'Normal', 0)";

            if (mysqli_query($conn, $sql_ins_file)) {
                echo "<script>alert('Tải lên tài liệu thành công!'); window.location.href='trangchu.php?p=hoso';</script>";
                exit;
            } else {
                echo "<script>alert('Lỗi lưu thông tin file vào CSDL: " . mysqli_error($conn) . "');</script>";
            }
        } else {
            echo "<script>alert('Lỗi khi tải file lên ổ đĩa lưu trữ hệ thống.');</script>";
        }
    }
}

// ==========================================
// 4. XỬ LÝ BỘ LỌC TÌM KIẾM HỒ SƠ TÀI LIỆU
// ==========================================
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$filter_type = isset($_GET['type']) ? trim($_GET['type']) : '';

$sql_folders = "SELECT d.id, d.ten_du_an, d.ma_da,
                (SELECT COUNT(*) FROM tai_lieu WHERE ma_du_an = d.ma_da) AS so_tai_lieu 
                FROM duan d 
                ORDER BY d.id DESC";
$result_folders = mysqli_query($conn, $sql_folders);

$projects_list = [];
if ($result_folders && mysqli_num_rows($result_folders) > 0) {
    while ($f_row = mysqli_fetch_assoc($result_folders)) {
        $projects_list[] = $f_row;
    }
    mysqli_data_seek($result_folders, 0);
}

$sql_files = "SELECT t.id, t.ma_du_an, t.ten_tai_lieu, t.loai_tai_lieu, t.duong_dan, t.ai_status, t.ai_score, t.ngay_tai, t.kich_thuoc, d.ten_du_an 
              FROM tai_lieu t
              LEFT JOIN duan d ON t.ma_du_an = d.ma_da
              WHERE 1=1";

if (!empty($search)) {
    $search_safe = mysqli_real_escape_string($conn, $search);
    $sql_files .= " AND (t.ten_tai_lieu LIKE '%$search_safe%' OR d.ten_du_an LIKE '%$search_safe%' OR t.ma_du_an LIKE '%$search_safe%' OR t.loai_tai_lieu LIKE '%$search_safe%')";
}

if (!empty($filter_type)) {
    $type_safe = mysqli_real_escape_string($conn, $filter_type);
    $sql_files .= " AND t.loai_tai_lieu = '$type_safe'";
}

$sql_files .= " ORDER BY t.ngay_tai DESC";
$result_files = mysqli_query($conn, $sql_files);
?>

<link rel="stylesheet" href="css/tranghoso.css">
<style>
    /* CSS POPUP MODAL */
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
        text-align: left;
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
        font-size: 22px;
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

    .btn-secondary {
        background: #7f8c8d;
        color: #fff;
        border: none;
        padding: 8px 15px;
        border-radius: 4px;
        cursor: pointer;
    }

    .btn-secondary:hover {
        background: #6c7a7d;
    }

    /* Thư mục Grid Giao diện */
    .folder-section {
        margin: 20px 0;
        text-align: left;
    }

    .folder-section h3 {
        font-size: 16px;
        color: #2c3e50;
        margin-bottom: 12px;
    }

    .folder-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 15px;
    }

    .folder-card {
        background: #fff;
        border: 1px solid #e0e0e0;
        padding: 15px;
        border-radius: 6px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        transition: 0.2s;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.02);
    }

    .folder-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.08);
        border-color: #bdc3c7;
    }

    .folder-info strong {
        display: block;
        color: #2c3e50;
        font-size: 14px;
        margin-bottom: 2px;
    }

    .folder-info span {
        font-size: 12px;
        color: #7f8c8d;
    }

    .btn-zip-download {
        background: none;
        border: none;
        color: #3498db;
        cursor: pointer;
        padding: 6px;
        border-radius: 4px;
        transition: 0.2s;
    }

    .btn-zip-download:hover {
        color: #2980b9;
        background: #f0f3f4;
        transform: scale(1.05);
    }

    /* ĐÃ SỬA LỖI HIỂN THỊ THANH TÌM KIẾM KHÔNG BỊ CHE KHUẤT */
    .search-input {
        flex: 1;
        display: flex;
        align-items: center;
        background: #fff;
        padding: 0 12px;
        border: 1px solid #ccc;
        border-radius: 4px;
        position: relative;
    }

    .search-input i {
        color: #7f8c8d;
        margin-right: 10px;
        font-size: 14px;
    }

    .search-input input {
        border: none !important;
        width: 100%;
        padding: 10px 0;
        outline: none;
        font-size: 14px;
        background: transparent;
    }
</style>

<div class="archive-wrapper">
    <div class="archive-header">
        <div class="header-title">
            <h2><i class="fas fa-folder-open"></i> Lưu trữ Hồ sơ & Tài liệu</h2>
            <p>Quản lý bản vẽ, hợp đồng và biên bản nghiệm thu tập trung</p>
        </div>
        <div class="header-actions" style="display: flex; gap: 10px;">
            <button type="button" class="btn-outline" onclick="toggleModal('folderPopupModal', true)" style="cursor: pointer; padding: 10px 15px; border: 1px solid #ccc; background:#fff; border-radius:4px; font-weight:bold;">
                <i class="fas fa-folder-plus"></i> Tạo thư mục mới
            </button>
            <button type="button" class="btn-primary" onclick="toggleModal('uploadPopupModal', true)" style="border: none; cursor: pointer;">
                <i class="fas fa-upload"></i> Tải tài liệu mới
            </button>
        </div>
    </div>

    <div class="archive-filter-bar">
        <form action="" method="GET" style="display: flex; width: 100%; gap: 15px; align-items: center;">
            <input type="hidden" name="p" value="hoso">
            <div class="search-input">
                <i class="fas fa-search"></i>
                <input type="text" id="aiSearch" name="search" value="<?php echo htmlspecialchars($search); ?>" placeholder="Tìm tên hồ sơ, mã dự án hoặc kết quả AI...">
            </div>
            <div class="filter-group">
                <select name="type" onchange="this.form.submit()" style="padding: 8px; border: 1px solid #ccc; border-radius: 4px; min-width: 180px; height: 38px;">
                    <option value="">Tất cả loại hồ sơ</option>
                    <option value="Bản vẽ" <?php echo ($filter_type == 'Bản vẽ') ? 'selected' : ''; ?>>Bản vẽ kỹ thuật</option>
                    <option value="Hợp đồng" <?php echo ($filter_type == 'Hợp đồng') ? 'selected' : ''; ?>>Hợp đồng thầu</option>
                    <option value="Nghiệm thu" <?php echo ($filter_type == 'Nghiệm thu') ? 'selected' : ''; ?>>Biên bản nghiệm thu</option>
                </select>
            </div>
            <?php if (!empty($search) || !empty($filter_type)): ?>
                <a href="trangchu.php?p=hoso" style="font-size: 13px; color: #e74c3c; text-decoration: none; font-weight: bold;"><i class="fas fa-times"></i> Xóa bộ lọc</a>
            <?php endif; ?>
        </form>
    </div>

    <div class="folder-section">
        <h3>Thư mục dự án hệ thống</h3>
        <div class="folder-grid">
            <?php if ($result_folders && mysqli_num_rows($result_folders) > 0): ?>
                <?php while ($folder = mysqli_fetch_assoc($result_folders)): ?>
                    <div class="folder-card" onclick="window.location.href='trangchu.php?p=hoso&search=<?php echo urlencode($folder['ma_da']); ?>'" style="cursor: pointer;">
                        <div style="display: flex; align-items: center; gap: 12px;">
                            <i class="fas fa-folder" style="color: #f39c12; font-size: 24px;"></i>
                            <div class="folder-info">
                                <strong><?php echo htmlspecialchars($folder['ten_du_an']); ?></strong>
                                <span><?php echo $folder['so_tai_lieu'] > 0 ? $folder['so_tai_lieu'] . ' tài liệu' : 'Thư mục trống'; ?> (<?php echo htmlspecialchars($folder['ma_da']); ?>)</span>
                            </div>
                        </div>

                        <?php if ($folder['so_tai_lieu'] > 0): ?>
                            <button type="button" class="btn-zip-download" title="Tải xuống toàn bộ thư mục (.zip)"
                                onclick="event.stopPropagation(); window.location.href='trangchu.php?p=hoso&action=download_folder&ma_da=<?php echo urlencode($folder['ma_da']); ?>'">
                                <i class="fas fa-download" style="font-size: 15px;"></i>
                            </button>
                        <?php endif; ?>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p style="color: #95a5a6; font-style: italic; font-size: 13px;">Chưa có thư mục dự án nào được khởi tạo.</p>
            <?php endif; ?>
        </div>
    </div>

    <div class="file-list-section">
        <h3>Danh mục tài liệu hệ thống</h3>
        <table class="file-table" id="fileTable">
            <thead>
                <tr>
                    <th>Tên tài liệu</th>
                    <th>Độ trùng lập</th>
                    <th>Dự án</th>
                    <th>Ngày tải</th>
                    <th style="text-align: center;">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (mysqli_num_rows($result_files) > 0) {
                    while ($row = mysqli_fetch_assoc($result_files)) {
                        $ai_color = '#28a745';
                        if ($row['ai_status'] == 'Duplicate') $ai_color = '#dc3545';
                        if ($row['ai_status'] == 'Warning') $ai_color = '#ffc107';
                ?>
                        <tr>
                            <td>
                                <div class="file-info">
                                    <i class="fas fa-file-pdf pdf-icon"></i>
                                    <strong><?php echo htmlspecialchars($row['ten_tai_lieu']); ?></strong>
                                </div>
                            </td>
                            <td>
                                <span class="ai-badge" style="background: <?php echo $ai_color; ?>; color: #fff; padding: 4px 8px; border-radius: 12px; font-size: 12px;">
                                    <i class="fas fa-robot"></i> <?php echo $row['ai_status']; ?> (<?php echo $row['ai_score']; ?>%)
                                </span>
                            </td>
                            <td>
                                <?php echo htmlspecialchars($row['ma_du_an'] ?? 'N/A'); ?>
                                <?php if (!empty($row['ma_du_an']) && $row['ma_du_an'] != 'N/A'): ?>
                                    <button type="button" class="btn-zip-download" title="Tải xuống toàn bộ tài liệu dự án này (.zip)"
                                        onclick="window.location.href='trangchu.php?p=hoso&action=download_folder&ma_da=<?php echo urlencode($row['ma_du_an']); ?>'">
                                        <i class="fas fa-file-archive" style="font-size: 13px;"></i>
                                    </button>
                                <?php endif; ?>
                            </td>
                            <td><?php echo date('d/m/Y', strtotime($row['ngay_tai'])); ?></td>
                            <td class="file-actions" style="text-align: center;">
                                <button class="btn-action btn-del" onclick="confirmDelete(<?php echo $row['id']; ?>)" title="Xóa">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                <?php
                    }
                } else {
                    echo "<tr><td colspan='5' style='text-align:center;'>Chưa có hồ sơ nào được lưu trữ hoặc phù hợp bộ lọc.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<div id="folderPopupModal" class="custom-modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3><i class="fas fa-folder-plus"></i> Tạo thư mục dự án mới</h3>
            <button class="close-btn" onclick="toggleModal('folderPopupModal', false)">&times;</button>
        </div>
        <form action="" method="POST">
            <input type="hidden" name="action_create_folder" value="1">
            <div class="form-group">
                <label>Mã thư mục / Mã dự án:</label>
                <input type="text" name="ma_da" class="form-control" placeholder="Ví dụ: DA_VLUTE_01" required>
            </div>
            <div class="form-group">
                <label>Tên thư mục / Tên dự án:</label>
                <input type="text" name="ten_du_an" class="form-control" placeholder="Ví dụ: Xây dựng trung tâm phần mềm" required>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-secondary" onclick="toggleModal('folderPopupModal', false)">Hủy bỏ</button>
                <button type="submit" class="btn-primary" style="border: none; cursor: pointer;">Tạo thư mục</button>
            </div>
        </form>
    </div>
</div>

<div id="uploadPopupModal" class="custom-modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3><i class="fas fa-upload"></i> Tải tài liệu vào hệ thống</h3>
            <button class="close-btn" onclick="toggleModal('uploadPopupModal', false)">&times;</button>
        </div>
        <form action="" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="action_upload_popup" value="1">

            <div class="form-group">
                <label>Chọn thư mục dự án đích:</label>
                <select name="target_ma_da" class="form-control" required>
                    <option value="">-- Chọn thư mục dự án mục tiêu --</option>
                    <?php foreach ($projects_list as $proj): ?>
                        <option value="<?php echo htmlspecialchars($proj['ma_da']); ?>">
                            <?php echo htmlspecialchars($proj['ten_du_an']); ?> (<?php echo htmlspecialchars($proj['ma_da']); ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label>Loại danh mục tài liệu:</label>
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
                <button type="button" class="btn-secondary" onclick="toggleModal('uploadPopupModal', false)">Đóng lại</button>
                <button type="submit" class="btn-primary" style="border: none; cursor: pointer;">Bắt đầu tải lên</button>
            </div>
        </form>
    </div>
</div>

<script src="js/Tranghoso.js"></script>