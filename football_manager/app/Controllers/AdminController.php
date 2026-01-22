<?php
// app/Controllers/AdminController.php

require_once '../app/Models/Team.php';
require_once '../app/Models/MatchModel.php';

class AdminController
{
    private $db;
    private $teamModel;
    private $matchModel;

    public function __construct($db)
    {
        $this->db = $db;
        $this->teamModel = new Team($this->db);
        $this->matchModel = new MatchModel($this->db);
    }

    public function index()
    {
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            header("Location: index.php?controller=auth&action=login");
            exit();
        }

        $message = "";

        // Add Team Logic
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_team'])) {
            $name = trim($_POST['team_name']);
            $logo = "images/teams/default.png";
            if (!empty($name)) {
                if ($this->teamModel->create($name, $logo)) {
                    $message = "✅ Équipe ajoutée avec succès !";
                } else {
                    $message = "❌ Erreur lors de l'ajout.";
                }
            }
        }

        // Add Match Logic
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_match'])) {
            $home = intval($_POST['home_team']);
            $away = intval($_POST['away_team']);
            $date = $_POST['match_date'];

            if ($home !== $away && !empty($date)) {
                if ($this->matchModel->create($home, $away, $date)) {
                    $message = "✅ Match programmé avec succès !";
                } else {
                    $message = "❌ Erreur lors de la programmation.";
                }
            }
        }

        $teams = $this->teamModel->getAll();
        $matchs = $this->matchModel->getUpcoming(); // For display list

        // Variables pour la vue
        $page_title = "Administration";
        $current_page = "admin";

        $this->render('admin/dashboard', compact('teams', 'matchs', 'message', 'page_title', 'current_page'));
    }

    private function render($view, $data = [])
    {
        extract($data);
        include '../app/Views/' . $view . '.php'; // Usually admin has diff layout, but lets use same partials
    }
}
?>