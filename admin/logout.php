<?php
    session_start();
    
    //Setzt nur den jeweiligen Eintrag zurück
    unset($_SESSION["eingeloggt"]);

    //Alle $_SESSION Variablen löschen.
    session_unset();

    //Vernichtet die ganze Session samt Cookie
    session_destroy();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logout aus dem Rezepte-Administrationsbereich</title>
</head>
<body>
    <h1>Logout aus dem Rezepte-Administrationsbereich</h1>
    <p>Sie wurden erfolgreich ausgeloggt.</p>
    <p>
        <a href="login.php">Weiter zum Login</a>
    </p>
</body>
</html>