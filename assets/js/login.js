app.controller('LoginController', function($scope, $http) {

    $scope.login = function(){
        var req = {
            method: "POST",
            url: base_url + "login/login",
            headers: {
                "Content-Type" : undefined
            },
            data: {
                'email' : $scope.login.email,
                'password' : $scope.login.password
            }
        }
    }
});
