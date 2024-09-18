<?php
final class LoginController
{
    public function defautAction()
    {
        //var_dump($_SESSION);

        $error = isset($_SESSION['login_error']) ? $_SESSION['login_error'] : '';
        unset($_SESSION['login_error']);

        Vue::montrer('auth/login', array('error' => $error));
        
    }

    public function loginAction() {

        if ($_SERVER['REQUEST_METHOD'] !== 'POST')
            return;

        $username = $_POST['username'];
        $password = $_POST['password'];

        $auth_model = new AuthModel();
        
        $result = $auth_model->login($username, $password);

        var_dump($result);
        try {

            if (!$result) {
                $_SESSION['login_error'] = "Mauvais nom d'utilisateur ou mot de passe";
                //header('Location: index.php?ctrl=Login');
                return;
            }

            //header('Location: index.php?ctrl=ZEBI'); // rediriger vers dashboard


        } catch (Exception $e) {
            $err = $e->getMessage();
            $_SESSION['login_error'] = $err;
            header('Location: index.php?ctrl=Login');
        }
    }

}
