<?php
include "funktionen.php";
ist_eingeloggt();

include "kopf.php";

echo "<h1>Zutat entfernen</h1>";

$sql_id = escape($_GET["id"]);
if ( !empty( $_GET["doit"] ) ) {
    //Bestätigungs_link wurde geklickt -> wirkich aus der DB löschen
    query("DELETE FROM zutaten WHERE id='{$sql_id}'");
    echo "<p>die Zutat wurde erfolgreich entfernt.<br>";
    echo "<a href='zutaten_liste.php'>Zurück zur Liste</a></p>";
} else {

    //Benutzer fragen, ob er die Zutat wirklich entfernen will
    $result = query("SELECT * FROM zutaten WHERE id='{$sql_id}'");
    $row = mysqli_fetch_assoc($result);

    $result2 = query("SELECT * FROM zutaten_zu_rezepte WHERE zutaten_id = '{$sql_id}'");
    $existiert_bei_rezept = mysqli_fetch_assoc($result2);

    if (empty($row)) {
        echo "<p>Diese Zutat existiert nicht (mehr).<br><a href='zutaten_liste.php'>Zurück zur Liste</a></p>";
    } else if ($existiert_bei_rezept) {
        echo "<p>Die Zutat <strong>" . htmlspecialchars($row["titel"]) . "</strong> wird noch bei einem Rezept verwendet und kann daher nicht entfernt werden.</p>";
        echo "<p><a href='zutaten_liste.php'>Zurück zur Liste</a></p>";
    } else {
        echo "<p>Sind Sie sicher, dass Sie diese Zutat <strong>" . htmlspecialchars($row["titel"]) . "</strong> entfernen möchten?</p>";
        echo "<p>
            <a href='zutaten_liste.php'>Nein, abbrechen</a>
            <a href='zutaten_entfernen.php?id=". $row["id"]."&amp;doit=1'>Ja, sicher</a>
            </p>";
    }
}
include "fuss.php";
