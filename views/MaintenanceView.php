<?php

class MaintenanceView
{
    public static function menu()
    {
        echo <<<HTML
            <h1>Karbantartás</h1>
            <ul>
                <li><a href="index.php?view=generate-data">Teszt adatok generálása</a></li>
                <li><a href="index.php?view=classes">Osztályok kezelése</a></li>
                <li><a href="index.php?view=students">Diákok kezelése</a></li>
                <li><a href="index.php?view=subjects">Tantárgyak kezelése</a></li>
                <li><a href="index.php?view=marks">Jegyek kezelése</a></li>
            </ul>
        HTML;
    }

    public static function generated()
    {
        echo <<<HTML
            <h1>Adatok generálva</h1>

            <p>A teszt adatok sikeresen létrejöttek.</p>

            <p><a href="index.php?view=maintenance">Vissza a karbantartáshoz</a></p>
        HTML;
    }
}