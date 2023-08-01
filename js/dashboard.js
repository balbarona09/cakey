import {ajax} from './ajax.js';

getDashboard();

function getDashboard() {
	startLoading();
	ajax({'action': 'getDashboard'}, '../ajaxPhp/dashboard.php', function(response) {
		if(response == 'error') {
			displayResult('Something went wrong.', 'danger', 'alert-dismissible fade show mt-4 mx-md-4', true);
		}
		else {
			displayDashboard(JSON.parse(response)[0]);
		}
		stopLoading();
	});
}

function displayDashboard(dashboard) {
	const products = document.getElementById('products');
	const customers = document.getElementById('customers');
	const pendingOrders = document.getElementById('pending-orders');
	const deliveryOrders = document.getElementById('delivery-orders');
	const completedOrders = document.getElementById('completed-orders');
	
	products.innerHTML = dashboard['products'];
	customers.innerHTML = dashboard['customers'];
	pendingOrders.innerHTML = dashboard['pending_orders'];
	deliveryOrders.innerHTML = dashboard['delivery_orders'];
	completedOrders.innerHTML = '&#8369;' + ( dashboard['completed_orders'] == null ? 0 : dashboard['completed_orders'] );
}