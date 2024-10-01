<?php
final class LoginController
{
    public static string $titre  = "Connexion";
    public function defautAction()
    {
        if (AuthModel::isLoggedIn()) {
            Vue::montrer("compte", array());
            //header("Location: /?ctrl=Login"); // redirect to dashboard
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
                header('Location: index.php?ctrl=Login');
                return;
            }


            //Vue::montrer('compte', '');
            header('Location: index.php?ctrl=Repas'); // rediriger vers dashboard


        } catch (Exception $e) {
            $err = $e->getMessage();
            $_SESSION['login_error'] = $err;
            header('Location: index.php?ctrl=Login');
        }
    }

}
