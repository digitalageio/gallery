function FilterCtrl($scope,$http) {

	$scope.selectedPiece = 'no piece selected yet';
	$scope.filterRGBA = 'rgba(0,0,0,0.0)';

	$scope.pieceSelect = function(piece){	
		$scope.selectedPiece = piece;
		if($scope.sq.label == 'a1'){
			$scope.filterRGBA = 'rgba(255,0,0,0.5)';
		}
	}


	$scope.callBoardFilters = function(){
		$http({
			"url":"filters.json.php",
			"method":"POST",
			"data": {
					"piece": $scope.piece
				}
		}).success(function(data){
			$scope.filters = data;
		});
	}

}

