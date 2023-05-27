<?php
include "funktionen.php";
ist_eingeloggt();

$errors = array();
$erfolg = false;

$sql_id = escape($_GET["id"]);

//prüfen ob das Formular abgeschickt wurde
if (!empty($_POST)) {

    $sql_name = escape($_POST["name"]) ;
    $sql_img_url = escape($_POST["img_url"]) ;

    if ( empty($sql_name) ) {
        $errors[] = "Bitte geben sie einen Name für die Kategorie ein.";
    } else {
        $result = query("SELECT * FROM kategorien WHERE name = '{$sql_name}' AND id != '{$sql_id}'");
        $row = mysqli_fetch_assoc($result);
        if ( $row){
            $errors[] = "Diese Kategorie existiert bereits.";
        }
    }

    if ( empty($errors)) {
        if ( $sql_img_url == "") {
            $sql_img_url = "NULL";
        }

        query("UPDATE `kategorien` SET name = '{$sql_name}', img_url = '{$sql_img_url}' WHERE id = '{$sql_id}'");

        $erfolg = true;
    }
}



include "kopf.php";
?>

    <h1>Kategorie bearbeiten </h1>
<?php
 if ( $erfolg) {
    echo "<p><strong>Kategorie wurde bearbeitet.</strong><br><a href='kategorien_liste.php'>Zurück zur Liste</a></p>";    

 } else {

    if ( !empty($errors) ) {
        echo "<ul>";
        foreach ($errors as $key => $error) {
            echo "<li>{$error}</li>";
        }
        echo "</ul>";
    }

    //Datenbank nach Kategorie-Datensatz fragen zur Vorbefüllung
    $result = query("SELECT * FROM kategorien WHERE id='{$sql_id}'");
    $row = mysqli_fetch_assoc($result);
?>

    <form  method="post">
        <div>
            <label for="name">Titel:</label>
            <input type="text" name="name" id="name" value="<?php if( !empty($_POST["name"]) ) {
                echo htmlspecialchars($_POST["name"]);
            } else {
                echo htmlspecialchars($row["name"]);
            } ?>">
        </div>
        <div>
            <label for="img_url">Bild URL:</label>
            <input type="text" name="img_url" id="img_url" value="<?php if( !empty($_POST["img_url"]) ) {
                echo htmlspecialchars($_POST["img_url"]);
            } else {
                echo htmlspecialchars($row["img_url"]);
            }  ?>">
        </div>
        <div>
            <button type="submit">Kategorie speichern</button>
        </div>
    </form>
<?php
}
include "fuss.php";