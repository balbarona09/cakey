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
	<main class="container-fluid p-0 ">
		<!--<div id="result"></div>-->
		<div class="bg-danger text-white text-center py-5 h-50">
			<h1>Order Placed</h1>
			<p>Go to My Purchases for more info.</p>
			<div class="">
				<a href="index.php" class="btn btn-lg btn-outline-light">Home</a>
				<a href="purchases.php" class="btn btn-lg btn-outline-light">My Purchases</a>
			</div>
		</div>
	</main>
</div>

<?php require_once 'requires/foot.php'; ?>