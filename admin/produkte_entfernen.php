
<?php
include "funktionen.php";
ist_eingeloggt();

include "kopf.php";

echo "<h1>Produkt entfernen</h1>";
$sql_id = escape($_GET["id"]);

if (!empty($_GET["doit"])) {
  // Bestätigungs-Link wurde geklickt -> wirklich in DB löschen
  query("DELETE FROM produkte WHERE id = '{$sql_id}' ");

  echo "<p>Die Produkt wurde erfolgreich entfernt.<br />
    <a href='produkte_liste.php'>Zurück zur Liste</a>
  </p>";
} else {
  // Benutzer fragen, ob er das Produkt wirklich entfernen will
  $result = query("SELECT * FROM produkte WHERE id = '{$sql_id}' ");
  $row = mysqli_fetch_assoc($result);

  if (empty($row)) {
    echo "<p>Dieses Produkt existiert nicht (mehr).<br />
      <a href='produkte_liste.php'>Zurück zur Liste</a>
    </p>";
  } else {
    echo "<p>Sind Sie sicher, dass Sie das Produkt
      <strong>".htmlspecialchars($row["titel"])."</strong>
      entfernen möchten?
    </p>";

    echo "<p>
      <a href='produkte_liste.php'>Nein, abbrechen</a> -
      <a href='produkte_entfernen.php?id={$row["id"]}&amp;doit=1'>Ja, entfernen</a>
    </p>";
  }
}

include "fuss.php";
