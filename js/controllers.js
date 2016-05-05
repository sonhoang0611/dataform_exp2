'use strict';

/* Controllers */
var phonecatApp = angular.module('myApp', ['shaka-editme']);

phonecatApp.controller('mywebCtrl', function ($scope, $http) {
  $http.get('profile.json').success(function(data) {
    $scope.profile = data;
  });
  
   $scope.add = function () {

                if ($scope.name != '' && $scope.score != '') 
                {
                    // ADD A NEW ELEMENT.
					
                    $scope.listskill.push({ name: $scope.name, score: $scope.score });

                    // CLEAR THE FIELDS.
                    $scope.name = '';
                    $scope.score = '';
                }
            };
});