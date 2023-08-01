<?php 

require_once('check-login.php');

$_SESSION['PAGE'] = 'PROFILE';
$_SESSION['PAGE_DROPDOWN'] = '';
require_once('requires/head.php');
require_once('requires/sidebar.php');

// For changing of email.
require_once '../classes/AccountVerification.php';
	
if(isset($_SESSION['CHANGE_EMAIL_VERIFICATION'])) {
	$accountVerification = unserialize($_SESSION['CHANGE_EMAIL_VERIFICATION']);
}
else {
	$accountVerification = new AccountVerification('', '', 'Cakey', 'Cakey - Verification Code');
	$_SESSION['CHANGE_EMAIL_VERIFICATION'] = serialize($accountVerification);
}

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
			<h5 class="card-header bg-white p-3">Profile</h5>
			<div class="card-body">
				<form id="edit-profile-form">
					<div class="row">
						<div class="col-md-7 mb-3">
							<label for="fullname">Fullname</label>
							<input type="text" id="fullname" class="form-control" placeholder="Firstname Lastname" required>
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
			$_SESSION['CHANGE_EMAIL_VERIFICATION'] = serialize($accountVerification);
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
	</div>
</div>
<!-- End of Main Content -->

<script src="../js/admin-profile.js" type="module"></script>
<?php require_once('requires/foot.php');