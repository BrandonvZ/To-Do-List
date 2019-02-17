var baseUrl = "http://localhost/to-do-list/";
var app = angular.module('myToDo', []);

app.controller('DashboardController', function($scope, $http) {

    // preset filters
    $scope.reverseFilter = [];
    $scope.typeFilter = [];

    // preset lists
    $scope.lists = [];

    // this function will filter on completion if the user presses on that specific filter
    $scope.filterDone = function(index){
        $scope.reverseFilter[index] = !$scope.reverseFilter[index];
        $scope.typeFilter[index] = 'done';
    }

    // this function will filter on time if the user presses on that specific filter
    $scope.filterTime = function(index){
        $scope.reverseFilter[index] = !$scope.reverseFilter[index];
        $scope.typeFilter[index] = 'duration';
    }

    // this function will get all lists
    $scope.getLists = function(){

        // clears all lists and filters
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

    // if the user clicks on the plus symbol to create a new list
    $scope.createList = function(){
        var req = {
            method : "GET",
            url: baseUrl + "Dashboard/createList",
            headers : {
                "Content-Type" : undefined
            }
        }
        $http(req).then(function successCallBack(response){
            // creates the list with an unique id and placeholder text
            var list = {
                'id' : response.data.id,
                'name' : "List Title"
            }
            $scope.lists.push(list);
        }, function errorCallback(response){});
    }

    // if the user clicks on the minus symbol to delete an existing list
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
            // loop through all lists
            for(var i = 0; i < $scope.lists.length; i++){

                // if the list id is equal to the id that got sent
                if($scope.lists[i].id == id){
                    $scope.lists.splice(i, 1);
                }
            }
        }, function errorCallback(response){});
    }

    // if the user changed the list title
    $scope.updateListTitle = function(data, elem){
        // sets the edited text in to the newTitle variable
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
            // loops through all lists
            for(var i = 0; i < $scope.lists.length; i++){

                // stores the edited list into the list variable
                var list = $scope.lists[i];

                // if the edited list id is equal to the id that got sent
                if(list.id == data.id){

                    // change the name into the user edited text
                    list.name = newTitle;
                }
            }
        }, function errorCallback(response){});
    }

    // this function will get all items that belong to an list for the user
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

    // if the user clicks on the checkbox next to the item
    $scope.acceptListItem = function(data, elem){
        // stores the checked checkbox into the currentItem variable
        var currentItem = elem.currentTarget;

        // stores the checked checkbox and the checked item into the currentItems variable
        var currentItems = currentItem.parentNode.getElementsByTagName('p');

        // if the checkbox is checked
        if(data.done == 1){

            // change value into 0
            data.done = 0;

            // loop through all currentItems
            for(var i = 0; i < currentItems.length; i++){

                // remove the styling
                currentItems[i].classList.remove("dashboard-list-item-done");
            }
        } else {
            // change value into 1
            data.done = 1;

            // loop through all currentItems
            for(var i = 0; i < currentItems.length; i++){

                // add the styling
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

    // if the user clicks on the plus symbol on the bottom of the list
    $scope.createListItem = function(listId){

        // if the specific list exists
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
            // loop through all lists
            for(var i = 0; i < $scope.lists.length; i++){

                // if the specific list id exists
                if($scope.lists[i].id['id'] != undefined){
                    $scope.lists[i].id = $scope.lists.id.id;
                }

                // if the specific list id is equal to the listId that got sent
                if($scope.lists[i].id == listId){

                    // if the list content is not existing
                    if($scope.lists[i].content == undefined){
                        $scope.lists[i].content = [];
                    }

                    // creates item with the item data
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

    // if the user changed the item title
    $scope.updateListItem = function(data, elem){
        // stores the user input into the newTitle variable
        var newTitle = elem.currentTarget.innerHTML;

        // if the data id exists
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
            // loop through all lists
            for(var i = 0; i < $scope.lists.length; i++){

                // stores the edited list into the list variable
                var list = $scope.lists[i];

                // if the edited list id is equal to the id that got sent
                if(list.id == data.list_id){

                    // loop through all list content
                    for(var q = 0; q < list.content.length; q++){

                        // stores the edited content into the content variable
                        var content = list.content[q];

                        // if the content id is equal to the data id that got sent
                        if(content.id == data.id){

                            // change the item name into the user edited text
                            content.name = newTitle;
                        }
                    }
                }
            }
        }, function errorCallback(response){});
    }

    // if the user changed the item duration
    $scope.updateListItemTime = function(data, elem){
        // stores the user input into the newTime variable
        var newTime = elem.currentTarget.innerHTML;

        // if the data id exists
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
            // loop through all lists
            for(var i = 0; i < $scope.lists.length; i++){

                // stores the edited list into the list variable
                var list = $scope.lists[i];

                // if the edited list id is equal to the id that got sent
                if(list.id == data.list_id){

                    // loop through all list content
                    for(var q = 0; q < list.content.length; q++){

                        // stores the edited content into the content variable
                        var content = list.content[q];

                        // if the content id is equal to the data id that got sent
                        if(content.id == data.id){

                            // change the item duration into the user edited duration
                            content.name = newTime;
                        }
                    }
                }
            }
        }, function errorCallback(response){});
    }

    // if the user presses the minus in the list header
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
            // loops through all lists
            for(var i = 0; i < $scope.lists.length; i++){

                // stores the edited list into the list variable
                var list = $scope.lists[i];

                // if the edited list id is equal to the id that got sent
                if(list.id == list_id){

                    // loop through all list content
                    for(var q = 0; q < list.content.length; q++){

                        // if the content id is equal to the data id that got sent
                        if(list.content[q].id == id){

                            // removes the list
                            list.content.splice(q, 1);
                        }
                    }
                }
            }
        }, function errorCallback(response){});
    }
});
