<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<link rel="stylesheet" href="css/tranghoso.css">

<style>
    /* 1. Thiết lập Container tràn toàn màn hình */
    .archive-wrapper { 
        width: 100%;
        max-width: 100% !important;
        padding: 20px 40px; 
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
        box-sizing: border-box;
    }

    /* 2. Thay đổi màu chữ Header sang TRẮNG để nổi bật trên nền xanh */
    .archive-header {
        background: #1e3c72;
        padding: 25px 30px;
        border-radius: 12px;
        margin-bottom: 25px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }
    .header-title h2 { 
        color: #ffffff; /* Đã đổi sang màu trắng */
        margin: 0; 
        font-size: 1.8rem;
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .header-title p { 
        color: rgba(255, 255, 255, 0.85); /* Trắng mờ cho đoạn giới thiệu */
        font-size: 0.95rem; 
        margin: 8px 0 0 0; 
    }

    /* 3. Form Card tối ưu cho toàn màn hình */
    .file-upload-card { 
        width: 100%;
        background: white; 
        padding: 40px; 
        border-radius: 15px; 
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        box-sizing: border-box;
    }

    /* Chia lưới 2 cột để form không bị quá dài khi màn hình rộng */
    .form-grid-layout {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 30px;
    }

    .input-group { display: flex; flex-direction: column; gap: 8px; margin-bottom: 20px; }
    .input-group label { font-weight: 600; color: #444; }
    
    .input-group input, .input-group select {
        padding: 12px;
        border-radius: 8px;
        border: 1px solid #ddd;
        transition: border-color 0.3s;
        outline: none;
        background: #fdfdfd;
    }
    .input-group input:focus, .input-group select:focus { border-color: #2a5298; box-shadow: 0 0 5px rgba(42,82,152,0.2); }

    /* Vùng Upload và Nút bấm chiếm hết chiều rộng */
    .full-width { grid-column: span 2; }

    .upload-area { 
        border: 2px dashed #2a5298; 
        padding: 50px; 
        text-align: center; 
        border-radius: 12px; 
        background: #f8fbff; 
        margin: 10px 0 20px 0;
    }

    .btn-primary {
        background: linear-gradient(to right, #1e3c72, #2a5298);
        color: white; padding: 15px; border-radius: 8px; font-weight: bold;
        display: flex; align-items: center; gap: 8px; transition: 0.3s;
        border: none; cursor: pointer;
    }
    .btn-primary:hover { opacity: 0.9; transform: translateY(-2px); box-shadow: 0 5px 15px rgba(30, 60, 114, 0.3); }
    
    .btn-del { 
        background: #f1f5f9; 
        color: #64748b; 
        text-decoration: none; 
        text-align: center; 
        line-height: 50px; 
        border-radius: 8px; 
        font-weight: bold; 
        height: 50px; 
        transition: 0.3s;
    }
    .btn-del:hover { background: #e2e8f0; color: #d32f2f; }
</style>

<div class="archive-wrapper">
    <div class="archive-header">
        <div class="header-title">
            <h2><i class="fas fa-file-signature"></i> Tải lên tài liệu mới</h2>
            <p>Hệ thống sẽ tự động phân tích và đối soát nội dung với dữ liệu hiện có.</p>
        </div>
    </div>

    <div class="file-upload-card">
        <form action="xuly_upload.php" method="POST" enctype="multipart/form-data" id="uploadForm">
            
            <div class="form-grid-layout">
                <div class="input-group">
                    <label>Mã dự án:</label>
                    <input type="text" name="ma_du_an" placeholder="Ví dụ: DA-2026-001" required>
                </div>

                <div class="input-group">
                    <label>Loại hồ sơ:</label>
                    <select name="loai_tai_lieu">
                        <option value="Bản vẽ">Bản vẽ kỹ thuật</option>
                        <option value="Hợp đồng">Hợp đồng thầu</option>
                        <option value="Nghiệm thu">Biên bản nghiệm thu</option>
                        <option value="Thuyết minh">Thuyết minh dự án</option>
                    </select>
                </div>

                <div class="full-width">
                    <div class="upload-area">
                        <i class="fas fa-cloud-arrow-up fa-4x" style="color: #2a5298; margin-bottom: 15px;"></i>
                        <p style="margin: 10px 0; font-size: 1.1rem; font-weight: 500;">Chọn tệp tin từ thiết bị của bạn</p>
                        <input type="file" name="file_upload" id="file_upload" required>
                        <p style="font-size: 0.85rem; color: #888; margin-top: 20px;">
                            Định dạng hỗ trợ: <strong>.txt, .pdf, .docx</strong> (Dung lượng tối đa 10MB)
                        </p>
                    </div>
                </div>

                <div class="full-width" id="ai-loading" style="display:none; margin-bottom: 20px; text-align: center; padding: 25px; border-radius: 10px; background: #fff9c4; border: 1px solid #fbc02d;">
                    <i class="fas fa-robot fa-spin fa-3x" style="color: #f57f17; margin-bottom: 10px;"></i>
                    <p style="font-weight: bold; color: #bc5100; margin: 5px 0; font-size: 1.1rem;">AI đang tiến hành đối soát dữ liệu...</p>
                    <small style="color: #666;">Hệ thống đang so sánh văn bản với cơ sở dữ liệu quốc gia.</small>
                </div>

                <div class="full-width" style="display: flex; gap: 15px; margin-top: 10px;">
                    <button type="submit" name="btnUpload" id="submitBtn" class="btn-primary" style="flex:2; justify-content: center; font-size: 1.1rem;">
                        <i class="fas fa-upload"></i> Xác nhận và Chấm điểm AI
                    </button>
                    <a href="trangchu.php?p=hoso" class="btn-del" style="flex:1;">
                        Hủy bỏ
                    </a>
                </div>
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
            loadingZone.style.display = 'block';
            submitBtn.disabled = true;
            submitBtn.style.opacity = '0.7';
            submitBtn.style.cursor = 'not-allowed';
            submitBtn.innerHTML = '<i class="fas fa-circle-notch fa-spin"></i> Hệ thống đang xử lý...';
            return true;
        };
    }
});
</script>