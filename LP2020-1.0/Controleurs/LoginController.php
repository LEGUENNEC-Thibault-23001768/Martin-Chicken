<?php

final class LoginController
{
    public function defautAction()
    {
        //var_dump($_SESSION);

        Vue::montrer('login/login.php', array('login' => ''));
    }

    public function loginAction() {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];

            $auth_model = new AuthModel();

            try {
                $result = $auth_model->login($username, $password);

                if ($result) {

                    header('Location: index.php?ctrl=ZEBI'); // rediriger vers dashboard
                } else {
                    // afficher un truc d'erreur
                    //Vue::montrer('login/login', array('login'=> ''));
                }

            } catch (Exception $e) {
                $err = $e->getMessage();
            }
        } else {
            //Vue::montrer('login/login', array('login'=> ''));
        }
    }

}
