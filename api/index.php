<?php


//Aufruf erfolgt: "http://localhost/JWE22/Speise_Karte/api/" => .htaccess - Datei

//http://localhost/JWE22/Speise_Karte/api/v1/rezepte => gibt eine Liste aller Rezepte zurück
//http://localhost/JWE22/Speise_Karte/api/v1/rezepte/1 => gibt das rezept mit der ID 1 inkl. Zutaten zurück

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

            # hier rufe ich die Funktion auf, die ein Rezept zurückgibt 
            echo json_encode('hier kommt ein array ein Rezept');
        }
        else {
            # hier rufe ich die Funktion auf, die alle Rezept zurückgibt 
            $rezepte = [
                [
                    'id' => 1,
                    'name' => 'Margarita',
                    'url' =>'http://localhost/jwe22/Speise_Karte/img/Pizza%20Margaritha%20Mild.jpg',
                    'preis' => '20€'
                ],
                [
                    'id' => 2,
                    'url' => 'http://localhost/jwe22/Speise_Karte/img/pizza%20quattro%20formaggi.jpg',
                    'name' => 'Fungi',
                    'preis' => '10€'
                ]
            ];
            echo json_encode($rezepte);
        }
        exit;
    default:
        // Es wurde eine methode aufgerufen die nicht existiert
        fehler("Die Methode '{$parameter[0]}' exstiert nicht.");
}