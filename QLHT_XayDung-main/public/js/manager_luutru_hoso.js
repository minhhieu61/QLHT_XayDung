/**
 * Quản lý các hiệu ứng và tương tác giao diện Lưu trữ hồ sơ
 */

// Hàm đóng/mở cấu trúc Modal hộp thoại nổi
function toggleModal(modalId, status) {
  const targetModal = document.getElementById(modalId);
  if (targetModal) {
    targetModal.style.display = status ? "flex" : "none";
  }
}

// Đóng modal khi người dùng click ra ngoài vùng nội dung hộp thoại (Click background)
window.addEventListener("click", function (event) {
  const folderModal = document.getElementById("folderModal");
  const uploadModal = document.getElementById("uploadModal");

  if (event.target === folderModal) {
    toggleModal("folderModal", false);
  }
  if (event.target === uploadModal) {
    toggleModal("uploadModal", false);
  }
});
