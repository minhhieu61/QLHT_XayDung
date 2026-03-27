<link rel="stylesheet" href="css/danhsachchuthau.css">

<div class="chuthau-container">
    <header class="vattu-header-top">
        <div class="table-title">
            <h2><i class="fas fa-handshake"></i> QUẢN LÝ DANH SÁCH CHỦ THẦU</h2>
            <p>Hệ thống quản lý đối tác xây dựng và nhà thầu phụ</p>
        </div>
    </header>

    <div class="table-card">
        <div class="table-actions">
            <form action="" method="GET" class="search-form">
                <i class="fas fa-search" style="color: #000077;"></i>
                <input type="text" name="search" placeholder="Tìm tên công ty, mã số thuế..." 
                       value="<?php echo $_GET['search'] ?? ''; ?>">
            </form>
            
            <button class="btn-add-new">
                <i class="fas fa-plus-circle"></i> Thêm chủ thầu
            </button>
        </div>

        <table class="main-table">
            <thead>
                <tr>
                    <th style="width: 25%;">Đơn vị thầu</th>
                    <th style="width: 20%;">Người đại diện</th>
                    <th style="width: 20%;">Liên hệ</th>
                    <th style="width: 15%;">Tổng vốn</th>
                    <th style="width: 12%;">Trạng thái</th>
                    <th style="width: 8%;">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <div class="user-info">
                            <div class="user-avatar cdt">CT</div>
                            <div>
                                <span class="entity-name">Công ty Xây dựng Delta</span>
                                <span class="entity-code">Mã: #CT042</span>
                            </div>
                        </div>
                    </td>
                    <td><b>Nguyễn Văn A</b></td>
                    <td>
                        <div class="contact-info">
                            <span><i class="fas fa-phone-alt"></i> 0270.3822.111</span>
                            <small>delta@build.vn</small>
                        </div>
                    </td>
                    <td style="font-weight: 800; color: #000077;">5,200,000,000</td>
                    <td><span class="status-tag working">Đang hợp tác</span></td>
                    <td>
                        <div class="action-btns">
                            <button class="btn-action edit" title="Sửa"><i class="fas fa-edit"></i></button>
                            <button class="btn-action delete" title="Xóa"><i class="fas fa-trash"></i></button>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>