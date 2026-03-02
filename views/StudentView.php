<?php

class StudentView
{
    public static function list($subjects)
    {
        echo <<<HTML
            <h1>Tantárgyak</h1>

            <p><a href="index.php?view=add-subject">Új diák hozzáadása</a></p>

            <table border="1" cellpadding="5">
                <tr>
                    <th>ID</th>
                    <th>Név</th>
                    <th>Osztály</th>
                    <th>Születési dátum</th>
                    <th>Műveletek</th>
                </tr>
        HTML;

        foreach ($subjects as $s) {
            $id = $s['id'];
            $name = htmlspecialchars($s['name'], ENT_QUOTES, 'UTF-8');

            echo <<<HTML
                <tr>
                    <td>{$id}</td>
                    <td>{$name}</td>
                    <td>{$class_id}</td>
                    <td>{$birth_date}</td>
                    <td>
                        <a href="index.php?view=edit-student&id={$id}">Módosítás</a> |
                        <a href="index.php?view=students&delete={$id}"
                           onclick="return confirm('Biztos törlöd?')">Törlés</a>
                    </td>
                </tr>
            HTML;
        }

        echo "</table>";
    }

    public static function addForm()
    {
        echo <<<HTML
            <h1>Új diák hozzáadása</h1>

            <form method="post" action="index.php?view=students">
                <label>Diák neve:</label><br>
                <input type="text" name="name"><br><br>
                <label>Diák osztály:</label><br>
                <input type="text" name="class_id"><br><br>
                <label>Diák születési dátuma:</label><br>
                <input type="text" name="birth_date"><br><br>

                <button type="submit" name="add-student">Hozzáadás</button>
                <a href="index.php?view=students">Mégse</a>
            </form>
        HTML;
    }

    public static function editForm($subject)
    {
        $id = $subject['id'];
        $name = htmlspecialchars($subject['name'], ENT_QUOTES, 'UTF-8');
        $name = htmlspecialchars($subject['class_id'], ENT_QUOTES, 'UTF-8');
        $name = htmlspecialchars($subject['birth_date'], ENT_QUOTES, 'UTF-8');

        echo <<<HTML
            <h1>Tantárgy módosítása</h1>

            <form method="post" action="index.php?view=students">
                <input type="hidden" name="id" value="{$id}">

                <label>Új név:</label><br>
                <input type="text" name="name" value="{$name}"><br><br>

                <button type="submit" name="update-student">Mentés</button>
                <a href="index.php?view=students">Mégse</a>
            </form>
        HTML;
    }
}
