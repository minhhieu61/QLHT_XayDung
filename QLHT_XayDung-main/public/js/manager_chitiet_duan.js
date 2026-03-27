function openTab(evt, tabName) {
  var i, tabContent, tabBtns;

  // Ẩn tất cả các tab-pane
  tabContent = document.getElementsByClassName("tab-pane");
  for (i = 0; i < tabContent.length; i++) {
    tabContent[i].classList.remove("active");
  }

  // Gỡ bỏ class active ở tất cả các nút
  tabBtns = document.getElementsByClassName("tab-btn");
  for (i = 0; i < tabBtns.length; i++) {
    tabBtns[i].classList.remove("active");
  }

  // Hiển thị tab hiện tại và thêm class active vào nút đã bấm
  document.getElementById(tabName).classList.add("active");
  evt.currentTarget.classList.add("active");
}
