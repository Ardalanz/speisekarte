<?php
include "funktionen.php";
ist_eingeloggt();

$error = array();
$erfolg = false;

// Prüfen, ob das Formular abgeschickt wurde
if (!empty($_POST)) {
  $sql_benutzer_id = escape($_POST["benutzer_id"]);
  $sql_titel = escape($_POST["titel"]);
  $sql_img_url = escape($_POST["img_url"]);
  $sql_preis = escape($_POST["preis"]);
  $sql_beschreibung = escape($_POST["beschreibung"]);
  $sql_id = escape($_GET["id"]);

  // Validierung
  if (empty($_POST["titel"])) {
    $error[] = "Bitte gib einen Namen für das neue Rezept ein.";
  }

  // Wenn kein Validierungsfehler -> in DB speichern
  if (empty($error)) {
    query("UPDATE rezepte SET
        benutzer_id = '{$sql_benutzer_id}',
        titel = '{$sql_titel}',
        img_url = '{$sql_img_url}',
        preis = '{$sql_preis}',
        beschreibung = '{$sql_beschreibung}'
      WHERE id = '{$sql_id}'
    ");

    // Alle Zutaten-Zuordnungen löschen und neu anlegen
    query("DELETE FROM zutaten_zu_rezepte WHERE rezepte_id = '{$sql_id}' ");
    foreach ($_POST["zutaten_id"] as $key => $zutat_id) {
      if (empty($zutat_id)) {
        continue;
      }

      $sql_zutaten_id = escape($zutat_id);
      $sql_menge = escape($_POST["menge"][$key]);
      $sql_einheit = escape($_POST["einheit"][$key]);

      query("INSERT INTO zutaten_zu_rezepte SET
        rezepte_id = '{$sql_id}',
        zutaten_id = '{$sql_zutaten_id}',
        menge = '{$sql_menge}',
        einheit = '{$sql_einheit}'
      ");
    }

    $erfolg = true;
  }

}

include "kopf.php";
?>

	<h1>Rezept bearbeiten</h1>

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
      <strong>Rezept wurde bearbeitet.</strong><br />
      <a href='rezepte_liste.php'>Zurück zur Liste</a>
    </p>";
  }

  // Datenbank nach Rezept-Datensatz fragen (zur Vorausfüllung)
  $sql_id = escape($_GET["id"]);
  $result = query("SELECT * FROM rezepte WHERE id = '{$sql_id}' ");
  $row = mysqli_fetch_assoc($result);
  ?>

  <form action="rezepte_bearbeiten.php?id=<?php echo $row["id"]; ?>" method="post">
    <div>
      <label for="benutzer_id">Benutzer:</label>
      <select name="benutzer_id" id="benutzer_id">
        <?php
        $result = query("SELECT * FROM benutzer ORDER BY benutzername ASC");
        while ($user = mysqli_fetch_assoc($result)) {
          echo "<option value='{$user["id"]}'";
          if (!empty($_POST["benutzer_id"]) && !$erfolg && $_POST["benutzer_id"] == $user["id"]) {
            // Formular wurde mit Fehlern abgeschickt -> Mit POST-Werten vorausfüllen
            echo " selected";
          } else if ((empty($_POST["benutzer_id"]) || $erfolg) && $row["benutzer_id"] == $user["id"]) {
            // Wir sind frisch zum Formular gekommen -> Mit Session-Benutzer-ID vorausfüllen
            echo " selected";
          }
          echo ">{$user["benutzername"]}</option>";
        }
        ?>
      </select>
    </div>

    <div>
      <label for="titel">Rezepttitel:</label>
      <input type="text" name="titel" id="titel" value="<?php
        if (!empty($_POST["titel"]) && !$erfolg) {
          echo htmlspecialchars($_POST["titel"]);
        } else {
          echo htmlspecialchars($row["titel"]);
        }
      ?>" />
    </div>

<div>
  <label for="titel">Foto URL:</label>
  <input type="text" name="img_url" id="img_url" value="<?php
    if (!empty($_POST["img_url"]) && !$erfolg) {
      echo htmlspecialchars($_POST["img_url"]);
    } else {
      echo htmlspecialchars($row["img_url"]);
    }
  ?>" />
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
      <label for="beschreibung">Beschreibung</label>
      <textarea name="beschreibung" id="beschreibung"><?php
        if (!empty($_POST["beschreibung"]) && !$erfolg) {
          echo htmlspecialchars($_POST["beschreibung"]);
        } else {
          echo htmlspecialchars($row["beschreibung"]);
        }
      ?></textarea>
    </div>

    <div class="zutatenliste">
      <?php
      // Ermitteln, wie viele Zutaten-Blöcke wir brauchen
      // (zum Vorausfüllen im Fehlerfall)
      $bloecke = 1;
      if (!empty($_POST["zutaten_id"]) && !$erfolg) {
        $bloecke = count($_POST["zutaten_id"]);
      } else {
        // DB fragen nach bisherigen Zutaten-Zuordnungen
        $result = query("SELECT * FROM zutaten_zu_rezepte
          WHERE rezepte_id = '{$sql_id}' ORDER BY id ASC ");
        $bloecke = mysqli_num_rows($result);
        $zutaten_zuordnungen = array();
        while ($zuordnung = mysqli_fetch_assoc($result)) {
          $zutaten_zuordnungen[] = $zuordnung;
        }
        //echo "<pre>"; print_r($zutaten_zuordnungen); echo "</pre>";
      }

      if ($bloecke < 1) {
        $bloecke = 1;
      }

      for ($i = 0; $i < $bloecke; $i++) {
        ?>
        <div class="zutatenblock">

          <div>
            <label for="zutaten_id">Zutat:</label>
            <select name="zutaten_id[]" id="zutaten_id">
              <option value="">- Bitte wählen -</option>
              <?php
              $result = query("SELECT * FROM zutaten ORDER BY titel ASC");
              while ($zutat = mysqli_fetch_assoc($result)) {
                echo "<option value='{$zutat["id"]}'";
                if (!empty($_POST["zutaten_id"]) && !$erfolg && $_POST["zutaten_id"][$i] == $zutat["id"]) {
                  // Formular wurde mit Fehlern abgeschickt -> Mit POST-Werten vorausfüllen
                  echo " selected";
                } else if (
                  (empty($_POST["zutaten_id"]) || $erfolg)
                  && !empty($zutaten_zuordnungen[$i])
                  && $zutaten_zuordnungen[$i]["zutaten_id"] == $zutat["id"]
                ) {
                  // Wir sind frisch zum Formular gekommen -> Mit Session-Benutzer-ID vorausfüllen
                  echo " selected";
                }
                echo ">{$zutat["titel"]}</option>";
              }
              ?>
            </select>
          </div>

          <div>
            <label for="menge">Menge</label>
            <input type="number" name="menge[]" id="menge" value="<?php
              if (!empty($_POST["menge"]) && !$erfolg) {
                echo htmlspecialchars($_POST["menge"][$i]);
              } else if (!empty($zutaten_zuordnungen[$i])) {
                echo htmlspecialchars($zutaten_zuordnungen[$i]["menge"]);
              }
            ?>" />
          </div>

          <div>
            <label for="einheit">Einheit</label>
            <input type="text" name="einheit[]" id="einheit" value="<?php
              if (!empty($_POST["einheit"]) && !$erfolg) {
                echo htmlspecialchars($_POST["einheit"][$i]);
              } else if (!empty($zutaten_zuordnungen[$i])) {
                echo htmlspecialchars($zutaten_zuordnungen[$i]["einheit"]);
              }
            ?>" />
          </div>

        </div>
      <?php
      } // Ende der for-Schleife
      ?>

    </div>

    <a class="zutat-neu" href="#" onclick="neueZutat();">Zutat hinzufügen</a>

    <div>
      <button type="submit">Rezept speichern</button>
    </div>

  </form>

<?php
include "fuss.php";
?>
