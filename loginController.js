mainApp.controller('loginController', function($http,CSRF){
	var login = this;
	login.state = false;
	login.state1 = true;
	login.ErrorBox = false;
	login.detail = {'email':'','password':'','_token':CSRF};
	login.errorMsg = '';

	login.changeState = function(invalid){
		if(!invalid){
			login.state = true;
			login.state1 = false;
			login.ErrorBox = false;
			console.log(login.detail);
			$http({
				method : 'post',
				url : 'http://localhost/customizedshop/public/login',
				data : login.detail
			})
			.success(function(data){
				console.log(data);
				switch(data){
					case 'error':
						login.errorMsg = 'These credentials do not match records';
						login.state = false;
						login.state1 = true;
						login.ErrorBox = true;
						break;
					case 'toomany':
						login.errorMsg = 'Too many login attempts, try again after 60 Seconds';
						login.state = false;
						login.state1 = true;
						login.ErrorBox = true;
						break;
					case 'dashboard':
						window.location.replace("http://localhost/customizedshop/public/dashboard");
						break;
					default:
						break;
				}
			})
			.error(function(data){
				console.log(data);
			});
		}
	}
});