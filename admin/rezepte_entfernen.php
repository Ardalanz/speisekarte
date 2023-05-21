<?php
include "funktionen.php";
ist_eingeloggt();

include "kopf.php";

echo "<h1>Rezept entfernen</h1>";
$sql_id = escape($_GET["id"]);

if (!empty($_GET["doit"])) {
  // Bestätigungs-Link wurde geklickt -> wirklich in DB löschen
  query("DELETE FROM rezepte WHERE id = '{$sql_id}' ");

  echo "<p>Die Rezept wurde erfolgreich entfernt.<br />
    <a href='rezepte_liste.php'>Zurück zur Liste</a>
  </p>";
} else {
  // Benutzer fragen, ob er das Rezept wirklich entfernen will
  $result = query("SELECT * FROM rezepte WHERE id = '{$sql_id}' ");
  $row = mysqli_fetch_assoc($result);

  if (empty($row)) {
    echo "<p>Dieses Rezept existiert nicht (mehr).<br />
      <a href='rezepte_liste.php'>Zurück zur Liste</a>
    </p>";
  } else {
    echo "<p>Sind Sie sicher, dass Sie das Rezept
      <strong>".htmlspecialchars($row["titel"])."</strong>
      entfernen möchten?
    </p>";

    echo "<p>
      <a href='rezepte_liste.php'>Nein, abbrechen</a> -
      <a href='rezepte_entfernen.php?id={$row["id"]}&amp;doit=1'>Ja, entfernen</a>
    </p>";
  }
}

include "fuss.php";
