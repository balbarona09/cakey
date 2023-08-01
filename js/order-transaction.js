import {ajax} from './ajax.js';
import {updateRegions, updateProvinces, updateCities, updateBarangays} from './address.js';

// Start Cart page
const cartDetailsTable = document.getElementById('cart-details-table');

if(cartDetailsTable != null) {
	getCart();
}

function getCart() {
	startLoading();
	ajax({'action': 'getCart'}, 'ajaxPhp/order-transaction.php', function(response) {
		if(response == 'error') {
			displayResult('Something Went Wrong. Please refresh.','danger');
		}
		else {
			if(cartDetailsTable != null) {
				displayCart(JSON.parse(response));
			}
			else {
				displayOrderSummary(JSON.parse(response));
			}
		}
		stopLoading();
	});
}

function displayCart(carts) {
	cartDetailsTable.innerHTML = '';
	const subtotal = document.getElementById('subtotal');
	const delivery = document.getElementById('delivery');
	const total = document.getElementById('total');
	const checkoutBtn = document.getElementById('btn-checkout');
	subtotal.innerHTML = 0;
	delivery.innerHTML = 0;
	if(JSON.stringify(carts) != "[]") {
		checkoutBtn.setAttribute('class', 'btn btn-primary');
	}
	for(let cart of carts) {
		const tr = document.createElement('tr');
		const orderDetailsTd = document.createElement('td');
		const productLink = document.createElement('a');
		const image = document.createElement('img');
		const product = document.createElement('p');
		const amount = document.createElement('p');
		const quantityTd = document.createElement('td');
		const totalPriceTd = document.createElement('td');
		const removeTd = document.createElement('td');
		const removeButton = document.createElement('button');
		
		productLink.setAttribute('href', 'product-details.php?id='+cart['product_id']);
		productLink.setAttribute('class', 'link-dark link-underline link-underline-opacity-0');
		image.setAttribute('src', 'images/product-images/'+cart['product_id']+'.'+cart['extension_file']);
		image.setAttribute('class', 'img-fluid');
		image.setAttribute('style', 'width: 100px');
		product.innerHTML = cart['name'];
		amount.innerHTML = '&#8369;'+cart['amount'];
		quantityTd.innerHTML = cart['quantity'];
		totalPriceTd.innerHTML = '&#8369;' + (cart['amount'] * cart['quantity']);
		removeButton.innerHTML = '&times;';
		removeButton.setAttribute('class', 'btn btn-danger');
		removeButton.addEventListener('click', function() { removeCart(cart['transaction_id']); } );
		
		productLink.appendChild(image);
		productLink.appendChild(product);
		productLink.appendChild(amount);
		orderDetailsTd.appendChild(productLink);
		tr.appendChild(orderDetailsTd);
		tr.appendChild(quantityTd);
		tr.appendChild(totalPriceTd);
		removeTd.appendChild(removeButton);
		tr.appendChild(removeTd);
		cartDetailsTable.appendChild(tr);
		
		subtotal.innerHTML = Number(subtotal.innerHTML) + cart['amount'] * cart['quantity'];
	}
	total.innerHTML = 'TOTAL: &#8369;' + (Number(subtotal.innerHTML) + Number(delivery.innerHTML));
	subtotal.innerHTML = 'SUBTOTAL: &#8369;' + subtotal.innerHTML;
	delivery.innerHTML = 'DELIVERY: &#8369;' + delivery.innerHTML;
}

function removeCart(transactionId) {
	startLoading();
	ajax({'action': 'removeCart', 'id': transactionId}, 'ajaxPhp/order-transaction.php', function(response) {
		if(response == 'success') {
			displayResult('Item Removed Successfully','success');
			getCart();
		}
		else {
			displayResult('Something Went Wrong. Please refresh.','danger');
		}
		stopLoading();
	});
}
//End Cart Page

//Start Checkout Page
const orderSummary = document.getElementById('order-summary');

if(orderSummary != null) {
	getCart();
	getUserAddress();
}

function getUserAddress() {
	startLoading();
	ajax({'action': 'getUserAddress'}, 'ajaxPhp/order-transaction.php', function(response) {
		if(response == 'error') {
			displayResult('Something Went Wrong. Please refresh.','danger');
		}
		else {
			displayUserAddress(JSON.parse(response)[0]);
		}
		stopLoading();
	});
}

