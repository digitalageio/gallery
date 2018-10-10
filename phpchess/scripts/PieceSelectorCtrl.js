function PieceSelectorCtrl($scope,$http) {

        $scope.sets = [
                {set:'clear',label:'Clear'},
                {set:'white',label:'White'},
                {set:'black',label:'Black'},
                {set:'blue',label:'Blue'},
                {set:'brown',label:'Brown'},
                {set:'yellow',label:'Yellow'}
        ];

	$scope.setSelect = $scope.sets[0];
        $scope.sizes = [
                {size:'48',label:'48px X 48px'}
        ];

	$scope.pieces = [
		{piece:'pawn',label:'Pawn'},
		{piece:'rook',label:'Rook'},
		{piece:'knight',label:'Knight'},
		{piece:'bishop',label:'Bishop'},
		{piece:'queen',label:'Queen'},
		{piece:'king',label:'King'}
	];
/*
	$scope.images = [
			{src:'getBytesGridFS.php?set=' + $scope.setSelect.set + '&piece=pawn&size=' + $scope.sizes[0]["size"]},
			{src:'getBytesGridFS.php?set=' + $scope.setSelect.set + '&piece=rook&size=' + $scope.sizes[0]["size"]},
			{src:'getBytesGridFS.php?set=' + $scope.setSelect.set + '&piece=knight&size=' + $scope.sizes[0]["size"]},
			{src:'getBytesGridFS.php?set=' + $scope.setSelect.set + '&piece=bishop&size=' + $scope.sizes[0]["size"]},
			{src:'getBytesGridFS.php?set=' + $scope.setSelect.set + '&piece=queen&size=' + $scope.sizes[0]["size"]},
			{src:'getBytesGridFS.php?set=' + $scope.setSelect.set + '&piece=king&size=' + $scope.sizes[0]["size"]}
        ];
*/
	$scope.selector = [];
	$scope.piece_src = "";
	$scope.selector["width"] = "140px";
	$scope.selector["height"] = "820px";
	$scope.selector["borderStyle"] = "solid";
	$scope.selector["borderColor"] = "black";
	$scope.selector["borderWidth"] = "1px";
	$scope.square = [];
	$scope.square["hex"] = "#000000";
	$scope.square["top"] = "10px";
	$scope.square["left"] = "10px";
	$scope.square["height"] = "40px";
	$scope.square["width"] = "120px";
	$scope.pieces = [];

	$scope.setSquareColor = function(color){
		$scope.square["hex"] = color;
	}

	$scope.callColors = function(){
		$http({
			"url":"generate216.json.php"
		}).success(function(data){
			$scope.colors = data;
		});
	}

	$scope.setChange = function(){
		$scope.images = [
                        {src:'getBytesGridFS.php?set=' + $scope.setSelect.set + '&piece=pawn&size=' + $scope.sizes[0]["size"]},
                        {src:'getBytesGridFS.php?set=' + $scope.setSelect.set + '&piece=rook&size=' + $scope.sizes[0]["size"]},
                        {src:'getBytesGridFS.php?set=' + $scope.setSelect.set + '&piece=knight&size=' + $scope.sizes[0]["size"]},
                        {src:'getBytesGridFS.php?set=' + $scope.setSelect.set + '&piece=bishop&size=' + $scope.sizes[0]["size"]},
                        {src:'getBytesGridFS.php?set=' + $scope.setSelect.set + '&piece=queen&size=' + $scope.sizes[0]["size"]},
                        {src:'getBytesGridFS.php?set=' + $scope.setSelect.set + '&piece=king&size=' + $scope.sizes[0]["size"]}
        	];
	}

	$scope.pieceSelect = function(src){
		$scope.$emit("selectedPiece",src);
	}

	$scope.callColors();
	$scope.setChange();
	

}

