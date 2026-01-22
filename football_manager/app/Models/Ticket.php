<?php
// app/Models/Ticket.php

class Ticket
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function buy($user_id, $match_id, $quantity, $zone)
    {
        $code = "TKT-" . strtoupper(substr(uniqid(), -6));
        $sql = "INSERT INTO tickets (user_id, match_id, quantity, zone, ticket_code) VALUES (?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($this->conn, $sql);
        mysqli_stmt_bind_param($stmt, "iiiis", $user_id, $match_id, $quantity, $zone, $code);

        if (mysqli_stmt_execute($stmt)) {
            return $code;
        }
        return false;
    }

    public function getUserTickets($user_id)
    {
        $sql = "SELECT t.*, m.match_date, 
                         t1.name as home_team, t1.logo_url as home_logo,
                         t2.name as away_team, t2.logo_url as away_logo
                  FROM tickets t
                  JOIN matches m ON t.match_id = m.id
                  JOIN teams t1 ON m.home_team_id = t1.id
                  JOIN teams t2 ON m.away_team_id = t2.id
                  WHERE t.user_id = ?
                  ORDER BY t.purchase_date DESC";
        $stmt = mysqli_prepare($this->conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $user_id);
        mysqli_stmt_execute($stmt);
        return mysqli_stmt_get_result($stmt);
    }

    public function delete($ticket_id, $user_id)
    {
        $sql = "DELETE FROM tickets WHERE id = ? AND user_id = ?";
        $stmt = mysqli_prepare($this->conn, $sql);
        mysqli_stmt_bind_param($stmt, "ii", $ticket_id, $user_id);
        return mysqli_stmt_execute($stmt);
    }
}
?>