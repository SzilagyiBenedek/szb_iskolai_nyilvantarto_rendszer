<?php

class StudentView
{
    public static function list($students)
    {
        echo <<<HTML
            <h1>Tantárgyak</h1>

            <p><a href="index.php?view=add-student">Új diák hozzáadása</a></p>

            <table border="1" cellpadding="5">
                <tr>
                    <th>ID</th>
                    <th>Név</th>
                    <th>Szül</th>
                    <th>Osztály</th>
                    <th>Műveletek</th>
                </tr>
        HTML;

        foreach ($students as $s) {
            $id = $s['id'];
            $name = htmlspecialchars($s['name'], ENT_QUOTES, 'UTF-8');
            $birthdate = htmlspecialchars($s['birthdate'], ENT_QUOTES, 'UTF-8');
            $class_name = htmlspecialchars($s['class_name'], ENT_QUOTES, 'UTF-8');
            echo <<<HTML
                <tr>
                    <td>{$id}</td>
                    <td>{$name}</td>
                    <td>{$birthdate}</td>
                    <td>{$class_name}</td>
                    <td>
                        <a href="index.php?view=edit-students&id={$id}">Módosítás</a> |
                        <a href="index.php?view=students&delete={$id}"
                           onclick="return confirm('Biztos törlöd?')">Törlés</a>
                    </td>
                </tr>
            HTML;
        }

        echo "</table>";
    }

    public static function addForm(array $classes)
{
    echo <<<HTML
        <h1>Új tanuló hozzáadása</h1>
        <form method="post" action="index.php?view=students">
            <label>Tanuló neve:</label><br>
            <input type="text" name="name" required><br><br>

            <label>Születési dátum:</label><br>
            <input type="date" name="birthdate" required><br><br>

            <label>Osztály:</label><br>
            <select name="class_id" required>
                <option value="">-- Válassz osztályt --</option>
HTML;

    foreach ($classes as $class) {
        $id = htmlspecialchars($class['id']);
        $text = htmlspecialchars($class['year'] . ' ' . $class['grade'] . $class['letter']); // pl. 2012 12C
        echo "<option value=\"{$id}\">{$text}</option>";
    }

    echo <<<HTML
            </select><br><br>
            <button type="submit" name="add-student">Hozzáadás</button>
            <a href="index.php?view=students">Mégse</a>
        </form>
HTML;
}

public static function editForm(array $student, array $classes)
{
    $id = $student['id'];
    $name = htmlspecialchars($student['name']);
    $birthdate = $student['birthdate'];
    $class_id = $student['class_id'];

    echo <<<HTML
        <h1>Tanuló módosítása</h1>
        <form method="post" action="index.php?view=students">
            <input type="hidden" name="id" value="{$id}">

            <label>Tanuló neve:</label><br>
            <input type="text" name="name" value="{$name}" required><br><br>

            <label>Születési dátum:</label><br>
            <input type="date" name="birthdate" value="{$birthdate}" required><br><br>

            <label>Osztály:</label><br>
            <select name="class_id" required>
                <option value="">-- Válassz osztályt --</option>
HTML;

    foreach ($classes as $class) {
        $cid = htmlspecialchars($class['id']);
        $text = htmlspecialchars($class['year'] . ' ' . $class['grade'] . $class['letter']); // pl. 2012 12C
        $selected = ($cid == $class_id) ? 'selected' : '';
        echo "<option value=\"{$cid}\" {$selected}>{$text}</option>";
    }

    echo <<<HTML
            </select><br><br>
            <button type="submit" name="update-student">Mentés</button>
            <a href="index.php?view=students">Mégse</a>
        </form>
HTML;
}
}
