<?php
session_start();

require_once __DIR__ . '/../app/Controllers/AccountController.php';

$controller = new AccountController();

if (isset($_POST['btn_edit_account'])) {
    $controller->handleEdit();
} else {
    header("Location: admin_dashboard.php");
}
