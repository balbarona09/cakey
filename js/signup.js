import {ajax} from './ajax.js';

const sendCodeForm = document.getElementById('signup-sendcode-form');
const verifyCodeForm = document.getElementById('signup-verifycode-form');
const insertAccountForm = document.getElementById('signup-insertaccount-form');
const changeEmail = document.getElementById('signup-change-email');
const resendCode = document.getElementById('signup-resendcode');

if(sendCodeForm != null) {
	sendCodeForm.addEventListener('submit', function(e) {
	e.preventDefault();
	startLoading();
	let email = document.getElementById('email');
	ajax({'email' : email.value}, 'ajaxPhp/signup.php', function(response) {
		if(response == 1) {
			location.reload();
		}
		else {
			let result = response == 'Email is already used' ? response : 'Code not sent. Please try again!';
			displayResult(result,'danger');
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
	ajax({'code' : code.value}, 'ajaxPhp/signup.php', function(response) {
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
		ajax({'action': 'RESEND CODE'},'ajaxPhp/signup.php', function(response) {
			if(response == 1) {
				displayResult('We have sent a new verification code.', 'success');
				disableResend();
				resendTimer = setInterval(resendTimerFunction, '1000');
				document.getElementById('attempts').innerHTML = 5;
			}
			else {
				displayResult('Something went wrong! Please try again!','danger')
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

if(insertAccountForm != null) {
	insertAccountForm.addEventListener('submit', function(e) {
	e.preventDefault();
	let fullname = document.getElementById('fullname');
	let password = document.getElementById('password');
	let confirmPassword = document.getElementById('confirm-password');
	ajax({'fullname' : fullname.value, 'password' : password.value, 'confirmPassword' : confirmPassword.value}, 
	'ajaxPhp/signup.php', function(response) {
		if(response == 1) {
			let myModal = new bootstrap.Modal(document.getElementById('staticBackdrop'));
			myModal.show();
			let counter = 5;
			setTimeout(function() {location.replace('login.php'); }, "5000");
			setInterval(function() {counter--; document.getElementById('counter').innerHTML = counter;}, '1000');
		}
		else {
			let result = response == 'Password do not match' ? response : 'Something went wrong. Please try again' ; 
			displayResult(result, 'danger');
			}
		});
	});
}


if(changeEmail != null) {
	changeEmail.addEventListener('click', function(e) {
	ajax({'action': 'CHANGE EMAIL'},'ajaxPhp/signup.php', function(response) {
		if(response == 1) {
			location.reload();
		}
		})
	});
}

