<?php
// app/Controllers/TicketController.php

require_once '../app/Models/Ticket.php';
require_once '../app/Models/MatchModel.php';

class TicketController
{
    private $db;
    private $ticketModel;
    private $matchModel;

    public function __construct($db)
    {
        $this->db = $db;
        $this->ticketModel = new Ticket($this->db);
        $this->matchModel = new MatchModel($this->db);
    }

    public function index()
    {
        // Liste des matchs pour acheter
        $upcoming_matches = $this->matchModel->getUpcoming();
        $this->render('tickets/index', ['upcoming_matches' => $upcoming_matches, 'page_title' => 'Billetterie', 'current_page' => 'ticketing']);
    }

    public function buy()
    {
        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?controller=auth&action=login");
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['match_id'])) {
            $match_id = intval($_POST['match_id']);
            $user_id = $_SESSION['user_id'];
            $zone = isset($_POST['zone']) ? intval($_POST['zone']) : 1;
            $quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 1;

            if ($quantity < 1)
                $quantity = 1;
            if ($quantity > 4)
                $quantity = 4;
            if ($zone < 1 || $zone > 4)
                $zone = 1;

            $code = $this->ticketModel->buy($user_id, $match_id, $quantity, $zone);

            if ($code) {
                header("Location: index.php?controller=ticket&action=my_tickets&success=" . $code);
                exit();
            } else {
                die("Erreur lors de l'achat.");
            }
        }
    }

    public function my_tickets()
    {
        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?controller=auth&action=login");
            exit();
        }

        $tickets = $this->ticketModel->getUserTickets($_SESSION['user_id']);
        $this->render('tickets/my_tickets', ['tickets' => $tickets, 'page_title' => 'Mes Tickets', 'current_page' => 'my_tickets']);
    }

    public function delete()
    {
        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?controller=auth&action=login");
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ticket_id'])) {
            $ticket_id = intval($_POST['ticket_id']);
            if ($this->ticketModel->delete($ticket_id, $_SESSION['user_id'])) {
                header("Location: index.php?controller=ticket&action=my_tickets&deleted=1");
                exit();
            }
        }
        header("Location: index.php?controller=ticket&action=my_tickets");
    }

    private function render($view, $data = [])
    {
        extract($data);
        include '../app/Views/' . $view . '.php';
    }
}
?>