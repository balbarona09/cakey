import {ajax} from './ajax.js';

let counter = 1;
let offset = 0;
let limit = 10;
let order = 'id';
let sort = 'ASC';
let status = 0;
const editId = document.getElementById('edit-id');
const editName = document.getElementById('edit-name');
const editImage = document.getElementById('edit-image');
const archiveId = document.getElementById('archive-id');
const deleteId = document.getElementById('delete-id');
const nextButton = document.getElementById('next');
const previousButton = document.getElementById('previous');

function showProductCategory() {
	nextButton.setAttribute("disabled", true);
	previousButton.setAttribute("disabled", true);
	ajax({'action': 'getProductCategory', 'limit': limit, 'offset': offset, 'order': order, 'sort': sort, 'status': status}, 
	'../ajaxPhp/product-categories.php', function(response) {
		const productCategories = JSON.parse(response);
		const productCategoryTable = document.getElementById('product-category-table');
		const entriesStatement = document.getElementById('entries-statement');
		const image = document.getElementById('image-product-categories');
		entriesStatement.innerHTML = productCategories.length == 1 ? 'Showing 0' : 'Showing ' + counter;
		productCategoryTable.innerHTML = '';
		for (let counterLoop = 0; counterLoop < productCategories.length; counterLoop++) {
			let productCategory = productCategories[counterLoop];
			
			if(counterLoop == productCategories.length - 1) {
				entriesStatement.innerHTML += ' to ' + --counter + ' of ' + productCategory + ' entries ';
				if(counter != productCategory) {
					nextButton.removeAttribute("disabled");
				}
				if(offset != 0) {
					previousButton.removeAttribute("disabled");
				}
				break;
			}
			
			const tr = document.createElement('tr');
			const thCounter = document.createElement('td');
			const tdName = document.createElement('td');
			const tdImage = document.createElement('button');
			const tdCreationDate = document.createElement('td');
			const tdUpdationDate = document.createElement('td');
			const tdAction = document.createElement('td');
			const editButton = document.createElement('button');
			const archiveButton = document.createElement('button');
		
			thCounter.innerHTML = counter;
			tdName.innerHTML = productCategory['name'];
			tdImage.innerHTML = 'Show Image';
			tdImage.setAttribute("class", "btn btn-sm btn-primary text-white");
			tdImage.setAttribute('data-bs-toggle', 'modal');
			tdImage.setAttribute('data-bs-target', '#image-product-categories-modal');
			tdImage.addEventListener('click', function() {
				image.src = "../images/product-category-images/" + productCategory['product_category_id'] + "." + productCategory['extension_file'];
			});
			tdCreationDate.innerHTML = productCategory['creation_date'];
			tdUpdationDate.innerHTML = productCategory['updation_date'];
			tdAction.setAttribute("class", "d-flex justify-content-around align-items-center")
			editButton.setAttribute('class', 'btn btn-sm btn-primary');
			editButton.setAttribute('data-bs-toggle', 'modal');
			editButton.setAttribute('data-bs-target', '#edit-product-categories-modal');
			editButton.innerHTML = 'Edit';
			editButton.addEventListener('click', function() {
				editId.value = productCategory['product_category_id'];
				editName.value = productCategory['name'];
			})
			archiveButton.setAttribute('class', 'btn btn-sm btn-secondary mx-2');
			archiveButton.setAttribute('data-bs-toggle', 'modal');
			archiveButton.setAttribute('data-bs-target', '#archive-product-categories-modal');
			archiveButton.innerHTML = status == 0 ? 'Archive' : 'Unarchive';
			document.getElementById('archive-product-categories-modal-label').innerHTML = 'Do you really want to '+archiveButton.innerHTML+' this category?';
			archiveButton.addEventListener('click', function() {
				archiveId.value = productCategory['product_category_id'];
			})
			
			
			tdAction.appendChild(editButton);
			tdAction.appendChild(archiveButton);
			tr.appendChild(thCounter);
			tr.appendChild(tdName);
			tr.appendChild(tdImage);
			tr.appendChild(tdCreationDate);
			tr.appendChild(tdUpdationDate);
			tr.appendChild(tdAction);
			productCategoryTable.appendChild(tr);
			
			counter++;
			
		}
	})
}

