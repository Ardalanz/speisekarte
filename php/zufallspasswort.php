<?php 
	function zufallspasswort($zufällig){
		$teil = explode("-", $zufällig);
        return $teil[2] . "." . $teil[1]. "." . $teil[0];
		
	}



	$zufällig = array("1", "g", "m", "a", "m", "7","4", "2");
	echo count($zufällig);
	$index = array_rand($zufällig);
	echo $zufällig[$index];

	echo "<br>";
	echo password_hash("12345", PASSWORD_DEFAULT );

	
	?>
		<div id='journal'>
			<div class='wrapper'>
					<div class='row'>
						<div class='col-xs-12'>
								<h1>Zufallspasswort</h1>
						</div>
					</div>
					
					<div class='row'>
						<div class='col-xs-12'>
							Hier sollen die Passwörter ausgegeben werden.
						</div>
					</div>

			</div>
		</div>
