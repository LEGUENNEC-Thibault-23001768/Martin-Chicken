<?php

final class TenracController
{
    public static string $titre = "Gestion des Tenracs";

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
        $tenracs = TenracModel::listerTenracs();
        Vue::montrer('gestion/lister', ['tenracs' => $tenracs, 'onTenrac' => true]);
    }

    public function ajouterAction()
    {
        AuthModel::checkAuth();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
                die('CSRF token validation failed');
            }
            $data = [
                'code_personnel' => $_POST['code_personnel'],
                'nom' => $_POST['nom'],
                'email' => $_POST['email'],
                'numero' => $_POST['numero'],
                'adresse' => $_POST['adresse'],
                'grade' => $_POST['grade'],
                'rang' => $_POST['rang'],
                'titre' => $_POST['titre'],
                'dignite' => $_POST['dignite'],
                'structure_id' => $_POST['structure_id']
            ];

            if ($this->validerAction($data)) {
                $id = TenracModel::ajouterTenrac($data);
                if ($id) {
                    header('Location: index.php?ctrl=Login');
                    exit();
                } else {
                    $error = 'Erreur lors de l\'ajout du Tenrac.';
                }
            } else {
                $error = 'Veuillez remplir tous les champs obligatoires.';
            }
        }

        $structures = StructureModel::listerStructures();
        Vue::montrer('gestion/ajouter', [
            'onTenrac' => true,
            'structures' => $structures,
            'error' => $error ?? null
        ]);
    }

    public function modifierAction()
    {
        AuthModel::checkAuth();

        $id = $_GET['id'] ?? $_POST['id'] ?? null;

        if (!$id) {
            echo "ID du Tenrac non spécifié.";
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
                die('CSRF token validation failed');
            }
            $data = [
                'code_personnel' => $_POST['code_personnel'],
                'nom' => $_POST['nom'],
                'email' => $_POST['email'],
                'numero' => $_POST['numero'],
                'adresse' => $_POST['adresse'],
                'grade' => $_POST['grade'],
                'rang' => $_POST['rang'],
                'titre' => $_POST['titre'],
                'dignite' => $_POST['dignite'],
                'structure_id' => $_POST['structure_id']
            ];

            if ($this->validerAction($data)) {
                if (TenracModel::modifierTenrac((int)$id, $data)) {
                    header('Location: index.php?ctrl=Login');
                    exit();
                } else {
                    $error = "Erreur lors de la modification du Tenrac.";
                }
            } else {
                $error = "Veuillez remplir tous les champs obligatoires.";
            }
        }

        $tenrac = TenracModel::obtenirTenrac((int)$id);
        $structures = StructureModel::listerStructures();
        Vue::montrer('gestion/modifier', [
            'tenrac' => $tenrac,
            'structures' => $structures,
            'onTenrac' => true,
            'error' => $error ?? null,
        ]);
    }

    public function supprimerAction()
    {
        AuthModel::checkAuth();

        $id = $_GET['id'] ?? null;
        if ($id) {
            if (TenracModel::supprimerTenrac((int)$id)) {
                header('Location: index.php?ctrl=Login');
                exit();
            } else {
                echo "Erreur lors de la suppression du Tenrac.";
            }
        } else {
            echo "ID manquant.";
        }
    }

    private function validerAction(array $data): bool
    {
        $requiredFields = ['code_personnel', 'nom', 'email', 'grade'];
        foreach ($requiredFields as $field) {
            if (empty($data[$field])) {
                return false;
            }
        }
        return true;
    }
}