function displayOrderSummary(carts) {
	orderSummary.innerHTML = '';
	let total = 0;
	for(let cart of carts) {
		const container = document.createElement('div');
		const productName = document.createElement('p');
		const productPrice = document.createElement('p');
		
		container.setAttribute('class', 'd-flex justify-content-between');
		productName.innerHTML = cart['name'] + '(' + cart['quantity'] + ')';
		productPrice.innerHTML = '&#8369;'+cart['amount'] * cart['quantity'];
		
		container.appendChild(productName);
		container.appendChild(productPrice);
		orderSummary.appendChild(container);
		
		total += Number(cart['amount']) * cart['quantity'];
	}
	const hr = document.createElement('hr');
	const container =  document.createElement('div');
	container.setAttribute('class', 'd-flex justify-content-between');
	const totalText = document.createElement('p');
	const totalAmount = document.createElement('p');
	totalText.innerHTML = 'Total: ';
	totalAmount.innerHTML = '&#8369;'+total;
	
	orderSummary.appendChild(hr);
	container.appendChild(totalText);
	container.appendChild(totalAmount);
	orderSummary.appendChild(container);	
}

function displayUserAddress(address) {
	const fullname = document.getElementById('fullname');
	const phone = document.getElementById('phone');
	const region = document.getElementById('region');
	const province = document.getElementById('province');
	const city = document.getElementById('city');
	const barangay = document.getElementById('barangay');
	const postalCode = document.getElementById('postal-code');
	const street = document.getElementById('street');
	
	fullname.value = address['name'];
	phone.value = address['phone'];
	updateRegions(address['region']);
	updateProvinces(address['province']);
	updateCities(address['city']);
	updateBarangays(address['barangay']);
	postalCode.value = address['postal_code'];
	street.value = address['street'];
}

const checkoutForm = document.getElementById('checkout-form');

if(checkoutForm != null) {
	checkoutForm.addEventListener('submit', placeOrder);
}

function placeOrder(e) {
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
	const paymentMethod = document.getElementById('cod');
	ajax({'action': 'placeOrder', 'fullname': fullname.value, 'phone': phone.value,
	'region': region.value, 'province': province.value, 'city': city.value, 'barangay': barangay.value,
	'postal_code': postalCode.value, 'street': street.value, 'payment_method': paymentMethod.value}, 
	'ajaxPhp/order-transaction.php', function(response) {
		if(response == 'success') {
			location.replace('order-placed.php');
		}
		else if(response == 'no_fullname') {
			displayResult('Please enter your fullname','danger');
		}
		else if(response == 'no_phone') {
			displayResult('Please enter your phone number','danger');
		}
		else if(response == 'no_region') {
			displayResult('Please enter your region','danger');
		}
		else if(response == 'no_province') {
			displayResult('Please enter your province','danger');
		}
		else if(response == 'no_city') {
			displayResult('Please enter your city','danger');
		}
		else if(response == 'no_barangay') {
			displayResult('Please enter your barangay','danger');
		}
		else if(response == 'no_postal_code') {
			displayResult('Please enter your postal code','danger');
		}
		else if(response == 'no_street') {
			displayResult('Please enter your street','danger');
		}
		else if(response == 'no_payment_method') {
			displayResult('Please enter your payment method','danger');
		}
		else {
			displayResult('Something went wrong. Please try again!','danger');
		}
		stopLoading();
		scrollTo(0, 0);
	});
}
//End Checkout page

//Start Puchases Page

const purchasesDetailsTable = document.getElementById('purchases-details-table');
const purchasesFilter = document.getElementById('purchases-filter');

if(purchasesDetailsTable != null) {
	getPurchases();
	purchasesFilter.addEventListener('change', getPurchases);
	
	const cancelOrderModal = new bootstrap.Modal(document.getElementById('cancel-order-modal'));
	const cancelOrderForm = document.getElementById('cancel-order-form');
	cancelOrderForm.addEventListener('submit', function (e) {
		e.preventDefault();
		cancelOrderModal.hide();
		cancelOrder();
	});
}

