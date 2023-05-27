<?php
include "funktionen.php";
ist_eingeloggt();

$erfolg = false;
$error = "";

if (!empty($_POST)) {

    //Validierung
    if (empty($_POST["name"]) ){
        $error = "Name darf nicht leer sein.";
    } else {
        //Überprüfen ob eine Kategoriee bereits existiert.
        $sql_name = escape($_POST["name"]) ;
        $img_url = escape($_POST["img_url"]) ;

        $result = query("SELECT * FROM kategorien WHERE name = '{$sql_name}'");
        $row = mysqli_fetch_assoc($result);
        if($row){
            $error = "Diese Kategorie existiert bereits.";
        }
    }

    //wenn kein Validierungsfehler --> in DB speichern
    if ( empty($error) ) {
        if ( $img_url == "") {
            $img_url = "NULL";
        }

        query("INSERT INTO `kategorien`(`name`, `img_url`) VALUES ('{$sql_name}','{$img_url}')");

        $erfolg = true;
    }

}

include "kopf.php";
?>

    <h1>Neue Kategorie anlegen </h1>
<?php
 if ( $erfolg) {
    echo "<p><strong>kategorie wurde angelegt.</strong><br><a href='kategorien_liste.php'>Zurück zur Liste</a></p>";
 } else {

    if (!empty($error) ){
        echo "<p>{$error}</p>";
    }
?>

    <form method="post">
        <div>
            <label for="name">Name:</label>
            <input type="text" name="name" id="name" value="<?php if( !empty($_POST["name"]) ) {
                echo htmlspecialchars($_POST["name"]);
            }  ?>">
        </div>
        <div>
            <label for="img_url">Bild URL:</label>
            <input type="text" name="img_url" id="img_url" value="<?php if( !empty($_POST["img_url"]) ) {
                echo htmlspecialchars($_POST["img_url"]);
            }  ?>">
        </div>
        <div>
            <button type="submit">Kategorie anlegen</button>
        </div>
    </form>
<?php
}
include "fuss.php";