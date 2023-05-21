<?php
//ist auch notwendig, um die $_SESSION zur verfügung zu haben
session_start();

//Verbindung zur Datenbank herstellen.
$db = mysqli_connect("localhost", "root", "", "speisekarte_jwe");

//mysql mitteilen, dass unsere Befehle als utf8 kommen
mysqli_set_charset($db, "utf8");

//Kurzform für mysql_query
function query($sql_befehl){
    global $db;
    $result = mysqli_query($db, $sql_befehl) or die(mysqli_error($db) . "<br>" . $sql_befehl);
    return $result;
}

//Escape Funktion um SQL-Injections zu vermeiden
function escape($post_var) {
    global $db;
    return mysqli_real_escape_string($db, $post_var);
}

//Diese Funkion überprüft, ob der Benutzer eingeloggt ist
//Falls nicht, wird er automatisch zum Login umgeleitet
function ist_eingeloggt() {
    if ( empty($_SESSION["eingeloggt"]) ) {
        //benutzer ist nicht eingeloggt -> umleiten zum Login
        header("Location: login.php");
        exit;//wird gemacht, um weitere "geheime" Inhalte darunter nicht zum Browser zu schicken.
    }
}
