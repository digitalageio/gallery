function GameboardCtrl($scope,$http) {

	$scope.directions = [
		{dir:'1',label:'rank advancing bottom to top'},
		{dir:'2',label:'rank advancing top to bottom'},
		{dir:'3',label:'rank advancing left to right'},
		{dir:'4',label:'rank advancing right to left'}
	];	

	$scope.selectedPiece = 'none';
	$scope.selectedSquare = '';
	$scope.selectedFile = '-';
	$scope.selectedRank = '-';
	$scope.boardDirection = $scope.directions[0];

	$scope.directionChanged = function(){
		$scope.callBoard();
	}

	$scope.pieceSelect = function(piece,label,file,rank){
		$scope.selectedSquare = label;
		$scope.selectedPiece = piece;
		$scope.selectedFile = file;
		$scope.selectedRank = rank;
		$scope.callBoard();
	}


	$scope.callBoard = function(){
		$http({
			"url":"squares.json.php",
			"method":"POST",
			"data": {
					"dir": $scope.boardDirection.dir,
					"piece": $scope.selectedPiece,
					"square": $scope.selectedSquare,
					"file": $scope.selectedFile,
					"rank": $scope.selectedRank
				}
		}).success(function(data){
			$scope.squares = data;
		});
	}

	$scope.callBoard();

}

