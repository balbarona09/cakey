import {ajax} from './ajax.js';

const sendCodeForm = document.getElementById('forgot-sendcode-form');
const verifyCodeForm = document.getElementById('forgot-verifycode-form');
const changeEmail = document.getElementById('forgot-change-email');
const resendCode = document.getElementById('forgot-resendcode');
const resetPasswordForm = document.getElementById('forgot-change-password-form');

if(sendCodeForm != null) {
	sendCodeForm.addEventListener('submit', function(e) {
	e.preventDefault();
	startLoading();
	let email = document.getElementById('email');
	ajax({'email' : email.value}, 'ajaxPhp/forgot-password.php', function(response) {
		if(response == 1) {
			location.reload();
		}
		else {
			displayResult('Code not sent! Please try again!','danger');
		}
		stopLoading();
		});
	});
}

if(verifyCodeForm != null) {
	let resendCounter = 120;
	let resendTimer = setInterval(resendTimerFunction, '1000');
	
	verifyCodeForm.addEventListener('submit', function(e) {
	e.preventDefault();
	startLoading();
	let code = document.getElementById('code');
	ajax({'code' : code.value}, 'ajaxPhp/forgot-password.php', function(response) {
		if(response == 1) {
			location.reload();
		}
		else if(response == 2){
			displayResult('Code is incorrect','danger');
			document.getElementById('attempts').innerHTML -= 1;
		}
		else if(response == 3) {
			document.getElementById('attempts').innerHTML = 0 ;
			displayResult('You have used all your attempts. You can resend new code after 2 minutes.','danger');
			disableResend();
			clearInterval(resendTimer);
			resendTimer = setInterval(resendTimerFunction, '1000');
		}
		stopLoading();
		});
	});
	
	resendCode.addEventListener('click', function(e) {
		if(resendCounter < 0) {
		startLoading();
		ajax({'action': 'RESEND CODE'},'ajaxPhp/forgot-password.php', function(response) {
			if(response == 1) {
				displayResult('We have sent a new verification code.', 'success');
				disableResend();
				resendTimer = setInterval(resendTimerFunction, '1000');
				document.getElementById('attempts').innerHTML = 5;
			}
			else {
				displayResult('Code not sent. Please try again!','danger')
			}
			stopLoading();
			})
		}
	});
	
	function resendTimerFunction() {
		resendCode.innerHTML = 'Resend Code(' + resendCounter + ')';
		resendCounter--;
		if(resendCounter < 0) {
			clearInterval(resendTimer);
			resendCode.innerHTML = 'Resend Code';
			resendCode.classList.add('link-underline-opacity-75-hover')
			resendCode.classList.remove('link-opacity-50');
		}
	}
	function disableResend() {
		resendCounter = 120;
		resendCode.classList.remove('link-underline-opacity-75-hover')
		resendCode.classList.add('link-opacity-50');
	}
}

if(resetPasswordForm != null) {
	resetPasswordForm.addEventListener('submit', function(e) {
	e.preventDefault();
	startLoading();
	let password = document.getElementById('password');
	let confirmPassword = document.getElementById('confirm-password');
	ajax({'password' : password.value, 'confirmPassword' : confirmPassword.value}, 
	'ajaxPhp/forgot-password.php', function(response) {
		if(response == 1) {
			let myModal = new bootstrap.Modal(document.getElementById('staticBackdrop'));
			myModal.show();
			let counter = 5;
			setTimeout(function() {location.replace('login.php'); }, "5000");
			setInterval(function() {counter--; document.getElementById('counter').innerHTML = counter;}, '1000');
		}
		else if(response == 'Password do not match') {
			displayResult('Passwords do not match', 'danger');
		}
		else {
			displayResult('Something went wrong. Please try again.','danger');
		}
		stopLoading();
		});
	});
}

if(changeEmail != null) {
	changeEmail.addEventListener('click', function(e) {
	ajax({'action': 'CHANGE EMAIL'},'ajaxPhp/forgot-password.php', function(response) {
		if(response == 1) {
			location.reload();
		}
		else {
			displayResult('Something went wrong. Please try again.','danger');
			console.log(response);
		}
		})
	});
}
