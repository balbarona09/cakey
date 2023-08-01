import {ajax} from './ajax.js';
import {updateRegions, updateProvinces, updateCities, updateBarangays} from './address.js';

const editProfileForm = document.getElementById('edit-profile-form');
const editPasswordForm = document.getElementById('edit-password-form');
const deactivateAccountForm = document.getElementById('deactivate-account-form');

getProfile();

editProfileForm.addEventListener('submit', function(e) {
	e.preventDefault();
	startLoading();
	const fullname = document.getElementById('fullname');
	const phone = document.getElementById('phone');
	const region = document.getElementById('region');
	const province = document.getElementById('province');
	const city = document.getElementById('city');
	const barangay = document.getElementById('barangay');
	const postalCode = document.getElementById('postal-code');
	const street = document.getElementById('street');
	const email = document.getElementById('email');
	ajax({'fullname': fullname.value, 'phone': phone.value, 'region': region.value, 
	'province': province.value, 'city': city.value, 'barangay': barangay.value, 
	'postal_code': postalCode.value, 'street': street.value, 'action' : 'editProfile'},
	'ajaxPhp/customer-profile.php', function(response) {
		if(response == 'success') {
			displayResult('Profile successfully updated.', 'success', 'alert-dismissible fade show mt-4 mx-md-4', true);
			document.getElementById('topbar-fullname').innerHTML = fullname.value;
		}
		else {
			displayResult('Somethig went wrong.', 'danger', 'alert-dismissible fade show mt-4 mx-md-4', true);
		}
		stopLoading();
	})
});

editPasswordForm.addEventListener('submit', function(e) {
	e.preventDefault();
	startLoading();
	const currentPassword = document.getElementById('current-password');
	const password = document.getElementById('password');
	const confirmPassword = document.getElementById('confirm-password');
	ajax({'currentPassword': currentPassword.value, 'password': password.value, 'confirmPassword': confirmPassword.value,  
	'action' : 'editPassword'}, 'ajaxPhp/customer-profile.php', function(response) {
		if(response == 'success') {
			editPasswordForm.reset();
			displayResult('Password successfully updated.', 'success', 'alert-dismissible fade show mt-4 mx-md-4', true, 'result-password');
		}
		else if(response == 'wrong_current_password') {
			displayResult('Current Password is incorrect.', 'danger', 'alert-dismissible fade show mt-4 mx-md-4', true, 'result-password');
		}
		else if(response == 'passwords_do_not_match') {
			displayResult('Passwords do not match.', 'danger', 'alert-dismissible fade show mt-4 mx-md-4', true, 'result-password');
		}
		else {
			displayResult('Somethig went wrong.', 'danger', 'alert-dismissible fade show mt-4 mx-md-4', true, 'result-password');
		}
		stopLoading();
	})
});

const deactivateAccountModal = new bootstrap.Modal(document.getElementById('deactivate-account-modal'));
deactivateAccountForm.addEventListener('submit', function(e) {
	e.preventDefault();
	startLoading();
	deactivateAccountModal.hide();
	ajax({'action' : 'deactivateAccount'}, 'ajaxPhp/customer-profile.php', function(response) {
		if(response == 'success') {
			let myModal = new bootstrap.Modal(document.getElementById('deactivate-modal-successfull'));
			myModal.show();
			let counter = 5;
			setTimeout(function() {location.replace('login.php'); }, "5000");
			setInterval(function() {counter--; document.getElementById('counter').innerHTML = counter;}, '1000');
		}
		else {
			displayResult('Somethig went wrong.', 'danger', 'alert-dismissible fade show mt-4 mx-md-4', true, 'result-password');
		}
		stopLoading();
	})
});

function getProfile() {
	startLoading();
	ajax({'action' : 'getProfile'}, 'ajaxPhp/customer-profile.php', function(response) {
		if(response == 'error') {
			displayResult('Somethig went wrong.', 'danger', 'alert-dismissible fade show mt-4 mx-md-4', true);
		}
		else {
			displayProfile(JSON.parse(response));
		}
		stopLoading();
	});
}

