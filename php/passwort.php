<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php

    # error_reporting(E_ERROR | E_PARSE);

    require 'checkpassword.php';

    // home kommt von checkpassword.php
    echo $home;

    $conn = new mysqli('127.0.0.1', 'root', '', 'speise_karte');

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $result = $conn->query("SELECT * FROM speise_karte");
    ?>
    <table>
        <tr>
            <th>Nr</th>
            <th>Speise</th>
        </tr>
        
        <?php
    while($row = $result->fetch_assoc()) {
        echo "<tr><td>{$row['nummer']}</td><td>{$row['name']}</td></tr>";
    }
        ?>
        
    </table>
</body>
</html>
