<div class="bg-primary p-3 d-flex justify-content-between align-items-center">
	<button class="btn btn-primary mt-2" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebar" aria-controls="sidebar">
		<i class="fas fa-bars d-lg-none"></i>
	</button>
	<div class="dropdown">
		<a class="btn btn-secondary dropdown-toggle z-3" href="#0" role="button" data-bs-toggle="dropdown" aria-expanded="false" id="topbar-fullname">
			<?php echo $_SESSION['USER_INFORMATION']['NAME'] ?>
		</a>
		<ul class="dropdown-menu">
			<li><a class="dropdown-item" href="profile.php">Profile</a></li>
			<li><a class="dropdown-item" href="../logout.php">Log out</a></li>
		</ul>
	</div>
</div>