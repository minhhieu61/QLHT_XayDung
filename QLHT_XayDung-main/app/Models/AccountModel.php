<?php
// app/Models/AccountModel.php

class AccountModel
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    // Lấy danh sách tất cả tài khoản
    public function getAll()
    {
        $sql = "SELECT id, fullname, username, role, created_at FROM accounts ORDER BY id DESC";
        return $this->db->query($sql);
    }

    // Thêm tài khoản
    public function save($fullname, $username, $password, $role)
    {
        $fullname = $this->db->real_escape_string($fullname);
        $username = $this->db->real_escape_string($username);
        $sql = "INSERT INTO accounts (fullname, username, password, role) 
                VALUES ('$fullname', '$username', '$password', '$role')";
        return $this->db->query($sql);
    }

    // Cập nhật tài khoản
    public function update($id, $fullname, $role, $hashed_password = null)
    {
        $id = intval($id);
        $fullname = $this->db->real_escape_string($fullname);
        $role = $this->db->real_escape_string($role);

        if ($hashed_password) {
            // Trường hợp có cập nhật mật khẩu
            $sql = "UPDATE accounts SET fullname = ?, role = ?, password = ? WHERE id = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->bind_param("sssi", $fullname, $role, $hashed_password, $id);
        } else {
            // Trường hợp KHÔNG cập nhật mật khẩu
            $sql = "UPDATE accounts SET fullname = ?, role = ? WHERE id = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->bind_param("ssi", $fullname, $role, $id);
        }

        return $stmt->execute();
    }

    // Xóa tài khoản
    public function delete($id)
    {
        $id = intval($id);
        $sql = "DELETE FROM accounts WHERE id = $id";
        return $this->db->query($sql);
    }

    // Kiểm tra username tồn tại
    public function checkExists($username)
    {
        $username = $this->db->real_escape_string($username);
        $result = $this->db->query("SELECT id FROM accounts WHERE username = '$username'");
        return $result->num_rows > 0;
    }

    // Đếm số lượng theo role
    public function countByRole($role = null)
    {
        $where = $role ? "WHERE role = '$role'" : "";
        $result = $this->db->query("SELECT COUNT(id) as total FROM accounts $where");
        $row = $result->fetch_assoc();
        return $row['total'];
    }
}
