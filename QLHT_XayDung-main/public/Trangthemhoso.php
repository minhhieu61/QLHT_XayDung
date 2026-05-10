<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<link rel="stylesheet" href="css/tranghoso.css">

<style>
    /* CSS bổ sung để đảm bảo giao diện cân đối */
    .archive-wrapper { padding: 20px; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
    .header-title h2 { color: #1e3c72; margin-bottom: 5px; }
    .header-title p { color: #666; font-size: 0.9rem; margin-bottom: 25px; }
    .input-group input, .input-group select {
        transition: border-color 0.3s;
        outline: none;
    }
    .input-group input:focus, .input-group select:focus { border-color: #2a5298; box-shadow: 0 0 5px rgba(42,82,152,0.2); }
    .btn-primary {
        background: linear-gradient(to right, #1e3c72, #2a5298);
        color: white; padding: 12px; border-radius: 8px; font-weight: bold;
        display: flex; align-items: center; gap: 8px; transition: 0.3s;
    }
    .btn-primary:hover { opacity: 0.9; transform: translateY(-1px); }
    .btn-del { background: #f44336; color: white; transition: 0.3s; }
    .btn-del:hover { background: #d32f2f; }
</style>

<div class="archive-wrapper">
    <div class="archive-header">
        <div class="header-title">
            <h2><i class="fas fa-file-signature"></i> Tải lên tài liệu mới</h2>
            <p>Hệ thống sẽ tự động phân tích và đối soát nội dung với dữ liệu hiện có.</p>
        </div>
    </div>

    <div class="file-list-section" style="max-width: 650px; margin: 0 auto; background: white; padding: 30px; border-radius: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.05);">
        <form action="xuly_upload.php" method="POST" enctype="multipart/form-data" id="uploadForm">
            
            <div class="input-group" style="margin-bottom: 20px;">
                <label style="display:block; margin-bottom:8px; font-weight:600; color: #444;">Mã dự án:</label>
                <input type="text" name="ma_du_an" placeholder="Ví dụ: DA-2026-001" required 
                       style="width:100%; padding:12px; border-radius:8px; border:1px solid #ddd; box-sizing: border-box;">
            </div>

            <div class="input-group" style="margin-bottom: 20px;">
                <label style="display:block; margin-bottom:8px; font-weight:600; color: #444;">Loại hồ sơ:</label>
                <select name="loai_tai_lieu" style="width:100%; padding:12px; border-radius:8px; border:1px solid #ddd; background-color: white;">
                    <option value="Bản vẽ">Bản vẽ kỹ thuật</option>
                    <option value="Hợp đồng">Hợp đồng thầu</option>
                    <option value="Nghiệm thu">Biên bản nghiệm thu</option>
                    <option value="Thuyết minh">Thuyết minh dự án</option>
                </select>
            </div>

            <div class="upload-area" style="border: 2px dashed #2a5298; padding: 35px; text-align: center; border-radius: 12px; background: #f8fbff; margin-bottom: 20px;">
                <i class="fas fa-cloud-arrow-up fa-3x" style="color: #2a5298; margin-bottom: 15px;"></i>
                <p style="margin: 10px 0; font-weight: 500;">Chọn tệp tin </p>
                <input type="file" name="file_upload" id="file_upload" required style="font-size: 0.9rem;">
                <p style="font-size: 0.8rem; color: #888; margin-top: 15px;">
                    Định dạng cho phép: <strong>.txt, .pdf, .docx</strong> (Tối đa 10MB)
                </p>
            </div>

            <div id="ai-loading" style="display:none; margin-top: 20px; text-align: center; padding: 20px; border-radius: 10px; background: #fff9c4; border: 1px solid #fbc02d;">
                <i class="fas fa-robot fa-spin fa-3x" style="color: #f57f17; margin-bottom: 10px;"></i>
                <p style="font-weight: bold; color: #bc5100; margin: 5px 0;">đang đối soát dữ liệu...</p>
                <small style="color: #666;">Quá trình này có thể mất vài giây tùy vào độ dài văn bản.</small>
            </div>

            <div class="form-actions" style="margin-top: 30px; display: flex; gap: 15px;">
                <button type="submit" name="btnUpload" id="submitBtn" class="btn-primary" style="flex:2; border:none; cursor:pointer; justify-content: center; font-size: 1rem;">
                    <i class="fas fa-upload"></i> Xác nhận và Kiểm tra
                </button>
                <a href="trangchu.php?p=hoso" class="btn-del" style="flex:1; text-decoration:none; text-align:center; line-height:45px; border-radius:8px; font-weight: bold; height: 45px;">
                    Hủy bỏ
                </a>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var form = document.getElementById('uploadForm');
    var loadingZone = document.getElementById('ai-loading');
    var submitBtn = document.getElementById('submitBtn');

    if(form) {
        form.onsubmit = function() {
            // Hiển thị thông báo đang xử lý
            loadingZone.style.display = 'block';
            
            // Vô hiệu hóa nút bấm để tránh gửi trùng
            submitBtn.disabled = true;
            submitBtn.style.opacity = '0.7';
            submitBtn.style.cursor = 'not-allowed';
            submitBtn.innerHTML = '<i class="fas fa-circle-notch fa-spin"></i> Đang phân tích...';
            
            return true; // Cho phép form gửi đi
        };
    }
});
</script>