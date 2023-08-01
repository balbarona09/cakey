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
	<main class="container-fluid">
		<div class="row justify-content-center">
			<div class="col-md-6 card mt-5 shadow border border-0">
				<div class="card-body">
					<div class="py-2">
						<h1>Log in</h1>
					</div>
					<div id="result"></div>
					<form class="form-row" id="login-form">
						<div class="col py-2">
							<label for="email" class="fw-bold">Email</label>
							<input type="email" name="email" id="email" class="form-control" placeholder="example@abc.com" required>
						</div>
						<div class="col py-2">
							<label for="password" class="fw-bold">Password</label>
							<input type="password" name="password" id="password" class="form-control" placeholder="Your Password" required>
						</div>
						<div class="col py-2">
							<a href="forgot-password.php" class="link-underline link-underline-opacity-0 link-underline-opacity-75-hover">Forgot Password?</a>
						</div>
						<div class="col py-2">
							<input type="submit" value="Log in" class="btn btn-primary w-100">
						</div>
					</form>
					<div class="text-center py-2">
						<span>No account Yet?</span> <a href="signup.php" class="link-underline link-underline-opacity-0 link-underline-opacity-75-hover">Sign up</a>
					</div>
				</div>
			</div>
		</div>
	</main>
</div>

<script src="js/login.js" type="module"></script>

<?php require_once 'requires/foot.php'; ?>