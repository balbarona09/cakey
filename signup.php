<?php
	session_start();
	
	require_once 'check-login.php';
	require_once 'requires/head.php';
	require_once 'requires/navbar.php';

	require_once 'classes/AccountVerification.php';
	
	if(isset($_SESSION['SIGNUP_ACCOUNT_VERIFICATION'])) {
		$accountVerification = unserialize($_SESSION['SIGNUP_ACCOUNT_VERIFICATION']);
	}
	else {
		$accountVerification = new AccountVerification('', '', 'Cakey', 'Cakey - Verification Code');
		$_SESSION['SIGNUP_ACCOUNT_VERIFICATION'] = serialize($accountVerification);
	}
		
?>
		
<div class="d-none vh-100 vw-100 position-fixed d-flex justify-content-center mt-5 pt-5 z-1" id="loader">
	<div class="spinner-border text-primary fw-bolder" role="status"></div>
</div>
<div class="bg-body-tertiary vh-100">
	<main class="container-fluid">
		<div class="row justify-content-center">
			<div class="col-md-6 card mt-5 shadow border border-0">
				<div class="card-body">
					<div class="py-2">
						<h1>Sign up</h1>
					</div>
					<div id="result"></div>
					<?php if($accountVerification->getStatus() == 'SEND CODE'): ?>
					<form class="form-row" id="signup-sendcode-form">
						<div class="col py-2">
							<label for="email" class="fw-bold">Email</label>
							<input type="email" name="email" id="email" class="form-control" placeholder="example@abc.com" required>
						</div>
						<div class="col py-2">
							<input type="submit" value="Send Verification Code" class="btn btn-primary w-100">
						</div>
					</form>
					<div class="text-center py-2">
						<span>Already have an account?</span> <a href="login.php" class="link-underline link-underline-opacity-0 link-underline-opacity-75-hover">Log in</a>
					</div>
					
					<?php elseif($accountVerification->getStatus() == 'VERIFY CODE'): ?>
					<form class="form-row" id="signup-verifycode-form">
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
						<a href="javascript:void(0);" class="link-underline link-underline-opacity-0 link-opacity-50" id="signup-resendcode">Resend Code(120)</a>
						<a href="javascript:void(0);" class="link-underline link-underline-opacity-0 link-underline-opacity-75-hover" id="signup-change-email">Change Email</a>
					</div>
					
					<?php elseif($accountVerification->getStatus() == 'VERIFIED'): ?>
					<form class="form-row" id="signup-insertaccount-form">
						<div class="col py-2">
							<label for="fullname" class="fw-bold">Fullname</label>
							<input type="text" name="fullname" id="fullname" class="form-control" placeholder="Firstname Lastname" required>
						</div>
						<div class="col py-2">
							<label for="password" class="fw-bold">Password</label>
							<input type="password" name="password" id="password" class="form-control" placeholder="Must be atleast 8 characters" minlength="8" required>
						</div>
						<div class="col py-2">
							<label for="confirm-password" class="fw-bold">Confirm Password</label>
							<input type="password" name="confirm-password" id="confirm-password" class="form-control" placeholder="Must match the password" required>
						</div>
						<div class="col py-2">
							<input type="submit" value="Sign Up" class="btn btn-primary w-100">
						</div>
					</form>
					<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header">
									<h5 class="text-success">Sign up Successfully</h5>
								</div>
								<div class="modal-body">
									<p>Redirect to Login Page in <span id="counter">5</span></p>
								</div>
								<div class="modal-footer">
									<a href="login.php" class="btn btn-secondary" >Go to Login</a>									
								</div>
							</div>
						</div>
					</div>
						
					<?php endif ?>
				</div>
			</div>
		</div>
	</main>
</div>

<script src="js/signup.js" type="module"></script>

<?php require_once 'requires/foot.php'; ?>