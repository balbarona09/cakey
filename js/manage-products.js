import {ajax} from './ajax.js';

let counter = 1;
let offset = 0;
let limit = 10;
let order = 'id';
let sort = 'ASC';
let status = 0;
const editId = document.getElementById('edit-id');
const editProductCategory = document.getElementById('edit-product-category');
const editDescription = document.getElementById('edit-description');
const editName = document.getElementById('edit-name');
const editAmount = document.getElementById('edit-amount');
const editImage = document.getElementById('edit-image');
const archiveId = document.getElementById('archive-id');
const deleteId = document.getElementById('delete-id');
const nextButton = document.getElementById('next');
const previousButton = document.getElementById('previous');

function showProduct() {
	nextButton.setAttribute("disabled", true);
	previousButton.setAttribute("disabled", true);
	ajax({'action': 'getProduct', 'limit': limit, 'offset': offset, 'order': order, 'sort': sort, 'status': status}, 
	'../ajaxPhp/products.php', function(response) {
		const products = JSON.parse(response);
		const productTable = document.getElementById('product-table');
		const entriesStatement = document.getElementById('entries-statement');
		const image = document.getElementById('image-product');
		entriesStatement.innerHTML = products.length == 1 ? 'Showing 0' : 'Showing ' + counter;
		productTable.innerHTML = '';
		for (let counterLoop = 0; counterLoop < products.length; counterLoop++) {
			let product = products[counterLoop];
			
			if(counterLoop == products.length - 1) {
				entriesStatement.innerHTML += ' to ' + --counter + ' of ' + product + ' entries ';
				if(counter != product) {
					nextButton.removeAttribute("disabled");
				}
				if(offset != 0) {
					previousButton.removeAttribute("disabled");
				}
				break;
			}
			
			const tr = document.createElement('tr');
			const thCounter = document.createElement('td');
			const tdProductCategoryName = document.createElement('td');
			const tdName = document.createElement('td');
			const tdAmount = document.createElement('td');
			const tdDescription = document.createElement('td');
			const tdImage = document.createElement('button');
			const tdCreationDate = document.createElement('td');
			const tdUpdationDate = document.createElement('td');
			const tdAction = document.createElement('td');
			const editButton = document.createElement('button');
			const archiveButton = document.createElement('button');
		
			thCounter.innerHTML = counter;
			tdProductCategoryName.innerHTML = product['product_category_name'];
			tdName.innerHTML = product['name'];
			tdAmount.innerHTML = '&#8369 ' + product['amount'];
			tdDescription.innerHTML =  product['description'];
			tdImage.innerHTML = 'Show Image';
			tdImage.setAttribute("class", "btn btn-sm btn-primary text-white");
			tdImage.setAttribute('data-bs-toggle', 'modal');
			tdImage.setAttribute('data-bs-target', '#image-product-modal');
			tdImage.addEventListener('click', function() {
				image.src = "../images/product-images/" + product['product_id'] + "." + product['extension_file'];
			});
			tdCreationDate.innerHTML = product['creation_date'];
			tdUpdationDate.innerHTML = product['updation_date'];
			tdAction.setAttribute("class", "d-flex justify-content-around align-items-center")
			editButton.setAttribute('class', 'btn btn-sm btn-primary');
			editButton.setAttribute('data-bs-toggle', 'modal');
			editButton.setAttribute('data-bs-target', '#edit-product-modal');
			editButton.innerHTML = 'Edit';
			editButton.addEventListener('click', function() {
				editId.value = product['product_id'];
				editName.value = product['name'];
				editAmount.value = product['amount'];
				editDescription.value = product['description'];
				getProductCategory(product['product_category_id']);
			})
			archiveButton.setAttribute('class', 'btn btn-sm btn-secondary mx-2');
			archiveButton.setAttribute('data-bs-toggle', 'modal');
			archiveButton.setAttribute('data-bs-target', '#archive-product-modal');
			archiveButton.innerHTML = status == 0 ? 'Archive' : 'Unarchive';
			document.getElementById('archive-product-modal-label').innerHTML = 'Do you really want to '+archiveButton.innerHTML+' this product?';
			archiveButton.addEventListener('click', function() {
				archiveId.value = product['product_id'];
			})
			
			
			tdAction.appendChild(editButton);
			tdAction.appendChild(archiveButton);
			tr.appendChild(thCounter);
			tr.appendChild(tdProductCategoryName);
			tr.appendChild(tdName);
			tr.appendChild(tdAmount);
			tr.appendChild(tdDescription);
			tr.appendChild(tdImage);
			tr.appendChild(tdCreationDate);
			tr.appendChild(tdUpdationDate);
			tr.appendChild(tdAction);
			productTable.appendChild(tr);
			
			counter++;
			
		}
	})
}

