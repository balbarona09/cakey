<?php 

require_once('check-login.php');
require_once '../config/connect.php';

$_SESSION['PAGE'] = 'products';
$_SESSION['PAGE_DROPDOWN'] = 'add_products';
require_once('requires/head.php');
require_once('requires/sidebar.php');

?>

<!-- This is used for showing loading in the screen. -->
<div class="d-none vh-100 vw-100 position-fixed d-flex justify-content-center mt-5 pt-5 z-1" id="loader">
	<div class="spinner-border text-primary fw-bolder" role="status"></div>
</div>
<!-- End for Loading Screen -->

<!-- Main Content -->
<div class="p-0 ml-lg-270px">
	<?php require_once('requires/topbar.php'); ?>		
	<div class="container-fluid">
		<div id="result"></div>
		<div class="card my-4 mx-md-4">
			<h5 class="card-header bg-white p-3">Products</h5>
			<div class="card-body">
				<form id="add-product-form">
					<div class="row">
						<div class="col-md-6 mb-3">
							<label for="product-category">Product Category</label>
							<select id="product-category" class="form-select" required>
								
							</select>
						</div>
						<div class="col-md-6 mb-3">
							<label for="name">Name</label>
							<input type="text" id="name" class="form-control" placeholder="Ex. Round Cake" maxlength="100" required>
						</div>
						<div class="col-md-6 mb-3">
							<label for="amount">(&#8369;) Amount</label>
							<input type="number" id="amount" class="form-control" placeholder="Ex. 650" step=".01" required>
						</div>
						<div class="col-md-6 mb-3">
							<label for="image">Image</label>
							<input type="file" id="image" class="form-control" required accept="image/jpeg, image/gif, image/png">
						</div>
						<div class="col-md-6 mb-3">
							<label for="description">Description</label>
							<textarea id="description" class="form-control" maxlength="256" required></textarea>
						</div>
						<div class="col-12">
							<input type="submit" class="btn btn-primary" value="Add Product">
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<!-- End for Main Content -->

<script src="../js/add-products.js" type="module"></script>
<?php require_once('requires/foot.php');
