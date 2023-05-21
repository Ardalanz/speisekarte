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
                    header("Location: home.php");
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

<body class="bg-dark text-light h-100">
    
    <div class="container h-100">
        <div class="row h-100 align-items-center justify-content-center">
            <div class="col-xl-6 col-lg-7 col-md-9 col-sm-12 col-12 rounded bg-black px-5 py-5">
                
                
                <header class="mb-4">
                    <h1 class="text-danger">Login into Admin</h1>
                </header>

                <form method="post">
                    <div class="row mb-3">
                        <div class="col-sm-4">
                            <label for="Benutzername">Benutzername:</label>
                        </div>
                        <div class="col-sm-8">
                            <input type="text" name="Benutzername" id="Benutzername" class="form-control">
                            <div id="userHelpBlock" class="form-text text-danger">
                                
                              </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-sm-4">
                            <label for="passwort">passwort:</label>
                        </div>
                        <div class="col-sm-8">
                            <input type="passwort" name="passwort" id="passwort" class="form-control">
                            <div id="passwordHelpBlock" class="form-text text-danger">
                                
                              </div>
                        </div>

                    </div>

                
                    <div class="row">
                        <div class="col-sm-4">
                           
                        </div>
                        <div class="col-sm-8">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <button id="button" type="submit" class="btn btn-success">Einloggen</button>
                            
                                </div>
                                <div class="col">
                                    <input type="checkbox" name="remember" id="remember" class="form-check-input">
                                    <label for="remember" class="form-check-label">Login merken</label>
                                </div>
                            </div>
                            
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>


    <script src="../js/jquery-3.6.3.js"></script>
    <script src="../js/main.js"></script>
    <script src="../js/bootstrap.js"></script>


    <!-- <form method="post">
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
    </form>  -->
</body>
</html>