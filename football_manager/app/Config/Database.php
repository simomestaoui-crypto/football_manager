<?php
// app/Config/Database.php
// Ce fichier gère UNIQUEMENT la connexion technique à la base de données.

class Database
{
    // Informations de connexion (Privées pour la sécurité)
    private $host = "127.0.0.1";      // Adresse du serveur BDD (Localhost)
    private $db_name = "football_db"; // Nom de la base
    private $username = "football_admin"; // Utilisateur
    private $password = "password123";    // Mot de passe
    private $port = 3306;             // Port (3306 standard, 8889 sur MAMP parfois)
    public $conn;                     // La variable qui stockera la connexion active

    // Fonction pour se connecter
    public function getConnection()
    {
        $this->conn = null;
        try {
            // Tentative de connexion avec mysqli
            $this->conn = mysqli_connect($this->host, $this->username, $this->password, $this->db_name, $this->port);
        } catch (Exception $exception) {
            // Si erreur, on l'affiche
            echo "Erreur de connexion : " . $exception->getMessage();
        }
        // On retourne la connexion prête à l'emploi
        return $this->conn;
    }
}
?>