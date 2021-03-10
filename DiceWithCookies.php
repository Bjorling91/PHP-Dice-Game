<!doctype html>
<html lang="en" >

	<head>
		<meta charset="utf-8" />
		<title>Roll the dice...</title>
		<link href="style/style.css" rel="stylesheet" />
		<link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" />
	</head>

	<body>

		<div>

		<?php
			//Skapar en flagga som har värdet true per automatik
			$disabled = true;
			//När användaren klickar på knappen btnRoll så inkluderas först OneDice.php och SixDices.php
			if(isset($_POST["btnRoll"])){

			include("include/OneDice.php");
			include("include/SixDices.php");

			//Skapar en instans av SixDices och tilldelar variablen $oSixDices SixDices innehåll
			$oSixDices = new SixDices();
			//variabeln $oSixDices tilldelas funktionen rollDices
			$oSixDices -> rollDices();
			//Variabeln $output tilldelas $oSixDices och funktionen svgDices
			$output = $oSixDices->svgDices();
			//Skriver ut det som finns i $output
			echo($output);

			//Skapar variabeln $nor och tilldelar den kakan nbrOfRounds
			//$nor tilldelas sedan $nor + 1 för att öka på värdet varje gång användaren trycker på btnRoll
			//Skapar en kaka som får namnet nbrOfRounds och värdet av $nor
			//Sedan skiver vi ut värdet av $nor varje gång man trycker på btnRoll
			$nor = $_COOKIE["nbrOfRounds"];
			$nor = $nor += 1;
			setcookie("nbrOfRounds", $nor);
			echo("<p>" . "Antal slag: " . $nor . "</p>");

			//Skapar variabeln $sor och tilldelar den kakan sumOfAllRounds
			//Variabeln $sum tilldelas $variabeln $oSixDices och funktionen sumDices
			//Variabeln $sor tilldelas värdet av $sor tillsammans med $sum
			//Skapar en kaka som får namnet sumOfAllRounds och värdet av $sor varje gång man trycker på btnRoll
			$sor = $_COOKIE["sumOfAllRounds"];
			$sum = $oSixDices->sumDices();
			$sor = $sor += $sum;
			setcookie("sumOfAllRounds", $sor);
			//Skriver ut summan av detta slagen
			echo("<p>" . "Summa: " . $sum . "</p>");
			//Skriver ut alla antal slag och den totala summan från föregående rundor
			echo("<p>" . "Summan av de förra " . $nor . " slagen är " . $sor . "</p>");

			//Skriver även ut medelvärdet av detta slag
			echo("<p>" . "Medel: " . ($sum/$nor) . "</p>");

			//när man tryckt på btnRoll så får flaggan värdet false vilket gör att man kan trycka på btnRoll igen
			//utan att behöva skapa ett nytt spel varje gång
			$disabled = false;
			}

			//Om användaren trycker på knappen btnNewGame så kommer texten New Game! upp på skärmen
			//Kakorna nbrOfRounds och sumOfAllRounds skapas och tilldelas värdet 0
			//Flaggan får värdet false vilket glr det möjigt att trycka på alla knappar
			if(isset($_POST["btnNewGame"])){
				echo ("<p>" . "New Game!" . "</p>");
				setcookie("nbrOfRounds", 0);
				setcookie("sumOfAllRounds", 0);
				$disabled = false;

			}
			//Om användaren trycker på knappen btnExit så tas båda kakorna nbrOfRounds och sumOfAllRounds bort
			if(isset($_POST["btnExit"])){
				setcookie("nbrOfRounds", "", time() - 3600);
				setcookie("sumOfAllRounds", "", time() - 3600);
			}
			//En if sats som kollar om kakorna nbrOfRounds och sumOfAllRounds finns lagrade på klienten
			//Och om användaren inte klickat på btnExit, btnNewGame eller btnRoll så ska flaggan få värdet false
			//Detta gör det möjligt att kopiera url:n, klistra in den i en ny flik och fortfarande kunna klicka på knapparna
			if(isset($_COOKIE["nbrOfRounds"]) && isset($_COOKIE["sumOfAllRounds"]) &&
			!isset($_POST["btnExit"]) && !isset($_POST["btnNewGame"]) && !isset($_POST["btnRoll"]) ) {

			$disabled = false;

		}
		?>
		</div>
		<!-- Knappen btnRoll, knappen innehåller en if sats som kollar om $disable = true,
		isåfall skirvs disabled ut och knappen går inte att trycka på-->
		<form action="<?php ?>" method="post">
			<input type="submit" name="btnRoll" class="btn btn-primary" value="Roll six dices" <?php
			if($disabled){
				echo("disabled");
			}
			?>/>
			<!-- btnNewGame kappen -->
			<input type="submit" name="btnNewGame" class="btn btn-primary" value="New Game" />
			<!-- Knappen btnExit, knappen innehåller en if sats som kollar om $disable = true,
			isåfall skirvs disabled ut och knappen går inte att trycka på-->
			<input type="submit" name="btnExit" class="btn btn-primary" value="Exit" <?php
			if($disabled){
					echo("disabled");
			}?>/>
		</form>

		<script src="script/animation.js">
		</script>
	</body>

</html>
