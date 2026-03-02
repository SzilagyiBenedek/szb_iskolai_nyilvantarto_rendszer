<?php

class ClassModel
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getAll()
    {
        return $this->pdo
            ->query("SELECT * FROM classes ORDER BY year DESC, grade ASC, letter ASC")
            ->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM classes WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($year, $grade, $letter)
    {
        $stmt = $this->pdo->prepare(
            "INSERT INTO classes (year, grade, letter) VALUES (:year, :grade, :letter)"
        );
        $stmt->execute([
            'year' => $year,
            'grade' => $grade,
            'letter' => $letter
        ]);
    }

    public function update($id, $year, $grade, $letter)
    {
        $stmt = $this->pdo->prepare("UPDATE classes SET year = :year, grade = :grade, letter = :letter WHERE id = :id");
        $stmt->execute([
            'id' => $id,
            'year' => $year,
            'grade' => $grade,
            'letter' => $letter
        ]);
    }

    public function delete($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM classes WHERE id = :id");
        $stmt->execute(['id' => $id]);
    }
}