<?php

class LayoutView
{
    public static function head($title = "Iskolai nyilvántartó rendszer")
    {
        echo <<<HTML
        <!DOCTYPE html>
        <html lang="hu">
        <head>
            <meta charset="UTF-8">
            <title>{$title}</title>
        </head>
        <body>
        HTML;
    }

    public static function menu()
{
    echo <<<HTML
    <nav>
        <a href="index.php?view=home">Kezdőlap</a> |
        <a href="index.php?view=subjects">Tantárgyak</a> |
        <a href="index.php?view=classes">Osztályok</a> |
        <a href="index.php?view=students">Diákok</a> |
        <a href="index.php?view=marks">Jegyek</a> ||
        <a href="index.php?view=maintenance">Karbantartás</a> |
        <a href="index.php?view=lists">Lista</a>
    HTML;

    if (isset($_SESSION['user'])) {

        $name = htmlspecialchars(
            $_SESSION['user']['username'],
            ENT_QUOTES,
            'UTF-8'
        );

        echo " | <a href='index.php?view=profile'>{$name}</a>";

    } else {

        echo "
            | <a href='index.php?view=register'>Regisztráció</a>
            | <a href='index.php?view=login'>Bejelentkezés</a>
        ";
    }

    echo <<<HTML
    </nav>
    <hr>
    HTML;
}

    public static function footer()
    {
        echo <<<HTML
    <hr>
    <footer>
    <p>Készítette: Szilágyi Benedek | v7 verzió | &copy; 2026</p>
    </footer>
    </body>
    </html>
    HTML;
    }
}