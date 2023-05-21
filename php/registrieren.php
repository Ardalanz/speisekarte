<?php
$fms = array();
$er = false;

if (!empty($_POST)) {
	if (empty($_POST["benutzername"])) {
		$fms[] = "namen eingeben.";
	} else if (mb_strlen($_POST["benutzername"]) < 4 ) {
		$fms[] = "ihre name ist zu kurz.";
	}
	
	if (empty($_POST["passwort"])) {
		$fms[] = "passwort eingeben.";
	} else if (mb_strlen($_POST["passwort"]) < 6 ) {
		$fms[] = "ihre passwort ist zu kurz.";
	} 


	if (empty($_POST["email"])) {
		$fms[] = "bitte geben sie ihren email an.";
	} else if ( preg_match("/^[^@]+@[^@]+\.[a-z]{2,6}$/i", "email") ) {
		echo "password ist zulässig.";
	}

	
	if (empty($fms)) {
		$er = true;

		$email = 'name@mydomain.com';
if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
   
   echo $email . ' is a valid email address.';
}
else {
   
   echo $email . ' is NOT a valid email address.';
}

		$inhalt = "Registierirung: 
            benutzername: {$_POST["benutzername"]}
            E-Mail: {$_POST["email"]}
            passwort: {$_POST["passwort"]}
            ";

		$datainame = date("Y-m-d_H-i-s");

		file_put_contents("registrierungen/{$datainame}.txt",$inhalt);

		
	}
}

?>

<div class='wrapper'>
	<div class='row'>
		<div class='col-xs-12'>
			<h1>Registrierung</h1>
		</div>
	</div>
</div>

<?php

if (!empty($fms)) {
	echo "<strong>Es sind folgenden fehler aufgetreten</strong>";
	echo "<ul>";
	foreach ($fms as $fm) {
		echo "<li>";
		echo $fm;
		echo "</li>";
	}
	echo "</ul>";
}

?>
<?php
if ($er) {
	echo "<h3> Registierirung Erfolgreich </h3>";
} else {

?>
<form id='register-form' method="post" action="index.php?seite=registrieren">
	<div class="wrapper">
		<div class='row'>
			<div class='col-xs-12 col-sm-12'>
				<label for='username'>Benutzername</label>
				<input type='text' id='username' name='benutzername' value="<?php 
                    if(!empty($_POST["benutzername"])) {
                        echo $_POST["benutzername"];
                    } 
                    ?>" />
			</div>
			<div class='col-xs-12 col-sm-12'>
				<label for='password'>Passwort</label>
				<input type='password' id='password' name='passwort' value="<?php 
                    if(!empty($_POST["passwort"])) {
                        echo $_POST["passwort"];
                    } 
                    ?>"/>
			</div>
			<div class='col-xs-12 col-sm-12'>
				<label for='email'>E-Mail</label>
				<input type='text' id='email' name='email' value="<?php 
                    if(!empty($_POST["email"])) {
                        echo $_POST["email"];
                    } 
                    ?>"/>
			</div>
			<div class='col-xs-12 col-sm-12'>
				<input type='checkbox' id='toc' name='agb' />
				<label for='toc'>Ich akzeptiere die AGB.</label>
			</div>
			<div class='col-xs-12'>
				<input type='submit' value='Registrieren' />
			</div>
		</div>
	</div>
</form>
<?php
}
?>