'use strict';	
app.controller('dashboardController', function($scope,services) {
	services.getUsers().then(function(data){
        $scope.users = data.data;
    });
});
