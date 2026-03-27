<link rel="stylesheet" href="css/manager_vattu_thietbi.css">

<div class="inventory-wrapper">
    <div class="inventory-header">
        <div class="header-title">
            <h2><i class="fas fa-boxes"></i> Quản lý Kho Vật tư & Thiết bị</h2>
            <p>Tổng hợp danh mục vật liệu và máy móc toàn hệ thống</p>
        </div>
        <div class="header-actions">
            <button class="btn-export"><i class="fas fa-file-excel"></i> Xuất báo cáo</button>
            <button class="btn-add-stock"><i class="fas fa-plus-circle"></i> Nhập kho mới</button>
        </div>
    </div>

    <div class="inventory-stats">
        <div class="stat-item">
            <div class="stat-icon blue"><i class="fas fa-layer-group"></i></div>
            <div class="stat-info">
                <label>Tổng chủng loại</label>
                <span class="value">156</span>
            </div>
        </div>
        <div class="stat-item">
            <div class="stat-icon orange"><i class="fas fa-exclamation-triangle"></i></div>
            <div class="stat-info">
                <label>Sắp hết hàng</label>
                <span class="value">08</span>
            </div>
        </div>
        <div class="stat-item">
            <div class="stat-icon green"><i class="fas fa-check-double"></i></div>
            <div class="stat-info">
                <label>Đang sẵn dùng</label>
                <span class="value">148</span>
            </div>
        </div>
    </div>

    <div class="inventory-filter-bar">
        <div class="search-box">
            <i class="fas fa-search"></i>
            <input type="text" placeholder="Tìm kiếm mã vật tư, tên thiết bị...">
        </div>
        <div class="filter-group">
            <select>
                <option value="">Tất cả phân loại</option>
                <option value="vlxd">Vật liệu xây dựng</option>
                <option value="dien">Thiết bị điện</option>
                <option value="may">Máy móc thi công</option>
            </select>
            <select>
                <option value="">Trạng thái tồn</option>
                <option value="high">Còn nhiều</option>
                <option value="low">Sắp hết</option>
            </select>
        </div>
    </div>

    <div class="inventory-table-container">
        <table class="main-table">
            <thead>
                <tr>
                    <th>Mã VT</th>
                    <th>Tên vật tư / Thiết bị</th>
                    <th>Phân loại</th>
                    <th>Số lượng tồn</th>
                    <th>Đơn vị</th>
                    <th>Giá trị ước tính</th>
                    <th>Trạng thái</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <tr class="alert-row">
                    <td>VT-0021</td>
                    <td><strong>Sơn Dulux Exterior Blue</strong></td>
                    <td>Vật liệu</td>
                    <td class="text-danger">05</td>
                    <td>Thùng</td>
                    <td>12.500.000đ</td>
                    <td><span class="status-pill low">Sắp hết</span></td>
                    <td>
                        <button class="btn-action-icon edit"><i class="fas fa-edit"></i></button>
                        <button class="btn-action-icon history"><i class="fas fa-history"></i></button>
                    </td>
                </tr>
                <tr>
                    <td>TB-0102</td>
                    <td><strong>Máy đục bê tông Makita</strong></td>
                    <td>Máy móc</td>
                    <td>12</td>
                    <td>Cái</td>
                    <td>84.000.000đ</td>
                    <td><span class="status-pill normal">Ổn định</span></td>
                    <td>
                        <button class="btn-action-icon edit"><i class="fas fa-edit"></i></button>
                        <button class="btn-action-icon history"><i class="fas fa-history"></i></button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>