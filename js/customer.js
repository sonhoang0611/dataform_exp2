app2.directive("customer", function(){
	return {
		restrict: 'E',
		scope: {
			cus: '='
		},
		templateUrl: 'customer.html'
	};
});