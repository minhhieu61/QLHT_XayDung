<?php
// app/Models/CongTrinh.php

class CongTrinh
{
    private $db;

    public function __construct($dbConn)
    {
        $this->db = $dbConn;
    }

    public function lay_tat_ca()
    {
        $sql = "SELECT * FROM projects ORDER BY id DESC";
        return $this->db->query($sql);
    }

    public function luu($ten, $trang_thai)
    {
        $ten = $this->db->real_escape_string($ten);
        $trang_thai = $this->db->real_escape_string($trang_thai);
        $sql = "INSERT INTO projects (name, status) VALUES ('$ten', '$trang_thai')";
        return $this->db->query($sql);
    }
}
