<?php 
	session_start(); 
	$_SESSION['PAGE'] = 'NEED_LOGIN';
	require_once 'check-login.php';
	require_once 'requires/head.php';
	require_once 'requires/navbar.php';
?>
<div class="d-none vh-100 vw-100 position-fixed d-flex justify-content-center mt-5 pt-5 z-1" id="loader">
	<div class="spinner-border text-primary fw-bolder" role="status"></div>
</div>

<!-- Modal Cancel Order -->
<div class="modal fade" id="cancel-order-modal" tabindex="-1" aria-labelledby="cancel-order-modal-label" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-body">
				<h2 class="modal-title fs-5 text-center" id="cancel-order-modal-label">Do you really want to cancel this order?</h2>
				<form id="cancel-order-form">
					<input type="hidden" id="cancel-order-id" value="">
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
<!-- End for Modal Cancel Order -->

<div class="bg-body-tertiary vh-100">
	<main class="container-fluid pt-3">
		<div id="result"></div>
		<div class="">
			<h1 class="h2">MY PURCHASES</h1><hr>
			<select class="form-select w-50" id="purchases-filter">
				<option value="-1">All</option>
				<option value="1">Waiting for confirmation</option>
				<option value="2">On Delivery</option>
				<option value="3">Completed</option>
				<option value="4">Cancelled By You</option>
				<option value="5">Cancelled By Admin</option>
			</select>
		</div>
		<div class="row">
			<div class="col-md-12 table-responsive">
				<table class="table table-lg">
					<thead>
						<tr>
							<th scope="col">Order Details</th>
							<th scope="col">Quantity</th>
							<th scope="col">Total Price(&#8369;)</th>
							<th scope="col">Status</th>
							<th scope="col">Action</th>
						</tr>
					</thead>
					<tbody id="purchases-details-table">
					
					</tbody>
				</table>
			</div>
		</div>
	</main>
</div>

<script src="js/order-transaction.js" type="module"></script>

<?php require_once 'requires/foot.php'; ?>