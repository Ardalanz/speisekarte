<?php
include "funktionen.php";
ist_eingeloggt();

$erfolg = false;
$errors = array();

//Prüfen ob das Formular abgeschickt wurde
if (!empty($_POST)) {


    $sql_titel = escape($_POST["titel"]) ;
    $sql_beschreibung = escape($_POST["beschreibung"]) ;
    $sql_preis = escape($_POST["preis"]) ;
    $sql_benutzer_id = escape($_POST["benutzer_id"]);

    //Validierung
    if (empty($_POST["titel"]) ){
        $errors[] = "Bitte geben Sie einen Namen für das neue Rezept ein.";
    } 
    //kein ELSE weil es kann ja das gleiche Rezept geben nur mit leicht unterschiedlichen Zutaten


    //wenn kein Validierungsfehler --> in DB speichern
    if ( empty($errors) ) {


        query("INSERT INTO `rezepte` (`titel`, `beschreibung`,`benutzer_id`, `preis`) VALUES ('{$sql_titel}','{$sql_beschreibung}','{$sql_benutzer_id}','{$sql_preis}')");
        //gibt zurück welche zuletzt erstellte ID ist.
        $neue_rezept_id = mysqli_insert_id($db);

        //Zuordnung zu Zutaten anlegen
        foreach ($_POST["zutaten_id"] as $key => $zutat_id) {
            if ( empty($zutat_id)) {
                continue;
            }
            $sql_zutaten_id = escape($zutat_id);
            $sql_menge = escape($_POST["menge"][$key]);
            $sql_einheit = escape($_POST["einheit"][$key]);

            query("INSERT INTO zutaten_zu_rezepte SET
                rezepte_id ='{$neue_rezept_id}',
                zutaten_id ='{$sql_zutaten_id}',
                menge ='{$sql_menge}',
                einheit ='{$sql_einheit}'
                ");

        }


        $erfolg = true;
    }

}

include "kopf.php";
?>

    <h1>Neues Rezept anlegen </h1>
<?php
 if ( $erfolg) {
    echo "<p><strong>Rezept wurde angelegt.</strong><br><a href='rezepte_liste.php'>Zurück zur Liste</a></p>";
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
            <label for="benutzer_id">Benutzer:</label> 
            <select name="benutzer_id" id="benutzer_id">
                <?php
                $result = query("SELECT * FROM benutzer ORDER BY benutzername ASC");
                while ($user = mysqli_fetch_assoc($result)) {
                    echo "<option value='{$user["id"]}'";
                    if ( !empty($_POST["benutzer_id"]) && !$erfolg && $_POST["benutzer_id"] == $user["id"] ) {
                        echo " selected";
                    } elseif ( (empty($_POST["benutzer_id"]) || $erfolg) && $_SESSION["benutzer_id"] == $user["id"] ) {
                        //mit Session-Benutzer-Id vorausfüllen
                        echo " selected";
                    }
                    echo ">{$user["benutzername"]}</option>";
                }
                ?>
            </select>
        </div>  
        <div>
            <label for="titel">Rezepttitel:</label>
            <input type="text" name="titel" id="titel" value="<?php if( !empty($_POST["titel"]) ) {
                echo htmlspecialchars($_POST["titel"]);
            }  ?>">
        </div>
        <div>
            <label for="preis">Preis:</label>
            <input type="text" name="preis" id="preis" value="<?php if( !empty($_POST["preis"]) ) {
                echo htmlspecialchars($_POST["preis"]);
            }  ?>">
        </div>
        <div>
            <label for="beschreibung">Beschreibung:</label>
            <textarea name="beschreibung" id="beschreibung"><?php if( !empty($_POST["beschreibung"]) ) {
                echo htmlspecialchars($_POST["beschreibung"]);
            }?></textarea>
        </div>
        <div>
            <label for="img_url">Foto URL:</label>
            <textarea name="img_url" id="img_url"><?php if( !empty($_POST["img_url"]) ) {
                echo htmlspecialchars($_POST["img_url"]);
            }?></textarea>
        </div>

        <div class="zutatenliste">
            <?php
            //Ermitteln wieviel Blöcke wir brauchen
            $bloecke = 1;
            if ( !empty($_POST["zutaten_id"]) && !$erfolg) {
                $bloecke = count($_POST["zutaten_id"]);
            }

            for ($i=0; $i < $bloecke; $i++) {
            ?>
                <div class="zutatenblock">
                    <div>
                        <label for="zutaten_id">Zutat:</label>
                        <select name="zutaten_id[]" id="zutaten_id">
                            <option value="">-Bitte wählen-</option>
                            <?php
                            $result = query("SELECT * FROM zutaten ORDER BY titel ASC");
                            while ($zutat = mysqli_fetch_assoc($result)) {
                                echo "<option value='{$zutat["id"]}'";
                                if (!empty($_POST["zutaten_id"]) && !$erfolg && $_POST["zutaten_id"] == $zutat["id"]){
                                    echo " selected";
                                }
                                echo ">{$zutat["titel"]}</option>";
                            }
                            ?>
                        </select> 
                    </div>
                    <div>
                        <label for="menge">Menge:</label>
                        <input type="number" name="menge[]" id="menge" value="<?php 
                            if ( !empty($_POST["menge"]) && !$erfolg ) {
                                echo htmlspecialchars($_POST["menge"][$i]);
                            }  ?>">
                    </div>
                    <div>
                        <label for="einheit">Einheit:</label>
                        <input type="text" name="einheit[]" id="einheit" value="<?php 
                            if ( !empty($_POST["einheit"]) && !$erfolg ) {
                                echo htmlspecialchars($_POST["einheit"][$i]);
                            }  ?>">
                    </div>
                </div>
            <?php
            } ?>
        </div>
        <a class="zutat-neu" href="#" onclick="neueZutat();">Zutat hinzufügen</a>
        <div>
            <button type="submit">Rezept anlegen</button>
        </div>
    </form>
<?php
}
include "fuss.php";