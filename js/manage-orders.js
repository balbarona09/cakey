import {ajax} from './ajax.js';

let counter = 1;
let offset = 0;
let limit = 10;
let order = 'id';
let sort = 'ASC';
let status = 1;
const confirmOrderId = document.getElementById('confirm-order-id');
const cancelOrderId = document.getElementById('cancel-order-id');
const receiveOrderId = document.getElementById('receive-order-id');
const nextButton = document.getElementById('next');
const previousButton = document.getElementById('previous');

function showOrders() {
	nextButton.setAttribute("disabled", true);
	previousButton.setAttribute("disabled", true);
	ajax({'action': 'getOrders', 'limit': limit, 'offset': offset, 'order': order, 'sort': sort, 'status': status}, 
	'../ajaxPhp/manage-orders.php', function(response) {
		const orders = JSON.parse(response);
		const orderTable = document.getElementById('order-table');
		const entriesStatement = document.getElementById('entries-statement');
		entriesStatement.innerHTML = orders.length == 1 ? 'Showing 0' : 'Showing ' + counter;
		orderTable.innerHTML = '';
		for (let counterLoop = 0; counterLoop < orders.length; counterLoop++) {
			let order = orders[counterLoop];
			
			if(counterLoop == orders.length - 1) {
				entriesStatement.innerHTML += ' to ' + --counter + ' of ' + order + ' entries ';
				if(counter != order) {
					nextButton.removeAttribute("disabled");
				}
				if(offset != 0) {
					previousButton.removeAttribute("disabled");
				}
				break;
			}
			
			const tr = document.createElement('tr');
			const thCounter = document.createElement('td');
			const tdProduct = document.createElement('td');
			const tdAmount = document.createElement('td');
			const tdQuantity = document.createElement('td');
			const tdTotal = document.createElement('td');
			const tdCustomer = document.createElement('td');
			const tdAddress = document.createElement('td');
			const showAddress = document.createElement('button');
			const tdPaymentMethod = document.createElement('td');
			const tdCreationDate = document.createElement('td');
			const tdUpdationDate = document.createElement('td');
			const tdAction = document.createElement('td');
		
			thCounter.innerHTML = counter;
			tdProduct.innerHTML = order['ordered_product'];
			tdAmount.innerHTML = '&#8369;' + order['ordered_amount'];
			tdQuantity.innerHTML = order['quantity'];
			tdTotal.innerHTML = '&#8369;' + (order['ordered_amount'] * order['quantity']);
			tdCustomer.innerHTML = order['fullname'];
			showAddress.setAttribute('class', 'btn btn-primary');
			showAddress.setAttribute('data-bs-toggle', 'modal');
			showAddress.setAttribute('data-bs-target', '#address-modal');
			showAddress.addEventListener('click', function() {
				document.getElementById('fullname-modal').innerHTML = order['fullname'];
				document.getElementById('phone-modal').innerHTML = order['phone'];
				document.getElementById('region-modal').innerHTML = order['region'];
				document.getElementById('province-modal').innerHTML = order['province'];
				document.getElementById('city-modal').innerHTML = order['city'];
				document.getElementById('barangay-modal').innerHTML = order['barangay'];
				document.getElementById('postal-code-modal').innerHTML = order['postal_code'];
				document.getElementById('street-modal').innerHTML = order['street'];
			});
			showAddress.innerHTML = 'Show Address';
			tdPaymentMethod.innerHTML = order['payment_method'];
			tdCreationDate.innerHTML = order['creation_date'];
			tdUpdationDate.innerHTML = order['updation_date'];
			tdAction.setAttribute("class", "d-flex justify-content-around align-items-center");
			if(status == 1) {
				const confirmButton = document.createElement('button');
				confirmButton.setAttribute('class', 'btn btn-sm btn-primary mx-2');
				confirmButton.setAttribute('data-bs-toggle', 'modal');
				confirmButton.setAttribute('data-bs-target', '#confirm-order-modal');
				confirmButton.innerHTML = 'Confirm';
				confirmButton.addEventListener('click', function() {
					confirmOrderId.value = order['transaction_id'];
				});
				tdAction.appendChild(confirmButton);
			}
			if(status == 2) {
				const receiveButton = document.createElement('button');
				receiveButton.setAttribute('class', 'btn btn-sm btn-primary mx-2');
				receiveButton.setAttribute('data-bs-toggle', 'modal');
				receiveButton.setAttribute('data-bs-target', '#receive-order-modal');
				receiveButton.innerHTML = 'Receive';
				receiveButton.addEventListener('click', function() {
					receiveOrderId.value = order['transaction_id'];
				});
				tdAction.appendChild(receiveButton);
			}
			if(status == 1 || status == 2) {
				const cancelButton = document.createElement('button');
				cancelButton.setAttribute('class', 'btn btn-sm btn-secondary mx-2');
				cancelButton.setAttribute('data-bs-toggle', 'modal');
				cancelButton.setAttribute('data-bs-target', '#cancel-order-modal');
				cancelButton.innerHTML = 'Cancel';
				cancelButton.addEventListener('click', function() {
				 cancelOrderId.value = order['transaction_id'];
				});
				tdAction.appendChild(cancelButton);
			}
			
			tdAddress.appendChild(showAddress);
			tr.appendChild(thCounter);
			tr.appendChild(tdProduct);
			tr.appendChild(tdAmount);
			tr.appendChild(tdQuantity);
			tr.appendChild(tdTotal);
			tr.appendChild(tdCustomer);
			tr.appendChild(tdAddress);
			tr.appendChild(tdPaymentMethod);
			tr.appendChild(tdCreationDate);
			tr.appendChild(tdUpdationDate);
			tr.appendChild(tdAction);
			orderTable.appendChild(tr);
			
			counter++;
			
		}
	})
}

