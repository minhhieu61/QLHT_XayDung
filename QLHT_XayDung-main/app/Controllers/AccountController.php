<?php
// app/Controllers/AccountController.php

require_once __DIR__ . '/../Core/Database.php';
require_once __DIR__ . '/../Models/AccountModel.php';

class AccountController
{
    private $model;
    private $db;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->conn;
        $this->model = new AccountModel($this->db);
    }

    public function index()
    {
        return [
            'accounts'      => $this->model->getAll(),
            'total_acc'     => $this->model->countByRole(),
            'total_user'    => $this->model->countByRole('user'),
            'total_admin'   => $this->model->countByRole('admin'), // Đã thêm dấu phẩy ở đây
            'total_manager' => $this->model->countByRole('manager')
        ];
    }

    // Xử lý Thêm tài khoản
    public function handleAdd()
    {
        // Kiểm tra đúng tên button từ Form gửi lên
        if (isset($_POST['btn_save_account'])) {
            $username = trim($_POST['username']);
            $fullname = trim($_POST['fullname']);
            $password = $_POST['password'];
            $role     = $_POST['role']; // Sẽ nhận: admin, manager, hoặc user

            // 1. Kiểm tra trống (Validate cơ bản)
            if (empty($username) || empty($password) || empty($fullname)) {
                header("Location: admin_dashboard.php?status=error_empty");
                exit();
            }

            // 2. Kiểm tra trùng tên đăng nhập
            if ($this->model->checkExists($username)) {
                echo "<script>alert('Tên đăng nhập đã tồn tại!'); window.location.href='admin_dashboard.php';</script>";
            } else {
                // 3. Mã hóa mật khẩu
                $hashed_pass = password_hash($password, PASSWORD_DEFAULT);

                // 4. Lưu vào DB thông qua Model
                $result = $this->model->save($fullname, $username, $hashed_pass, $role);

                if ($result) {
                    header("Location: admin_dashboard.php?status=success");
                } else {
                    header("Location: admin_dashboard.php?status=error_db");
                }
            }
            exit();
        }
    }

    // Xử lý Sửa
    // public function handleEdit()
    // {
    //     if (isset($_POST['btn_save_account'])) {
    //         $id = intval($_POST['user_id']);
    //         $fullname = trim($_POST['fullname']);
    //         $role = $_POST['role'];
    //         $passSql = "";

    //         if (!empty($_POST['password'])) {
    //             $hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
    //             $passSql = ", password = '$hash'";
    //         }

    //         $this->model->update($id, $fullname, $role, $passSql);
    //         header("Location: admin_dashboard.php?status=updated");
    //         exit();
    //     }
    // }
    public function handleEdit()
    {
        if (isset($_POST['btn_save_account'])) {
            $id = intval($_POST['user_id']);
            $fullname = trim($_POST['fullname']);
            $role = $_POST['role'];

            $hashed_password = null;
            if (!empty($_POST['password'])) {
                $hashed_password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            }

            $result = $this->model->update($id, $fullname, $role, $hashed_password);

            if ($result) {
                // Kiểm tra: Nếu ID tài khoản vừa sửa TRÙNG với ID đang đăng nhập
                if (isset($_SESSION['user_id']) && $id === intval($_SESSION['user_id'])) {
                    $_SESSION['user'] = $fullname; // Cập nhật tên mới vào Session ngay lập tức
                }

                header("Location: admin_dashboard.php?status=updated");
            } else {
                echo "Lỗi: " . $this->db->error;
            }
            exit();
        }
    }
    public function handleDelete($id)
    {
        if (isset($_SESSION['user_id']) && $id == $_SESSION['user_id']) {
            header("Location: admin_dashboard.php?status=error_self");
        } else {
            $this->model->delete($id);
            header("Location: admin_dashboard.php?status=deleted");
        }
        exit();
    }
}
