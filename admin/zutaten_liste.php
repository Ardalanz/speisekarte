<?php
include "funktionen.php";
ist_eingeloggt();

include "kopf.php";
?>
<h1>Zutaten</h1>
<p><a href="zutaten_neu.php">Neue Zutat anlegen</a></p>
<?php


$result = query("SELECT * FROM zutaten ORDER BY titel ASC");
//var_dump($result);
echo "<table border='1'>";
    echo "<thead>";
        echo "<th>Id</th>";
        echo "<th>Titel</th>";
        echo "<th>kCal</th>";
        echo "<th>Optionen</th>";
    echo "</thead>";
    echo "<tbody>";

    while($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
            echo "<td>" . $row["id"] . "</td>";
            echo "<td>" . $row["titel"] . "</td>";
            echo "<td>" . $row["kcal_pro_100"] . "</td>";
            echo "<td>" . "<a href='zutaten_bearbeiten.php?id={$row["id"]}'>Bearbeiten</a>" . "<br>"
            ."<a href='zutaten_entfernen.php?id={$row["id"]}'>Entfernen</a>". "</td>";

        echo "</tr>";
    }
    echo "</tbody>";
echo "</table>";

include "fuss.php";
