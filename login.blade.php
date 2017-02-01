<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Customized Admin</title>

    <!-- Bootstrap Core CSS -->
    <link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('css/bootstrap.css')}}" rel="stylesheet">
    
    

    <!-- Custom CSS -->
    <link href="{{asset('css/sb-admin.css')}}" rel="stylesheet">

    <!--Cusrtom CSS -->
    <link href="{{asset('font-awesome/css/font-awesome.min.css')}}" rel="stylesheet" type="text/css">

    <!--jquery ui widget-->
    <link rel="stylesheet" href="{{asset('css/ionicons.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/jquery-ui-1820custom.css')}}">
    

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

<div class="container">
    
      <div style="margin-top:70px;" class="welll row col-md-4 col-md-offset-4">
     <div  class="" ng-app="mainApp" ng-controller="loginController as login">
       <h1 style="font-size:60px;color:#fff;"> Admin <i class="fa fa-user" ></i></h1>   
       <form name="LoginForm" novalidate="">

        <div class="form-group" ng-class="{ 'has-error' : LoginForm.username.$invalid && LoginForm.username.$touched }">
            @if ($errors->has('email'))
                <span class="help-block">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif
            <label style="color:#fff;">Username * </label>
                <input type="email" style="" name="username" placeholder="email" ng-model="login.detail.email" class="form-control" required>
                <p ng-show="LoginForm.username.$invalid && LoginForm.username.$touched" style="font-size:14px;" class="help-block">This should be a valid email.</p>
        </div>
        

        <div class="form-group" ng-class="{ 'has-error' : LoginForm.password.$invalid && LoginForm.password.$touched }">
            <label style="color:#fff;">Password * </label>
            
                <input type="password" name="password" ng-model="login.detail.password" class="form-control" required>
                <p ng-show="LoginForm.password.$invalid && LoginForm.password.$touched" style="font-size:14px;" class="help-block"> password is required.</p>
        </div>
        <button ng-show="login.state" class="btn btn-block btn-info">
            <i class="fa fa-circle-o-notch fa-spin" style="font-size:24px;"></i>
        </button>
        <button ng-show="login.ErrorBox" class="btn btn-block btn-danger">
            @{{login.errorMsg}}
        </button>
        <button type="submit" ng-show="login.state1" ng-click="login.changeState(UsersForm.$valid)" ng-disabled="LoginForm.$invalid" class="btn btn-block btn-primary">
            <span style="font-size:20px;">Login</span>
        </button>
        <span><a href="#">Forgot password</a></span>
        </form>
    </div>
</div>
</div>
    <script src="{{asset('js/jquery-1.12.0.min.js')}}"></script>
    <script src="{{asset('js/bootstrap.min.js')}}"></script>
    <script src="{{asset('app/lib/angular.min.js') }}"></script>
    <script src="{{asset('js/megamenu.js')}}"></script>

     <!-- AngularJS Application Scripts -->
    <script src="http://localhost:3000/socket.io/socket.io.js"></script>
    <script src="{{asset('rtApp/angular-socket-io/socket.js')}}"></script>

    <script src="{{asset('rtApp/rtApp.js')}}"></script>
    <script>
    var mainApp = angular.module('mainApp', []);
    mainApp.constant('API_URL', 'http://localhost/customizedshop/public').constant('CSRF', '{{ csrf_token() }}');
    </script>
    <script src="{{asset('app/controllers/loginController.js')}}"></script>

</body>
</html>