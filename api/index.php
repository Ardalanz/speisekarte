<?php

require "../admin/funktionen.php";

// Aufruf erfolgt: "http://localhost/Speisekarte/speisekarte/api/" => .htaccess - Datei

// http://localhost/Speisekarte/speisekarte/api/v1/rezepte => gibt eine Liste aller Rezepte zurück
// http://localhost/Speisekarte/speisekarte/api/v1/kategorie => gibt eine Liste aller Rezepte zurück
// http://localhost/Speisekarte/speisekarte/api/v1/rezepte/1 => gibt das rezept mit der ID 1 inkl. Zutaten zurück


header("Content-Type: application/json;");

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
    case "rezepte":
        # wenn ich eine id für das Rezept habe 
        if (!empty($parameter[1])) {
            // ID wurde übergeben - Detail eines Rezepts ausgeben
            $ausgabe = array(
              "status" => 1
            );
            // Rezeptdaten ermitteln
            $sql_rezept_id = escape($parameter[1]);
            $result = query("SELECT * FROM rezepte WHERE id = '{$sql_rezept_id}' ");
            $rezept = mysqli_fetch_assoc($result);
            if (!$rezept) {
              fehler("Mit der id '{$parameter[1]}' wurde kein Rezept gefunden.");
            }
            $ausgabe["rezept"] = $rezept;
            // Benutzerdaten ermitteln und an Ausgabe anhängen
            $result = query("SELECT id, benutzername, email FROM benutzer WHERE id = '{$rezept["benutzer_id"]}' ");
            $ausgabe["benutzer"] = mysqli_fetch_assoc($result);
            // Zutaten ermitteln und an Ausgabe anhängen
            $result = query("SELECT zutaten.*, zutaten_zu_rezepte.menge, zutaten_zu_rezepte.einheit
                FROM zutaten_zu_rezepte JOIN zutaten ON zutaten_zu_rezepte.zutaten_id = zutaten.id
                WHERE zutaten_zu_rezepte.rezepte_id = '{$sql_rezept_id}'
                ORDER BY zutaten_zu_rezepte.id
            ");
            $ausgabe["zutaten"] = array();
            while ($zutat = mysqli_fetch_assoc($result)) {
              $ausgabe["zutaten"][] = $zutat;
            }
        
            echo json_encode($ausgabe);
          } else {
            // Liste aller Rezepte
            $ausgabe = array(
              "status" => 1,
              "result" => array()
            );
            $where = "";
            if (!empty($_GET["suche"])) {
              $sql_suche = escape($_GET["suche"]);
              $where = "WHERE rezepte.titel LIKE '%{$sql_suche}%'";
            }
            $result = query("SELECT rezepte.id, rezepte.titel, rezepte.img_url, rezepte.preis, benutzer.benutzername
              FROM rezepte LEFT JOIN benutzer ON rezepte.benutzer_id = benutzer.id
              {$where}
              ORDER BY rezepte.id ASC");
            while ($row = mysqli_fetch_assoc($result)) {
              $ausgabe["result"][] = $row;
            }
            echo json_encode($ausgabe);
          }

        exit;
        case 'kategorie':
            # gleich wie in Liste aller Rezepte!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
            
            exit;
    default:
        // Es wurde eine methode aufgerufen die nicht existiert
        fehler("Die Methode '{$parameter[0]}' exstiert nicht.");
}