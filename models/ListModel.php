<?php

class ListModel
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getYears(): array
    {
        $stmt = $this->pdo->query("SELECT DISTINCT year FROM classes ORDER BY year DESC");
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    public function getClassesByYear(int $year): array
    {
        $stmt = $this->pdo->prepare(
            "SELECT id, grade, letter FROM classes WHERE year = ? ORDER BY grade, letter"
        );
        $stmt->execute([$year]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getClassName(int $classId): ?array
    {
        $stmt = $this->pdo->prepare(
            "SELECT id, grade, letter, year FROM classes WHERE id = ?"
        );
        $stmt->execute([$classId]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    public function getStudentsByClass(int $classId): array
    {
        $stmt = $this->pdo->prepare(
            "SELECT id, name, birthdate FROM students WHERE class_id = ? ORDER BY name"
        );
        $stmt->execute([$classId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getClassAverage(int $classId): ?float
    {
        $stmt = $this->pdo->prepare("SELECT AVG(m.mark) AS avg
            FROM marks m
            JOIN students s ON m.student_id = s.id
            WHERE s.class_id = ?
        ");
        $stmt->execute([$classId]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['avg'] !== null ? round((float)$row['avg'], 2) : null;
    }

    public function getClassSubjectAverages(int $classId): array
    {
        $stmt = $this->pdo->prepare("SELECT sub.name AS subject_name, AVG(m.mark) AS avg
            FROM marks m
            JOIN students s ON m.student_id = s.id
            JOIN subjects sub ON m.subject_id = sub.id
            WHERE s.class_id = ?
            GROUP BY sub.id, sub.name
            ORDER BY sub.name
        ");
        $stmt->execute([$classId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getStudentAverage(int $studentId): ?float
    {
        $stmt = $this->pdo->prepare("
            SELECT AVG(mark) AS avg FROM marks WHERE student_id = ?
        ");
        $stmt->execute([$studentId]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['avg'] !== null ? round((float)$row['avg'], 2) : null;
    }

    public function getStudentSubjectAverages(int $studentId): array
    {
        $stmt = $this->pdo->prepare("SELECT sub.name AS subject_name, AVG(m.mark) AS avg
            FROM marks m
            JOIN subjects sub ON m.subject_id = sub.id
            WHERE m.student_id = ?
            GROUP BY sub.id, sub.name
            ORDER BY sub.name
        ");
        $stmt->execute([$studentId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getStudent(int $studentId): ?array
    {
        $stmt = $this->pdo->prepare("SELECT s.id, s.name, s.birthdate,
                   CONCAT(c.grade, c.letter) AS class_name,
                   c.id AS class_id, c.year
            FROM students s
            JOIN classes c ON s.class_id = c.id
            WHERE s.id = ?
        ");
        $stmt->execute([$studentId]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }
}
