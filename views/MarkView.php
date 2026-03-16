<?php

class MarkView
{
    public static function list($marks)
    {
        echo <<<HTML
            <h1>Jegyek</h1>

            <p><a href="index.php?view=add-mark">Új jegy hozzáadása</a></p>

            <table border="1" cellpadding="5">
                <tr>
                    <th>ID</th>
                    <th>Tantárgy</th>
                    <th>Jegy</th>
                    <th>Tanuló</th>
                    <th>Dátum</th>
                    <th>Műveletek</th>
                </tr>
        HTML;

        foreach ($marks as $mark) {
            $id = $mark['id'];
            $subject_name = htmlspecialchars($mark['subject_name']);
            $mark_value = htmlspecialchars($mark['mark']);
            $student_name = htmlspecialchars($mark['student_name']);
            $date = htmlspecialchars($mark['date']);
        
            echo <<<HTML
                <tr>
                    <td>{$id}</td>
                    <td>{$subject_name}</td>
                    <td>{$mark_value}</td>
                    <td>{$student_name}</td>
                    <td>{$date}</td>
                    <td>
                        <a href="index.php?view=edit-mark&id={$id}">Módosítás</a> |
                        <a href="index.php?view=marks&delete={$id}"
                           onclick="return confirm('Biztos törlöd?')">Törlés</a>
                    </td>
                </tr>
            HTML;
        }

        echo "</table>";
    }

    public static function addForm(array $subjects, array $students)
{
    echo <<<HTML
        <h1>Új jegy hozzáadása</h1>

        <form method="post" action="index.php?view=marks">
            <label>Tantárgy:</label><br>
            <select name="subject_id" required>
                <option value="">-- Válassz tantárgyat --</option>
    HTML;

    foreach ($subjects as $subject) {
        $id = htmlspecialchars($subject['id']);
        $name = htmlspecialchars($subject['name']);
        echo "<option value=\"{$id}\">{$name}</option>";
    }

    echo <<<HTML
            </select><br><br>

            <label>Jegy:</label><br>
            <input type="number" name="mark" min="1" max="5" required><br><br>

            <label>Tanuló:</label><br>
            <select name="student_id" required>
                <option value="">-- Válassz tanulót --</option>
    HTML;

    foreach ($students as $student) {
        $id = htmlspecialchars($student['id']);
        $name = htmlspecialchars($student['name']);
        echo "<option value=\"{$id}\">{$name}</option>";
    }

    echo <<<HTML
            </select><br><br>

            <label>Dátum:</label><br>
            <input type="date" name="date" required><br><br>

            <button type="submit" name="add-mark">Hozzáadás</button>
            <a href="index.php?view=marks">Mégse</a>
        </form>
    HTML;
}

public static function editForm(array $mark, array $subjects, array $students)
{
    $id = $mark['id'];
    $subject_id = $mark['subject_id'];
    $mark_value = $mark['mark'];
    $student_id = $mark['student_id'];
    $date = $mark['date'];

    echo <<<HTML
        <h1>Jegy módosítása</h1>

        <form method="post" action="index.php?view=marks">
            <input type="hidden" name="id" value="{$id}">

            <label>Új tantárgy:</label><br>
            <select name="subject_id" required>
                <option value="">-- Válassz tantárgyat --</option>
    HTML;

    foreach ($subjects as $subject) {
        $sid = htmlspecialchars($subject['id']);
        $sname = htmlspecialchars($subject['name']);
        $selected = ($sid == $subject_id) ? 'selected' : '';
        echo "<option value=\"{$sid}\" {$selected}>{$sname}</option>";
    }

    echo <<<HTML
            </select><br><br>

            <label>Új jegy:</label><br>
            <input type="number" name="mark" min="1" max="5" value="{$mark_value}" required><br><br>

            <label>Új tanuló:</label><br>
            <select name="student_id" required>
                <option value="">-- Válassz tanulót --</option>
    HTML;

    foreach ($students as $student) {
        $stid = htmlspecialchars($student['id']);
        $stname = htmlspecialchars($student['name']);
        $selected = ($stid == $student_id) ? 'selected' : '';
        echo "<option value=\"{$stid}\" {$selected}>{$stname}</option>";
    }

    echo <<<HTML
            </select><br><br>

            <label>Új dátum:</label><br>
            <input type="date" name="date" value="{$date}" required><br><br>

            <button type="submit" name="update-mark">Mentés</button>
            <a href="index.php?view=marks">Mégse</a>
        </form>
    HTML;
}
}