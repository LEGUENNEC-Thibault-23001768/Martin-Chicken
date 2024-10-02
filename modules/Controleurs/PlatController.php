<?php 

final class PlatController
{
    public static string $titre = "Gestion des Plats";

    private function checkAuth()
    {
        if (!AuthModel::isLoggedIn()) {
            header("HTTP/1.1 401 Unauthorized");
            header("Location: /?ctrl=Compte");
            exit();
        }
    }

    public function defaultAction()
    {
        $this->checkAuth();
        $this->listerAction();
    }

    public function ajouterAction()
    {
        $this->checkAuth();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nom = $_POST['nom'] ?? '';
            $ingredients = $_POST['ingredients'] ?? []; 
            $presence = isset($_POST['presence']);
            $sauces = $_POST['sauces'] ?? [];

            if ($nom) {
                $platId = PlatModel::ajouterPlat($nom, $presence);

                if ($platId) {
                    if (!empty($ingredients)) {
                        PlatModel::associerIngredients($platId, $ingredients);
                    }
                    
                    if (!empty($sauces)) {
                        PlatModel::associerSauces($platId, $sauces);
                    }

                    header("Location: ?ctrl=Compte");
                    exit();
                } else {
                    $error = 'Erreur lors de l\'ajout du plat.';
                }
            } else {
                $error = 'Veuillez remplir tous les champs obligatoires.';
            }
        }

        $ingredients = PlatModel::listerIngredients();
        $sauces = PlatModel::listerSauces();
        Vue::montrer('gestion/ajouter', [
            'onPlat' => true, 
            'ingredients' => $ingredients, 
            'sauces' => $sauces,
            'error' => $error ?? null
        ]);
    }

    public function modifierAction()
    {
        $this->checkAuth();

        $id = $_GET['id'] ?? $_POST['id'] ?? null;

        if (!$id) {
            header("Location: ?ctrl=Compte");
            exit();
        }

        $plat = PlatModel::obtenirPlat((int) $id);
        if (!$plat) {
            header("Location: ?ctrl=Compte");
            exit();
        }

        $error = null;
        $success = false;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nom = trim($_POST['nom'] ?? '');
            $ingredients = $_POST['ingredients'] ?? [];
            $sauces = $_POST['sauces'] ?? [];

            $modifications = false;

            // Vérifier si le nom a changé
            if ($nom !== '' && $nom !== $plat['nom']) {
                PlatModel::modifierPlat((int) $id, $nom);
                $modifications = true;
            }

            // Vérifier si les ingrédients ont changé
            $ingredientsActuels = array_column(PlatModel::obtenirIngredientsPlat((int)$id), 'id');
            if (array_diff($ingredients, $ingredientsActuels) !== array_diff($ingredientsActuels, $ingredients)) {
                PlatModel::mettreAJourIngredients((int) $id, $ingredients);
                $modifications = true;
            }

            // Vérifier si les sauces ont changé
            $saucesActuelles = array_column(PlatModel::obtenirSaucesPlat((int)$id), 'id');
            if (array_diff($sauces, $saucesActuelles) !== array_diff($saucesActuelles, $sauces)) {
                PlatModel::mettreAJourSauces((int) $id, $sauces);
                $modifications = true;
            }

            if ($modifications) {
                $success = true;
                $plat = PlatModel::obtenirPlat((int) $id);
                header("Location: ?ctrl=Compte");
            } else {
                $error = "Aucune modification n'a été effectuée.";
            }
        }

        $ingredients = PlatModel::listerIngredients();
        $ingredientsPlat = PlatModel::obtenirIngredientsPlat((int)$id);
        $sauces = PlatModel::listerSauces();
        $saucesPlat = PlatModel::obtenirSaucesPlat((int)$id);
        
        Vue::montrer('gestion/modifier', [
            'plat' => $plat, 
            'ingredients' => $ingredients, 
            'ingredientsPlat' => $ingredientsPlat,
            'sauces' => $sauces,
            'saucesPlat' => $saucesPlat,
            'onPlat' => true,
            'error' => $error,
            'success' => $success
        ]);
    }

    public function supprimerAction()
    {
        $this->checkAuth();
        $id = $_GET['id'] ?? null;
        $validation = $_GET['validation'] ?? null;
        if ((bool) $validation === true) {
            PlatModel::supprimerPlat((int) $id);
            header("Location: ?ctrl=Compte");
        }

        Vue::montrer('gestion/supprimer',['id' => $id, 'onPlat' => true]);
    }

    public function listerAction()
    {
        $this->checkAuth();

        $plats = PlatModel::listerPlats();
        Vue::montrer('gestion/lister', ['plats' => $plats, 'onPlat' => true]);
    }
}
?>