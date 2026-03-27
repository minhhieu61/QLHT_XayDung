<link rel="stylesheet" href="css/manager_luutru_hoso.css">

<div class="archive-wrapper">
    <div class="archive-header">
        <div class="header-title">
            <h2><i class="fas fa-folder-open"></i> Lưu trữ Hồ sơ & Tài liệu</h2>
            <p>Quản lý bản vẽ, hợp đồng và biên bản nghiệm thu tập trung</p>
        </div>
        <div class="header-actions">
            <button class="btn-outline"><i class="fas fa-folder-plus"></i> Tạo thư mục</button>
            <button class="btn-primary"><i class="fas fa-upload"></i> Tải tài liệu mới</button>
        </div>
    </div>

    <div class="archive-filter-bar">
        <div class="search-input">
            <i class="fas fa-search"></i>
            <input type="text" placeholder="Tìm tên hồ sơ, mã dự án, loại tài liệu...">
        </div>
        <div class="filter-group">
            <select>
                <option value="">Tất cả loại hồ sơ</option>
                <option value="ban-ve">Bản vẽ kỹ thuật</option>
                <option value="hop-dong">Hợp đồng thầu</option>
                <option value="nghiem-thu">Biên bản nghiệm thu</option>
            </select>
        </div>
    </div>

    <div class="folder-section">
        <h3>Thư mục dự án gần đây</h3>
        <div class="folder-grid">
            <div class="folder-card">
                <i class="fas fa-folder"></i>
                <div class="folder-info">
                    <strong>Cải tạo Nhà Khu A</strong>
                    <span>24 tài liệu</span>
                </div>
                <button class="btn-more"><i class="fas fa-ellipsis-v"></i></button>
            </div>
            <div class="folder-card">
                <i class="fas fa-folder"></i>
                <div class="folder-info">
                    <strong>Sửa chữa KTX</strong>
                    <span>12 tài liệu</span>
                </div>
                <button class="btn-more"><i class="fas fa-ellipsis-v"></i></button>
            </div>
            <div class="folder-card">
                <i class="fas fa-folder"></i>
                <div class="folder-info">
                    <strong>Hệ thống PCCC</strong>
                    <span>08 tài liệu</span>
                </div>
                <button class="btn-more"><i class="fas fa-ellipsis-v"></i></button>
            </div>
        </div>
    </div>

    <div class="file-list-section">
        <h3>Tài liệu mới cập nhật</h3>
        <table class="file-table">
            <thead>
                <tr>
                    <th>Tên tài liệu</th>
                    <th>Loại</th>
                    <th>Dự án</th>
                    <th>Ngày tải</th>
                    <th>Kích thước</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <i class="fas fa-file-pdf pdf-icon"></i>
                        <strong>Ban_ve_dien_KhuA.pdf</strong>
                    </td>
                    <td>Bản vẽ</td>
                    <td>Khu A - VLUTE</td>
                    <td>25/03/2026</td>
                    <td>4.5 MB</td>
                    <td class="file-actions">
                        <button title="Tải xuống"><i class="fas fa-download"></i></button>
                        <button title="Xem trực tiếp"><i class="fas fa-eye"></i></button>
                        <button title="Xóa" class="text-danger"><i class="fas fa-trash"></i></button>
                    </td>
                </tr>
                <tr>
                    <td>
                        <i class="fas fa-file-word word-icon"></i>
                        <strong>Hop_dong_thi_cong_01.docx</strong>
                    </td>
                    <td>Hợp đồng</td>
                    <td>KTX Xá</td>
                    <td>22/03/2026</td>
                    <td>1.2 MB</td>
                    <td class="file-actions">
                        <button title="Tải xuống"><i class="fas fa-download"></i></button>
                        <button title="Xem trực tiếp"><i class="fas fa-eye"></i></button>
                        <button title="Xóa" class="text-danger"><i class="fas fa-trash"></i></button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>