<?php
// app/Models/Employee.php

class Employee
{
    private $db;

    public function __construct($dbConn)
    {
        $this->db = $dbConn;
    }

    // Lấy danh sách nhân viên kèm tên công trình họ đang làm
    public function getAllWithProject()
    {
        $sql = "SELECT employees.*, projects.name as project_name 
                FROM employees 
                LEFT JOIN projects ON employees.project_id = projects.id";
        return $this->db->query($sql);
    }

    // Thêm nhân viên mới
    public function save($fullname, $position, $project_id)
    {
        $fullname = $this->db->real_escape_string($fullname);
        $position = $this->db->real_escape_string($position);
        $project_id = (int)$project_id;

        $sql = "INSERT INTO employees (fullname, position, project_id) 
                VALUES ('$fullname', '$position', '$project_id')";
        return $this->db->query($sql);
    }
}
