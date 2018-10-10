function PieceEditorCtrl($scope,$http) {

	$scope.$on("selectedColor", function(event,color){
		$scope.gridColor = color;
	});

	$scope.$on("selectedPiece", function(event,src){
		var q = src.split("?");
		$scope.gridPiece = "pngToGrid.php?" + q[1];
		$scope.convert2Grid();
	});

	$scope.convert2Grid = function(){
		$http({
			"url":$scope.gridPiece
		}).success( function(data){
			$scope.squares = data;
		});
	}
}
