<?php

class UserModel
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function create($username, $email, $password)
    {
        $stmt = $this->pdo->prepare("
            INSERT INTO users(username,email,password)
            VALUES(:username,:email,:password)
        ");

        $stmt->execute([
            'username' => $username,
            'email' => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT)
        ]);
    }

    public function findByEmail($email)
    {
        $stmt = $this->pdo->prepare("
            SELECT * FROM users
            WHERE email = :email
        ");

        $stmt->execute([
            'email' => $email
        ]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function find($id)
    {
        $stmt = $this->pdo->prepare("
            SELECT * FROM users
            WHERE id=:id
        ");

        $stmt->execute([
            'id'=>$id
        ]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($id, $username, $password = null)
    {
        if ($password) {

            $stmt = $this->pdo->prepare("
                UPDATE users
                SET username=:username,
                    password=:password
                WHERE id=:id
            ");

            $stmt->execute([
                'username'=>$username,
                'password'=>password_hash($password,PASSWORD_DEFAULT),
                'id'=>$id
            ]);

        } else {

            $stmt = $this->pdo->prepare("
                UPDATE users
                SET username=:username
                WHERE id=:id
            ");

            $stmt->execute([
                'username'=>$username,
                'id'=>$id
            ]);
        }
    }
}