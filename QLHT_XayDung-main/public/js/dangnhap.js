document.addEventListener("DOMContentLoaded", function () {
  const loginForm = document.querySelector(".form-main");
  const errorBox = document.getElementById("error-js");

  loginForm.addEventListener("submit", function (e) {
    const user = document.getElementById("user").value.trim();
    const pass = document.getElementById("pass").value.trim();

    if (user === "" || pass === "") {
      e.preventDefault(); // Dừng gửi form
      errorBox.textContent = "Bạn chưa nhập tài khoản hoặc mật khẩu!";
      errorBox.style.display = "block";

      // Hiệu ứng rung nhẹ khi có lỗi
      loginForm.style.animation = "shake 0.5s";
      setTimeout(() => {
        loginForm.style.animation = "";
      }, 500);
    }
  });
});

// Thêm hiệu ứng rung bằng CSS qua JS
const style = document.createElement("style");
style.innerHTML = `
@keyframes shake {
    0% { transform: translateX(0); }
    25% { transform: translateX(-5px); }
    50% { transform: translateX(5px); }
    75% { transform: translateX(-5px); }
    100% { transform: translateX(0); }
}`;
document.head.appendChild(style);
function togglePassword() {
  const passwordInput = document.getElementById("txt_pass");
  const toggleIcon = document.getElementById("toggleIcon");

  if (passwordInput.type === "password") {
    // Hiện mật khẩu
    passwordInput.type = "text";
    toggleIcon.classList.remove("fa-eye");
    toggleIcon.classList.add("fa-eye-slash");
  } else {
    // Ẩn mật khẩu
    passwordInput.type = "password";
    toggleIcon.classList.remove("fa-eye-slash");
    toggleIcon.classList.add("fa-eye");
  }
}
