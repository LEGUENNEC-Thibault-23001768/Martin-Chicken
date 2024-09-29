<?php

final class RepasController 
{
    private $repasModel;

    public function __construct()
    {
        $this->repasModel = new RepasModel();
    }

    public function defaultAction()
    {
        $repas = $this->repasModel->findAll();
        Vue::montrer('repas', ['repas' => $repas]);
    }

    public function addAction()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'titre' => $_POST['titre'],
                'date' => $_POST['date'],
                'description' => $_POST['description']
            ];

            $this->repasModel->insert($data);
            header('Location: index.php?ctrl=repas');
            exit();
        } else {
            Vue::montrer('formulaires/repas_add');
        }
    }

    public function editAction()
    {
        $id = $_GET['id'] ?? null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $id) {
            $data = [
                'titre' => $_POST['titre'],
                'date' => $_POST['date'],
                'description' => $_POST['description']
            ];

            $this->repasModel->update($id, $data);
            header('Location: index.php?ctrl=repas');
            exit();
        } else {
            $repas = $this->repasModel->findById($id);
            Vue::montrer('formulaires/repas_edit', ['repas' => $repas]);
        }
    }

    public function deleteAction()
    {
        $id = $_GET['id'] ?? null;

        if ($id) {
            $this->repasModel->delete($id);
            header('Location: index.php?ctrl=repas');
            exit();
        } else {
            $this->defaultAction();
        }
    }
}
?>
