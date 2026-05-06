<link rel="stylesheet" href="css/themchuthau.css">
<div class="chuthau-container">
    <div class="header-top-ql">
        <h1><i class="fas fa-plus-circle"></i> THÊM CHỦ THẦU MỚI</h1>
    </div>

    <div class="table-card-custom" style="padding: 30px;">
        <form action="xuly_themchuthau.php" method="POST">
            <div class="form-group-grid" style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div class="input-box">
                    <label>Mã chủ thầu</label>
                    <input type="text" name="ma_ct" placeholder="VD: CT001" required>
                </div>
                <div class="input-box">
                    <label>Tên đơn vị thầu</label>
                    <input type="text" name="ten_don_vi" placeholder="Tên công ty..." required>
                </div>
                <div class="input-box">
                    <label>Người đại diện</label>
                    <input type="text" name="nguoi_dai_dien" required>
                </div>
                <div class="input-box">
                    <label>Số điện thoại</label>
                    <input type="text" name="so_dien_thoai" required>
                </div>
                <div class="input-box">
                    <label>Email</label>
                    <input type="email" name="email">
                </div>
                <div class="input-box">
                    <label>Tổng vốn đầu tư (VNĐ)</label>
                    <input type="number" name="tong_von" value="0">
                </div>
                <div class="input-box">
                    <label>Trạng thái</label>
                    <select name="trang_thai">
                        <option value="Đang hợp tác">Đang hợp tác</option>
                        <option value="Tạm ngưng">Tạm ngưng</option>
                    </select>
                </div>
            </div>
            
            <div style="margin-top: 30px; display: flex; gap: 10px;">
                <button type="submit" class="btn-add-ct" style="border:none; cursor:pointer;">LƯU THÔNG TIN</button>
                <a href="trangchu.php?p=danhsachchuthau" class="btn-delete" style="text-decoration:none; display:inline-block; padding: 10px 20px; border-radius:5px;">HỦY BỎ</a>
            </div>
        </form>
    </div>
</div>