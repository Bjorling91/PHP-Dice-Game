<?php

	class SixDices {

		private $sixDices;

		public function __construct() {
			$this->sixDices = array();
		}

		public function rollDices() {

			for($counter = 0; $counter < 6; $counter++) {
				array_push( $this->sixDices, new OneDice( mt_rand(1, 6) ) );
			}
		}

		function svgDices() {

			/*
				<img src="https://openclipart.org/download/282132/Die6.svg" />
				<img src="https://openclipart.org/download/282131/Die5.svg" />
				<img src="https://openclipart.org/download/282130/Die4.svg" />
				<img src="https://openclipart.org/download/282129/Die3.svg" />
				<img src="https://openclipart.org/download/282128/Die2.svg" />
				<img src="https://openclipart.org/download/282127/Die1.svg" />
			*/

			$pathNbr = array(1 => 27, 2 => 28, 3 => 29, 4 => 30, 5 => 31, 6 => 32);

			$sixDices = "<div style='background-color: green;'><p>Senaste omgången:</p>";

			for($counter = 0; $counter < 6; $counter++) {
				$sixDices .= "<img src='https://openclipart.org/download/2821";
				$sixDices .= $pathNbr[ $this->sixDices[$counter]->getNbr() ];
				$sixDices .= "/Die" . $this->sixDices[$counter]->getNbr() . ".svg' alt='Dice" . ( $counter + 1) . "' />" . PHP_EOL;
			}

			return $sixDices . "</div>";

		}

		function sumDices() {

			$sum = 0;

			for($counter = 0; $counter < 6; $counter++) {
				$sum += $this->sixDices[$counter]->getNbr();
			}

			return $sum;
		}

		function dumpDices() {
			echo("<pre>");
			print_r($this->sixDices);
			var_dump($this->sixDices);
			echo("</pre>");
		}

	}
