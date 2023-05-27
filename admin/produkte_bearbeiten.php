<?php
include "funktionen.php";
ist_eingeloggt();

$error = array();
$erfolg = false;

// Prüfen, ob das Formular abgeschickt wurde
if (!empty($_POST)) {
  $sql_titel = escape($_POST["titel"]);
  $sql_untertitel = escape($_POST["untertitel"]);
  $sql_preis = escape($_POST["preis"]);
  $sql_menge = escape($_POST["menge"]);
  $sql_einheit = escape($_POST["einheit"]);
  $sql_kategorie_id = escape($_POST["kategorie_id"]);
  $sql_anzeigen = escape($_POST["anzeigen"]);
  $sql_id = escape($_GET["id"]);
  $sql_img_url = escape($_POST["img_url"]);

  // Validierung
  if (empty($_POST["titel"])) {
    $error[] = "Bitte gib einen Namen für das neue Produkt ein.";
  }

  // Wenn kein Validierungsfehler -> in DB speichern
  if (empty($error)) {
    query("UPDATE produkte SET
        titel = '{$sql_titel}',
        untertitel = '{$sql_untertitel}',
        preis = '{$sql_preis}',
        menge = '{$sql_menge}',
        einheit = '{$sql_einheit}',
        kategorie_id = '{$sql_kategorie_id}',
        anzeigen = '{$sql_anzeigen}',
        img_url = '{$sql_img_url}'
      WHERE id = '{$sql_id}'
    ");

    $erfolg = true;
  }

}

include "kopf.php";
?>

	<h1>Produkt bearbeiten</h1>

  <?php
  // Fehler ausgeben, wenn aufgetreten
  if (!empty($error)) {
    echo "<ul>";
    foreach ($error as $ein_fehler) {
      echo "<li>{$ein_fehler}</li>";
    }
    echo "</ul>";
  }

  // Erfolgsmeldung
  if ($erfolg) {
    echo "<p>
      <strong>Produkt wurde bearbeitet.</strong><br />
      <a href='produkte_liste.php'>Zurück zur Liste</a>
    </p>";
  }

  // Datenbank nach Produkt-Datensatz fragen (zur Vorausfüllung)
  $sql_id = escape($_GET["id"]);
  $result = query("SELECT * FROM produkte WHERE id = '{$sql_id}' ");
  $row = mysqli_fetch_assoc($result);
  ?>

  <form action="produkte_bearbeiten.php?id=<?php echo $row["id"]; ?>" method="post">
  <div>
      <label for="kategorie_id">Benutzer:</label>
      <select name="kategorie_id" id="kategorie_id">
        <?php
        $result = query("SELECT * FROM kategorien ORDER BY name ASC");
        while ($kategorie = mysqli_fetch_assoc($result)) {
          echo "<option value='{$kategorie["id"]}'";
          if (!empty($_POST["kategorie_id"]) && !$erfolg && $_POST["kategorie_id"] == $kategorie["id"]) {
            // Formular wurde mit Fehlern abgeschickt -> Mit POST-Werten vorausfüllen
            echo " selected";
          } else if ((empty($_POST["kategorie_id"]) || $erfolg) && $row["kategorie_id"] == $kategorie["id"]) {
            // Wir sind frisch zum Formular gekommen -> Mit Session-Benutzer-ID vorausfüllen
            echo " selected";
          }
          echo ">{$kategorie["name"]}</option>";
        }
        ?>
      </select>
    </div>
    <div>
      <label for="titel">Produkttitel:</label>
      <input type="text" name="titel" id="titel" value="<?php
        if (!empty($_POST["titel"]) && !$erfolg) {
          echo htmlspecialchars($_POST["titel"]);
        } else {
          echo htmlspecialchars($row["titel"]);
        }
      ?>" />
    </div>
    <div>
      <label for="untertitel">Untertitel</label>
      <textarea name="untertitel" id="untertitel"><?php
        if (!empty($_POST["untertitel"]) && !$erfolg) {
          echo htmlspecialchars($_POST["untertitel"]);
        } else {
          echo htmlspecialchars($row["untertitel"]);
        }
      ?></textarea>
    </div>
    <div>
  <label for="preis">Preis:</label>
  <input type="text" name="preis" id="preis" value="<?php
    if (!empty($_POST["preis"]) && !$erfolg) {
      echo htmlspecialchars($_POST["preis"]);
    } else {
      echo htmlspecialchars($row["preis"]);
    }
  ?>" />
</div>
<div>
  <label for="menge">Menge:</label>
  <input type="text" name="menge" id="menge" value="<?php
    if (!empty($_POST["menge"]) && !$erfolg) {
      echo htmlspecialchars($_POST["menge"]);
    } else {
      echo htmlspecialchars($row["menge"]);
    }
  ?>" />
</div>
<div>
  <label for="einheit">Einheit:</label>
  <input type="text" name="einheit" id="einheit" value="<?php
    if (!empty($_POST["einheit"]) && !$erfolg) {
      echo htmlspecialchars($_POST["einheit"]);
    } else {
      echo htmlspecialchars($row["einheit"]);
    }
  ?>" />
</div>
<div>
  <label for="anzeigen">Anzeigen:</label>
  <select name="anzeigen" id="anzeigen">
        <?php
        
          echo "<option value='ja'";
          if ($row["anzeigen"] == 'ja') echo " selected"; 
          echo ">ja</option>";
          
          echo "<option value='nein'";
          if ($row["anzeigen"] == 'nein') echo " selected"; 
          echo ">nein</option>";
        ?>
      </select>
</div>

<div>
  <label for="img_url">Foto URL:</label>
  <input type="text" name="img_url" id="img_url" value="<?php
    if (!empty($_POST["img_url"]) && !$erfolg) {
      echo htmlspecialchars($_POST["img_url"]);
    } else {
      echo htmlspecialchars($row["img_url"]);
    }
  ?>" />
</div>

    <div>
      <button type="submit">Produkt speichern</button>
    </div>

  </form>

<?php
include "fuss.php";
?>