showProductCategory();

const editProductCategoryModal = new bootstrap.Modal(document.getElementById('edit-product-categories-modal'));
const editProductCategoryForm = document.getElementById('edit-product-category-form');
editProductCategoryForm.addEventListener('submit', function(e) {
	e.preventDefault();
	startLoading();
	editProductCategoryModal.hide();
	ajax({'id': editId.value, 'name': editName.value, 'image': editImage.files[0], 'action' : 'editProductCategory'}, 
	'../ajaxPhp/product-categories.php', function(response) {
		if(response == 'success') {
			counter = offset + 1;
			showProductCategory();
			editName.value = '';
			editImage.value = null;
			displayResult('Product category successfully updated.', 'success', 'alert-dismissible fade show mt-4 mx-md-4', true);
		}
		else if(response == 'already_exist') {
			displayResult('Category name already exist.', 'danger', 'alert-dismissible fade show mt-4 mx-md-4', true);
		}
		else {
			console.log(response);
			displayResult('Somethig went wrong.', 'danger', 'alert-dismissible fade show mt-4 mx-md-4', true);
		}
		stopLoading();
	})
});

const archiveProductCategoryModal = new bootstrap.Modal(document.getElementById('archive-product-categories-modal'));
const archiveProductCategoryForm = document.getElementById('archive-product-category-form');
archiveProductCategoryForm.addEventListener('submit', function(e) {
	e.preventDefault();
	startLoading();
	archiveProductCategoryModal.hide();
	let archiveStatus = status == 0 ? 1 : 0;
	ajax({'id': archiveId.value, 'status': archiveStatus, 'action' : 'archiveProductCategory'}, '../ajaxPhp/product-categories.php', function(response) {
		if(response == 'success') {
			counter = offset + 1;
			showProductCategory();
			displayResult('Product category successfully archived.', 'success', 'alert-dismissible fade show mt-4 mx-md-4', true);
		}
		else {
			displayResult('Somethig went wrong.', 'danger', 'alert-dismissible fade show mt-4 mx-md-4', true);
		}
		stopLoading();
	})
});

const filter = document.getElementById('filter-product-category');
filter.addEventListener('change', function(e) {
	status = e.target.value;
	counter = offset + 1;
	showProductCategory();
})

const productCategoriesLimit = document.getElementById('product-category-limit');
productCategoriesLimit.addEventListener('change', function(e) {
	limit = e.target.value;
	counter = offset + 1;
	showProductCategory();
});

nextButton.addEventListener('click', function() {
	counter++;
	offset = counter - 1;
	showProductCategory();
});

previousButton.addEventListener('click', function() {
	counter = offset - (productCategoriesLimit.value - 1);
	counter = counter <= 0 ? 1 : counter;
	offset = counter - 1;
	showProductCategory();
});

const nameSort = document.getElementById('name-sort');
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
	nameSort.firstElementChild.classList.remove("text-primary");
	nameSort.lastElementChild.classList.remove("text-primary");
	creationDateSort.firstElementChild.classList.remove("text-primary");
	creationDateSort.lastElementChild.classList.remove("text-primary");
	updationDateSort.firstElementChild.classList.remove("text-primary");
	updationDateSort.lastElementChild.classList.remove("text-primary");
}

nameSort.addEventListener('click', function(e) {
	order = 'name';
	handleIconColor(nameSort.firstElementChild, nameSort.lastElementChild);
	counter = offset + 1;
	showProductCategory();
});

creationDateSort.addEventListener('click', function(e) {
	order = 'creation_date';
	handleIconColor(creationDateSort.firstElementChild, creationDateSort.lastElementChild)
	counter = offset + 1;
	showProductCategory();
});

updationDateSort.addEventListener('click', function(e) {
	order = 'updation_date';
	handleIconColor(updationDateSort.firstElementChild, updationDateSort.lastElementChild)
	counter = offset + 1;
	showProductCategory();
});
