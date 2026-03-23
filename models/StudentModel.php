<?php

class StudentModel
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    // Lekérdezi az összes tanulót az osztály nevével
    public function getAll()
    {
        $stmt = $this->pdo->query("SELECT students.id, students.name, students.birthdate, CONCAT(classes.grade, classes.letter) AS class_name FROM students LEFT JOIN classes ON students.class_id = classes.id
            ORDER BY students.id DESC
        ");

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getClasses()
    {
        $stmt = $this->pdo->query("SELECT id, grade, letter FROM classes ORDER BY grade, letter");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // Egy tanuló lekérdezése ID alapján
    public function find($id)
    {
        $stmt = $this->pdo->prepare("SELECT students.id, name, birthdate, class_id, CONCAT(classes.grade, classes.letter) AS class_name FROM students
            LEFT JOIN classes ON students.class_id = classes.id
            WHERE students.id = :id
        ");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Új tanuló létrehozása
    public function create($name, $birthdate, $class_id)
    {
        $stmt = $this->pdo->prepare("INSERT INTO students (name, birthdate, class_id) VALUES (:name, :birthdate, :class_id)");
        $stmt->execute([
            'name'       => $name,
            'birthdate' => $birthdate,
            'class_id'   => $class_id
        ]);
    }

    // Tanuló adatainak frissítése
    public function update($id, $name, $birthdate, $class_id)
    {
        $stmt = $this->pdo->prepare("UPDATE students SET name = :name, birthdate = :birthdate, class_id = :class_id WHERE id = :id");
        $stmt->execute([
            'name'       => $name,
            'birthdate' => $birthdate,
            'class_id'   => $class_id,
            'id'         => $id
        ]);
    }

    // Tanuló törlése
    public function delete($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM students WHERE id = :id");
        $stmt->execute(['id' => $id]);
    }
}