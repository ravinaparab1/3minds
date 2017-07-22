
<!DOCTYPE HTML>
<html>
<head>
<title>Brandex Dashboard Login</title>
<link href="css/style.css" rel="stylesheet" type="text/css" media="all" />
<link href='http://fonts.googleapis.com/css?family=Rokkitt' rel='stylesheet' type='text/css'>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
</head>
<body id="dashboard" ng-app="App" ng-controller="dashboardController">
<h1 class="text-center">Brandex User List</h1>
<table class="vertical-center" id="dashboard-table">
  <tr class="header">
    <th>Name</th>
    <th>User Id</th>
    <th>
      <select class="platform-select" ng-model="filterPlatform">
        <option value="">Platform</option>
        <option ng-repeat="option in users" ng-value="option.oauth_provider">{{option.oauth_provider}}</option>
      </select>
    </th>
    <th>Profile Link</th>
  </tr>
  <tr ng-repeat="user in users | filter : { oauth_provider : filterPlatform}">
    <td>{{user.name}}</td>
    <td>{{user.oauth_uid}}</td>
    <td>{{user.oauth_provider}}</td>
    <td><a href="user.link">{{user.link | limitTo: 30 }}{{user.link.length > 30 ? '...' : ''}}</a></td>
  </tr>
</table>
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js"></script>
<script src="js/app.js"></script>
<script src="js/dashboard.js"></script>
</body>