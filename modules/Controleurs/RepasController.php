<?php

final class RepasController
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
    }

    // Ajouter un nouveau repas
    public function ajouterAction()
    {
        if (!AuthModel::isLoggedIn()) {
            header("HTTP/1.1 401 Unauthorized");
            header("Location: /?ctrl=Login");
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            $id = $_POST['id'];
            $nom = $_POST['nom'];
            $date = $_POST['date'];
            $adresse = $_POST['adresse'];
            $presence = isset($_POST['presence']) ? 1 : 0;

            if ($nom && $date && $adresse) {
                RepasModel::ajouterRepas($nom, $date, $adresse, $presence);
                header('Location: index.php?ctrl=Repas&action=lister');
            } else {
                Vue::montrer('gestion/ajouter', array('onRepas' => true, 'error' => 'Tous les champs sont obligatoires.'));
                return;
            }
        } else {
            Vue::montrer('gestion/ajouter', ['onRepas' => true]);
        }
    }

    // Modifier un repas existant
    public function modifierAction()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Traitement du formulaire POST pour la modification
            $id = $_POST['id'];
            $nom = $_POST['nom'];
            $date = $_POST['date'];
            $adresse = $_POST['adresse'];
            $presence = isset($_POST['presence']) ? 1 : 0;

            if ($nom && $date && $adresse) {
                RepasModel::modifierRepas((int)$id, $nom, $date, $adresse, $presence);
                header('Location: index.php?ctrl=Repas&action=lister');
            } else {
                echo "Remplissez tous les champs.";
            }
        } else {
            // Affichage du formulaire pré-rempli pour la modification
            $id = $_GET['id'] ?? null;
            if ($id) {
                $repas = RepasModel::obtenirRepas((int)$id);
                //error_log(print_r($repas,true));
                if (isset($repas)) {
                    error_log("azioezhaioe");
                    Vue::montrer('gestion/modifier', ['repas' => $repas, 'onRepas' => true]);
                } else {
                    echo "Repas introuvable.";
                }
            } else {
                echo "ID manquant.";
            }
        }
    }

    // Supprimer un repas
    public function supprimerAction()
    {
        $id = $_GET['id'] ?? null;
        if ($id) {
            RepasModel::supprimerRepas((int)$id);
            header('Location: index.php?ctrl=Repas&action=lister');
        } else {
            echo "ID manquant.";
        }
    }

    // Lister tous les repas
    public function listerAction()
    {
        $repas = RepasModel::listerRepas();
        //error_log(print_r($repas,true));
        Vue::montrer('gestion/lister', ['repas' => $repas, 'onRepas' => true]);
    }
}
