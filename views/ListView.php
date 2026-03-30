<?php

class ListView
{
    public static function selectForm(array $years, ?   int $selectedYear, array $classes): void
    {
        echo "<h1>Listák</h1>";

        echo <<<HTML
        <form method="get" action="index.php">
            <input type="hidden" name="view" value="lists">
            <input type="hidden" name="subview" value="select">
            <label><strong>Tanév:</strong></label>
            <select name="year" onchange="this.form.submit()">
                <option value="">Év</option>
        HTML;

        foreach ($years as $year) {
            $sel = ($year == $selectedYear) ? 'selected' : '';
            echo "<option value=\"{$year}\" {$sel}>{$year}</option>";
        }

        echo "</select></form><br>";

        if ($selectedYear && !empty($classes)) {
            echo "<h2>{$selectedYear} – Osztályok</h2>";
            echo "<table border=\"1\" cellpadding=\"6\">";
            echo "<tr><th>Osztály</th><th>Műveletek</th></tr>";
            foreach ($classes as $cls) {
                $id     = $cls['id'];
                $name   = htmlspecialchars($cls['grade'] . $cls['letter'], ENT_QUOTES, 'UTF-8');
                echo <<<HTML
                <tr>
                    <td>{$name}</td>
                    <td>
                        <a href="index.php?view=lists&subview=class&class_id={$id}">
                            Osztálylista
                        </a>
                    </td>
                </tr>
                HTML;
            }
            echo "</table>";
        }
    }

    public static function classList(
        array $classInfo,
        array $students,
        float $classAvg,
        array $subjectAverages
    ): void {
        $className = htmlspecialchars(
            $classInfo['grade'] . $classInfo['letter'], ENT_QUOTES, 'UTF-8'
        );
        $year = htmlspecialchars($classInfo['year'], ENT_QUOTES, 'UTF-8');
        $classId = (int)$classInfo['id'];

        echo "<h1>{$year} – {$className} osztály</h1>";
        echo "<p><a href=\"index.php?view=lists&subview=select&year={$year}\">Vissza</a></p>";

        $avgDisplay = $classAvg !== null ? $classAvg : 'Nincs adat';
        echo "<h2>Osztály tanulmányi átlaga: <strong>{$avgDisplay}</strong></h2>";

        echo "<h2>Tantárgyankénti átlag</h2>";
        {
            echo "<table border=\"1\" cellpadding=\"6\">";
            echo "<tr><th>Tantárgy</th><th>Átlag</th></tr>";
            foreach ($subjectAverages as $row) {
                $subj = htmlspecialchars($row['subject_name'], ENT_QUOTES, 'UTF-8');
                $avg  = round((float)$row['avg'], 2);
                echo "<tr><td>{$subj}</td><td>{$avg}</td></tr>";
            }
            echo "</table>";
        }


        echo "<h2>Tanulók</h2>";
        {
            echo "<table border=\"1\" cellpadding=\"6\">";
            echo "<tr><th>Név</th><th>Születési dátum</th><th>Műveletek</th></tr>";
            foreach ($students as $s) {
                $sid       = (int)$s['id'];
                $name      = htmlspecialchars($s['name'], ENT_QUOTES, 'UTF-8');
                $birthDate = htmlspecialchars($s['birthdate'], ENT_QUOTES, 'UTF-8');
                echo <<<HTML
                <tr>
                    <td>{$name}</td>
                    <td>{$birthDate}</td>
                    <td>
                        <a href="index.php?view=lists&subview=student&student_id={$sid}&back_class={$classId}&back_year={$year}">
                            Átlagok
                        </a>
                    </td>
                </tr>
                HTML;
            }
            echo "</table>";
        }
    }

    public static function studentDetail(
        array $student,
        float $studentAvg,
        array $subjectAverages
    ): void {
        $name      = htmlspecialchars($student['name'], ENT_QUOTES, 'UTF-8');
        $birthDate = htmlspecialchars($student['birthdate'], ENT_QUOTES, 'UTF-8');
        $className = htmlspecialchars($student['class_name'], ENT_QUOTES, 'UTF-8');
        $classId   = (int)($student['class_id'] ?? 0);
        $year      = htmlspecialchars($student['year'] ?? '', ENT_QUOTES, 'UTF-8');

        echo "<h1>Tanuló: {$name}</h1>";

        if ($classId) {
            echo "<p><a href=\"index.php?view=lists&subview=class&class_id={$classId}\">Vissza</a></p>";
        }
        echo "<h2>Tanulmányi átlag: <strong>{$studentAvg}</strong></h2>";

        echo "<h2>Tantárgyankénti átlag</h2>";
        {
            echo "<table border=\"1\" cellpadding=\"6\">";
            echo "<tr><th>Tantárgy</th><th>Átlag</th></tr>";
            foreach ($subjectAverages as $row) {
                $subj = htmlspecialchars($row['subject_name'], ENT_QUOTES, 'UTF-8');
                $avg  = round((float)$row['avg'], 2);
                echo "<tr><td>{$subj}</td><td>{$avg}</td></tr>";
            }
            echo "</table>";
        }
    }
}
