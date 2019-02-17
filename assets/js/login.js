app.controller('LoginController', function($scope, $http) {

    // page control
    $scope.loggedIn = false;
    $scope.registerIn = false;
    $scope.adminPage = false;

    // preset variables
    $scope.login = {};
    $scope.register = {};
    $scope.user = {};

    // preset variables
    $scope.users = [];

    // this will check if the user still has a session
    var req = {
        method : "GET",
        url: baseUrl + "Login/checkLogin",
        headers : {
            "Content-Type" : undefined
        }
    }
    $http(req).then(function successCallBack(response){
        // if the user still has a session, enter dashboard page. If not, enter login page
        if(response.data != "false"){
            $scope.user = response.data;
            $scope.loggedIn = true;
            $scope.registerIn = false;

            // will get all lists for the user
            $scope.getLists();
            document.title = "To-Do-List | Dashboard";
        } else {
            $scope.loggedIn = false;
            document.title = "To-Do-List | Login";
        }
    }, function errorCallback(response){});

    // if the user presses the login button, will send the inputted data to Login.php (controller)
    $scope.login = function(){
        var req = {
            method: "POST",
            url: baseUrl + "Login/login",
            headers: {
                "Content-Type" : undefined
            },
            data: {
                'email' : $scope.login.email,
                'password' : $scope.login.password
            }
        }
        $http(req).then(function successCallBack(response){
            // if the username and password match, enter dashboard page. If not, stay on login page
            if(response.data != "false"){
                $scope.user = response.data;
                $scope.loggedIn = true;

                // will get all lists for the user
                $scope.getLists();
                document.title = "To-Do-List | Dashboard";
            } else {
                console.log(response.data);
            }
        }, function errorCallback(response){});
    }

    // this function will get all users and set it to the $scope.users variable
    $scope.getUsers = function(){
        var req = {
            method : "GET",
            url: baseUrl + "Login/getUsers",
            headers : {
                "Content-Type" : undefined
            }
        }
        $http(req).then(function successCallBack(response){
            $scope.users = response.data;
        }, function errorCallback(response){});
    }

    // if the user presses the logout button, will log the user out and sends user back to login page
    $scope.logout = function(){
        var req = {
            method : "GET",
            url: baseUrl + "Login/logout",
            headers : {
                "Content-Type" : undefined
            }
        }
        $http(req).then(function successCallBack(response){
            // if the session has been unset
            $scope.loggedIn = false;
        }, function errorCallback(response){});
    }

    // if the user is an admin and presses the ADMIN PAGE button, will enable admin page and disable dashboard page
    $scope.toAdmin = function(){
        $scope.adminPage = true;

        // getUsers function will be called to collect every user in the 'users' table
        $scope.getUsers();
    }

    // if the admin checks/unchecks a checkbox
    $scope.adminToggle = function(role){
        if(role.role_id == 1){
            role.role_id = 2;
        } else {
            role.role_id = 1;
        }

        var req = {
            method: "POST",
            url: baseUrl + "Login/adminToggle",
            headers: {
                "Content-Type" : undefined
            },
            data: {
                'id' : role.id,
                'role_id' : role.role_id
            }
        }
        $http(req).then(function successCallBack(response){
            // if the user role id is equal to the role id
            if($scope.user.id == role.id){

                // if the role_id is 2 ('User' role)
                if(role.role_id == 2){

                    // calls the toDashboard function
                    $scope.toDashboard();

                    $scope.user.role_id = role.role_id;
                }
            }
        }, function errorCallback(response){});
    }

    // this function will show all users on the admin page
    $scope.showUserList = function(id){
        $scope.lists = [];
        $scope.reverseFilter = [];
        $scope.typeFilter = [];

        var req = {
            method : "POST",
            url: baseUrl + "Dashboard/showUserList",
            headers : {
                "Content-Type" : undefined
            },
            data : {
                'id' : id
            }
        }
        $http(req).then(function successCallBack(response){
            $scope.lists = response.data;
            $scope.adminPage = false;
        }, function errorCallback(response){});
    }

    // this function will delete an user if an admin clicked on the trash bin on the admin page
    $scope.deleteUser = function(id){
        var req = {
            method: "POST",
            url: baseUrl + "Dashboard/deleteUser",
            headers: {
                "Content-Type":undefined
            },
            data: {
                'id': id
            }
        }
        $http(req).then(function successCallback(response){
            // loop through all users
            for(var i = 0; i < $scope.users.length; i++){
                if($scope.users[i].id == id){
                    $scope.users.splice(i, 1);
                }
            }
        }, function errorCallback(response){});
    }

    // if the user is an admin and presses the DASHBOARD button, will enable dashboard page and disable admin page
    $scope.toDashboard = function(){
        $scope.adminPage = false;

        // shows all lists for the admin it self
        $scope.showUserList($scope.user.id);
    }

    // if the user presses the register here button, will enable the register page and disable the login page
    $scope.toRegister = function(){
        $scope.registerIn = true;
        document.title = "To-Do-List | Register";
    }

    // if the user presses the register button, will send the inputted data to Login.php (controller)
    $scope.register = function(){
        var req = {
            method: "POST",
            url: baseUrl + "Login/register",
            headers: {
                "Content-Type" : undefined
            },
            data: {
                'email' : $scope.register.email,
                'password' : $scope.register.password
            }
        }
        $http(req).then(function successCallBack(response){
            // if the user has been created, enter dashboard page. If not, stay on register page
            if(response.data != "false"){
                $scope.user = response.data;
                $scope.loggedIn = true;
                $scope.registerIn = false;

                // will get all lists for the user
                $scope.getLists();
                document.title = "To-Do-List | Dashboard";
            } else {
                console.log(response.data);
            }
        }, function errorCallback(response){});
    }

    // if the user presses the go back button, will enable the login page and disable the register page
    $scope.toLogin = function(){
        $scope.registerIn = false;
        document.title = "To-Do-List | Login";
    }
});
