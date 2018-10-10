<?php
	require_once('board.class.php');
	$board = new board(true,'');
	$board->setupBoard(true,'');
	$squares = array();
	$dimension = 80;
	$data = file_get_contents("php://input");
	$objData = json_decode($data);
	$dir = $objData->dir;
	$selectedPiece = $objData->piece;
	$selectedSquare = $objData->square;
	if(!empty($selectedSquare)){
		$moves = $board->selectSquare($selectedSquare);//["piece"]->moveList($board->squareArray[$selectedSquare]["file"],$board->squareArray[$selectedSquare]["rank"]);
	}
	//var_dump($objData);
	$bgColorWhite = 'gray';
	$textColorWhite = 'white';
	$bgColorBlack = 'black';
	$textColorBlack = 'black';
        foreach($board->squareArray as $label => $square_param){
			$square_css = array();
			$square_css['file'] = $square_param["file"];
			$square_css['rank'] = $square_param["rank"];
			$i = $square_param["rank"];
			$j = $square_param["file"];	
	if(!empty($selectedSquare)){
			if(in_array($label,$moves)){
				$square_css["filterRGBA"] = 'rgba(255,0,0,0.25)';	
			} else $square_css["filterRGBA"] = 'rgba(0,0,0,0.0)';
	}	
			$square_css["label"] = $label;
			if(!empty($square_param["piece"])){
				$square_css["piece"] = $square_param["piece"]->key;
				$square_css["pieceType"] = $square_param["piece"]->type;
				$square_css["imgUrl"] = 'url(' . $square_param["piece"]->imgUrl . ')';
				//if($selectedPiece === $square_param["piece"]->key){
				//	$square_css["filterRGBA"] = 'rgba(255,0,0,0.25)';	
				//} else $square_css["filterRGBA"] = 'rgba(0,0,0,0.0)';	
			} else {
				$square_css["piece"] = 'none';
				$square_css["imgUrl"] = 'url("")';
			}
			//$square_css['board'] = $board;
			$square_css['textAlign'] = 'center';
			$square_css['width'] = $dimension . 'px';
			$square_css['height'] = $dimension . 'px';
			$square_css['margin'] = '0 auto';
			$square_css['borderWidth'] = '2px';
			$square_css['borderStyle'] = 'solid';
			$square_css['borderColor'] = 'lightgray';
			$square_css['position'] = 'absolute';
			switch($dir){
				case 1: $modi = 9 - $i;
					$modj = $j;
				break;
				case 2: $modi = $i;
					$modj = 9 - $j;
				break;
                                case 3: $modi = $j;
                                        $modj = $i;
                                break;
                                case 4: $modi = 9 - $j;
                                        $modj = 9 - $i;
                                break;
				default:
					$modi = $i;
					$modj = $j;
				break;
			}
			$square_css['top'] = (($modi * $dimension) + ($dimension)) . 'px';
			$square_css['left'] = (($modj * $dimension) + ($dimension)) . 'px';
			if(($i + $j) % 2 === 0){
				$square_css['backgroundColor'] = $bgColorBlack;
				$square_css['color'] = $textColorWhite;
			} else { 
				$square_css['backgroundColor'] = $bgColorWhite;
				$square_css['color'] = $textColorBlack;
			}
			array_push($squares,$square_css);
	}
	$json = json_encode($squares);
	echo $json;
?>

