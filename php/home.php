
<?php

// Wenn jemand frisch zur Webseite kommt, existiert $_GET["seite"] nicht.
// Das wird erst durch einen Klick auf einen Menüpunkt gesetzt.
// Mit dieser Abfrage schaffen wir eine Variable $seite die immer
// gesetzt ist (Standardwert: "home")
if (empty($_GET["seite"])) {
  $seite = "home";
} else {
  $seite = $_GET["seite"];
}

echo "<pre>";
print_r($_GET);
echo "</pre>";

// Prüfen, ob in $seite ein gültiger Wert steht (nicht manipuliert)

if ($seite == "registrieren") {
  $include_datei = "php/registrieren.php";
  $seitentitel = "Registrieren";
  $meta_description = "wifi";//beschreibung und gut für such maschine
} else if ($seite == "passwort") {
  $include_datei = "php/zufallspasswort.php";
  $seitentitel = "Zufallspasswort";
} else {
  // Seite gibt's bei uns nicht -> error 404 ausgeben
  header("HTTP/1.0 404 Not Found"); // für Suchmaschine
  $include_datei = "404.php";
  $seitentitel = "Error 404";
  echo ">" . in_array("registrieren", $seite) . "<";
}

// Dateien wieder Block für Block zusammensetzen
include "zufallspasswort.php";
include "checkpassword.php";
include $include_datei;
include "registrieren.php";
