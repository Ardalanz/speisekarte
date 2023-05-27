<?php
include "funktionen.php";
ist_eingeloggt();

$erfolg = false;
$errors = array();

//Prüfen ob das Formular abgeschickt wurde
if (!empty($_POST)) {


    $sql_titel = escape($_POST["titel"]);
    $sql_untertitel = escape($_POST["untertitel"]);
    $sql_preis = escape($_POST["preis"]);
    $sql_menge = escape($_POST["menge"]);
    $sql_einheit = escape($_POST["einheit"]);
    $sql_kategorie_id = escape($_POST["kategorie_id"]);
    $sql_anzeigen = escape($_POST["anzeigen"]);
    $sql_img_url = escape($_POST["img_url"]);

    //Validierung
    if (empty($_POST["titel"]) ){
        $errors[] = "Bitte geben Sie einen Namen für das neue Produkt ein.";
    } 
    //kein ELSE weil es kann ja das gleiche Produkt geben nur mit leicht unterschiedlichen Zutaten

    //wenn kein Validierungsfehler --> in DB speichern
    if ( empty($errors) ) {

        query("INSERT INTO `produkte` (titel, untertitel, preis, menge, einheit, kategorie_id, anzeigen, img_url) VALUES ('{$sql_titel}', '{$sql_untertitel}', '{$sql_preis}', '{$sql_menge}', '{$sql_einheit}', '{$sql_kategorie_id}', '{$sql_anzeigen}', '{$sql_img_url}')");
        //gibt zurück welche zuletzt erstellte ID ist.
        $neue_produkt_id = mysqli_insert_id($db);

        $erfolg = true;
    }

}

include "kopf.php";
?>

    <h1>Neues Produkt anlegen </h1>
<?php
 if ( $erfolg) {
    echo "<p><strong>Produkt wurde angelegt.</strong><br><a href='produkte_liste.php'>Zurück zur Liste</a></p>";
 } else {

    if (!empty($errors) ){
        echo "<ul>";
        foreach ($errors as $key => $error) {
            echo "<li>{$error}</li>";
        }
        echo "</ul>";
    }
?>

    <form method="post">
        <div>
            <label for="kategorie_id">Kategorie:</label> 
            <select name="kategorie_id" id="kategorie_id">
                <?php
                $result = query("SELECT * FROM kategorien ORDER BY name ASC");
                while ($kategorie = mysqli_fetch_assoc($result)) {
                    echo "<option value='{$kategorie["id"]}'";
                    echo ">{$kategorie["name"]}</option>";
                }
                ?>
            </select>
        </div>  
        <div>
            <label for="titel">Produkttitel:</label>
            <input type="text" name="titel" id="titel" value="<?php if( !empty($_POST["titel"]) ) {
                echo htmlspecialchars($_POST["titel"]);
            }  ?>">
        </div>
        <div>
            <label for="untertitel">Untertitel:</label>
            <textarea name="untertitel" id="untertitel"><?php if( !empty($_POST["untertitel"]) ) {
                echo htmlspecialchars($_POST["untertitel"]);
            }?></textarea>
        </div>
        <div>
            <label for="preis">Preis:</label>
            <input type="text" name="preis" id="preis" value="<?php if( !empty($_POST["preis"]) ) {
                echo htmlspecialchars($_POST["preis"]);
            }  ?>">
        </div>
        <div>
            <label for="menge">Menge:</label>
            <input type="text" name="menge" id="menge" value="<?php if( !empty($_POST["menge"]) ) {
                echo htmlspecialchars($_POST["menge"]);
            }  ?>">
        </div>
        <div>
            <label for="einheit">Einheit:</label>
            <input type="text" name="einheit" id="einheit" value="<?php if( !empty($_POST["einheit"]) ) {
                echo htmlspecialchars($_POST["einheit"]);
            }  ?>">
        </div>
        <div>
            <label for="anzeigen">Anzeigen:</label>
            <select name="anzeigen" id="anzeigen">
            <option value='ja'>ja</option>
            <option value='nein'>nein</option>
      </select>
        </div>
        <div>
            <label for="img_url">Foto URL:</label>
            <textarea name="img_url" id="img_url"><?php if( !empty($_POST["img_url"]) ) {
                echo htmlspecialchars($_POST["img_url"]);
            }?></textarea>
        </div>

        <div>
            <button type="submit">Produkt anlegen</button>
        </div>
    </form>
<?php
}
include "fuss.php";