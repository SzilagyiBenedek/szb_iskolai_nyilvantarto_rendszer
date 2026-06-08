<?php

require_once "models/UserModel.php";
require_once "views/UserView.php";

class UserController
{
    private UserModel $model;

    public function __construct(PDO $pdo)
    {
        $this->model = new UserModel($pdo);
    }

    public function handleRequest(string $view)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            if (isset($_POST['register'])) {

                $this->model->create(
                    $_POST['username'],
                    $_POST['email'],
                    $_POST['password']
                );

                header("Location: index.php?view=login");
                exit;
            }

            if (isset($_POST['login'])) {

                $user = $this->model->findByEmail($_POST['email']);

                if (
                    $user &&
                    password_verify($_POST['password'], $user['password'])
                ) {

                    $_SESSION['user'] = [
                        'id'=>$user['id'],
                        'username'=>$user['username']
                    ];

                    header("Location: index.php");
                    exit;
                }

                UserView::loginForm("Hibás email vagy jelszó!");
                return;
            }

            if (isset($_POST['update-profile'])) {

                $password = trim($_POST['password']);

                $this->model->update(
                    $_SESSION['user']['id'],
                    $_POST['username'],
                    $password ?: null
                );

                $_SESSION['user']['username'] = $_POST['username'];

                header("Location: index.php");
                exit;
            }
        }

        switch ($view) {

            case 'register':
                UserView::registerForm();
                break;

            case 'login':
                UserView::loginForm();
                break;

            case 'logout':
                session_destroy();

                header("Location: index.php");
                exit;

            case 'profile':

                if (!isset($_SESSION['user'])) {
                    header("Location: index.php?view=login");
                    exit;
                }

                $user = $this->model->find(
                    $_SESSION['user']['id']
                );

                UserView::profileForm($user);
                break;
        }
    }
}