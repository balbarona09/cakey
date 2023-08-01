<?php 

require_once('check-login.php');
require_once '../config/connect.php';

$_SESSION['PAGE'] = 'product_categories';
$_SESSION['PAGE_DROPDOWN'] = 'manage_product_categories';
require_once('requires/head.php');
require_once('requires/sidebar.php');

?>

<!-- This is used for showing loading in the screen. -->
<div class="d-none vh-100 vw-100 position-fixed d-flex justify-content-center mt-5 pt-5 z-1" id="loader">
	<div class="spinner-border text-primary fw-bolder" role="status"></div>
</div>
<!-- End for Loading Screen -->

<!-- Modal edit -->
<div class="modal fade" id="edit-product-categories-modal" tabindex="-1" aria-labelledby="edit-product-categories-modal-label" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h2 class="modal-title fs-5" id="edit-product-categories-modal-label">Edit Product Categories</h2>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<form id="edit-product-category-form">
					<label for="edit-name">Name</label>
					<input type="text" class="form-control" id="edit-name" placeholder="Ex. Round Cake" required>
					<label for="edit-image" class="mt-3">Image (leave empty if not changing)</label>
					<input type="file" class="form-control" id="edit-image" accept="image/jpeg, image/gif, image/png">
					<input type="hidden" id="edit-id" value="">
					<input type="submit" class="btn btn-primary mt-3" value="Save changes">
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal" aria-label="Close">Close</button> 
			</div>
		</div>
	</div>
</div>
<!-- End for Modal edit -->

<!-- Modal Archive -->
<div class="modal fade" id="archive-product-categories-modal" tabindex="-1" aria-labelledby="archive-product-categories-modal-label" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-body">
				<h2 class="modal-title fs-5 text-center" id="archive-product-categories-modal-label">Do you really want to archive this category?</h2>
				<form id="archive-product-category-form">
					<input type="hidden" id="archive-id" value="">
					<div class="d-flex justify-content-center p-3">
						<input type="submit" class="btn btn-danger" value="Yes">
						<div class="mx-2"></div>
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal" aria-label="Close">No</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<!-- End for Modal archive -->

<!-- Modal Image -->
<div class="modal fade" id="image-product-categories-modal" tabindex="-1" aria-labelledby="image-product-categories-modal-label" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<img src="" class="img-fluid" id="image-product-categories">
			</div>
		</div>
	</div>
</div>
<!-- End for Modal Image -->

<!-- Main Content -->
<div class="p-0 ml-lg-270px">
	<?php require_once('requires/topbar.php'); ?>		
	<div class="container-fluid">
		<div id="result"></div>
		<div class="card my-4 mx-md-4 p-2 table-responsive">
			<div class="p-2">
				Show
				<select class="" id="product-category-limit">
					<option selected>10</option>
					<option>25</option>
					<option>50</option>
					<option>100</option>
				</select>
				Entries
				<select class="float-end" id="filter-product-category">
					<option value="0">Active</option>
					<option value="1">Archived</option>
				</select>
			</div>
			<table class="table table-sm table-striped table-hover table-bordered text-center mb-0">
				<thead>
					<tr>
						<th scope="col">#</th>
						<th scope="col">Product Category Name
							<button class="btn p-0 border border-0 d-inline-flex flex-column" id="name-sort">
								<i class="fas fa-sort-up"></i>
								<i class="fas fa-sort-down" style="margin-top: -10px;"></i>
							</button>
						</th>
						<th scope="col">Image</th>
						<th scope="col">Creation Date
							<button class="btn p-0 border border-0 d-inline-flex flex-column" id="creation-date-sort">
								<i class="fas fa-sort-up"></i>
								<i class="fas fa-sort-down" style="margin-top: -10px;"></i>
							</button>
						</th>
						<th scope="col">Updation Date
							<button class="btn p-0 border border-0 d-inline-flex flex-column" id="updation-date-sort">
								<i class="fas fa-sort-up"></i>
								<i class="fas fa-sort-down" style="margin-top: -10px;"></i>
							</button>
						</th>
						<th scope="col">Action</th>
					</tr>
				</thead>
				<tbody id="product-category-table">
					
				</tbody>
			</table>
			<div class="p-2">
				<span class="float-start" id="entries-statement">
				Showing 1 to 2 of 2 entries
				</span>
				<div class="float-end">
					<button class="btn btn-sm btn-outline-secondary" id="previous">Previous</button>
					<!--<button class="btn btn-sm btn-secondary">1</button>-->
					<button class="btn btn-sm btn-outline-secondary" id="next">Next</button>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- End for Main Content -->

<script src="../js/manage-product-categories.js" type="module"></script>
<?php require_once('requires/foot.php');
	