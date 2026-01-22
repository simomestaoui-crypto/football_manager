<?php
// app/Controllers/AuthController.php

require_once '../app/Models/User.php';

class AuthController
{
    private $db;
    private $userModel;

    public function __construct($db)
    {
        $this->db = $db;
        $this->userModel = new User($this->db);
    }

    public function login()
    {
        $error = "";
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];

            /** @var array|bool $user */
            $user = $this->userModel->login($email, $password);
            if ($user) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role'];
                header("Location: index.php");
                exit();
            } else {
                $error = "Email ou mot de passe incorrect.";
            }
        }
        $this->render('auth/login', ['error' => $error, 'page_title' => 'Connexion', 'current_page' => 'login']);
    }

    public function register()
    {
        $success = false;
        $error = "";

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $confirm_password = $_POST['confirm_password'];

            if ($password !== $confirm_password) {
                $error = "Les mots de passe ne correspondent pas.";
            } else {
                if ($this->userModel->register($username, $email, $password)) {
                    $success = true;
                } else {
                    $error = "Erreur lors de l'inscription (Email déjà utilisé ?).";
                }
            }
        }
        $this->render('auth/register', ['success' => $success, 'error' => $error, 'page_title' => 'Inscription', 'current_page' => 'register']);
    }

    public function logout()
    {
        session_destroy();
        header("Location: index.php");
        exit();
    }

    private function render($view, $data = [])
    {
        extract($data);
        include '../app/Views/' . $view . '.php';
    }
}
?>