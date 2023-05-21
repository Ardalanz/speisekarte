<?php
include "funktionen.php";
ist_eingeloggt();

include "kopf.php";
?>
<h1>Rezepte</h1>
<p><a href="rezepte_neu.php">Neues Rezept anlegen</a></p>
<?php

$result = query("SELECT rezepte.*, benutzer.benutzername FROM rezepte JOIN benutzer ON rezepte.benutzer_id = benutzer.id ORDER BY rezepte.titel ASC");

echo "<table border='1'>";
    echo "<thead>";
        echo "<th>Titel</th>";
        echo "<th>Beschreibung</th>";
        echo "<th>Foto URL</th>";
        echo "<th>Preis</th>";
        echo "<th>Benutzername</th>";
        echo "<th>Optionen</th>";
    echo "</thead>";
    echo "<tbody>";

    while($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
            echo "<td>" . $row["titel"] . "</td>";
            echo "<td>" . $row["beschreibung"] . "</td>";
            echo "<td>" . $row["img_url"] . "</td>";
            echo "<td>" . $row["preis"] . "</td>";
            echo "<td>" . $row["benutzername"] . "</td>";
            echo "<td>" . "<a href='rezepte_bearbeiten.php?id={$row["id"]}'>Bearbeiten</a>" . "<br>"
            ."<a href='rezepte_entfernen.php?id={$row["id"]}'>Entfernen</a>". "</td>";

        echo "</tr>";
    }
    echo "</tbody>";
echo "</table>";

include "fuss.php";