function getPurchases() {
	startLoading();
	ajax({'action': 'getPurchases', 'status': purchasesFilter.value}, 'ajaxPhp/order-transaction.php', function(response) {
		if(response == 'error') {
			displayResult('Something Went Wrong. Please refresh.','danger');
		}
		else {
			displayPurchases(JSON.parse(response));
		}
		stopLoading();
	});
}

function displayPurchases(purchases) {
	purchasesDetailsTable.innerHTML = '';
	for(let purchase of purchases) {
		const tr = document.createElement('tr');
		const orderDetailsTd = document.createElement('td');
		const productLink = document.createElement('a');
		const image = document.createElement('img');
		const product = document.createElement('p');
		const amount = document.createElement('p');
		const quantityTd = document.createElement('td');
		const totalPriceTd = document.createElement('td');
		const statusTd = document.createElement('td');
		const actionTd = document.createElement('td');
		const statusText = {'1': 'Waiting for confirmation', '2': 'On Delivery', '3': 'Completed', 
		'4': 'Cancelled By You', '5': 'Cancelled By Admin'};
		const statusClass = {'1': 'text-secondary', '2': 'text-danger', '3': 'text-success', 
		'4': 'text-danger', '5': 'text-danger'};
		
		productLink.setAttribute('href', 'product-details.php?id='+purchase['product_id']);
		productLink.setAttribute('class', 'link-dark link-underline link-underline-opacity-0');
		image.setAttribute('src', 'images/product-images/'+purchase['product_id']+'.'+purchase['extension_file']);
		image.setAttribute('class', 'img-fluid');
		image.setAttribute('style', 'width: 100px');
		product.innerHTML = purchase['name'];
		amount.innerHTML = '&#8369;'+purchase['amount'];
		quantityTd.innerHTML = purchase['quantity'];
		totalPriceTd.innerHTML = '&#8369;' + (purchase['amount'] * purchase['quantity']);
		statusTd.innerHTML = statusText[purchase['status']];
		statusTd.setAttribute('class', statusClass[purchase['status']] + ' fw-medium');
		if(purchase['status'] == 1) {
			const cancelButton = document.createElement('button');
			const cancelId = document.getElementById('cancel-order-id');
			cancelButton.innerHTML = 'Cancel Order';
			cancelButton.setAttribute('class', 'btn btn-primary');
			cancelButton.setAttribute('data-bs-toggle', 'modal');
			cancelButton.setAttribute('data-bs-target', '#cancel-order-modal');
			cancelButton.addEventListener('click', function() {
				cancelId.value = purchase['transaction_id'];
			});
			actionTd.appendChild(cancelButton);
		}
		else if(purchase['status'] == 3) {
			const orderAgainButton = document.createElement('button');
			orderAgainButton.innerHTML = 'Order Again';
			orderAgainButton.setAttribute('class', 'btn btn-danger');
			orderAgainButton.addEventListener('click', function() { buyAgain(purchase['product_id']); } );
			actionTd.appendChild(orderAgainButton);
		}
		
		productLink.appendChild(image);
		productLink.appendChild(product);
		productLink.appendChild(amount);
		orderDetailsTd.appendChild(productLink);
		tr.appendChild(orderDetailsTd);
		tr.appendChild(quantityTd);
		tr.appendChild(totalPriceTd);
		tr.appendChild(statusTd);
		tr.appendChild(actionTd);
		purchasesDetailsTable.appendChild(tr);
		
	}
}

function buyAgain(id) {
	startLoading();
	ajax({'action': 'addToCart', 'id': id, 'quantity': '1'}, 'ajaxPhp/menu.php', function(response) {
		if(response == 'success') {
			location.replace('cart.php');
		}
		else {
			displayResult('Something Went Wrong. Please Try again.','danger');
		}
		stopLoading();
	});
}

function cancelOrder(transactionId = document.getElementById('cancel-order-id').value) {
	startLoading();
	ajax({'action': 'cancelOrder', 'id': transactionId}, 'ajaxPhp/order-transaction.php', function(response) {
		if(response == 'success') {
			displayResult('Order Successfully Cancelled','success', 'alert-dismissible fade show mt-4 mx-md-4', true);
			getPurchases();
		}
		else {
			displayResult('Something Went Wrong. Please refresh.','danger');
		}
		stopLoading();
		scrollTo(0, 0);
	});
}