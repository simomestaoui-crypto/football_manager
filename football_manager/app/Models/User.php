<?php
// app/Models/User.php

class User
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function register($username, $email, $password)
    {
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($this->conn, $sql);
        mysqli_stmt_bind_param($stmt, "sss", $username, $email, $password_hash);
        return mysqli_stmt_execute($stmt);
    }

    /**
     * @return array|bool
     */
    public function login($email, $password): array|bool
    {
        $sql = "SELECT id, username, password, role FROM users WHERE email = ?";
        $stmt = mysqli_prepare($this->conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($row = mysqli_fetch_assoc($result)) {
            if (password_verify($password, $row['password'])) {
                return $row;
            }
        }
        return false;
    }
}
?>