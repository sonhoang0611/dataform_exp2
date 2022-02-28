app.directive("place", function(){
	return {
		restrict: 'E',
		scope: {
			where: '='
		},
		templateUrl: 'place.html'
	};
});