import {ajax} from './ajax.js';

//Start Product Category Page.
const menuCategoryContainer = document.getElementById('menu-category-container');
if(menuCategoryContainer != null) {
	getMenuCategories();
}

function getMenuCategories() {
	startLoading();
	ajax({'action': 'getMenuCategories'}, 'ajaxPhp/menu.php', function(response) {
		if(response == 'error') {
			displayResult('Something Went Wrong. Please refresh.','danger');
		}
		else {
			displayMenuCategory(JSON.parse(response));
		}
		stopLoading();
	})
}

function displayMenuCategory(menuCategories) {
	if(JSON.stringify(menuCategories) == "[]") {
		document.getElementById('menu-title').innerHTML = 'No menu yet here';
	}
	for(let menuCategory of menuCategories) {
		let container = document.createElement('a');
		let image = document.createElement('img');
		let name = document.createElement('h2');
		
		
		container.setAttribute('href', 'products.php?id='+menuCategory['product_category_id']);
		container.setAttribute('class', 'card shadow pointer text-decoration-none mb-2');
		image.setAttribute('src', 'images/product-category-images/'+ 
		menuCategory['product_category_id'] +'.'+ menuCategory['extension_file']);
		image.setAttribute('class', 'img-fluid mb-2');
		image.setAttribute('style', 'height: 260px');
		name.innerHTML = menuCategory['name'];
		
		container.appendChild(image);
		container.appendChild(name);
		menuCategoryContainer.appendChild(container);
	}
}
//End Product Category Page

//Start Products Page
const productContainer = document.getElementById('product-container');
if(productContainer != null) {
	getProducts();
}


function getProducts() {
	startLoading();
	const urlParams = new URLSearchParams(window.location.search);
	const id = urlParams.get('id');
	ajax({'action': 'getProducts', 'product_category_id': id}, 'ajaxPhp/menu.php', function(response) {
		if(response == 'error') {
			displayResult('Something Went Wrong. Please refresh.','danger');
		}
		else {
			displayProducts(JSON.parse(response));
		}
		stopLoading();
	})
}

function displayProducts(products) {
	let productCategoryTitle = document.getElementById('product-category-title');
	productCategoryTitle.innerHTML = JSON.stringify(products) == "[]" ? 'No products yet here' : products[0]['product_category'];
	for(let product of products) {
		const container = document.createElement('a');
		const image = document.createElement('img');
		const name = document.createElement('h2');
		const amount = document.createElement('p');
		const orderButton = document.createElement('a');
		
		let link = sessionStorage.getItem('logged_in') == 'true' ? 'product-details.php?id='+product['product_id'] : 'login.php';
		container.setAttribute('href', link);
		container.setAttribute('class', 'card shadow pointer text-decoration-none mb-2');
		image.setAttribute('src', 'images/product-images/'+ 
		product['product_id'] +'.'+ product['extension_file']);
		image.setAttribute('class', 'img-fluid mb-2');
		image.setAttribute('style', 'height: 260px');
		name.innerHTML = product['name'];
		amount.innerHTML = '&#8369;' + product['amount'];
		amount.setAttribute('class', 'h6 text-danger');
		orderButton.innerHTML = 'Start Order';
		orderButton.setAttribute('class', 'btn btn-lg btn-primary w-75 m-auto mb-3');
		
		container.appendChild(image);
		container.appendChild(name);
		container.appendChild(amount);
		container.appendChild(orderButton);
		productContainer.appendChild(container);
	}
}
//End Products Page

//Start Products Deatails Page
const productDetailsContainer = document.getElementById('product-details-container');
if(productDetailsContainer != null) {
	getProduct();
	const subtractQuantityButton = document.getElementById('subtract-quantity');
	const addQuantityButton = document.getElementById('add-quantity');
	const addToCartButton = document.getElementById('add-to-cart');
	const buyNowButton = document.getElementById('buy-now');
	
	subtractQuantityButton.addEventListener('click', subtractQuantity);
	addQuantityButton.addEventListener('click', addQuantity);
	addToCartButton.addEventListener('click', addToCart);
	buyNowButton.addEventListener('click', addToCart);
}
function subtractQuantity() {
	const quantity = document.getElementById('quantity');
	if(Number(quantity.innerHTML) > 1) {
		quantity.innerHTML = Number(quantity.innerHTML) - 1;
	}
}
function addQuantity() {
	const quantity = document.getElementById('quantity');
	quantity.innerHTML = Number(quantity.innerHTML) + 1;
}
function addToCart(e) {
	startLoading();
	const urlParams = new URLSearchParams(window.location.search);
	const id = urlParams.get('id');
	const quantity = document.getElementById('quantity');
	ajax({'action': 'addToCart', 'id': id, 'quantity': quantity.innerHTML}, 'ajaxPhp/menu.php', function(response) {
		if(response == 'success') {
			if(e.target.innerHTML == 'Buy now') {
				location.replace('cart.php');
			}
			displayResult('Successfully Added to Cart.','success');
		}
		else {
			displayResult('Something Went Wrong. Please Try again.','danger');
		}
		stopLoading();
	})
}

function getProduct() {
	startLoading();
	const urlParams = new URLSearchParams(window.location.search);
	const id = urlParams.get('id');
	ajax({'action': 'getProduct', 'id': id}, 'ajaxPhp/menu.php', function(response) {
		if(response == 'error') {
			displayResult('Something Went Wrong. Please refresh.','danger');
		}
		else {
			displayProductDetails(JSON.parse(response));
		}
		stopLoading();
	})
}

function displayProductDetails(product) {
	let image = document.getElementById('product-details-image');
	let productName = document.getElementById('product-details-name');
	let productAmount = document.getElementById('product-details-amount');
	let productDescription = document.getElementById('product-details-description');
	
	image.setAttribute('src', 'images/product-images/' + product[0]['product_id'] +"."+ product[0]['extension_file']);
	productName.innerHTML = product[0]['name'];
	productAmount.innerHTML = '&#8369;' + product[0]['amount'];
	productDescription.innerHTML = product[0]['description'];
}
//End Products Details Page