<?php
// app/Models/Team.php

class Team
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getAll()
    {
        $sql = "SELECT * FROM teams ORDER BY name ASC";
        return mysqli_query($this->conn, $sql);
    }

    public function create($name, $logo_url)
    {
        $sql = "INSERT INTO teams (name, logo_url) VALUES (?, ?)";
        $stmt = mysqli_prepare($this->conn, $sql);
        mysqli_stmt_bind_param($stmt, "ss", $name, $logo_url);
        return mysqli_stmt_execute($stmt);
    }
}
?>