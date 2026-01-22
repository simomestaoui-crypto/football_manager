<?php
// public/index.php : LE ROUTEUR (POINT D'ENTRÉE UNIQUE)
// C'est la "Porte d'entrée" du site. TOUTES les requêtes passent par ici.

session_start(); // Démarrage de la session (pour garder l'utilisateur connecté)

// 1. Chargement de la configuration
require_once '../app/Config/Database.php';

// 2. Connexion à la Base de Données
// On crée une instance de la classe Database et on récupère la connexion active
$database = new Database();
$db = $database->getConnection();

// 3. Analyse de l'URL (Qui appelle ?)
// On regarde si l'URL contient ?controller=... (ex: index.php?controller=ticket)
// Si rien n'est précisé, par défaut on va sur 'home' (Accueil)
$controllerName = isset($_GET['controller']) ? $_GET['controller'] : 'home';

// On regarde si l'URL contient ?action=... (ex: index.php?action=buy)
// Si rien n'est précisé, par défaut on exécute l'action 'index' (Page principale du contrôleur)
$actionName = isset($_GET['action']) ? $_GET['action'] : 'index';

// 4. Aiguillage (Switch) : On choisit le bon Contrôleur
switch ($controllerName) {
    case 'auth':
        require_once '../app/Controllers/AuthController.php';
        $controller = new AuthController($db); // On passe la connexion DB au contrôleur
        break;
    case 'ticket':
        require_once '../app/Controllers/TicketController.php';
        $controller = new TicketController($db);
        break;
    case 'admin':
        require_once '../app/Controllers/AdminController.php';
        $controller = new AdminController($db);
        break;
    case 'home':
    default:
        // Si le contrôleur demandé n'existe pas, on redirige vers l'accueil
        require_once '../app/Controllers/HomeController.php';
        $controller = new HomeController($db);
        break;
}

// 5. Exécution de l'action demandée
// On vérifie si la méthode (ex: buy()) existe bien dans le contrôleur choisi
if (method_exists($controller, $actionName)) {
    $controller->{$actionName}(); // On lance la fonction (ex: $controller->buy())
} else {
    // Si l'action n'existe pas (ex: ?action=nimportequoi), on lance l'index par sécurité
    $controller->index();
}
?>