function displayProfile(profile) {
	const fullname = document.getElementById('fullname');
	const phone = document.getElementById('phone');
	const region = document.getElementById('region');
	const province = document.getElementById('province');
	const city = document.getElementById('city');
	const barangay = document.getElementById('barangay');
	const postalCode = document.getElementById('postal-code');
	const street = document.getElementById('street');
	const email = document.getElementById('email');
	
	fullname.value = profile[0]['name'];
	phone.value = profile[0]['phone'];
	updateRegions(profile[0]['region']);
	updateProvinces(profile[0]['province']);
	updateCities(profile[0]['city']);
	updateBarangays(profile[0]['barangay']);
	postalCode.value = profile[0]['postal_code'];
	street.value = profile[0]['street'];
	if(email != null) {
		email.value = profile[0]['email'];
	}
}

//For changing Email.
const sendCodeForm = document.getElementById('edit-email-sendcode-form');
const verifyCodeForm = document.getElementById('edit-email-verifycode-form');
const insertAccountForm = document.getElementById('edit-email-insertaccount-form');
const changeEmail = document.getElementById('edit-email-change-email');
const resendCode = document.getElementById('edit-email-resendcode');

if(sendCodeForm != null) {
	sendCodeForm.addEventListener('submit', function(e) {
	e.preventDefault();
	startLoading();
	let email = document.getElementById('email');
	let password = document.getElementById('email-password');
	ajax({'email' : email.value, 'password': password.value, 'action': 'editEmail'}, 'ajaxPhp/customer-profile.php', function(response) {
		if(response == 1) {
			location.reload();
		}
		else if(response == 'wrong_current_password') {
			displayResult('Current Password is incorrect.','danger','alert-dismissible fade show mt-4 mx-md-4', true, 'result-email');
		}
		else {
			let result = response == 'Email is already used' ? response : 'Code not sent. Please try again!';
			displayResult(result,'danger','alert-dismissible fade show mt-4 mx-md-4', true, 'result-email');
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
	ajax({'action': 'editEmail', 'code' : code.value}, 'ajaxPhp/customer-profile.php', function(response) {
		if(response == 1) {
			location.reload();
		}
		else if(response == 2){
			displayResult('Code is incorrect.','danger','alert-dismissible fade show mt-4 mx-md-4', true, 'result-email');
			document.getElementById('attempts').innerHTML -= 1;
		}
		else if(response == 3) {
			document.getElementById('attempts').innerHTML = 0 ;
			displayResult('You have used all your attempts. You can resend new code after 2 minutes.','danger','alert-dismissible fade show mt-4 mx-md-4', true, 'result-email');
			disableResend();
			clearInterval(resendTimer);
			resendTimer = setInterval(resendTimerFunction, '1000');
		}
		else {
			displayResult('Something went wrong! Please try again.','danger','alert-dismissible fade show mt-4 mx-md-4', true, 'result-email');
		}
		stopLoading();
		});
	});
	
	resendCode.addEventListener('click', function(e) {
	if(resendCounter < 0) {
		startLoading();
		ajax({'action': 'editEmail', 'action2': 'RESEND CODE'},'ajaxPhp/customer-profile.php', function(response) {
			if(response == 1) {
				displayResult('We have sent a new verification code.','success','alert-dismissible fade show mt-4 mx-md-4', true, 'result-email');
				disableResend();
				resendTimer = setInterval(resendTimerFunction, '1000');
				document.getElementById('attempts').innerHTML = 5;
			}
			else {
				displayResult('Something went wrong! Please try again!','danger','alert-dismissible fade show mt-4 mx-md-4', true, 'result-email');
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

if(changeEmail != null) {
	changeEmail.addEventListener('click', function(e) {
	ajax({'action': 'editEmail', 'action2': 'CHANGE EMAIL'},'ajaxPhp/customer-profile.php', function(response) {
		if(response == 1) {
			location.reload();
		}
		})
	});
}