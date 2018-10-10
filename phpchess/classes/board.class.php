<?php

	class board {
		public $board = array();
		public $squares = array();
		public $pieces = array();
		public $selectedSquare = '';
		public $selectedPiece = '';
		public $designations = array(1 => 'a','b','c','d','e','f','g','h');

		function __construct($default,$id){
		//construct board from default settings
			include('piece.class.php');
			include('pieceRoster.php');
			if($default){ 
        			$i=1;
        			for($i=1;$i<9;$i++){
                			$j=1;
                			for($j=1;$j<9;$j++){
						$this->squares[$this->designations[$j] . $i] = array();
						$this->squares[$this->designations[$j] . $i]['rank'] = $i;
						$this->squares[$this->designations[$j] . $i]['file'] = $j;
					}
				}
				foreach($roster as $k => $r){
					$this->pieces[$k] = new piece($r);
				}
        		} 
		}

		function setupBoard($default,$config){
		//setup pieces in the default configuration
			include('defaultLayout.php');
			if($default){
				$this->board = $defaultLayout;
			} else $this->board = json_decode($config);
		}

		function selectSquare($square){
			$this->selectedSquare = $square;
			$n = $this->findPair("square",$this->selectedSquare);
			if($this->board[$n]["piece"] > 0){
				$piece = $this->board[$n]["piece"] > 0){
			}
			$file = $this->squares[$square]["file"];
			$rank = $this->squares[$square]["rank"];
			return $this->moveValidity($file,$rank);
		}

		function moveValidity($piece,$square){
			$validMoves[0] = array();
			$validMoves[1] = array();
			$possible = $this->piecesArray[$piece]->moveList($this->squareArray[$square]["file"],$this->squareArray[$square]["rank"]);
			foreach($possible as $pairs){
				foreach($pairs as $p){
					$s = $this->designations[$p[0]] . $p[1];
					if($this->isUnoccupied($s)){
						array_push($validMoves[0],$s);
					} else if($this->squareArray[$square]["piece"]->team === $this->squareArray[$s]["piece"]->team){
						break;
					} else array_push($validMoves[1],$s);
				}
			}
			return $validMoves; 
		}
		
		function movePiece($piece,$square){	
			$this->board[$this->findPair("piece",$piece)]["piece"] = 0;
			$this->board[$this->findPair("square",$square)]["piece"] = $piece;
		}

		function findPair($type,$id){
			foreach($this->board as $n => $b){
				if($b[$type] === $id){
					return $n;
				}
			}
		}

	}
?>

