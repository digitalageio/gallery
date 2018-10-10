function ColorSelectorCtrl($scope,$http) {

	$scope.selected = [];
	$scope.selector = [];
	$scope.selector["width"] = "140px";
	$scope.selector["height"] = "820px";
	$scope.selector["borderStyle"] = "solid";
	$scope.selector["borderColor"] = "black";
	$scope.selector["borderWidth"] = "1px";
	$scope.colorBox = [];
	$scope.recentColors = [];
	$scope.recentColorBox = [];
	$scope.recentColorBox["top"] = "60px";
	$scope.recentColorBox["left"] = "10px";
	$scope.recentColorBox["width"] = "20px";
	$scope.recentColorBox["height"] = "20px";
	$scope.colorBox["top"] = "90px";
	$scope.colorBox["left"] = "10px";
	$scope.selected["hex"] = "#000000";
	$scope.selected["top"] = "10px";
	$scope.selected["left"] = "10px";
	$scope.selected["height"] = "40px";
	$scope.selected["width"] = "120px";

	$scope.recentColor = function(color){
		if($scope.recentColors.length > 5){
			$scope.recentColors.shift();
		}
		$scope.recentColors.push(color);
	}

	$scope.selectColor = function(color){
		$scope.selected["hex"] = color;
		$scope.$emit('selectedColor',color);
	}


	$scope.callColors = function(){
		$http({
			"url":"generate216.json.php"
		}).success(function(data){
			$scope.colors = data;
		});
	}

	$scope.callColors();

}

