var baseUrl = "http://localhost/to-do-list/";
var app = angular.module('myToDo', []);

app.controller('DashboardController', function($scope, $http) {

    $scope.lists = [];

    $scope.getLists = function(){
        $scope.lists = [];
        var req = {
            method : "GET",
            url: baseUrl + "Dashboard/getLists",
            headers : {
                "Content-Type" : undefined
            }
        }
        $http(req).then(function successCallBack(response){
            $scope.lists = response.data;
        }, function errorCallback(response){});
    }

    $scope.createList = function(){
        var req = {
            method : "GET",
            url: baseUrl + "Dashboard/createList",
            headers : {
                "Content-Type" : undefined
            }
        }
        $http(req).then(function successCallBack(response){
            var list = {
                'id' : response.data.id,
                'name' : "List Title"
            }
            $scope.lists.push(list);
        }, function errorCallback(response){});
    }

    $scope.deleteList = function(id){
        var req = {
            method: "POST",
            url: baseUrl + "dashboard/deleteList",
            headers: {
                "Content-Type":undefined
            },
            data: {
                'id': id
            }
        }
        $http(req).then(function successCallback(response){
            for(var i = 0; i < $scope.lists.length; i++){
                if($scope.lists[i].id == id){
                    $scope.lists.splice(i, 1);
                }
            }
        }, function errorCallback(response){});
    }

    $scope.updateListTitle = function(data, elem){
        var newTitle = elem.currentTarget.innerHTML;
        var req = {
            method: "POST",
            url: baseUrl + "dashboard/updateListTitle",
            headers: {
                "Content-Type":undefined
            },
            data: {
                'id' : data.id,
                'value' : newTitle
            }
        }
        $http(req).then(function successCallback(response){
            for(var i = 0; i < $scope.lists.length; i++){
                var list = $scope.lists[i];
                if(list.id == data.id){
                    list.name = newTitle;
                }
            }
        }, function errorCallback(response){});
    }
});