showOrders();

const confirmOrderModal = new bootstrap.Modal(document.getElementById('confirm-order-modal'));
const confirmOrderForm = document.getElementById('confirm-order-form');
confirmOrderForm.addEventListener('submit', function(e) {
	e.preventDefault();
	startLoading();
	confirmOrderModal.hide();
	ajax({'id': confirmOrderId.value, 'action' : 'confirmOrder'}, '../ajaxPhp/manage-orders.php', function(response) {
		if(response == 'success') {
			counter = offset + 1;
			showOrders();
			displayResult('Order Successfully Confirmed.', 'success', 'alert-dismissible fade show mt-4 mx-md-4', true);
		}
		else {
			displayResult('Somethig went wrong.', 'danger', 'alert-dismissible fade show mt-4 mx-md-4', true);
		}
		stopLoading();
	})
});

const cancelOrderModal = new bootstrap.Modal(document.getElementById('cancel-order-modal'));
const cancelOrderForm = document.getElementById('cancel-order-form');
cancelOrderForm.addEventListener('submit', function(e) {
	e.preventDefault();
	startLoading();
	cancelOrderModal.hide();
	ajax({'id': cancelOrderId.value, 'action' : 'cancelOrder'}, '../ajaxPhp/manage-orders.php', function(response) {
		if(response == 'success') {
			counter = offset + 1;
			showOrders();
			displayResult('Order Successfully Cancelled.', 'success', 'alert-dismissible fade show mt-4 mx-md-4', true);
		}
		else {
			displayResult('Somethig went wrong.', 'danger', 'alert-dismissible fade show mt-4 mx-md-4', true);
		}
		stopLoading();
	})
});

const receiveOrderModal = new bootstrap.Modal(document.getElementById('receive-order-modal'));
const receiveOrderForm = document.getElementById('receive-order-form');
receiveOrderForm.addEventListener('submit', function(e) {
	e.preventDefault();
	startLoading();
	receiveOrderModal.hide();
	ajax({'id': receiveOrderId.value, 'action' : 'receiveOrder'}, '../ajaxPhp/manage-orders.php', function(response) {
		if(response == 'success') {
			counter = offset + 1;
			showOrders();
			displayResult('Order Successfully Received.', 'success', 'alert-dismissible fade show mt-4 mx-md-4', true);
		}
		else {
			displayResult('Somethig went wrong.', 'danger', 'alert-dismissible fade show mt-4 mx-md-4', true);
		}
		stopLoading();
	})
});

