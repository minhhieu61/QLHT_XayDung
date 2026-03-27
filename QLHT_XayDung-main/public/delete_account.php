<?php
session_start();

// Nạp file Controller thủ công
require_once __DIR__ . '/../app/Controllers/AccountController.php';

// Khởi tạo đối tượng
$controller = new AccountController();

// Gọi hàm delete
if (isset($_GET['id'])) {
    $controller->handleDelete($_GET['id']);
} else {
    header("Location: admin_dashboard.php");
}
