<!doctype html>
<html lang="en" >
	<head>
		<meta charset="utf-8" />
		<title><?php echo($_SERVER["PHP_SELF"]); ?></title>

		<!-- Observera vår CSS-class disableLink -->
		<style>
			.disableLink {
				pointer-events: none;
				opacity: 0.2;
			}
		</style>

	</head>
	<body>
		<div>
			<?php
				//Exempel med sessioner!
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
					session_destroy();
				}
				$disabled = true; //Skapar en flagga som kollar om disablelink

				session_start();
				session_regenerate_id(true);

				if(!isset($_GET["start"]) && !isset($_GET["test"]) && !isset($_GET["avsluta"]) && !isset($_SESSION["dateandtime"])){
						deleteSession();
				}


			?>

			<a href="<?php echo($_SERVER["PHP_SELF"]); ?>?start=true">Starta session</a>
			<a href="<?php echo($_SERVER["PHP_SELF"]); ?>?test=true" <?php if($disabled===true){
				echo("class='disableLink'");
			}
			?>>Testa session</a>
			<a href="<?php echo($_SERVER["PHP_SELF"]); ?>?avsluta=true" <?php ?>>Avsluta session</a>
		</div>
	</body>
</html>
