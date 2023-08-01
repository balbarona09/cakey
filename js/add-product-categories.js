import {ajax} from './ajax.js';

const addProductCategoryForm = document.getElementById('add-product-category-form');

addProductCategoryForm.addEventListener('submit', function(e) {
	e.preventDefault();
	startLoading();
	let name = document.getElementById('name');
	let image = document.getElementById('image');
	ajax({'name': name.value, 'image' : image.files[0], 'action' : 'addProductCategory'}, '../ajaxPhp/product-categories.php', function(response) {
		if(response == 'success') {
			addProductCategoryForm.reset();
			displayResult('Product category successfully added.', 'success', 'alert-dismissible fade show mt-4 mx-md-4', true);
		}
		else if(response == 'already_exist') {
			displayResult('Category name already exist.', 'danger', 'alert-dismissible fade show mt-4 mx-md-4', true);
		}
		else {
			displayResult('Somethig went wrong.', 'danger', 'alert-dismissible fade show mt-4 mx-md-4', true);
		}
		stopLoading();
	})
});