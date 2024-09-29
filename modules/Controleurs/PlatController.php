<?php

final class PlatController 
{
    private $platModel;

    public function __construct()
    {
        $this->platModel = new PlatModel(); 
    }

    public function defaultAction()
    {
        $plats = $this->platModel->findAll();
        Vue::montrer('plat', ['plats' => $plats]);
    }

    public function addAction()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'nom' => $_POST['nom'],
                'ingredients' => $_POST['ingredients'],
                'sauces' => $_POST['sauces'],
                'description' => $_POST['description']
            ];

            $this->platModel->insert($data);
            header('Location: index.php?ctrl=plat');
            exit();
        } else {
            Vue::montrer('formulaires/plat_add');
        }
    }

    public function editAction()
    {
        $id = $_GET['id'] ?? null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $id) {
            $data = [
                'nom' => $_POST['nom'],
                'ingredients' => $_POST['ingredients'],
                'sauces' => $_POST['sauces'],
                'description' => $_POST['description']
            ];

            $this->platModel->update($id, $data);
            header('Location: index.php?ctrl=plat');
            exit();
        } else {
            $plat = $this->platModel->findById($id);
            Vue::montrer('formulaires/plat_edit', ['plat' => $plat]);
        }
    }

    public function deleteAction()
    {
        $id = $_GET['id'] ?? null;

        if ($id) {
            $this->platModel->delete($id);
            header('Location: index.php?ctrl=plat');
            exit();
        } else {
            $this->defaultAction();
        }
    }
}
?>
