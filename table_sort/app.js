angular.module('sortApp', [])

.controller('mainController', function($scope) {
	$scope.sortType = 'name';
	$scope.sortReverse = false;
	$scope.searchLanguage = '';

	$scope.languages = [
		{ name: 'PHP', author: 'Rasmus Lerdorf', year: 1995 },
		{ name: 'Node.js', author: 'Ryan Dahl', year: 2009 },
		{ name: 'C++', author: 'Bjarne Stroustrup', year: 1983 },
		{ name: 'C', author: 'Dennis Ritchie', year: 1972 },
		{ name: 'Javascript', author: 'Brendan Eich', year: 1995 },
		{ name: 'Java', author: 'James Gosling', year: 1995 },
		{ name: 'Python', author: 'Guido van Rossum', year: 1991 },
		{ name: 'COBOL', author: 'CODASYL', year: 1968 },
		{ name: 'Perl', author: 'Larry Wall', year: 1987 },
		{ name: 'Ruby', author: 'Yukihiro Matsumoto', year: 1995 },
		{ name: 'Go', author: 'Robert Griesemer, et al.', year: 2009 },
		{ name: 'Rust', author: 'Graydon Hoare', year: 2012 },
		{ name: 'Erlang', author: 'Joe Armstrong, et al.', year: 1986 },
		{ name: 'Scala', author: 'Martin Odersky', year: 2003 }
	];

});