function getProductCategory(id) {
	ajax({'action': 'getProductCategory'}, '../ajaxPhp/products.php', function(response) {
		let productCategorySelect = document.getElementById('edit-product-category');
		productCategorySelect.innerHTML = '';
		let productCategories = JSON.parse(response);
		for(let productCategory of productCategories) {
			let option = document.createElement('option');
			if(productCategory['product_category_id'] == id) {
				option.setAttribute('selected', true);
			}
			option.setAttribute('value', productCategory['product_category_id']);
			option.innerHTML = productCategory['name'];
			productCategorySelect.appendChild(option);
		}
	});
}

showProduct();

const editProductModal = new bootstrap.Modal(document.getElementById('edit-product-modal'));
const editProductForm = document.getElementById('edit-product-form');
editProductForm.addEventListener('submit', function(e) {
	e.preventDefault();
	startLoading();
	editProductModal.hide();
	ajax({'id': editId.value, 'name': editName.value, 'amount': editAmount.value, 'product_category_id': editProductCategory.value, 
	'description': editDescription.value, 'image': editImage.files[0], 'action' : 'editProduct'}, 
	'../ajaxPhp/products.php', function(response) {
		if(response == 'success') {
			counter = offset + 1;
			showProduct();
			displayResult('Product successfully updated.', 'success', 'alert-dismissible fade show mt-4 mx-md-4', true);
		}
		else if(response == 'already_exist') {
			displayResult('Product name already exist.', 'danger', 'alert-dismissible fade show mt-4 mx-md-4', true);
		}
		else {
			console.log(response);
			displayResult('Somethig went wrong.', 'danger', 'alert-dismissible fade show mt-4 mx-md-4', true);
		}
		stopLoading();
	})
});

const archiveProductModal = new bootstrap.Modal(document.getElementById('archive-product-modal'));
const archiveProductForm = document.getElementById('archive-product-form');
archiveProductForm.addEventListener('submit', function(e) {
	e.preventDefault();
	startLoading();
	archiveProductModal.hide();
	let archiveStatus = status == 0 ? 1 : 0;
	ajax({'id': archiveId.value, 'status': archiveStatus, 'action' : 'archiveProduct'}, '../ajaxPhp/products.php', function(response) {
		if(response == 'success') {
			counter = offset + 1;
			showProduct();
			displayResult('Product successfully archived.', 'success', 'alert-dismissible fade show mt-4 mx-md-4', true);
		}
		else {
			displayResult('Somethig went wrong.', 'danger', 'alert-dismissible fade show mt-4 mx-md-4', true);
		}
		stopLoading();
	})
});

const filter = document.getElementById('filter-product');
filter.addEventListener('change', function(e) {
	status = e.target.value;
	counter = offset + 1;
	showProduct();
})

const productsLimit = document.getElementById('product-limit');
productsLimit.addEventListener('change', function(e) {
	limit = e.target.value;
	counter = offset + 1;
	showProduct();
});

nextButton.addEventListener('click', function() {
	counter++;
	offset = counter - 1;
	showProduct();
});

previousButton.addEventListener('click', function() {
	counter = offset - (productsLimit.value - 1);
	counter = counter <= 0 ? 1 : counter;
	offset = counter - 1;
	showProduct();
});

const nameSort = document.getElementById('name-sort');
const creationDateSort = document.getElementById('creation-date-sort');
const updationDateSort = document.getElementById('updation-date-sort');
const productCategorySort = document.getElementById('product-category-sort');

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
	nameSort.firstElementChild.classList.remove("text-primary");
	nameSort.lastElementChild.classList.remove("text-primary");
	creationDateSort.firstElementChild.classList.remove("text-primary");
	creationDateSort.lastElementChild.classList.remove("text-primary");
	updationDateSort.firstElementChild.classList.remove("text-primary");
	updationDateSort.lastElementChild.classList.remove("text-primary");
	productCategorySort.firstElementChild.classList.remove("text-primary");
	productCategorySort.lastElementChild.classList.remove("text-primary");
}

nameSort.addEventListener('click', function(e) {
	order = 'name';
	handleIconColor(nameSort.firstElementChild, nameSort.lastElementChild);
	counter = offset + 1;
	showProduct();
});

creationDateSort.addEventListener('click', function(e) {
	order = 'creation_date';
	handleIconColor(creationDateSort.firstElementChild, creationDateSort.lastElementChild)
	counter = offset + 1;
	showProduct();
});

updationDateSort.addEventListener('click', function(e) {
	order = 'updation_date';
	handleIconColor(updationDateSort.firstElementChild, updationDateSort.lastElementChild)
	counter = offset + 1;
	showProduct();
});

productCategorySort.addEventListener('click', function(e) {
	order = 'product_category_name';
	handleIconColor(productCategorySort.firstElementChild, productCategorySort.lastElementChild)
	counter = offset + 1;
	showProduct();
});
