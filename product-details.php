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
	<main class="container-fluid text-center pt-3">
		<div id="result"></div>
		<div id="product-details-container" class="d-flex flex-wrap justify-content-evenly">
			<div>
				<img class="img-fluid" id="product-details-image">
			</div>
			<div class="text-start flex-basis-35-sm mb-3">
				<h1 id="product-details-name"></h1>
				<h5 class="text-danger" id="product-details-amount"></h5>
				<p id="product-details-description">Description</p>
				<div class="d-flex mb-0">
					<button class="btn btn-primary" id="subtract-quantity">-</button>
					<span class="card p-3 mx-3" id="quantity">1</span>
					<button class="btn btn-primary" id="add-quantity">+</button>
				</div>
				<p class="mt-0 mb-3 text-secondary">Quantity</p>
				<button class="btn btn-dark w-100 mb-2" id="add-to-cart">Add to Cart</button>
				<button class="btn btn-danger w-100 mb-2" id="buy-now">Buy now</button>
			</div>
		</div>
	</main>
</div>

<script src="js/menu.js" type="module"></script>

<?php require_once 'requires/foot.php'; ?>