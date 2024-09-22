<?php
namespace Controleurs;

use Noyau\Controleur;
use Modele\AuthModel;
use Noyau\Connexion as DB;

class Connexion extends Controleur {

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];

            $db = DB::getInstance();
            $authModel = new AuthModel($db);

            $user = $authModel->login($username, $password);

            if ($user) {
                session_start();
                $_SESSION['user_id'] = $user['Id'];
                $_SESSION['username'] = $user['username'];

                header("Location: index.php?action=dashboard");
                exit();
            } else {
                $this->render('login/login', ['error' => 'Invalid username or password']);
            }
        } else {
            $this->render('login/login');
        }
    }

    public function dashboard() {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?action=login");
            exit();
        }

        $this->render('standard/entete');
        echo "<h2>Welcome, " . $_SESSION['username'] . "</h2>";
        echo "<p>This is your dashboard.</p>";
        $this->render('standard/pied');
    }
}
