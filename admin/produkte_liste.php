<?php
include "funktionen.php";
ist_eingeloggt();

include "kopf.php";
?>
<h1>Produkte</h1>
<p><a href="produkte_neu.php">Neues Produkt anlegen</a></p>


<?php

$result = query("SELECT produkte.*, kategorien.name kategorie_name FROM produkte JOIN kategorien ON produkte.kategorie_id = kategorien.id ORDER BY produkte.titel ASC");

echo "<table class= 'tabelle'>";
    echo "<thead>";
        echo "<th>Titel</th>";
        echo "<th>Untertitel</th>";
        echo "<th>Preis</th>";
        echo "<th>Menge</th>";
        echo "<th>Einheit</th>";
        echo "<th>Kategorie</th>";
        echo "<th>Anzeigen</th>";
        echo "<th>Foto URL</th>";
        echo "<th>Optionen</th>";
    echo "</thead>";
    echo "<tbody>";

    while($row = mysqli_fetch_assoc($result)) {

        
        echo "<tr>";
            echo "<td><div class='spalte-handy'>Titel</div>" . $row["titel"] . "</td>";
            echo "<td><div class='spalte-handy'>Untertitel</div>" . $row["untertitel"] . "</td>";
            echo "<td><div class='spalte-handy'>Preis</div>" . $row["preis"] . "</td>";
            echo "<td><div class='spalte-handy'>Menge</div>" . $row["menge"] . "</td>";
            echo "<td><div class='spalte-handy'>Einheit</div>" . $row["einheit"] . "</td>";
            echo "<td><div class='spalte-handy'>Kategorie</div>" . $row["kategorie_name"] . "</td>";
            echo "<td><div class='spalte-handy'>Anzeigen</div>" . $row["anzeigen"] . "</td>";
            echo "<td><div class='spalte-handy'>Foto URL</div>" . $row["img_url"] . "</td>";
            echo "<td><div class='spalte-handy'>Optionen</div>" . "<a href='produkte_bearbeiten.php?id={$row["id"]}'>Bearbeiten</a>" . "<br>"
            ."<a href='produkte_entfernen.php?id={$row["id"]}'>Entfernen</a>". "</td>";

        echo "</tr>";
    }
    echo "</tbody>";
echo "</table>";

include "fuss.php";