<?php
require_once "models/ListModel.php";
require_once "views/ListView.php";

class ListController
{
    private ListModel $model;

    public function __construct(PDO $pdo)
    {
        $this->model = new ListModel($pdo);
    }

    public function handleRequest(): void
    {
        $subview = $_GET['subview'] ?? 'select';

        switch ($subview) {

            case 'select':
            default:
                $years = $this->model->getYears();
                $selectedYear = isset($_GET['year']) ? (int)$_GET['year'] : null;
                $classes = $selectedYear ? $this->model->getClassesByYear($selectedYear) : [];
                ListView::selectForm($years, $selectedYear, $classes);
                break;

            case 'class':
                $classId = (int)($_GET['class_id'] ?? 0);
                $classInfo = $this->model->getClassName($classId);
                if (!$classInfo) {
                    echo "<p>Nem található az osztály.</p>";
                    break;
                }
                $students        = $this->model->getStudentsByClass($classId);
                $classAvg        = $this->model->getClassAverage($classId);
                $subjectAverages = $this->model->getClassSubjectAverages($classId);
                ListView::classList($classInfo, $students, $classAvg, $subjectAverages);
                break;

            case 'student':
                $studentId = (int)($_GET['student_id'] ?? 0);
                $student   = $this->model->getStudent($studentId);
                $studentAvg      = $this->model->getStudentAverage($studentId);
                $subjectAverages = $this->model->getStudentSubjectAverages($studentId);
                ListView::studentDetail($student, $studentAvg, $subjectAverages);
                break;
        }
    }
}
