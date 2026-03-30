<?php

require_once "config.php";

class Install {

    private $pdo;

    public function __construct()
    {
        $this->pdo = new PDO(
            "mysql:host=".DB_HOST.";dbname=".DB_NAME,DB_USERNAME,DB_PASSWORD
        );
    }

    public function generate()
    {
        $this->pdo->exec("SET FOREIGN_KEY_CHECKS=0");

        $this->pdo->exec("TRUNCATE TABLE marks");
        $this->pdo->exec("TRUNCATE TABLE students");
        $this->pdo->exec("TRUNCATE TABLE subjects");
        $this->pdo->exec("TRUNCATE TABLE classes");

        $this->pdo->exec("SET FOREIGN_KEY_CHECKS=1");

        $this->generateSubjects();
        $this->generateClasses();
        $this->generateStudents();
        $this->generateMarks();

    }

    private function generateSubjects()
    {
        foreach(SUBJECTS as $subject){

            $stmt = $this->pdo->prepare(
                "INSERT INTO subjects(name) VALUES (?)"
            );

            $stmt->execute([$subject]);
        }
    }

    private function generateClasses()
{
    foreach(CLASSES as $fullClass){

        preg_match('/(\d+)([A-Z])/', $fullClass, $matches);

        $grade = (int)$matches[1];
        $letter = $matches[2];
        $year = date("Y");

        $stmt = $this->pdo->prepare(
            "INSERT INTO classes(grade, letter, year) VALUES (?,?,?)"
        );

        $stmt->execute([$grade, $letter, $year]);
    }
}

    private function generateStudents()
    {
        $classes = $this->pdo->query("SELECT id FROM classes")->fetchAll(PDO::FETCH_COLUMN);

        foreach($classes as $classId){

            $studentCount = rand(MIN_CLASS_COUNT, MAX_CLASS_COUNT);

            for($i=0; $i<$studentCount; $i++){

                $lastname = NAMES['lastnames'][array_rand(NAMES['lastnames'])];

                if(rand(0,1)){
                    $firstname = NAMES['firstnames']['men'][array_rand(NAMES['firstnames']['men'])];
                } else {
                    $firstname = NAMES['firstnames']['women'][array_rand(NAMES['firstnames']['women'])];
                }   
                $name = $lastname . " " . $firstname;

                $year = rand(date("Y")-18, date("Y")-14);
                $month = rand(1,12);
                $day = rand(1,31);
                $birthdate = sprintf("%04d-%02d-%02d", $year, $month, $day);

                $stmt = $this->pdo->prepare(
                    "INSERT INTO students(name, birthdate, class_id) VALUES (?,?,?)"
                );

                $stmt->execute([$name, $birthdate, $classId]);
            }
        }
    }

    private function generateMarks()
    {
    
        $students = $this->pdo->query("SELECT id FROM students")->fetchAll(PDO::FETCH_COLUMN);
        $subjects = $this->pdo->query("SELECT id FROM subjects")->fetchAll(PDO::FETCH_COLUMN);
    
        foreach($students as $studentId){
    
            foreach($subjects as $subjectId){
    
                $marksCount = rand(3,4);
    
                for($i=0; $i<$marksCount; $i++){
    
                    $mark = rand(1,5);
                    $year = rand(date("Y")-2, date("Y"));
                    $month = rand(1,12);
                    $day = rand(1,28);
                    $date = sprintf("%04d-%02d-%02d", $year, $month, $day);
    
                    $stmt = $this->pdo->prepare(
                        "INSERT INTO marks(student_id, subject_id, mark, date) VALUES (?,?,?,?)"
                    );
    
                    $stmt->execute([$studentId, $subjectId, $mark, $date]);
                }
            }
        }
    }
}