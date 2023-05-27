<!DOCTYPE html>
<html lang="de">
<head>
    <link rel="stylesheet" href="../css/admin_form.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Speisekarte Verwaltung</title>
</head>
<body>
        <nav>
            <ul>
                <li><a href="index.php">Start</a></li>
                <li><a href="produkte_liste.php">Produkte</a></li>
                <li><a href="kategorien_liste.php">Kategorien</a></li>
                <li><a href="logout.php">Ausloggen</a>
                <br>
                    Eingeloggt als: <?php echo $_SESSION["benutzername"];?>
                </li>
            </ul>
        </nav>



