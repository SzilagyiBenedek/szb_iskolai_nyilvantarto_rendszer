<?php

class UserView
{
    public static function registerForm()
    {
        echo '
        <h1>Regisztráció</h1>

        <form method="post">

            <label>Név:</label><br>
            <input type="text" name="username"><br><br>

            <label>Email:</label><br>
            <input type="email" name="email"><br><br>

            <label>Jelszó:</label><br>
            <input type="password" name="password"><br><br>

            <button name="register">
                Regisztráció
            </button>

        </form>';
    }

    public static function loginForm($error = "")
    {
        echo "<h1>Bejelentkezés</h1>";

        if ($error) {
            echo "<p style='color:red'>$error</p>";
        }

        echo '
        <form method="post">

            <label>Email:</label><br>
            <input type="email" name="email"><br><br>

            <label>Jelszó:</label><br>
            <input type="password" name="password"><br><br>

            <button name="login">
                Bejelentkezés
            </button>

        </form>';
    }

    public static function profileForm($user)
    {
        $name = htmlspecialchars($user['username']);

        echo "
        <h1>Profil</h1>

        <form method='post'>

            <label>Név:</label><br>
            <input
                type='text'
                name='username'
                value='{$name}'
            ><br><br>

            <label>Új jelszó:</label><br>
            <input
                type='password'
                name='password'
            ><br><br>

            <button name='update-profile'>
                Mentés
            </button>

            <a href='index.php?view=logout'>
                Kilépés
            </a>

        </form>
        ";
    }
}