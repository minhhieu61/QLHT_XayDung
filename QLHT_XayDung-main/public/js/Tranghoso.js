/**
 * Quản lý tương tác UI trang Hồ sơ dữ liệu
 */

// Đóng mở Modal Popup
function toggleModal(modalId, status) {
  const targetModal = document.getElementById(modalId);
  if (targetModal) {
    targetModal.style.display = status ? "flex" : "none";
  }
}

// Đóng khi click ngoài vùng trắng nội dung modal
window.addEventListener("click", function (event) {
  const folderModal = document.getElementById("folderPopupModal");
  const uploadModal = document.getElementById("uploadPopupModal");

  if (event.target === folderModal) {
    toggleModal("folderPopupModal", false);
  }
  if (event.target === uploadModal) {
    toggleModal("uploadPopupModal", false);
  }
});

// Xác nhận xóa tài liệu khỏi hệ thống
function confirmDelete(id) {
  if (
    confirm(
      "Bạn có chắc muốn xóa tài liệu này? Kết quả AI liên quan cũng sẽ bị mất.",
    )
  ) {
    window.location.href = "xuly_xoahoso.php?id=" + id;
  }
}

// Live Search Client-side nhanh cho bảng danh sách tài liệu
document.addEventListener("DOMContentLoaded", function () {
  const searchInput = document.getElementById("aiSearch");
  if (searchInput) {
    searchInput.addEventListener("keyup", function () {
      let filter = this.value.toLowerCase();
      let rows = document.querySelectorAll("#fileTable tbody tr");

      rows.forEach((row) => {
        if (row.cells.length > 1) {
          let text = row.innerText.toLowerCase();
          row.style.display = text.includes(filter) ? "" : "none";
        }
      });
    });
  }
});
