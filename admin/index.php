<?php 

require_once('check-login.php');

$_SESSION['PAGE'] = 'dashboard';
$_SESSION['PAGE_DROPDOWN'] = '';
require_once('requires/head.php');
require_once('requires/sidebar.php');


?>

<!-- This is used for showing loading in the screen. -->
<div class="d-none vh-100 vw-100 position-fixed d-flex justify-content-center mt-5 pt-5 z-1" id="loader">
	<div class="spinner-border text-primary fw-bolder" role="status"></div>
</div>
<!-- End for Loading Screen -->

<div class="p-0 ml-lg-270px">
	<?php require_once('requires/topbar.php'); ?>		
	<div class="container-fluid">
		<div class="d-flex flex-wrap justify-content-around pt-3">
			<div class="card shadow dashboard-container px-3 mb-4" >
				<h5 class="p-3">Products</h5>
				<h2 class="px-3 pb-5" id="products">0</h2>
			</div>
			<div class="card shadow dashboard-container px-3 mb-4">
				<h5 class="p-3">Customers</h5>
				<h2 class="px-3 pb-5" id="customers">0</h2>
			</div>
			<div class="card shadow dashboard-container px-3 mb-4" >
				<h5 class="p-3">Pending Orders</h5>
				<h2 class="px-3 pb-5" id="pending-orders">0</h2>
			</div>
			<div class="card shadow dashboard-container px-3 mb-4" >
				<h5 class="p-3">On Delivery Orders</h5>
				<h2 class="px-3 pb-5" id="delivery-orders">0</h2>
			</div>
			<div class="card shadow dashboard-container px-3 mb-4" >
				<h5 class="p-3">Completed Orders</h5>
				<h2 class="px-3 pb-5" id="completed-orders">0</h2>
			</div>
			<div class="dashboard-container px-3 mb-4" >
			</div>
			</div>
		</div>
	</div>
</div>

<script src="../js/dashboard.js" type="module"></script>
<?php require_once('requires/foot.php'); ?>
		