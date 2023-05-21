<?php
include "funktionen.php";

    if (!empty($_POST)) {
        //Validierung
        if ( empty($_POST["benutzername"]) || empty($_POST["passwort"]) ) {
            $error = "Benutzername oder Passwort war leer!";
        } else {
            //Benutzer und Passwort wurden übergeben
            //=> in der DB nachsehen, ob der Benutzer existiert

            //Daten von Formualen/Benutzern ($_GET / §_POST)
            //immer mit mysqli_real_escape_string behandeln
            //bevor die Daten in einem Datenbankbefehl verwendet werden
            $sql_benutzername = escape( $_POST["benutzername"] );
            
            //echo "SELECT * FROM benutzer WHERE benutzername=\"{$_POST["benutzername"]}\"";
            //echo "<br>";
            //var_dump($sql_benutzername);

            //Datenbank fragen ob der eingegeben Benutzer exitstiert.
            $result = query( "SELECT * FROM benutzer WHERE benutzername='{$sql_benutzername}'");

            //Einen Datensatz aus mysql in ein php Array umwandeln
            $row = mysqli_fetch_assoc($result);

            if ($row)
            {
                //var_dump($row);
                //Benutzername existiert => Passwort prüfen
                //if ( $_POST["passwort"] == $row["passwort"])
                if ( password_verify( $_POST["passwort"], $row["passwort"] ) )
                {
                    //Alles super -> login merken
                    $_SESSION["eingeloggt"] = true;
                    $_SESSION["benutzername"] = $row["benutzername"];
                    $_SESSION["benutzer_id"] = $row["id"];

                    //letztes Login & Anzahl der Logins in DB speichern#
                    query("UPDATE `benutzer` SET `letztes_login`=NOW(),`anzahl_logins`=anzahl_logins+1 WHERE benutzername = '{$row['benutzername']}'");

                    //Umleitung zum Admin-System
                    header("Location: index.php");
                    exit;
                } else {
                    //Passwort war falsch -> Fehlermeldung
                    //idealerweise die selbe Fehlermeldung, somit kann man nicht darauf schließen was von beiden (PW or Benutzer) falsch gewesen ist
                    $error = "Benutzername oder Passwort war falsch";
                }

            } else {
                //eingegebener Benutzer ist nicht in der DB -> Fehlermeldung
                //idealerweise die selbe Fehlermeldung, somit kann man nicht darauf schließen was von beiden (PW or Benutzer) falsch gewesen ist
                $error = "Benutzername oder Passwort war falsch";
            }

        }
    }
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Loginbereich zur Rezepteverwaltung</title>
</head>
<body>
    <h1>Loginbereich zur Rezepteverwaltung</h1>
<?php
    if (!empty($error) ){
        echo "<p>{$error}</p>";
    }
?>
    <form method="post">
    <div>
        <label for="benutzername">Benutzername:</label>
        <input type="text" name="benutzername" id="benutzername" >
    </div>
    <div>
        <label for="passwort">Passwort:</label>
        <input type="password" name="passwort" id="passwort" >
    </div>
    <div>
        <button type="submit">Einloggen</button>
    </div>
    </form> 
</body>
</html>