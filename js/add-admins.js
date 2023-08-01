import {ajax} from './ajax.js';

const addCustomerForm = document.getElementById('add-customer-form');

addCustomerForm.addEventListener('submit', function(e) {
	e.preventDefault();
	startLoading();
	const fullname = document.getElementById('fullname');
	const email = document.getElementById('email');
	const password = document.getElementById('password');
	const confirmPassword = document.getElementById('confirm-password');
	ajax({'fullname': fullname.value, 'email' : email.value, 'password': password.value, 'confirmPassword': confirmPassword.value,
	'action' : 'addAdmin'}, '../ajaxPhp/admins.php', function(response) {
		if(response == 'success') {
			addCustomerForm.reset();
			displayResult('Admin successfully added.', 'success', 'alert-dismissible fade show mt-4 mx-md-4', true);
		}
		else if(response == 'already_exist') {
			displayResult('Email already exist.', 'danger', 'alert-dismissible fade show mt-4 mx-md-4', true);
		}
		else if(response == 'passwords_do_not_match') {
			displayResult('Passwords do not match.', 'danger', 'alert-dismissible fade show mt-4 mx-md-4', true);
		}
		else {
			displayResult('Somethig went wrong.', 'danger', 'alert-dismissible fade show mt-4 mx-md-4', true);
		}
		stopLoading();
	})
});