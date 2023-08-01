import {ajax} from './ajax.js';

const addProductForm = document.getElementById('add-product-form');

addProductForm.addEventListener('submit', function(e) {
	e.preventDefault();
	startLoading();
	let productCategoryId = document.getElementById('product-category');
	let name = document.getElementById('name');
	let amount = document.getElementById('amount');
	let description = document.getElementById('description');
	let image = document.getElementById('image');
	ajax({'product_category_id': productCategoryId.value, 'name': name.value, 'amount': amount.value, 'description': description.value, 
	'image' : image.files[0], 'action' : 'addProduct'}, '../ajaxPhp/products.php', function(response) {
		if(response == 'success') {
			addProductForm.reset();
			displayResult('Product category successfully added.', 'success', 'alert-dismissible fade show mt-4 mx-md-4', true);
		}
		else if(response == 'already_exist') {
			displayResult('Product name already exist.', 'danger', 'alert-dismissible fade show mt-4 mx-md-4', true);
		}
		else {
			displayResult('Somethig went wrong.', 'danger', 'alert-dismissible fade show mt-4 mx-md-4', true);
		}
		stopLoading();
	})
});

function getProductCategory() {
	ajax({'action': 'getProductCategory'}, '../ajaxPhp/products.php', function(response) {
		let productCategorySelect = document.getElementById('product-category');
		productCategorySelect.innerHTML = '';
		let productCategories = JSON.parse(response);
		for(let productCategory of productCategories) {
			let option = document.createElement('option');
			option.setAttribute('value', productCategory['product_category_id']);
			option.innerHTML = productCategory['name'];
			productCategorySelect.appendChild(option);
		}
	});
}

getProductCategory();