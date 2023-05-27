<?php
include "funktionen.php";
ist_eingeloggt();


include "kopf.php";
?>




    <link rel="stylesheet" href="../css/adminForm.css">

        <style>

            @font-face {
            font-family: MarckScripts;
            src: url(../fonts/PTSerif-BoldItalic.ttf);
            font-weight: bold;
            }
            h1,
            table,
            thead,
            tbody,
            tr,
            td {
                margin: 10px;
                padding: 25px;
                border-style: inset;
                max-width: 100%;
                height: 100%;
                margin-inline: auto;
                box-shadow: 1px 1px 1px 1px transparent;
                border-radius: 1%;
                text-decoration: none;
            }
            header {
                margin: 10px;
            }
            body {
                background: linear-gradient(55deg, #000, #000000, #00000025, #000000);
                background-size: 400% 800%;
                animation: gradient 30s ease infinite;
                color: rgb(255, 255, 255);
            }
            h1 {
                color: white;
            }
            p {
                color: var(--dark-orange);
                margin: 20px;
                text-align: center;
                text-decoration: underline;
                box-shadow: 5px 5px 50px 5px var(--dark-orange);
            }
            nav {
                margin: 10px;
                padding: 10px;
                color: var(--dark-orange);
                margin: 20px;
                text-align: center;
                text-decoration: none;
                box-shadow: 5px 5px 50px 5px var(--dark-orange);
                width: 100%;
                font-size: 3rem;
            }
            a:hover {
                color: #ffffff;
                box-shadow: 1px 1px 5px 1px var(--dark-orange);
            }


        </style>

    <h1>Administrationsbereich</h1>
    <p>Willkommen im geheimen Admin-Bereich<p>



    
<?php
include "fuss.php";