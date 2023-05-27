<?php
include "funktionen.php";
ist_eingeloggt();

include "kopf.php";
?>
<h1>Kategorien</h1>
<p><a href="kategorien_neu.php">Neue Kategorie anlegen</a></p>
<?php


$result = query("SELECT * FROM kategorien ORDER BY name ASC");
//var_dump($result);
echo "<table class= 'tabelle'>";
    echo "<thead>";
        echo "<th>Id</th>";
        echo "<th>Name</th>";
        echo "<th>Bild Url</th>";
        echo "<th>Optionen</th>";
    echo "</thead>";
    echo "<tbody>";
    
    
    
    
    while($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
            echo "<td><div class='spalte-handy'>Id</div>" . $row["id"] . "</td>";
            echo "<td><div class='spalte-handy'>Name</div>" . $row["name"] . "</td>";
            echo "<td><div class='spalte-handy'>Bild Url</div>" . $row["img_url"] . "</td>";
            echo "<td><div class='spalte-handy'>Optionen</div>" . "<a href='kategorien_bearbeiten.php?id={$row["id"]}'>Bearbeiten</a>" . "<br>"
            ."<a href='kategorien_entfernen.php?id={$row["id"]}'>Entfernen</a>". "</td>";

        echo "</tr>";
    }
    echo "</tbody>";
echo "</table>";

include "fuss.php";
