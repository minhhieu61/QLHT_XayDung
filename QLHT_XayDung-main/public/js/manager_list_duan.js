document.addEventListener("DOMContentLoaded", function () {
  const searchInput = document.getElementById("searchInput");
  const statusFilter = document.getElementById("statusFilter");
  const projectGrid = document.getElementById("projectGrid");
  const noResultsBlock = document.getElementById("noResults");

  // Lấy tất cả các thẻ card dự án
  const projectCards = projectGrid.querySelectorAll(".project-card");

  function filterProjects() {
    const keyword = searchInput.value.toLowerCase().trim();
    const selectedStatus = statusFilter.value;

    let visibleCount = 0;

    projectCards.forEach(function (card) {
      const cardKeywords = card.getAttribute("data-search-keyword") || "";
      const cardStatus = card.getAttribute("data-status") || "";

      // Kiểm tra từ khóa tìm kiếm
      const matchesSearch = cardKeywords.includes(keyword);

      // Kiểm tra trạng thái phân loại (all, ongoing, paused, completed)
      const matchesStatus =
        selectedStatus === "all" || cardStatus === selectedStatus;

      if (matchesSearch && matchesStatus) {
        card.style.display = "block";
        visibleCount++;
      } else {
        card.style.display = "none";
      }
    });

    // Hiển thị thông báo nếu không tìm thấy bất kỳ kết quả nào khớp
    if (visibleCount === 0) {
      noResultsBlock.style.display = "block";
    } else {
      noResultsBlock.style.display = "none";
    }
  }

  // Gắn sự kiện lắng nghe thao tác
  if (searchInput) {
    searchInput.addEventListener("input", filterProjects);
  }

  if (statusFilter) {
    statusFilter.addEventListener("change", filterProjects);
  }
});
