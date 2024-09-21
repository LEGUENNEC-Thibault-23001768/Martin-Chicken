<?php 
final class PlatController
{
    public function defautAction()
    {
        Vue::montrer("gestion/dashboard", []);
    }

    public function ajouterAction()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nom = $_POST['nom'];
            $repas_id = $_POST['repas_id'];

            if ($nom && $repas_id) {
                PlatModel::ajouterPlat($nom, (int) $repas_id);
                header('Location: index.php?ctrl=Plat&action=lister');
            } else {
                echo "Remplissez tous les champs.";
            }
        } else {
            Vue::montrer('gestion/ajouter', ['actionPlat' => true]);
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
            Vue::montrer('gestion/modifier', ['plat' => $plat, 'actionPlat' => true]);
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
        Vue::montrer('gestion/lister', ['plats' => $plats, 'actionPlat' => true]);
    }

}

?>