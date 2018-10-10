<?php

	require_once('board.class.php');
	$board = new board(true,'');
	$board->setupBoard(true,'');
	$square = "d7";
	$d = array(1 => 'a','b','c','d','e','f','g','h');
	$board->movePiece(32,"h4");
	//echo json_encode($board->squareArray);
	//echo "<hr>";
	var_dump($board->selectSquare($square));
	//foreach($moves[0] as $m){
	//	$m;	
	//}
?>
