<?php
require_once '../Noyau/Connexion.php';
require_once '../Modele/AuthModel.php';

class AuthController {
    private $db;
    private $authModel;

    public function __construct() {
        $database = new Database();
        $this->db = $database->connect();
        $this->authModel = new AuthModel($this->db);
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];

            $user = $this->authModel->login($username, $password);

            if ($user) {
                // Si authentifié, démarrer une session
                session_start();
                $_SESSION['user_id'] = $user['Id'];
                $_SESSION['username'] = $user['username'];
                
                // Redirection vers le tableau de bord
                //header("Location: /project-root/public/index.php?action=dashboard");
                exit();
            } else {
                // Retourner à la page de connexion avec une erreur
                $error = "Invalid username or password";
                include '../Vues/login.php';
            }
        } else {
            include '../Vues/login.php';
        }
    }

    public function dashboard() {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header("Location: /project-root/public/index.php?action=login");
            exit();
        }

        echo "<h2>Welcome, " . $_SESSION['username'] . "</h2>";
        echo "<p>This is your dashboard.</p>";
    }
}
?>
