<!doctype html>
<html lang="en" >

	<head>
		<meta charset="utf-8" />
		<title>Roll the dice...</title>
		<style>
			.disableLink {
				pointer-events: none;
				opacity: 0.2;
			}
		</style>
		<link href="style/style.css" rel="stylesheet" />
		<link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" />
	</head>

	<body>

		<div>

			<?php
				//Skapar en session som kommer generera ett nytt id varje gång sidan körs
				session_start();
				session_regenerate_id(true);

				//Skapar en flagga som har värdet true per automatik
				$disabled = true;

				//Skapar funktionen deleteSession som tar bort sessionen när man klickar på länken linkExit
				function deleteSession(){
					session_unset(); //Tömmer det tidigare innehållet i sessionskakan
					if(ini_get("session.use_cookies")){ //Ta reda på om sessionskakor har använts
						$data = session_get_cookie_params(); //Hämtar datan som finns i kakan, värde.

						$path = $data["path"];
						$domain = $data["domain"];
						$secure = $data["secure"];
						$httponly = $data["httponly"];

						$name = session_name();

						setcookie($name, "", time() - 3600, $path, $domain, $secure, $httponly);
					}
					//Förstör sessionen med session_destroy
					session_destroy();
				}
				//Om användaren inte har klickat på linkRoll, linkNewGame, linkExit och sessionsvariablerna nbrOfRounds och sumOfAllRounds inte är skapade
				//Så anropar man deleteSession och tar bort sessionen
				if(!isset($_GET["linkRoll"]) && !isset($_GET["linkNewGame"]) && !isset($_GET["linkExit"]) && !isset($_SESSION["nbrOfRounds"]) &&!isset($_SESSION["sumOfAllRounds"])){
						deleteSession();
				}
				//När användaren klickar på länken linkRoll så inkluderas först OneDice.php och SixDices.php
				if(isset($_GET["linkRoll"])){

				include("include/OneDice.php");
				include("include/SixDices.php");

				//Skapar en instans av SixDices och tilldelar variablen $oSixDices SixDices innehåll
				$oSixDices = new SixDices();
				//variabeln $oSixDices
				$oSixDices -> rollDices();
				//Variabeln $output tilldelas $oSixDices och
				$output = $oSixDices->svgDices();
				//Skriver ut det som finns i $output
				echo($output);

				//Skapar sessoionsvariabeln nbrOfRounds och stoppar den i variabeln $nor
				//$nor tilldelas sedan $nor + 1 för att öka på värdet varje gång användaren trycker på linkRoll
				//Sedan stoppar man tillbaka $nor i sessionsvariabeln nbrOfRounds med det nya medelvärdet
				//Sist skriver man ut innehåller på $nor
				$nor = $_SESSION["nbrOfRounds"];
				$nor = $nor += 1;
				$_SESSION["nbrOfRounds"] = $nor;
				echo("<p>" . "Antal slag: " . $nor . "</p>");

				//Skapar sessoionsvariabeln sumOfAllRounds och stoppar den i variabeln $sor
				//$sum tilldelas $oSixDices och funktionen sumDices som räknar ut summan av 6 slagna tärningar
				//$sor tilldelas sedan summan av de slagna tärningarna och sedan stoppar man tillbaka värdet på $sor i sessionsvariabeln sumOfAllRounds
				$sor = $_SESSION["sumOfAllRounds"];
				$sum = $oSixDices->sumDices();
				$sor = $sor += $sum;
				$_SESSION["sumOfAllRounds"] = $sor;
				//Skriver ut summan av alla slagna tärningar
				echo("<p>" . "Summa: " . $sum . "</p>");
				//skriver ut den totala summan från föregående rundor
				echo("<p>" . "Summan av de förra " . $nor . " slagen är " . $sor . "</p>");

				//Skriver ut medelvärdet på rundan som nyss är slagen, tar summan / antal slag
				echo("<p>" . "Medel: " . ($sum/$nor) . "</p>");

				$disabled = false;
				}
				//Om användaren klickar på linkNewGame så kommer texten New Game! upp på skärmen
				//och sessionsvariablerna nbrOfRounds och sumOfAllRounds skapas och tilldelas värdet 0
				//Variabeln $disable får värdet false vilket gör det möjligt att trycka på länkarna linkroll och linkExit
				if(isset($_GET["linkNewGame"])){
					echo ("<p>" . "New Game!" . "</p>");
					$_SESSION["nbrOfRounds"] = 0;
					$_SESSION["sumOfAllRounds"] = 0;

					$disabled = false;

				}
				//Om användaren trycker på Exit länken så anropas funktionen deleteSession() och variabeln $disable får värdet true
				//Vilket gör linkRoll och linkExit oklickbara
				if(isset($_GET["linkExit"])){

					deleteSession();

					$disabled = true;
				}
			?>

		</div>
		<!-- De klickabara länkarna linkRoll, linkNewGame och linkExit -->
		<!-- Sätter en if sats på länkarna linkRoll och linkExit som kollar om värdet på $disable = true, isåfall ska länkarna inte gå att trycka på -->
		<a href="<?php echo($_SERVER["PHP_SELF"]); ?>?linkRoll=true"  class="btn btn-primary <?php if($disabled){ echo("disableLink");}?>">Roll six dices</a>
		<a href="<?php echo($_SERVER["PHP_SELF"]);?>?linkNewGame=true" class="btn btn-primary" >New game</a>
		<a href="<?php echo($_SERVER["PHP_SELF"]);?>?linkExit=true" class="btn btn-primary <?php if($disabled){echo("disableLink");}?>">Exit</a>

		<script src="script/animation.js"></script>

	</body>

</html>
