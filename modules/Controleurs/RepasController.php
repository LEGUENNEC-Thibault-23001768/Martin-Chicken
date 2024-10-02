<?php 
final class RepasController
{
    public static string $titre = "Gestion des Repas";

    private function checkAuth()
    {
        if (!AuthModel::isLoggedIn()) {
            header("HTTP/1.1 401 Unauthorized");
            header("Location: ?ctrl=Compte");
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
            $date = $_POST['date'] ?? '';
            $adresse = $_POST['adresse'] ?? '';
            $plats = $_POST['plats'] ?? [];

            if ($nom && $date && $adresse) {
                $repasId = RepasModel::ajouterRepas($nom, $date, $adresse);

                if ($repasId) {
                    if (!empty($plats)) {
                        RepasModel::associerPlats($repasId, $plats);
                    }

                    header("Location: ?ctrl=Compte");
                    exit();
                } else {
                    $error = 'Erreur lors de l\'ajout du repas.';
                }
            } else {
                $error = 'Veuillez remplir tous les champs obligatoires.';
            }
        }

        $plats = PlatModel::listerPlats();
        Vue::montrer('gestion/ajouter', [
            'onRepas' => true, 
            'plats' => $plats,
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

        $repas = RepasModel::obtenirRepas((int) $id);
        if (!$repas) {
            header("Location: ?ctrl=Compte");
            exit();
        }

        $error = null;
        $success = false;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nom = trim($_POST['nom'] ?? '');
            $date = $_POST['date'] ?? '';
            $adresse = trim($_POST['adresse'] ?? '');
            $plats = $_POST['plats'] ?? [];


            $modifications = false;

            if ($nom !== '' && $date !== '' && $adresse !== '') {
                if ($nom !== $repas['nom'] || $date !== $repas['date'] || $adresse !== $repas['adresse']) {
                    RepasModel::modifierRepas((int) $id, $nom, $date, $adresse);
                    $modifications = true;
                }

                $platsActuels = array_column(RepasModel::obtenirPlatsRepas((int)$id), 'id');
                if (array_diff($plats, $platsActuels) !== array_diff($platsActuels, $plats)) {
                    RepasModel::mettreAJourPlats((int) $id, $plats);
                    $modifications = true;
                }

                if ($modifications) {
                    $success = true;
                    $repas = RepasModel::obtenirRepas((int) $id);
                    header("Location: ?ctrl=Compte");
                } else {
                    $error = "Aucune modification n'a été effectuée.";
                }
            } else {
                $error = "Veuillez remplir tous les champs obligatoires.";
            }
        }

        $plats = PlatModel::listerPlats();
        $platsRepas = RepasModel::obtenirPlatsRepas((int)$id);

        $platsFormates = array_map(function($plat) {
            return [
                'id' => $plat['id'],
                'nom' => $plat['nom'],
                'ingredients' => implode(', ', $plat['ingredients'])
            ];
        }, $platsRepas);

        error_log(print_r($platsFormates,true));

        Vue::montrer('gestion/modifier', [
            'repas' => $repas, 
            'plats' => $plats,
            'platsRepas' => $platsFormates,
            'onRepas' => true,
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
            RepasModel::supprimerRepas((int) $id);
            header("Location: ?ctrl=Compte");
        }

        Vue::montrer('gestion/supprimer',['id' => $id, 'onRepas' => true]);
    }

    public function listerAction()
    {
        $this->checkAuth();

        $repas = RepasModel::listerRepasAvecPlats();
        Vue::montrer('gestion/lister', ['repas' => $repas, 'onRepas' => true]);
    }

    public function rechercherAction()
    {
        $this->checkAuth();

        $terme = $_GET['terme'] ?? '';
        if ($terme) {
            $resultats = RepasModel::rechercherRepas($terme);
            Vue::montrer('gestion/rechercher', ['resultats' => $resultats, 'terme' => $terme, 'onRepas' => true]);
        } else {
            header("Location: ?ctrl=Compte");
            exit();
        }
    }
}
?>