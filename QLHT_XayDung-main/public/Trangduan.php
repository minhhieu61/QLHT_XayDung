<link rel="stylesheet" href="css/danhsachduan.css">

<div class="duan-container">
    <div class="header-top-ql">
        <div class="header-title-ql">
            <h1><i class="fas fa-layer-group"></i> HỆ THỐNG QUẢN LÝ DỰ ÁN</h1>
            <p>Phân loại và theo dõi tiến độ các công trình xây dựng</p>
        </div>
    </div>

    <div class="action-bar">
        <div class="search-box-custom">
            <i class="fas fa-search" style="color: #ccc;"></i>
            <input type="text" placeholder="Tìm tên dự án, đơn vị thi công...">
        </div>
        
        <a href="trangchu.php?p=themduan" class="btn-add-project" style="text-decoration: none; display: flex; align-items: center; gap: 8px;">
            <i class="fas fa-plus-circle"></i> Thêm dự án
        </a>
    </div>

    <div class="table-card-custom">
        <table class="main-table">
            <thead>
                <tr>
                    <th style="width: 30%;">Thông tin dự án</th>
                    <th style="width: 25%;">Chủ đầu tư</th>
                    <th style="width: 25%;">Nhà thầu xây dựng</th>
                    <th style="width: 12%;">Trạng thái</th>
                    <th style="width: 8%;">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <div class="project-cell">
                            <div class="project-icon-box"><i class="fas fa-building"></i></div>
                            <div>
                                <span class="text-bold">Xây dựng Nhà học C1 - VLUTE</span>
                                <span class="text-sub">Mã số: #DA-C1-2026</span>
                            </div>
                        </div>
                    </td>
                    <td>
                        <span class="text-bold">Ban Quản lý VLUTE</span>
                        <span class="text-sub"><i class="fas fa-user-tie"></i> ThS. Nguyễn Văn A</span>
                    </td>
                    <td>
                        <span class="text-bold">Công ty Xây dựng Delta</span>
                        <span class="text-sub"><i class="fas fa-hard-hat"></i> Đội thi công số 4</span>
                    </td>
                    <td><span class="badge-working">Đang thực hiện</span></td>
                    <td>
                        <div class="action-btns">
                            <button class="btn-circle btn-edit" title="Chỉnh sửa"><i class="fas fa-pen"></i></button>
                            <button class="btn-circle btn-del" title="Xóa"><i class="fas fa-trash"></i></button>
                            <a href="trangchu.php?p=chitietduan&id=1" class="btn-circle btn-view" title="Xem chi tiết">
                                <i class="fas fa-eye"></i>
                            </a>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>