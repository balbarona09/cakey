<?php 
	session_start(); 
	require_once 'check-login.php';
	require_once 'requires/head.php';
	require_once 'requires/navbar.php';
?>

<div class="d-none vh-100 vw-100 position-fixed d-flex justify-content-center mt-5 pt-5 z-1" id="loader">
	<div class="spinner-border text-primary fw-bolder" role="status"></div>
</div>

<div class="bg-body-tertiary vh-100">
	<div id="result"></div>
	<main class="container-fluid text-center pt-3">
		<h1 class="" id="product-category-title"></h1>
		<div id="product-container" class="d-flex flex-wrap justify-content-evenly">
		
		</div>
	</main>
	<div>
	
	</div>
</div>

<script src="js/menu.js" type="module"></script>

<?php require_once 'requires/foot.php'; ?>