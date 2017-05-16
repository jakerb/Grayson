var app = angular.module('plugin', ['angular.filter']).config(function($interpolateProvider){
    $interpolateProvider.startSymbol('[[').endSymbol(']]');
});

app.controller('admin', function($scope, $http, $timeout) {
  
  $scope.isFullScreen = false;
  $scope.isListView = false;
  
});