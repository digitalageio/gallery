<?php
	class piece {
		
		public $type;
		public $team;
		public $side;
		public $imgUrl;
		public $initPos;
		public $key;
		public $axes;
		
	
		function __construct($key){
			include('pieceRoster.php');
			$this->key = $key;
			$this->type = $roster[$key]['type'];
			$this->team = $roster[$key]['team'];
			$this->name = $roster[$key]['pos'];
			$this->imgUrl = $roster[$key]['imgUrl'];
			$this->initPos = $roster[$key]['default'];
		}

		function moveList($x,$y){
			$moveList = array();
			$a = $this->axisArray();
			if($this->type === 'knight'){
				for($i=0;$i<8;$i++){
					$moveList[$i] = array();
					$xy[0] = $x + $a[$i][0]; 	
					$xy[1] = $y + $a[$i][1]; 	
						if($xy[0] > 0 && $xy[0] < 9 && $xy[1] > 0 && $xy[1] < 9){
							array_push($moveList[$i],$xy);
						}
				}
			} else {
			for($i=0;$i<8;$i++){
				$moveList[$i] = array();
				if($a[$i] > 0){
					for($j=1;$j<=$a[$i];$j++){
						$xy = array();
						$axes = array(array(0,1),array(1,1),array(1,0),array(1,-1),array(0,-1),array(-1,-1),array(-1,0),array(-1,1));
						$xy[0] = $x + ($j * $axes[$i][0]);
						$xy[1] = $y + ($j * $axes[$i][1]);
						if($xy[0] > 0 && $xy[0] < 9 && $xy[1] > 0 && $xy[1] < 9){
							array_push($moveList[$i],$xy);
						}
						
					}
				}
			}
			}
			return $moveList;
		}

		function axisArray(){
			switch($this->type){									
				case 'pawn':
					$axis = array();
					if($this->team === 'white'){
					$axis[0] = 1;	
					$axis[1] = 1;	
					$axis[2] = 0;	
					$axis[3] = 0;	
					$axis[4] = 0;	
					$axis[5] = 0;	
					$axis[6] = 0;	
					$axis[7] = 1;
					} else if($this->team === 'black'){
					$axis[0] = 0;
					$axis[1] = 0;
					$axis[2] = 0;
					$axis[3] = 1;
					$axis[4] = 1;
					$axis[5] = 1;
					$axis[6] = 0;
					$axis[7] = 0;
					}
				break;
				case 'rook':
					$axis = array();
					$axis[0] = 7;	
					$axis[1] = 0;	
					$axis[2] = 7;	
					$axis[3] = 0;	
					$axis[4] = 7;	
					$axis[5] = 0;	
					$axis[6] = 7;	
					$axis[7] = 0;
				break;
				case 'knight':
					$axis = array();
					$axis[0] = array(1,2);	
					$axis[1] = array(2,1);	
					$axis[2] = array(2,-1);	
					$axis[3] = array(1,-2);	
					$axis[4] = array(-1,-2);	
					$axis[5] = array(-2,-1);	
					$axis[6] = array(-2,1);	
					$axis[7] = array(-1,2);		
				break;
				case 'bishop':
					$axis = array();
					$axis[0] = 0;	
					$axis[1] = 7;	
					$axis[2] = 0;	
					$axis[3] = 7;	
					$axis[4] = 0;	
					$axis[5] = 7;	
					$axis[6] = 0;	
					$axis[7] = 7;
				break;
				case 'queen':
					$axis = array();
					$axis[0] = 7;	
					$axis[1] = 7;	
					$axis[2] = 7;	
					$axis[3] = 7;	
					$axis[4] = 7;	
					$axis[5] = 7;	
					$axis[6] = 7;	
					$axis[7] = 7;
				break;
				case 'king':
					$axis = array();
					$axis[0] = 1;	
					$axis[1] = 1;	
					$axis[2] = 1;	
					$axis[3] = 1;	
					$axis[4] = 1;	
					$axis[5] = 1;	
					$axis[6] = 1;	
					$axis[7] = 1;
				break;
	
			}
			return $axis;
		}
	}
?>
