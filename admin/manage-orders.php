<?php 

require_once('check-login.php');
require_once '../config/connect.php';

$_SESSION['PAGE'] = 'orders';
$_SESSION['PAGE_DROPDOWN'] = 'manage_orders';
require_once('requires/head.php');
require_once('requires/sidebar.php');

?>

<!-- This is used for showing loading in the screen. -->
<div class="d-none vh-100 vw-100 position-fixed d-flex justify-content-center mt-5 pt-5 z-1" id="loader">
	<div class="spinner-border text-primary fw-bolder" role="status"></div>
</div>
<!-- End for Loading Screen -->

<!-- Modal Confirm Order -->
<div class="modal fade" id="confirm-order-modal" tabindex="-1" aria-labelledby="confirm-order-modal-label" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-body">
				<h2 class="modal-title fs-5 text-center" id="confirm-order-modal-label">Do you really want to confirm this Order?</h2>
				<form id="confirm-order-form">
					<input type="hidden" id="confirm-order-id" value="">
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
<!-- End for Modal Confirm Order -->

<!-- Modal Cancel Order -->
<div class="modal fade" id="cancel-order-modal" tabindex="-1" aria-labelledby="cancel-order-modal-label" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-body">
				<h2 class="modal-title fs-5 text-center" id="cancel-order-modal-label">Do you really want to cancel this Order?</h2>
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

<!-- Modal Receive Order -->
<div class="modal fade" id="receive-order-modal" tabindex="-1" aria-labelledby="receive-order-modal-label" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-body">
				<h2 class="modal-title fs-5 text-center" id="receive-order-modal-label">Do you really want to receive this Order?</h2>
				<form id="receive-order-form">
					<input type="hidden" id="receive-order-id" value="">
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
<!-- End for Modal Receive Order -->

<!-- Modal Address -->
<div class="modal fade" id="address-modal" tabindex="-1" aria-labelledby="address-modal-label" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h3>Delivery Address</h3>
			</div>
			<div class="modal-body">
				<div class="row">
					<p class="col-md-6">Fullname: <span id="fullname-modal" class="fw-bold"></span></p>
					<p class="col-md-6">Phone: <span id="phone-modal" class="fw-bold"></span></p>
					<p class="col-md-6">Region: <span id="region-modal" class="fw-bold"></span></p>
					<p class="col-md-6">Province: <span id="province-modal" class="fw-bold"></span></p>
					<p class="col-md-6">City: <span id="city-modal" class="fw-bold"></span></p>
					<p class="col-md-6">Barangay: <span id="barangay-modal" class="fw-bold"></span></p>
					<p class="col-md-6">Postal Code: <span id="postal-code-modal" class="fw-bold"></span></p>
					<p class="col-md-6">Street: <span id="street-modal" class="fw-bold"></span></p>
				</div>
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
			</div>
		</div>
	</div>
</div>
<!-- End for Modal Address -->

<!-- Main Content -->
<div class="p-0 ml-lg-270px">
	<?php require_once('requires/topbar.php'); ?>		
	<div class="container-fluid">
		<div id="result"></div>
		<div class="card my-4 mx-md-4 p-2 table-responsive">
			<div class="p-2">
				Show
				<select class="" id="order-limit">
					<option selected>10</option>
					<option>25</option>
					<option>50</option>
					<option>100</option>
				</select>
				Entries
				<select class="float-end" id="filter-order">
					<option value="1">Pending Orders</option>
					<option value="2">On Delivery Orders</option>
					<option value="3">Completed Orders</option>
					<option value="4">User Cancelled Orders</option>
					<option value="5">Admin Cancelled Orders</option>
				</select>
			</div>
			<table class="table table-sm table-striped table-hover table-bordered text-center mb-0">
				<thead>
					<tr>
						<th scope="col">#</th>
						<th scope="col">Product
							<button class="btn p-0 border border-0 d-inline-flex flex-column" id="product-sort">
								<i class="fas fa-sort-up"></i>
								<i class="fas fa-sort-down" style="margin-top: -10px;"></i>
							</button>
						</th>
						<th scope="col">Amount
							<button class="btn p-0 border border-0 d-inline-flex flex-column" id="amount-sort">
								<i class="fas fa-sort-up"></i>
								<i class="fas fa-sort-down" style="margin-top: -10px;"></i>
							</button>
						</th>
						<th scope="col">Quantity
							<button class="btn p-0 border border-0 d-inline-flex flex-column" id="quantity-sort">
								<i class="fas fa-sort-up"></i>
								<i class="fas fa-sort-down" style="margin-top: -10px;"></i>
							</button>
						</th>
						<th scope="col">Total Amount
							<button class="btn p-0 border border-0 d-inline-flex flex-column" id="total-sort">
								<i class="fas fa-sort-up"></i>
								<i class="fas fa-sort-down" style="margin-top: -10px;"></i>
							</button>
						</th>
						<th scope="col">Customer
							<button class="btn p-0 border border-0 d-inline-flex flex-column" id="customer-sort">
								<i class="fas fa-sort-up"></i>
								<i class="fas fa-sort-down" style="margin-top: -10px;"></i>
							</button>
						</th>
						<th scope="col">Address
						</th>
						<th scope="col">Payment Method
							<button class="btn p-0 border border-0 d-inline-flex flex-column" id="payment-method-sort">
								<i class="fas fa-sort-up"></i>
								<i class="fas fa-sort-down" style="margin-top: -10px;"></i>
							</button>
						</th>
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
				<tbody id="order-table">
					
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

<script src="../js/manage-orders.js" type="module"></script>
<?php require_once('requires/foot.php');
	