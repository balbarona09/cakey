<?php 
	session_start();
	$_SESSION['PAGE'] = 'NEED_LOGIN';
	require_once 'check-login.php';
	require_once 'requires/head.php';
	require_once 'requires/navbar.php';
	
	// For changing of email.
	require_once 'classes/AccountVerification.php';
	
	if(isset($_SESSION['CHANGE_CUSTOMER_EMAIL_VERIFICATION'])) {
		$accountVerification = unserialize($_SESSION['CHANGE_CUSTOMER_EMAIL_VERIFICATION']);
	}
	else {
		$accountVerification = new AccountVerification('', '', 'Cakey', 'Cakey - Verification Code');
		$_SESSION['CHANGE_CUSTOMER_EMAIL_VERIFICATION'] = serialize($accountVerification);
	}
?>
<!-- This is used for showing loading in the screen. -->
<div class="d-none vh-100 vw-100 position-fixed d-flex justify-content-center mt-5 pt-5 z-1" id="loader">
	<div class="spinner-border text-primary fw-bolder" role="status"></div>
</div>
<!-- End for Loading Screen -->

<!-- Modal Deactivate Account -->
<div class="modal fade" id="deactivate-account-modal" tabindex="-1" aria-labelledby="deactivate-account-modal-label" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-body">
				<h2 class="modal-title fs-5 text-center" id="deactivate-account-modal-label">Do you really want to deactivate your account?</h2>
				<form id="deactivate-account-form">
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
<!-- End for Modal Deactivate Account -->

<!-- Modal for Deactivate Successfull -->
<div class="modal fade" id="deactivate-modal-successfull" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="text-success">Account Deactivation Successfull</h5>
			</div>
			<div class="modal-body">
				<p>Redirect to Home Page in <span id="counter">5</span></p>
			</div>
			<div class="modal-footer">
				<a href="index.php" class="btn btn-secondary" >Go Home</a>									
			</div>
		</div>
	</div>
</div>
<!-- End for Modal Deactivate Successfull -->

<!-- Main Content -->
<div class="p-0">		
	<div class="container-fluid">
		<div id="result"></div>
		<div class="card my-4 mx-md-4">
			<h5 class="card-header bg-white p-3">Profile</h5>
			<div class="card-body">
				<form id="edit-profile-form">
					<div class="row">
						<div class="col-md-6 mb-3">
							<label for="fullname">Fullname</label>
							<input type="text" id="fullname" class="form-control" placeholder="Firstname Lastname" required>
						</div>
						<div class="col-md-6 mb-3">
							<label for="phone">Phone</label>
							<input type="text" id="phone" class="form-control" placeholder="Ex. 09112233456" minlength="11" maxlength="11" required>
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
							<label for="postal-code">Postal Code</label>
							<input type="text" id="postal-code" class="form-control" placeholder="Ex. 1772" required>
						</div>
						<div class="col-md-6 mb-3">
							<label for="street">Street</label>
							<input type="text" id="street" class="form-control" placeholder="Ex. 121 Rose street" required>
						</div>
						<div class="col-12">
							<input type="submit" class="btn btn-sm btn-primary" value="Save Profile">
						</div>
					</div>
				</form>
			</div>
		</div>
		<div id="result-email"></div>
		<?php if($accountVerification->getStatus() == 'VERIFIED'): 
			$accountVerification = new AccountVerification('balbarona09@gmail.com', 'kluuidjvywejjjft', 'Cakey', 'Cakey - Verification Code');
			$_SESSION['CHANGE_CUSTOMER_EMAIL_VERIFICATION'] = serialize($accountVerification);
		?>
			<div class="alert alert-success alert-dismissible fade show mt-4 mx-md-4">
				Email Successfully changed 
				<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
			</div>
		<?php endif; ?>
		<div class="card my-4 mx-md-4">
			<h5 class="card-header bg-white p-3">Email</h5>
			<div class="card-body">
				<?php if($accountVerification->getStatus() == 'SEND CODE'): ?>
				<form id="edit-email-sendcode-form">
					<div class="row">
						<div class="col-md-7 mb-3">
							<label for="email-password">Password</label>
							<input type="password" id="email-password" class="form-control" placeholder="Enter your password" required>
						</div>
						<div class="col-md-7 mb-3">
							<label for="email">Email</label>
							<input type="email" id="email" class="form-control" placeholder="Ex. abc@gmail.com" required>
						</div>
						<div class="col-12">
							<input type="submit" class="btn btn-sm btn-primary" value="Send Verification Code">
						</div>
					</div>
				</form>
				<?php elseif($accountVerification->getStatus() == 'VERIFY CODE'): ?>
					<form class="form-row" id="edit-email-verifycode-form">
						<div class="col py-2">
							<label for="code" class="fw-bold">Enter Verification Code</label>
							<p class="py-1">We just sent a verification code to <span style="color: blue;"><?php echo $accountVerification->getEmail(); ?></span>. 
							Enter that code below. You only have <span class="fw-bold" id="attempts"><?php echo $accountVerification->getAttempts(); ?></span> attempts.</p>
							<input type="text" name="code" id="code" class="form-control" placeholder="Your code" required>
						</div>
						<div class="col py-2">
							<input type="submit" value="Verify Code" class="btn btn-primary w-100">
						</div>
					</form>
					<div class="py-2 d-flex justify-content-between">
						<a href="javascript:void(0);" class="link-underline link-underline-opacity-0 link-opacity-50" id="edit-email-resendcode">Resend Code(120)</a>
						<a href="javascript:void(0);" class="link-underline link-underline-opacity-0 link-underline-opacity-75-hover" id="edit-email-change-email">Change Email</a>
					</div>
				<?php endif; ?>
			</div>
		</div>
		<div id="result-password"></div>
		<div class="card my-4 mx-md-4">
			<h5 class="card-header bg-white p-3">Password</h5>
			<div class="card-body">
				<form id="edit-password-form">
					<div class="row">
						<div class="col-md-7 mb-3">
							<label for="password">Current Password</label>
							<input type="password" id="current-password" class="form-control" placeholder="Enter your current password" required>
						</div>
						<div class="col-md-7 mb-3">
							<label for="password">New Password</label>
							<input type="password" id="password" class="form-control" placeholder="Must be atleast 8 characters" minlength="8" required>
						</div>
						<div class="col-md-7 mb-3">
							<label for="confirm-password">Confirm Password</label>
							<input type="password" id="confirm-password" class="form-control" placeholder="Must match the password" minlength="8" required>
						</div>
						<div class="col-12">
							<input type="submit" class="btn btn-sm btn-primary" value="Change Password">
						</div>
					</div>
				</form><hr>
			</div>
		</div>
		<div class="card my-4 mx-md-4">
			<h5 class="card-header bg-white p-3">Account</h5>
			<div class="card-body">
				<button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deactivate-account-modal">Deactivate Account</button>
				<hr>
			</div>
		</div>
	</div>
</div>
<!-- End of Main Content -->

<script src="js/address.js" type="module"></script>
<script src="js/customer-profile.js" type="module"></script>
<?php require_once 'requires/foot.php'; ?>