<?php
// app/Controllers/HomeController.php
// CONTROLLER : Le "Chef d'Orchestre" de la partie publique.
// Il reçoit la demande du Routeur, demande les infos au Modèle, et envoie le tout à la Vue.

require_once '../app/Models/MatchModel.php'; // On a besoin du Modèle Match

class HomeController
{
    private $db;
    private $matchModel;

    // Constructeur : Lancé automatiquement à la création
    public function __construct($db)
    {
        $this->db = $db;
        // On prépare le Modèle (l'outil pour faire les requêtes SQL)
        $this->matchModel = new MatchModel($this->db);
    }

    // ACTION : Page d'accueil (Classement)
    public function index()
    {
        // 1. LOGIQUE : On demande les données au Modèle
        $standings = $this->matchModel->getStandings();

        // 2. PRÉPARATION : On prépare les variables pour l'affichage
        $page_title = "Classement du Championnat";
        $current_page = "index";

        $view_data = [
            'standings' => $standings,
            'page_title' => $page_title,
            'current_page' => $current_page
        ];

        // 3. AFFICHAGE : On charge la Vue (le fichier HTML)
        $this->render('home/index', $view_data);
    }

    // ACTION : Calendrier
    public function calendar()
    {
        // On récupère les matchs joués et à venir via le Modèle
        $played = $this->matchModel->getPlayed();
        $upcoming = $this->matchModel->getUpcoming();

        $page_title = "Calendrier & Résultats";
        $current_page = "calendar";

        // On envoie tout à la vue 'home/calendar.php'
        $this->render('home/calendar', compact('played', 'upcoming', 'page_title', 'current_page'));
    }

    // ACTION : Statistiques
    public function stats()
    {
        $topScorers = $this->matchModel->getTopScorers();
        $bestAttack = $this->matchModel->getBestAttack();
        $bestDefense = $this->matchModel->getBestDefense();

        $page_title = "Statistiques";
        $current_page = "stats";

        $this->render('home/stats', compact('topScorers', 'bestAttack', 'bestDefense', 'page_title', 'current_page'));
    }

    public function contact()
    {
        $page_title = "Contactez-nous";
        $current_page = "contact";
        $msg_sent = false;

        // Si le formulaire a été soumis (POST)
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Simulation d'envoi
            $msg_sent = true;
        }

        $this->render('home/contact', compact('page_title', 'current_page', 'msg_sent'));
    }

    // Fonction utilitaire pour inclure la Vue
    private function render($view, $data = [])
    {
        // 'extract' transforme le tableau ['titre' => 'Accueil'] en variable $titre = 'Accueil'
        extract($data);
        // On inclut le fichier de vue (HTML)
        include '../app/Views/' . $view . '.php';
    }
}
?>