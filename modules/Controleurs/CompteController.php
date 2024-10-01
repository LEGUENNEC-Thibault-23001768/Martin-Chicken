<?php
final class CompteController
{
    public static string $titre  = "Connexion";
    public function defaultAction()
    {
        if (AuthModel::isLoggedIn()) {
            Vue::montrer('compte');
        } else {
            $error = isset($_SESSION['login_error']) ? $_SESSION['login_error'] : '';
            unset($_SESSION['login_error']);
            Vue::montrer('compte', array('error' => $error));
        }
    }

    public function loginAction() {

        if ($_SERVER['REQUEST_METHOD'] !== 'POST')
            return;

        if (isset($_SESSION['login_error']))
            unset($_SESSION['login_error']);

        $username = $_POST['username'];
        $password = $_POST['password'];

        $auth_model = new AuthModel();
        
        $result = $auth_model->login($username, $password);

        try {

            if (!$result) {
                $_SESSION['login_error'] = "Mauvais nom d'utilisateur ou mot de passe";
                header('Location: index.php?ctrl=Compte');
                return;
            }

            Vue::montrer('compte');


        } catch (Exception $e) {
            $err = $e->getMessage();
            $_SESSION['login_error'] = $err;
            header('Location: index.php?ctrl=Login');
        }
    }

}