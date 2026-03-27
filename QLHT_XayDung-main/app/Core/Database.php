<?php
// app/Core/Database.php


class Database
{
    private $host = "localhost";
    private $user = "root";
    private $pass = "";
    private $db   = "qlht_xaydung_vlute";
    public $conn;

    public function __construct()
    {
        $this->conn = new mysqli($this->host, $this->user, $this->pass, $this->db);

        if ($this->conn->connect_error) {
            die("Ket noi CSDL that bai: " . $this->conn->connect_error);
        }
        $this->conn->set_charset("utf8");
    }
}
// KẾT THÚC FILE TẠI ĐÂY, KHÔNG VIẾT GÌ THÊM