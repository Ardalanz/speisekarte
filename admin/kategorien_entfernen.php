<?php
include "funktionen.php";
ist_eingeloggt();

include "kopf.php";

echo "<h1>Kategorie entfernen</h1>";

$sql_id = escape($_GET["id"]);
if ( !empty( $_GET["doit"] ) ) {
    //Bestätigungs_link wurde geklickt -> wirkich aus der DB löschen
    query("DELETE FROM kategorien WHERE id='{$sql_id}'");
    echo "<p>die Kategorie wurde erfolgreich entfernt.<br>";
    echo "<a href='kategorien_liste.php'>Zurück zur Liste</a></p>";
} else {

    //Benutzer fragen, ob er die Kategorie wirklich entfernen will
    $result = query("SELECT * FROM kategorien WHERE id='{$sql_id}'");
    $row = mysqli_fetch_assoc($result);

    if (empty($row)) {
        echo "<p>Diese Kategorie existiert nicht (mehr).<br><a href='kategorien_liste.php'>Zurück zur Liste</a></p>";
    } else {
        echo "<p>Sind Sie sicher, dass Sie diese Kategorie <strong>" . htmlspecialchars($row["name"]) . "</strong> entfernen möchten?</p>";
        echo "<p>
            <a href='kategorien_liste.php'>Nein, abbrechen</a>
            <a href='kategorien_entfernen.php?id=". $row["id"]."&amp;doit=1'>Ja, sicher</a>
            </p>";
    }
}
include "fuss.php";
