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
		<div>
			<h1 class="h2">MY CART</h1><hr>
		</div>
		<div class="row">
			<div class="col-md-9 table-responsive">
				<table class="table table-lg">
					<thead>
						<tr>
							<th scope="col">Order Details</th>
							<th scope="col">Quantity</th>
							<th scope="col">Total Price(&#8369;)</th>
							<th scope="col">Remove</th>
						</tr>
					</thead>
					<tbody id="cart-details-table">
					
					</tbody>
				</table>
			</div>
			<div class="col-md-3">
				<table class="table table-lg">
					<thead>
						<tr>
							<th scope="col">Summary</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>
								<p id="subtotal">SUBTOTAL: &#8369;0</p>
								<p id="delivery">DELIVERY: &#8369;0</p><hr>
								<p id="total">TOTAL: &#8369;0</p>
								<a href="checkout.php" class="btn btn-primary disabled" id="btn-checkout">CHECKOUT</a>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</main>
</div>

<script src="js/order-transaction.js" type="module"></script>

<?php require_once 'requires/foot.php'; ?>