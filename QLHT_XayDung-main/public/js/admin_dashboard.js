/**
 * Quản lý các hiệu ứng và tương tác trên trang Admin Dashboard
 */

// 1. Khai báo các element dùng chung (Thêm submitBtn vào đây)
const modal = document.getElementById("accountModal");
const form = document.getElementById("accountForm");
const submitBtn = document.getElementById("submitBtn"); // Khai báo thêm dòng này

// --- 2. HÀM MỞ MODAL ĐỂ THÊM TÀI KHOẢN ---
function openAddModal() {
  if (!modal || !form) return;

  // Cập nhật giao diện Modal sang chế độ THÊM
  document.getElementById("modalTitle").innerText = "Thêm Tài Khoản Mới";

  // Đổi chữ trên nút thành "XÁC NHẬN THÊM"
  if (submitBtn) submitBtn.innerText = "XÁC NHẬN THÊM";

  document.getElementById("passLabel").innerText = "Mật khẩu";
  document.getElementById("usernameGroup").style.display = "block"; // Hiện ô username
  if (document.getElementById("passNote"))
    document.getElementById("passNote").style.display = "none";

  // Reset form và xóa ID ẩn
  form.reset();
  document.getElementById("modal_user_id").value = "";

  // Cài đặt bắt buộc nhập mật khẩu khi thêm mới
  const passInput = document.getElementById("modal_password");
  passInput.required = true;
  passInput.placeholder = "Nhập mật khẩu ít nhất 6 ký tự";

  modal.style.display = "block";

  // Focus vào ô đầu tiên cho trải nghiệm tốt hơn
  setTimeout(() => {
    document.getElementById("modal_fullname").focus();
  }, 100);
}

// --- 3. HÀM MỞ MODAL ĐỂ SỬA TÀI KHOẢN ---
// Sửa lại để nhận 1 đối tượng 'user' (Khớp với json_encode ở PHP)
function openEditModal(user) {
  if (!modal || !form) return;

  // Cập nhật giao diện Modal sang chế độ SỬA
  document.getElementById("modalTitle").innerText = "Chỉnh Sửa Tài Khoản";

  // Đổi chữ trên nút thành "LƯU THAY ĐỔI"
  if (submitBtn) submitBtn.innerText = "LƯU THAY ĐỔI";

  document.getElementById("passLabel").innerText = "Mật khẩu mới";
  if (document.getElementById("passNote"))
    document.getElementById("passNote").style.display = "block";

  // Ẩn ô username (Không cho sửa username để đảm bảo tính nhất quán DB)
  document.getElementById("usernameGroup").style.display = "none";

  // Đổ dữ liệu từ đối tượng 'user' vào các ô input
  document.getElementById("modal_user_id").value = user.id;
  document.getElementById("modal_fullname").value = user.fullname;
  document.getElementById("modal_username").value = user.username;
  document.getElementById("modal_role").value = user.role;

  // Không bắt buộc nhập mật khẩu khi sửa
  const passInput = document.getElementById("modal_password");
  passInput.required = false;
  passInput.value = ""; // Xóa trắng ô pass
  passInput.placeholder = "Để trống nếu không muốn thay đổi";

  modal.style.display = "block";
}

// --- 4. CÁC HÀM ĐÓNG MODAL & TIỆN ÍCH ---
function closeModal() {
  if (modal) {
    modal.style.display = "none";
    form.reset(); // Xóa dữ liệu cũ khi đóng
  }
}

// Đóng modal khi click ra ngoài vùng trắng (vùng xám)
window.onclick = function (event) {
  if (event.target == modal) {
    closeModal();
  }
};

// Lắng nghe phím ESC để đóng modal nhanh
document.addEventListener("keydown", function (event) {
  if (event.key === "Escape") {
    closeModal();
  }
});

// Hàm hỗ trợ confirm nhanh khi bấm nút Xóa
function confirmDelete(id) {
  return confirm(
    `CẢNH BÁO: Bạn có chắc chắn muốn xóa vĩnh viễn tài khoản #${id} này không? Hành động này không thể hoàn tác.`,
  );
}
let currentRole = "all";
function filterByRole(role) {
  currentRole = role;
  searchUser();
}

function searchUser() {
  const input = document.getElementById("searchInput").value.toLowerCase();
  const rows = document.querySelectorAll(".account-row");
  rows.forEach((row) => {
    const fullname = row
      .querySelector(".fullname-cell")
      .innerText.toLowerCase();
    const username = row
      .querySelector(".username-cell")
      .innerText.toLowerCase();
    const role = row.getAttribute("data-role");
    const matchesRole = currentRole === "all" || role === currentRole;
    const matchesSearch = fullname.includes(input) || username.includes(input);
    row.style.display = matchesRole && matchesSearch ? "" : "none";
  });
}
