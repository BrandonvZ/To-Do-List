app.controller('LoginController', function($scope, $http) {

    $scope.loggedIn = false;
    $scope.registerIn = false;

    var req = {
        method : "GET",
        url: baseUrl + "Login/checkLogin",
        headers : {
            "Content-Type" : undefined
        }
    }
    $http(req).then(function successCallBack(response){
        if(response.data == true){
            $scope.loggedIn = true;
            $scope.registerIn = false;
        } else {
            $scope.loggedIn = false;
        }
    }, function errorCallback(response){});

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
            if(response.data == true){
                $scope.loggedIn = true;
            } else {
                console.log(response.data);
            }
        }, function errorCallback(response){});
    }

    $scope.toRegister = function(){
        $scope.registerIn = true;
    }

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
            if(response.data == true){
                $scope.loggedIn = true;
                $scope.registerIn = false;
            } else {
                console.log(response.data);
            }
        }, function errorCallback(response){});
    }

    $scope.toLogin = function(){
        $scope.registerIn = false;
    }
});
