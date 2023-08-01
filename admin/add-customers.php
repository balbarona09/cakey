<?php 

require_once('check-login.php');
require_once '../config/connect.php';

$_SESSION['PAGE'] = 'customers';
$_SESSION['PAGE_DROPDOWN'] = 'add_customers';
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
			<h5 class="card-header bg-white p-3">Customers</h5>
			<div class="card-body">
				<form id="add-customer-form">
					<div class="row">
						<div class="col-md-6 mb-3">
							<label for="fullname">Fullname</label>
							<input type="text" id="fullname" class="form-control" placeholder="Firstname Lastname" required>
						</div>
						<div class="col-md-6 mb-3">
							<label for="email">Email</label>
							<input type="email" id="email" class="form-control" placeholder="Ex. abc@gmail.com" required>
						</div>
						<div class="col-md-6 mb-3">
							<label for="password">Password</label>
							<input type="password" id="password" class="form-control" placeholder="Must be atleast 8 characters" minlength="8" required>
						</div>
						<div class="col-md-6 mb-3">
							<label for="confirm-password">Confirm Password</label>
							<input type="password" id="confirm-password" class="form-control" placeholder="Must match the password" minlength="8" required>
						</div>
						<div class="col-12">
							<input type="submit" class="btn btn-primary" value="Add Customer">
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<!-- End for Main Content -->

<script src="../js/add-customers.js" type="module"></script>
<?php require_once('requires/foot.php');
