<?php

	class OneDice {
		
		private $nbr;
		
		public function setNbr($inDiceNbr) {
			
			if($inDiceNbr > 0 && $inDiceNbr < 7) {
				$this->nbr = $inDiceNbr;
			} else {
				$this->nbr = 1;
			}
		}
		
		public function getNbr() {
			return $this->nbr;
		}
		
		public function __construct($inNbr) {
			$this->setNbr($inNbr);
		}
	}