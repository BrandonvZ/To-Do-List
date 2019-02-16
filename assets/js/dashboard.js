var baseUrl = "http://localhost/to-do-list/";
var app = angular.module('myToDo', []);

app.controller('DashboardController', function($scope, $http) {

    $scope.reverseFilter = [];
    $scope.typeFilter = [];
    $scope.lists = [];

    $scope.filterDone = function(index){
        $scope.reverseFilter[index] = !$scope.reverseFilter[index];
        $scope.typeFilter[index] = 'done';
    }

    $scope.filterTime = function(index){
        $scope.reverseFilter[index] = !$scope.reverseFilter[index];
        $scope.typeFilter[index] = 'duration';
    }

    $scope.getLists = function(){
        $scope.lists = [];
        $scope.reverseFilter = [];
        $scope.typeFilter = [];

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

    $scope.getItems = function(){
        var req = {
            method : "GET",
            url: baseUrl + "dashboard/getItems",
            headers : {
                "Content-Type" : undefined
            }
        }
        $http(req).then(function successCallBack(response){
            $scope.lists = response.data;
        }, function errorCallback(response){});
    }

    $scope.acceptListItem = function(data, elem){
        var currentItem = elem.currentTarget;
        var currentItems = currentItem.parentNode.getElementsByTagName('p');

        if(data.done == 1){
            data.done = 0;
            for(var i = 0; i < currentItems.length; i++){
                currentItems[i].classList.remove("dashboard-list-item-done");
            }
        } else {
            data.done = 1;
            for(var i = 0; i < currentItems.length; i++){
                currentItems[i].classList.add("dashboard-list-item-done");
            }
        }

        var req = {
            method: "POST",
            url: baseUrl + "dashboard/acceptListItem",
            headers: {
                "Content-Type":undefined
            },
            data: {
                'id' : data.id,
                'value' : data.done
            }
        }
        $http(req).then(function successCallBack(response){}, function errorCallback(response){});
    }

    $scope.createListItem = function(listId){
        if(listId['id'] != undefined){
            listId = listId.id;
        }

        var req = {
            method: "POST",
            url: baseUrl + "dashboard/createListItem",
            headers: {
                "Content-Type":undefined
            },
            data: {
                'list_id' : listId
            }
        }
        $http(req).then(function successCallBack(response){
            for(var i = 0; i < $scope.lists.length; i++){
                if($scope.lists[i].id['id'] != undefined){
                    $scope.lists[i].id = $scope.lists.id.id;
                }
                if($scope.lists[i].id == listId){
                    if($scope.lists[i].content == undefined){
                        $scope.lists[i].content = [];
                    }

                    var item = {
                        'id' : response.data.id,
                        'name' : 'Item Name',
                        'done' : 0,
                        'duration' : 0,
                        'list_id' : listId
                    };
                    $scope.lists[i].content.push(item);
                }
            }
        }, function errorCallback(response){});
    }

    $scope.updateListItem = function(data, elem){
        var newTitle = elem.currentTarget.innerHTML;

        if(data['id'] != undefined){
            data = data.id
        }

        var req = {
            method: "POST",
            url: baseUrl + "dashboard/updateListItem",
            headers: {
                "Content-Type":undefined
            },
            data: {
                'id' : data,
                'value' : newTitle
            }
        }
        $http(req).then(function successCallBack(response){
            for(var i = 0; i < $scope.lists.length; i++){
                var list = $scope.lists[i];
                if(list.id == data.list_id){
                    for(var q = 0; q < list.content.length; q++){
                        var content = list.content[q];
                        if(content.id == data.id){
                            content.name = newTitle;
                        }
                    }
                }
            }
        }, function errorCallback(response){});
    }

    $scope.updateListItemTime = function(data, elem){
        var newTime = elem.currentTarget.innerHTML;

        if(data['id'] != undefined){
            data = data.id
        }

        var req = {
            method: "POST",
            url: baseUrl + "dashboard/updateListItemTime",
            headers: {
                "Content-Type":undefined
            },
            data: {
                'id' : data,
                'value' : newTime
            }
        }
        $http(req).then(function successCallBack(response){
            for(var i = 0; i < $scope.lists.length; i++){
                var list = $scope.lists[i];
                if(list.id == data.list_id){
                    for(var q = 0; q < list.content.length; q++){
                        var content = list.content[q];
                        if(content.id == data.id){
                            content.name = newTime;
                        }
                    }
                }
            }
        }, function errorCallback(response){});
    }

    $scope.deleteListItem = function(id, list_id){
        var req = {
            method: "POST",
            url: baseUrl + "dashboard/deleteListItem",
            headers: {
                "Content-Type":undefined
            },
            data: {
                'id' : id,
            }
        }
        $http(req).then(function successCallBack(response){
            for(var i = 0; i < $scope.lists.length; i++){
                var list = $scope.lists[i];
                if(list.id == list_id){
                    for(var q = 0; q < list.content.length; q++){
                        if(list.content[q].id == id){
                            list.content.splice(q, 1);
                        }
                    }
                }
            }
        }, function errorCallback(response){});
    }
});