const filter = document.getElementById('filter-order');
filter.addEventListener('change', function(e) {
	status = e.target.value;
	counter = offset + 1;
	showOrders();
})

const orderLimit = document.getElementById('order-limit');
orderLimit.addEventListener('change', function(e) {
	console.log('dd');
	limit = e.target.value;
	counter = offset + 1;
	showOrders();
});

nextButton.addEventListener('click', function() {
	counter++;
	offset = counter - 1;
	showOrders();
});

previousButton.addEventListener('click', function() {
	counter = offset - (orderLimit.value - 1);
	counter = counter <= 0 ? 1 : counter;
	offset = counter - 1;
	showOrders();
});

const productSort = document.getElementById('product-sort');
const amountSort = document.getElementById('amount-sort');
const quantitySort = document.getElementById('quantity-sort');
const totalSort = document.getElementById('total-sort');
const customerSort = document.getElementById('customer-sort');
const paymentMethodSort = document.getElementById('payment-method-sort');
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
	productSort.firstElementChild.classList.remove("text-primary");
	productSort.lastElementChild.classList.remove("text-primary");
	amountSort.firstElementChild.classList.remove('text-primary');
	amountSort.lastElementChild.classList.remove('text-primary');
	quantitySort.firstElementChild.classList.remove('text-primary');
	quantitySort.lastElementChild.classList.remove('text-primary');
	totalSort.firstElementChild.classList.remove('text-primary');
	totalSort.lastElementChild.classList.remove('text-primary');
	customerSort.firstElementChild.classList.remove('text-primary');
	customerSort.lastElementChild.classList.remove('text-primary');
	paymentMethodSort.firstElementChild.classList.remove('text-primary');
	paymentMethodSort.lastElementChild.classList.remove('text-primary');
	creationDateSort.firstElementChild.classList.remove("text-primary");
	creationDateSort.lastElementChild.classList.remove("text-primary");
	updationDateSort.firstElementChild.classList.remove("text-primary");
	updationDateSort.lastElementChild.classList.remove("text-primary");
}

productSort.addEventListener('click', function(e) {
	order = 'ordered_product';
	handleIconColor(productSort.firstElementChild, productSort.lastElementChild);
	counter = offset + 1;
	showOrders();
});

amountSort.addEventListener('click', function(e) {
	order = 'ordered_amount';
	handleIconColor(amountSort.firstElementChild, amountSort.lastElementChild);
	counter = offset + 1;
	showOrders();
});

quantitySort.addEventListener('click', function(e) {
	order = 'ordered_amount';
	handleIconColor(quantitySort.firstElementChild, quantitySort.lastElementChild);
	counter = offset + 1;
	showOrders();
});

totalSort.addEventListener('click', function(e) {
	order = 'ordered_amount';
	handleIconColor(totalSort.firstElementChild, totalSort.lastElementChild);
	counter = offset + 1;
	showOrders();
});

customerSort.addEventListener('click', function(e) {
	order = 'ordered_amount';
	handleIconColor(customerSort.firstElementChild, customerSort.lastElementChild);
	counter = offset + 1;
	showOrders();
});

paymentMethodSort.addEventListener('click', function(e) {
	order = 'ordered_amount';
	handleIconColor(paymentMethodSort.firstElementChild, paymentMethodSort.lastElementChild);
	counter = offset + 1;
	showOrders();
});

creationDateSort.addEventListener('click', function(e) {
	order = 'creation_date';
	handleIconColor(creationDateSort.firstElementChild, creationDateSort.lastElementChild)
	counter = offset + 1;
	showOrders();
});

updationDateSort.addEventListener('click', function(e) {
	order = 'updation_date';
	handleIconColor(updationDateSort.firstElementChild, updationDateSort.lastElementChild)
	counter = offset + 1;
	showOrders();
});
