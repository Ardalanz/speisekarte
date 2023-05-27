<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rezepteverwaltung</title>
</head>
<body>

    <link rel="stylesheet" href="../css/adminForm.css">
    
        <nav>
            <ul>
                <li><a href="index.php">Start</a></li>
                <li><a href="zutaten_liste.php">Zutaten</a></li>
                <li><a href="rezepte_liste.php">Rezepte</a></li>
                <li><a href="logout.php">Ausloggen</a>
                <br>
                    Eingeloggt als: <?php echo $_SESSION["benutzername"];?>
                </li>
            </ul>
        </nav>



