<nav class="navbar navbar-expand-lg bg-primary sticky-top">
	<div class="container-lg">
		<button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<a href="index.php" class="navbar-brand p-0">
			<img src="images/logo.svg" alt="Cakey" width="200" height="100">
		</a>
		<div class="offcanvas offcanvas-start bg-primary" tabindex="-1" id="navbarNav" aria-labelledby="offcanvasNavbarLabel">
			<div class="offcanvas-header">
				<button type="button" class="btn-close mt-2" data-bs-dismiss="offcanvas" aria-label="Close"></button>
			</div>
			<div class="offcanvas-body">
				<div class="navbar-nav flex-row-lg justify-content-evenly w-100">
					<a href="menu.php" class="text-white h5 p-2 link-underline-light link-underline-opacity-0 link-underline-opacity-100-hover link-offset-3">Menu</a>
					<a href="index.php#location" class="text-white h5 p-2 link-underline-light link-underline-opacity-0 link-underline-opacity-100-hover link-offset-3" id="navbar-location">Locations</a>
					<a href="index.php#about-us" class="text-white h5 p-2 link-underline-light link-underline-opacity-0 link-underline-opacity-100-hover link-offset-3" id="navbar-about-us">About Us</a>
					<a href="index.php#contact-us" class="text-white h5 p-2 link-underline-light link-underline-opacity-0 link-underline-opacity-100-hover link-offset-3" id="navbar-contact-us">Contact Us</a>
					<?php if(isset($_SESSION['USER_INFORMATION'])): ?>
					<div class="dropdown">
						<a class="btn btn-lg btn-danger h5 fw-bold dropdown-toggle z-3" href="#0" role="button" data-bs-toggle="dropdown" aria-expanded="false" id="topbar-fullname">
							<?php echo $_SESSION['USER_INFORMATION']['NAME']; ?>
						</a>
						<ul class="dropdown-menu">
							<li><a class="dropdown-item" href="profile.php">My Profile</a></li>
							<li><a class="dropdown-item" href="purchases.php">My Purchases</a></li>
							<li><a class="dropdown-item" href="cart.php">My Cart</a></li>
							<li><a class="dropdown-item" href="logout.php">Log out</a></li>
						</ul>
					</div>
					<?php else: ?>
					<a href="login.php" class="btn btn-lg btn-danger h5 fw-bold">Log in / Sign up</a>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
</nav>