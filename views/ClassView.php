<?php

class ClassView
{
    public static function list($classes)
    {
        echo <<<HTML
<h1>Osztályok</h1>

<p><a href="index.php?view=add-class">Új osztály hozzáadása</a></p>

<table border="1" cellpadding="5">
<tr>
<th>ID</th>
<th>Tanév</th>
<th>Évfolyam</th>
<th>Betű</th>
<th>Műveletek</th>
</tr>
HTML;

        foreach ($classes as $c) {

            $id = $c['id'];
            $year = htmlspecialchars($c['year']);
            $grade = htmlspecialchars($c['grade']);
            $letter = htmlspecialchars($c['letter']);

            echo <<<HTML
<tr>
<td>{$id}</td>
<td>{$year}</td>
<td>{$grade}</td>
<td>{$letter}</td>
<td>
<a href="index.php?view=edit-class&id={$id}">Módosítás</a> |
<a href="index.php?view=classes&delete={$id}" onclick="return confirm('Biztos törlöd?')">Törlés</a>
</td>
</tr>
HTML;
        }

        echo "</table>";
    }

    public static function addForm()
    {
        echo <<<HTML
<h1>Új osztály hozzáadása</h1>

<form method="post" action="index.php?view=classes">
<label>Tanév:</label><br>
<input type="number" name="year" required><br><br>

<label>Évfolyam:</label><br>
<input type="number" name="grade" required><br><br>

<label>Betűjel:</label><br>
<input type="text" name="letter" required><br><br>

<button type="submit" name="add-class">Hozzáadás</button>
<a href="index.php?view=classes">Mégse</a>
</form>
HTML;
    }

    public static function editForm($class)
    {
        $id = $class['id'];
        $year = htmlspecialchars($class['year']);
        $grade = htmlspecialchars($class['grade']);
        $letter = htmlspecialchars($class['letter']);

        echo <<<HTML
<h1>Osztály módosítása</h1>

<form method="post" action="index.php?view=classes">
<input type="hidden" name="id" value="{$id}">

<label>Tanév:</label><br>
<input type="number" name="year" value="{$year}" required><br><br>

<label>Évfolyam:</label><br>
<input type="number" name="grade" value="{$grade}" required><br><br>

<label>Betűjel:</label><br>
<input type="text" name="letter" value="{$letter}" required><br><br>

<button type="submit" name="update-class">Mentés</button>
<a href="index.php?view=classes">Mégse</a>
</form>
HTML;
    }
}