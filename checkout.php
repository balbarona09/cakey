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

<div class="bg-body-tertiary vh-100">
	<main class="container-fluid pt-3">
		<div id="result"></div>
		<div class="row">
			<form class="col-md-8 px-5" id="checkout-form">
				<h4>Delivery Address</h4><hr>
				<div class="row">
					<div class="col-md-6 mb-3">
						<label for="fullname">Fullname</label>
						<input type="text" name="fullname" id="fullname" placeholder="Firstname Lastname" class="form-control" required>
					</div>
					<div class="col-md-6 mb-3">
						<label for="phone">Phone</label>
						<input type="tel" name="phone" id="phone" class="form-control" placeholder="Ex. 09112233456" required>
					</div>
					<div class="col-md-6 mb-3">
						<label for="region">Region</label>
						<select id="region" class="form-select" required></select>
					</div>
					<div class="col-md-6 mb-3">
						<label for="province">Province</label>
						<select id="province" class="form-select" required></select>
					</div>
					<div class="col-md-6 mb-3">
						<label for="city">City</label>
						<select id="city" class="form-select" required></select>
					</div>
					<div class="col-md-6 mb-3">
						<label for="barangay">Barangay</label>
						<select id="barangay" class="form-select" required></select>
					</div>
					<div class="col-md-6 mb-3">
						<label for="postal-code">Postal code</label>
						<input type="text" name="postal-code" id="postal-code" class="form-control" required>
					</div>
					<div class="col-md-6 mb-3">
						<label for="street">Street name, Building, House no.</label>
						<input type="text" name="street" id="street" class="form-control" required>
					</div>
				</div><hr>
				<h4>Payment Method</h4><hr>
				<div class="col-md-6 mb-3">
					<input type="radio" name="payment-method" id="cod" value="Cash on Delivery" required>
					<label for="cod">Cash on Delivery</label>
				</div>
				<div class="col-md-12 mb-3">
					<input type="submit" value="Place order" class="btn btn-primary w-100">
				</div>
			</form>
			<div class="col-md-4 px-5">
				<h4>Order Summary</h4><hr>
				<div id="order-summary">
				</div>
			</div>
		</div>
	</main>
</div>

<script src="js/address.js" type="module"></script>
<script src="js/order-transaction.js" type="module"></script>

<?php require_once 'requires/foot.php'; ?>