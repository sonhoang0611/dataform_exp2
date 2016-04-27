'use strict';

/* Controllers */
var phonecatApp = angular.module('myApp', []);

phonecatApp.controller('mywebCtrl', function ($scope, $http) {
  $http.get('profile.json').success(function(data) {
    $scope.profile = data;
  });
});