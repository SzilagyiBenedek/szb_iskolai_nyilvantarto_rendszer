<?php
require_once "models/StudentModel.php";
require_once "views/StudentView.php";

class StudentController
{
    private StudentModel $model;
    private PDO $pdo; 

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
        $this->model = new StudentModel($pdo);
    }

    public function handleRequest(string $view)
    {
        // --- POST műveletek ---
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            if (isset($_POST['add-student'])) {
                $this->model->create(
                $_POST['name'],
                $_POST['birthdate'],
                $_POST['class_id']);
                header("Location: index.php?view=students");
                exit;
            }

            if (isset($_POST['update-student'])) {
                $this->model->update(
                $_POST['id'], 
                $_POST['name'],
                $_POST['birthdate'],
                $_POST['class_id']);
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

            case 'students':
                $students = $this->model->getAll();
                StudentView::list($students);
                break;

            case 'add-student':
                require_once "models/ClassModel.php";
                $classModel = new ClassModel($this->pdo);
                $classes = $classModel->getAll();
                StudentView::addForm($classes);
                break;

            case 'edit-student':
                $student = $this->model->find($_GET['id']);
            
                require_once "models/ClassModel.php";
                $classModel = new ClassModel($this->pdo);
                $classes = $classModel->getAll();                
                StudentView::editForm($student, $classes);
                break;
        }
    }
}
