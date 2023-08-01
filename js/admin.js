/* Rotating of icon in collapse */
const productCategoriesCollapse = document.getElementById('product-categories-collapse');
rotateIcon(productCategoriesCollapse);

const productsCollapse = document.getElementById('product-collapse');
rotateIcon(productsCollapse);

const customerCollapse = document.getElementById('customer-collapse');
rotateIcon(customerCollapse);

const adminCollapse = document.getElementById('admin-collapse');
rotateIcon(adminCollapse);

const orderCollapse = document.getElementById('order-collapse');
rotateIcon(orderCollapse);

function rotateIcon(element) {
	element.addEventListener('show.bs.collapse', function() {
		element.previousElementSibling.lastElementChild.setAttribute('class', 'fas fa-caret-down');
	});
	element.addEventListener('hide.bs.collapse', function() {
		element.previousElementSibling.lastElementChild.setAttribute('class', 'fas fa-caret-down fa-rotate-90');
	});
}