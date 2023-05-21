<?php
include "funktionen.php";
ist_eingeloggt();

$erfolg = false;
$error = "";

if (!empty($_POST)) {

    //Validierung
    if (empty($_POST["titel"]) ){
        $error = "Titel darf nicht leer sein.";
    } else {
        //Überprüfen ob eine Zutate bereits existiert.
        $sql_titel = escape($_POST["titel"]) ;
        $sql_kcal_pro_100 = escape($_POST["kcal_pro_100"]) ;

        $result = query("SELECT * FROM zutaten WHERE titel = '{$sql_titel}'");
        $row = mysqli_fetch_assoc($result);
        if($row){
            $error = "Diese Zutat existiert bereits.";
        }
    }

    //wenn kein Validierungsfehler --> in DB speichern
    if ( empty($error) ) {
        if ( $sql_kcal_pro_100 == "") {
            $sql_kcal_pro_100 = "NULL";
        }

        query("INSERT INTO `zutaten`(`titel`, `kcal_pro_100`) VALUES ('{$sql_titel}',{$sql_kcal_pro_100})");

        $erfolg = true;
    }

}

include "kopf.php";
?>

    <h1>Neue Zutat anlegen </h1>
<?php
 if ( $erfolg) {
    echo "<p><strong>zutat wurde angelegt.</strong><br><a href='zutaten_liste.php'>Zurück zur Liste</a></p>";
 } else {

    if (!empty($error) ){
        echo "<p>{$error}</p>";
    }
?>

    <form method="post">
        <div>
            <label for="titel">Titel:</label>
            <input type="text" name="titel" id="titel" value="<?php if( !empty($_POST["titel"]) ) {
                echo htmlspecialchars($_POST["titel"]);
            }  ?>">
        </div>
        <div>
            <label for="kcal_pro_100">KCal/100:</label>
            <input type="number" name="kcal_pro_100" id="kcal_pro_100" value="<?php if( !empty($_POST["kcal_pro_100"]) ) {
                echo htmlspecialchars($_POST["kcal_pro_100"]);
            }  ?>">
        </div>
        <div>
            <button type="submit">Zutat anlegen</button>
        </div>
    </form>
<?php
}
include "fuss.php";