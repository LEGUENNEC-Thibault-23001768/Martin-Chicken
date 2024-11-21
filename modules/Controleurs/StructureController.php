<?php

final class StructureController
{
    public static string $titre = "Gestion des Structures";

    public function defaultAction()
    {
        if (!AuthModel::isLoggedIn()) {
            header("HTTP/1.1 401 Unauthorized");
            header("Location: ?ctrl=Compte");
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
            if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
                die('CSRF token validation failed');
            }

            $type = $_POST['type'];
            $nom = $_POST['nom'];
            $adresse = $_POST['adresse'];

            if ($type && $nom && $adresse) {
                $id = StructureModel::ajouterStructure($type, $nom, $adresse);
                if ($id) {
                    header("Location: ?ctrl=Compte");
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
        $structure = StructureModel::obtenirStructure((int) $id);
        if (!$id) {
            echo "ID de la structure non spécifié.";
            return;
        }

        if (!$structure) {
            header("Location: ?ctrl=Compte");
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
                die('CSRF token validation failed');
            }
            $nom = trim($_POST['nom'] ?? '');
            $adresse = $_POST['adresse'] ?? [];

            $modifications = false;

            if ($nom !== '' && $nom !== $structure['nom']) {
                StructureModel::modifierStructure((int) $id, $nom, $adresse);
                $modifications = true;
            }

            if ($adresse !== '' && $adresse !== $structure['adresse']) {
                StructureModel::modifierStructure((int) $id, $nom, $adresse);
                $modifications = true;
            }

            if ($modifications) {
                header("Location: ?ctrl=Compte");
            } else {
                $error = "Aucune modification n'a été effectuée.";
            }
    }
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
        $validation = $_GET['validation'] ?? null;
        if ((bool) $validation === true) {
            StructureModel::supprimerStructure((int) $id);
            header("Location: ?ctrl=Compte");
        }

        Vue::montrer('gestion/supprimer',['id' => $id, 'onStructure' => true]);
    }
}