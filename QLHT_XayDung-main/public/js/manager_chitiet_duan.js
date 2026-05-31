/**
 * -------------------------------------------------------------------
 * PHẦN 1: ĐIỀU KHIỂN CHUYỂN ĐỔI TAB (TỔNG QUAN / KINH PHÍ)
 * -------------------------------------------------------------------
 * @param {Event} evt - Sự kiện tác động click chuột
 * @param {String} tabName - ID của vùng tab-pane cần kích hoạt hiển thị
 */
function openTab(evt, tabName) {
  var i, tabContent, tabBtns;

  // 1. Ẩn toàn bộ các nội dung tab-pane khác
  tabContent = document.getElementsByClassName("tab-pane");
  for (i = 0; i < tabContent.length; i++) {
    tabContent[i].classList.remove("active");
  }

  // 2. Gỡ bỏ trạng thái sáng (active) trên các nút điều hướng cũ
  tabBtns = document.getElementsByClassName("tab-btn");
  for (i = 0; i < tabBtns.length; i++) {
    tabBtns[i].classList.remove("active");
  }

  // 3. Hiển thị tab được chọn và gán class active vào nút hiện tại
  var targetTab = document.getElementById(tabName);
  if (targetTab) {
    targetTab.classList.add("active");
  }

  if (evt && evt.currentTarget) {
    evt.currentTarget.classList.add("active");
  }
}

/**
 * -------------------------------------------------------------------
 * PHẦN 2: ĐIỀU KHIỂN ẨN / HIỆN CÁC POPUP MODALS TRÊN GIAO DIỆN
 * -------------------------------------------------------------------
 */

// Điều khiển Modal Nhân sự / Nhà thầu
function toggleModal(show) {
  const modal = document.getElementById("assignmentModal");
  if (modal) {
    if (show) modal.classList.add("open");
    else modal.classList.remove("open");
  }
}

// Điều khiển Modal Mô tả chi tiết dự án
function toggleDescModal(show) {
  const modal = document.getElementById("descriptionModal");
  if (modal) {
    if (show) modal.classList.add("open");
    else modal.classList.remove("open");
  }
}

// Điều khiển Modal Thêm mới hóa đơn chứng từ phát sinh
function toggleInvoiceModal(show) {
  const modal = document.getElementById("invoiceModal");
  if (modal) {
    if (show) modal.classList.add("open");
    else modal.classList.remove("open");
  }
}

// Xử lý đóng tự động khi người dùng nhấp chuột ra ngoài vùng trống của Modal Box
window.onclick = function (event) {
  const modalAssign = document.getElementById("assignmentModal");
  const modalDesc = document.getElementById("descriptionModal");
  const modalInvoice = document.getElementById("invoiceModal");

  if (event.target == modalAssign) modalAssign.classList.remove("open");
  if (event.target == modalDesc) modalDesc.classList.remove("open");
  if (event.target == modalInvoice) modalInvoice.classList.remove("open");
};
