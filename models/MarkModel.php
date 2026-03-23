<?php

class MarkModel
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getAll()
    {
        $stmt = $this->pdo->query("SELECT marks.id, subjects.name AS subject_name, marks.mark, students.name AS student_name, marks.date FROM marks LEFT JOIN subjects ON marks.subject_id = subjects.id LEFT JOIN students ON marks.student_id = students.id ORDER BY marks.id DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getSubjects()
    {
        $stmt = $this->pdo->query("SELECT id, name FROM subjects ORDER BY name");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getStudents()
    {
        $stmt = $this->pdo->query("SELECT id, name FROM students ORDER BY name");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM marks WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($subject_id,$mark,$student_id,$date)
    {
        $stmt = $this->pdo->prepare("INSERT INTO marks (subject_id, mark, student_id, date)
        VALUES (:subject_id, :mark, :student_id, :date)");
        $stmt->execute([
            'subject_id'  => $subject_id,
            'mark' => $mark,
            'student_id'   => $student_id,
            'date' => $date
        ]);
    }

    public function update($id,$subject_id, $mark, $student_id, $date)
    {
        $stmt = $this->pdo->prepare("UPDATE marks SET subject_id = :subject_id, mark = :mark, student_id = :student_id, date = :date WHERE id = :id");
        $stmt->execute([
            'subject_id'  => $subject_id,
            'mark' => $mark,
            'student_id'   => $student_id,
            'date' => $date,
            'id'     => $id
        ]);
    }

    public function delete($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM marks WHERE id = :id");
        $stmt->execute(['id' => $id]);
    }
}
