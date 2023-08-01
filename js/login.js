import {ajax} from './ajax.js';

const loginForm = document.getElementById('login-form');
loginForm.addEventListener('submit', function(e) {
	e.preventDefault();
	startLoading();
	let email = document.getElementById('email');
	let password = document.getElementById('password');
	ajax({'email': email.value, 'password': password.value}, 'ajaxPhp/login.php', function(response) {
		if(response == 1) {
			location.replace('handle-user.php');
		}
		else if(response == 'Your Account has been blocked') {
			displayResult(response,'danger');
		}
		else if(response == 'Your Account has been deactivated') {
			displayResult(response,'danger');
		}
		else {
			displayResult('Email or Password is incorrect. Please try again.','danger');
		}
			stopLoading();
	})
});
