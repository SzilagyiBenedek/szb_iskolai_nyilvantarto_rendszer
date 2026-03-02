<?php
require_once "models/StudentModel.php";
require_once "views/StudentView.php";

class StudentController
{
    private StudentModel $model;

    public function __construct(PDO $pdo)
    {
        $this->model = new StudentModel($pdo);
    }

    public function handleRequest(string $view)
    {
        // --- POST műveletek ---
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            if (isset($_POST['add-student'])) {
                $this->model->create($_POST['name']);
                header("Location: index.php?view=students");
                exit;
            }

            if (isset($_POST['update-student'])) {
                $this->model->update($_POST['id'], $_POST['name']);
                header("Location: index.php?view=students");
                exit;
            }
        }

        // --- GET törlés ---
        if (isset($_GET['delete'])) {
            $this->model->delete($_GET['delete']);
            header("Location: index.php?view=students");
            exit;
        }

        // --- Nézetek ---
        switch ($view) {

            case 'student':
                $subjects = $this->model->getAll();
                SubjectView::list($subjects);
                break;

            case 'add-student':
                SubjectView::addForm();
                break;

            case 'edit-student':
                $subject = $this->model->find($_GET['id']);
                SubjectView::editForm($subject);
                break;
        }
    }
}