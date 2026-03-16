<?php
require_once "models/MarkModel.php";
require_once "views/MarkView.php";

class MarkController
{
    private MarkModel $model;

    public function __construct(PDO $pdo)
    {
        $this->model = new MarkModel($pdo);
    }

    public function handleRequest(string $view)
    {
        // --- POST műveletek ---
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            if (isset($_POST['add-mark'])) {
                $this->model->create($_POST['subject_id'],
                                    $_POST['mark'],
                                    $_POST['student_id'],
                                    $_POST['date']);
                header("Location: index.php?view=marks");
                exit;
            }

            if (isset($_POST['update-mark'])) {
                $this->model->update(
                    $_POST['id'], 
                    $_POST['subject_id'],
                    $_POST['mark'],
                    $_POST['student_id'],
                    $_POST['date']);
                header("Location: index.php?view=marks");
                exit;
            }
        }

        // --- GET törlés ---
        if (isset($_GET['delete'])) {
            $this->model->delete($_GET['delete']);
            header("Location: index.php?view=marks");
            exit;
        }

        // --- Nézetek ---
        switch ($view) {

            case 'marks':
                $marks = $this->model->getAll();
                MarkView::list($marks);
                break;

                case 'add-mark':
                    $subjects = $this->model->getSubjects();
                    $students = $this->model->getStudents();
                    MarkView::addForm($subjects, $students);
                    break;
                
                case 'edit-mark':
                    $mark = $this->model->find($_GET['id']);
                    $subjects = $this->model->getSubjects();
                    $students = $this->model->getStudents();
                    MarkView::editForm($mark, $subjects, $students);
                    break;
        }
    }
}
