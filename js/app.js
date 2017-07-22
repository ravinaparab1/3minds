'use strict';
var app = angular.module('App', []);
app.factory("services", ['$http', function($http) {
	 var obj = {};
    obj.getUsers = function(){
        return $http.get('http://localhost/ravina_3minds/dashboardapi.php');
    }
    return obj;
}]);