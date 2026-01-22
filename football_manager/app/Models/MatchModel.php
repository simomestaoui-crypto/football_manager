<?php
// app/Models/MatchModel.php (Renamed to distinguish from keyword Match)

class MatchModel
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getPlayed()
    {
        $sql = "SELECT m.*, t1.name as home_team, t1.logo_url as home_logo, 
                         t2.name as away_team, t2.logo_url as away_logo
                  FROM matches m
                  JOIN teams t1 ON m.home_team_id = t1.id
                  JOIN teams t2 ON m.away_team_id = t2.id
                  WHERE m.match_date <= NOW()
                  ORDER BY m.match_date DESC";
        return mysqli_query($this->conn, $sql);
    }

    public function getUpcoming()
    {
        $sql = "SELECT m.*, t1.name as home_team, t1.logo_url as home_logo, 
                         t2.name as away_team, t2.logo_url as away_logo
                  FROM matches m
                  JOIN teams t1 ON m.home_team_id = t1.id
                  JOIN teams t2 ON m.away_team_id = t2.id
                  WHERE m.match_date > NOW()
                  ORDER BY m.match_date ASC";
        return mysqli_query($this->conn, $sql);
    }

    public function create($home_id, $away_id, $date)
    {
        $sql = "INSERT INTO matches (home_team_id, away_team_id, match_date, status) VALUES (?, ?, ?, 'scheduled')";
        $stmt = mysqli_prepare($this->conn, $sql);
        mysqli_stmt_bind_param($stmt, "iis", $home_id, $away_id, $date);
        return mysqli_stmt_execute($stmt);
    }

    public function getStandings()
    {
        $sql = "
            SELECT 
                t.id, t.name, t.logo_url,
                COUNT(games.team_id) as played,
                SUM(CASE WHEN games.points = 3 THEN 1 ELSE 0 END) as won,
                SUM(CASE WHEN games.points = 1 THEN 1 ELSE 0 END) as drawn,
                SUM(CASE WHEN games.points = 0 THEN 1 ELSE 0 END) as lost,
                SUM(games.goals_for) as goals_for,
                SUM(games.goals_against) as goals_against,
                SUM(games.goals_for - games.goals_against) as goal_diff,
                SUM(games.points) as points
            FROM teams t
            LEFT JOIN (
                SELECT home_team_id as team_id, home_score as goals_for, away_score as goals_against,
                CASE 
                    WHEN home_score > away_score THEN 3
                    WHEN home_score = away_score THEN 1
                    ELSE 0
                END as points
                FROM matches WHERE match_date <= NOW()
                UNION ALL
                SELECT away_team_id as team_id, away_score as goals_for, home_score as goals_against,
                CASE 
                    WHEN away_score > home_score THEN 3
                    WHEN away_score = home_score THEN 1
                    ELSE 0
                END as points
                FROM matches WHERE match_date <= NOW()
            ) as games ON t.id = games.team_id
            GROUP BY t.id
            ORDER BY points DESC, goal_diff DESC, goals_for DESC
        ";
        return mysqli_query($this->conn, $sql);
    }

    public function getBestAttack()
    {
        $sql = "SELECT t.name, t.logo_url, SUM(goals) as total_goals
                  FROM teams t
                  JOIN (
                      SELECT home_team_id as team_id, home_score as goals FROM matches WHERE match_date <= NOW()
                      UNION ALL
                      SELECT away_team_id as team_id, away_score as goals FROM matches WHERE match_date <= NOW()
                  ) as g ON t.id = g.team_id
                  GROUP BY t.id
                  ORDER BY total_goals DESC
                  LIMIT 1";
        $result = mysqli_query($this->conn, $sql);
        return mysqli_fetch_assoc($result);
    }

    public function getBestDefense()
    {
        $sql = "SELECT t.name, t.logo_url, SUM(goals_conceded) as total_conceded
                  FROM teams t
                  JOIN (
                      SELECT home_team_id as team_id, away_score as goals_conceded FROM matches WHERE match_date <= NOW()
                      UNION ALL
                      SELECT away_team_id as team_id, home_score as goals_conceded FROM matches WHERE match_date <= NOW()
                  ) as g ON t.id = g.team_id
                  GROUP BY t.id
                  ORDER BY total_conceded ASC
                  LIMIT 1";
        $result = mysqli_query($this->conn, $sql);
        return mysqli_fetch_assoc($result);
    }

    public function getTopScorers()
    {
        $sql = "SELECT p.name, p.position, t.name as team_name, t.logo_url, COUNT(g.id) as goals
                  FROM players p
                  JOIN teams t ON p.team_id = t.id
                  JOIN goals g ON p.id = g.player_id
                  GROUP BY p.id
                  ORDER BY goals DESC
                  LIMIT 10";
        return mysqli_query($this->conn, $sql);
    }
}
?>