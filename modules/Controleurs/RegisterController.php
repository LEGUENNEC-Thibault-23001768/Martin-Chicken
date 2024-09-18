<?php

require_once 'Noyau/Connexion.php';  // Assurez-vous que le chemin est correct


final class RegisterController
{

    public function defautAction()
    {
        //var_dump($_SESSION);

        Vue::montrer('auth/register', array('error' => ''));
    }

    public function registerAction()
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $username = $_POST['username'] ?? null;
            $email = $_POST['email'] ?? null;
            $password = $_POST['password'] ?? null;


            $auth_model = new AuthModel();


            if ($username && $email && $password) {
                try {
                    $result = $auth_model->register($username, $password, $email);
                    if ($result)
                        echo "coucou a toi jeune panda";
                        //header('Location: index.php?ctrl=ZEBI'); // rediriger vers dashboard
                } catch (PDOException $e) {
                    $getErreur = $e->getMessage();
                    if (strpos($getErreur, "23000"))
                        echo "le compte existe deja";
                }
            } else {
                echo "Remplissez tous les champs svp";
            }
        } else {
            echo "Methode requete invalide";
        }
    }

}