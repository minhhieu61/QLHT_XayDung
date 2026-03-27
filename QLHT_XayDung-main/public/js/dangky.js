document.addEventListener("DOMContentLoaded", function() {
    const form = document.querySelector(".form-main");

    form.addEventListener("submit", function(e) {
        const pass = document.getElementById("pass").value;
        const repass = document.getElementById("repass") ? document.getElementById("repass").value : null;

        // Nếu là trang đăng ký mới có repass
        if (repass !== null) {
            if (pass !== repass) {
                e.preventDefault();
                alert("Mật khẩu xác nhận không khớp, vui lòng kiểm tra lại!");
            }
        }
    });
});