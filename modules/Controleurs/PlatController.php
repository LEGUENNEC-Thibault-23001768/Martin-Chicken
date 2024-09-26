<?php 
final class PlatController
{
    public static string $titre  = "Compte";
    public function defautAction()
    {
        if (!AuthModel::isLoggedIn()) {
            header("HTTP/1.1 401 Unauthorized");
            header("Location: /?ctrl=Login");
            exit();
        }

        $this->listerAction();
        //Vue::montrer("gestion/dashboard", ['onPlat' => true]);
    }

    public function ajouterAction()
    {
        if (!AuthModel::isLoggedIn()) {
            header("HTTP/1.1 401 Unauthorized");
            header("Location: /?ctrl=Login");
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nom = $_POST['nom'];
            $repas_id = $_POST['repas_id'];
            
            error_log(print_r($nom, true));
            error_log(print_r($repas_id, true));
            if (isset($nom) && isset($repas_id)) {

                try {
                    PlatModel::ajouterPlat($nom, (int) $repas_id);
                } catch (Exc)

                header('Location: index.php');
            } else {
                Vue::montrer('gestion/ajouter', array('onPlat' => true, 'error' => 'caca pipi'));
                return;
            }
        } else {
            Vue::montrer('gestion/ajouter', ['onPlat' => true]);
        }
    }

    public function modifierAction()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $nom = $_POST['nom'];
            $repas_id = $_POST['repas_id'];

            if ($id && $nom && $repas_id) {
                PlatModel::modifierPlat((int) $id, $nom, (int) $repas_id);
                header('Location: index.php?ctrl=Plat&action=lister');
            } else {
                echo "Remplissez tous les champs.";
            }
        } else {
            $id = $_GET['id'] ?? null;
            $plat = PlatModel::obtenirPlat((int) $id);
            Vue::montrer('gestion/modifier', ['plat' => $plat, 'onPlat' => true]);
        }
    }

    public function supprimerAction()
    {
        $id = $_GET['id'] ?? null;
        if ($id) {
            PlatModel::supprimerPlat((int) $id);
            header('Location: index.php?ctrl=Plat&action=lister');
        } else {
            echo "ID manquant.";
        }
    }

    public function listerAction()
    {
        $plats = PlatModel::listerPlats();
        Vue::montrer('gestion/dashboard', ['plats' => $plats, 'onPlat' => true]);
    }

}

?>