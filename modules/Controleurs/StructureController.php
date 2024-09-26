<?php

final class StructureController
{
    public static string $titre = "Gestion des Structures";

    public function defautAction()
    {
        if (!AuthModel::isLoggedIn()) {
            header("HTTP/1.1 401 Unauthorized");
            header("Location: /?ctrl=Login");
            exit();
        }

        $this->listerAction();
    }

    public function listerAction()
    {
        $structures = StructureModel::listerStructures();
        Vue::montrer('gestion/lister', ['structures' => $structures, 'onStructure' => true]);
    }

    public function ajouterAction()
    {
        AuthModel::checkAuth();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $type = $_POST['type'];
            $nom = $_POST['nom'];
            $adresse = $_POST['adresse'];

            if ($type && $nom && $adresse) {
                $id = StructureModel::ajouterStructure($type, $nom, $adresse);
                if ($id) {
                    header('Location: index.php?ctrl=Structure&action=lister');
                    exit();
                } else {
                    Vue::montrer('gestion/ajouter', ['onStructure' => true, 'error' => 'Erreur lors de l\'ajout de la structure.']);
                }
            } else {
                Vue::montrer('gestion/ajouter', ['onStructure' => true, 'error' => 'Veuillez remplir tous les champs.']);
            }
        } else {
            Vue::montrer('gestion/ajouter', ['onStructure' => true]);
        }
    }

    public function modifierAction()
    {
        AuthModel::checkAuth();

        $id = $_GET['id'] ?? $_POST['id'] ?? null;

        if (!$id) {
            echo "ID de la structure non spécifié.";
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nom = $_POST['nom'];
            $adresse = $_POST['adresse'];

            if ($nom && $adresse) {
                if (StructureModel::modifierStructure((int)$id, $nom, $adresse)) {
                    header('Location: index.php?ctrl=Structure&action=lister');
                    exit();
                } else {
                    $error = "Erreur lors de la modification de la structure.";
                }
            } else {
                $error = "Veuillez remplir tous les champs.";
            }
        }

        $structure = StructureModel::obtenirStructure((int)$id);
        Vue::montrer('gestion/modifier', [
            'structure' => $structure,
            'onStructure' => true,
            'error' => $error ?? null,
        ]);
    }

    public function supprimerAction()
    {
        AuthModel::checkAuth();

        $id = $_GET['id'] ?? null;
        if ($id) {
            if (StructureModel::supprimerStructure((int)$id)) {
                header('Location: index.php?ctrl=Structure&action=lister');
                exit();
            } else {
                echo "Erreur lors de la suppression de la structure.";
            }
        } else {
            echo "ID manquant.";
        }
    }
}
