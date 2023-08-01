import {ajax} from './ajax.js';

let counter = 1;
let offset = 0;
let limit = 10;
let order = 'id';
let sort = 'ASC';
let status = 0;
const editId = document.getElementById('edit-id');
const editFullname = document.getElementById('edit-fullname');
const editEmail = document.getElementById('edit-email');
const blockId = document.getElementById('block-id');
const nextButton = document.getElementById('next');
const previousButton = document.getElementById('previous');

function showAdmin() {
	nextButton.setAttribute("disabled", true);
	previousButton.setAttribute("disabled", true);
	ajax({'action': 'getAdmin', 'limit': limit, 'offset': offset, 'order': order, 'sort': sort, 'status': status}, 
	'../ajaxPhp/admins.php', function(response) {
		const customers = JSON.parse(response);
		const customerTable = document.getElementById('customer-table');
		const entriesStatement = document.getElementById('entries-statement');
		entriesStatement.innerHTML = customers.length == 1 ? 'Showing 0' : 'Showing ' + counter;
		customerTable.innerHTML = '';
		for (let counterLoop = 0; counterLoop < customers.length; counterLoop++) {
			let customer = customers[counterLoop];
			
			if(counterLoop == customers.length - 1) {
				entriesStatement.innerHTML += ' to ' + --counter + ' of ' + customer + ' entries ';
				if(counter != customer) {
					nextButton.removeAttribute("disabled");
				}
				if(offset != 0) {
					previousButton.removeAttribute("disabled");
				}
				break;
			}
			
			const tr = document.createElement('tr');
			const thCounter = document.createElement('td');
			const tdFullname = document.createElement('td');
			const tdEmail = document.createElement('td');
			const tdCreationDate = document.createElement('td');
			const tdUpdationDate = document.createElement('td');
			const tdAction = document.createElement('td');
			const blockButton = document.createElement('button');
		
			thCounter.innerHTML = counter;
			tdFullname.innerHTML = customer['name'];
			tdEmail.innerHTML = customer['email'];
			tdCreationDate.innerHTML = customer['creation_date'];
			tdUpdationDate.innerHTML = customer['updation_date'];
			tdAction.setAttribute("class", "d-flex justify-content-around align-items-center")
			blockButton.setAttribute('class', 'btn btn-sm btn-secondary mx-2');
			blockButton.setAttribute('data-bs-toggle', 'modal');
			blockButton.setAttribute('data-bs-target', '#block-customers-modal');
			blockButton.innerHTML = status == 0 ? 'Block' : 'Unblock';
			document.getElementById('block-customers-modal-label').innerHTML = 'Do you really want to '+blockButton.innerHTML+' this user?';
			blockButton.addEventListener('click', function() {
				blockId.value = customer['user_id'];
			})
			
			
			tdAction.appendChild(blockButton);
			tr.appendChild(thCounter);
			tr.appendChild(tdFullname);
			tr.appendChild(tdEmail);
			tr.appendChild(tdCreationDate);
			tr.appendChild(tdUpdationDate);
			tr.appendChild(tdAction);
			customerTable.appendChild(tr);
			
			counter++;
			
		}
	})
}

showAdmin();

const blockCustomerModal = new bootstrap.Modal(document.getElementById('block-customers-modal'));
const blockCustomerForm = document.getElementById('block-customer-form');
blockCustomerForm.addEventListener('submit', function(e) {
	e.preventDefault();
	startLoading();
	blockCustomerModal.hide();
	let archiveStatus = status == 0 ? 2 : 0;
	ajax({'id': blockId.value, 'status': archiveStatus, 'action' : 'blockCustomer'}, '../ajaxPhp/customers.php', function(response) {
		if(response == 'success') {
			counter = offset + 1;
			showAdmin();
			displayResult('Customer successfully blocked / unblocked.', 'success', 'alert-dismissible fade show mt-4 mx-md-4', true);
		}
		else {
			displayResult('Somethig went wrong.', 'danger', 'alert-dismissible fade show mt-4 mx-md-4', true);
			console.log(response);
		}
		stopLoading();
	})
});

const filter = document.getElementById('filter-customer');
filter.addEventListener('change', function(e) {
	status = e.target.value;
	counter = offset + 1;
	showAdmin();
})

const customerLimit = document.getElementById('customer-limit');
customerLimit.addEventListener('change', function(e) {
	limit = e.target.value;
	counter = offset + 1;
	showAdmin();
});

nextButton.addEventListener('click', function() {
	counter++;
	offset = counter - 1;
	showAdmin();
});

previousButton.addEventListener('click', function() {
	counter = offset - (customerLimit.value - 1);
	counter = counter <= 0 ? 1 : counter;
	offset = counter - 1;
	showAdmin();
});

const fullnameSort = document.getElementById('fullname-sort');
const emailSort = document.getElementById('email-sort');
const creationDateSort = document.getElementById('creation-date-sort');
const updationDateSort = document.getElementById('updation-date-sort');

function handleIconColor(upIcon, downIcon) {
	if(upIcon.classList.contains('text-primary')) {
		removeTextPrimary();
		downIcon.classList.add('text-primary');
		sort = 'DESC';
	}
	else {
		removeTextPrimary();
		upIcon.classList.add('text-primary');
		sort = 'ASC';
	}
}

function removeTextPrimary() {
	fullnameSort.firstElementChild.classList.remove("text-primary");
	fullnameSort.lastElementChild.classList.remove("text-primary");
	emailSort.firstElementChild.classList.remove('text-primary');
	emailSort.lastElementChild.classList.remove('text-primary');
	creationDateSort.firstElementChild.classList.remove("text-primary");
	creationDateSort.lastElementChild.classList.remove("text-primary");
	updationDateSort.firstElementChild.classList.remove("text-primary");
	updationDateSort.lastElementChild.classList.remove("text-primary");
}

fullnameSort.addEventListener('click', function(e) {
	order = 'name';
	handleIconColor(fullnameSort.firstElementChild, fullnameSort.lastElementChild);
	counter = offset + 1;
	showAdmin();
});

emailSort.addEventListener('click', function(e) {
	order = 'email';
	handleIconColor(emailSort.firstElementChild, emailSort.lastElementChild);
	counter = offset + 1;
	showAdmin();
});

creationDateSort.addEventListener('click', function(e) {
	order = 'creation_date';
	handleIconColor(creationDateSort.firstElementChild, creationDateSort.lastElementChild)
	counter = offset + 1;
	showAdmin();
});

updationDateSort.addEventListener('click', function(e) {
	order = 'updation_date';
	handleIconColor(updationDateSort.firstElementChild, updationDateSort.lastElementChild)
	counter = offset + 1;
	showAdmin();
});
