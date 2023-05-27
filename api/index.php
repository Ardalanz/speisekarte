<?php

require "../admin/funktionen.php";

// Aufruf erfolgt: "http://localhost/Speisekarte/speisekarte/api/" => .htaccess - Datei

// http://localhost/Speisekarte/speisekarte/api/v1/produkte/list => gibt eine Liste aller Produkte zurück
// http://localhost/Speisekarte/speisekarte/api/v1/produkte/1 => gibt das produkt mit der ID 1
// http://localhost/Speisekarte/speisekarte/api/v1/kategorie/list => gibt eine Liste aller Kategorien zurück
// http://localhost/Speisekarte/speisekarte/api/v1/kategorie/1 => gibt eine Kategorie zurück
// http://localhost/Speisekarte/speisekarte/api/v1/kategorie/1/produkte => gibt alle Produkte einer Kategorie zurück


header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

function fehler($message)
{
    header("HTTP/1.1 404 Not Found");
    echo json_encode(
        array(
            "status" => 0,
            "error"  => $message
        )
    );
    exit;
}

// GET-Parameter aus request_uri entfernen
$request_uri_ohne_get = explode("?", $_SERVER["REQUEST_URI"])[0];
// Aus Anfrage-URI die gewünschte Methode ermitteln
$teile     = explode("/api/", $request_uri_ohne_get, 2);
$parameter = explode("/", $teile[1]);

// array_shift entfernt den ersten Wert aus einem Array und gibt ihn zurück
// aus diesem lesen wir hier gleich unsere Version raus.
$api_version = ltrim(array_shift($parameter), "vV");
if (empty($api_version)) {
    fehler("Bitte geben Sie eine API-Version an.");
}

// Leere Einträge aus Parameter-Array entfernen
foreach ($parameter as $k => $v) {
    if (empty($v)) {
        unset($parameter[$k]);
    }
    else {
        // Alle Parameter in Kleinbuchstaben umwandeln, falls diese falsch daherkommen
        $parameter[$k] = mb_strtolower($v);
    }
}
// Indizes neu zuordnen falls mit doppelten Schrägstrichen aufgerufen wird
$parameter = array_values($parameter);

if (empty($parameter)) {
    fehler("Nach der Version wurde keine Methode übergeben. Prüfen Sie Ihren Aufruf!");
}

// Ab hier ist in $parameter[0] immer die Hauptmethode drin,
// in $parameter[1], etc. die genauere Spezifizierung was angefragt wurde

switch ($parameter[0]) {
    case "produkte":
        # wenn ich eine id für das Produkt habe 
        if ($parameter[1] != "list") {
            // ID wurde übergeben - Detail eines Produkts ausgeben
            $ausgabe = array(
              "status" => 1
            );
            // Produktdaten ermitteln
            $sql_produkt_id = escape($parameter[1]);
            $result = query("SELECT * FROM produkte WHERE id = '{$sql_produkt_id}' ");
            $produkt = mysqli_fetch_assoc($result);
            if (!$produkt) {
              fehler("Mit der id '{$parameter[1]}' wurde kein Produkt gefunden.");
            }
            $ausgabe["produkt"] = $produkt;
            $result = query("SELECT * from produkte where id = '{$sql_produkt_id}'");
        
            echo json_encode($ausgabe);
          } else {
            // Liste aller Produkte
            $ausgabe = array(
              "status" => 1,
              "result" => array()
            );
            $result = query("SELECT * FROM produkte where anzeigen != 'nein' ORDER BY titel ASC");

            while ($row = mysqli_fetch_assoc($result)) {
              $ausgabe["result"][] = $row;
            }
            echo json_encode($ausgabe);
          }

        exit;
        case 'kategorien':

        if ($parameter[1] == 'list') {
            // Liste aller Produkte
            $ausgabe = array(
              "status" => 1,
              "result" => array()
            );
            $result = query("SELECT * FROM kategorien ORDER BY name ASC");

            while ($row = mysqli_fetch_assoc($result)) {
              $ausgabe["result"][] = $row;
            }
            echo json_encode($ausgabe);

        } else if ($parameter[2] == 'produkte') {
          $ausgabe = array(
            "status" => 1,
            "result" => array()
          );
          $result = query("SELECT * FROM produkte where anzeigen != 'nein' and kategorie_id = '{$parameter[1]}' ORDER BY titel ASC");

          while ($row = mysqli_fetch_assoc($result)) {
            $ausgabe["result"][] = $row;
          }
          echo json_encode($ausgabe);
        } else {
          
        }
            
            exit;
    default:
        // Es wurde eine methode aufgerufen die nicht existiert
        fehler("Die Methode '{$parameter[0]}' exstiert nicht.");
}