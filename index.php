<?php 
	session_start(); 
	require_once 'check-login.php';
	require_once 'requires/head.php';
	require_once 'requires/navbar.php';
?>

<div class="container-fluid p-0 hero-image" id="hero">
	<div class="d-flex flex-column justify-content-center align-items-center h-100 w-100">
		<h1 class="text-white mb-3 display-2">Cakey</h1>
		<a href="menu.php" class="btn btn-lg btn-danger">See Menu</a>
	</div>
</div>
<a id="location" style="display: block; position: relative; top: -100px;visibility: hidden;"></a>
<div class="container-fluid p-2 bg-white">
	<div class="row justify-content-center">
		<div class="col-md-3 bg-body-secondary p-4">
			<img src="images/hero1.jpg" class="img-fluid">
			<p class="h4">Cakey</p>
			<h2 class="h6">Filinvest Corporate City, Commerce Ave, Alabang, Muntinlupa, Metro Manila</h2>
			<h2 class="h6"><a href="tel:09112233456" class="text-black link-underline link-underline-opacity-0">09112233456</a></h2>
			<a href="https://www.google.com/maps/place/Festival+Mall/@14.4172098,121.0379756,17z/data=!4m6!3m5!1s0x3397d0366c767411:0x1039c643800bbe6f!8m2!3d14.4172046!4d121.0405505!16s%2Fm%2F0h3xxmc?entry=ttu" class="btn btn-lg btn-primary" target="_blank">Get Directions</a>
			<div class="mt-3">
				<span class="h5">Store Hours</span><br>
				Sun: 8:00 AM - 6:00 PM</br>
				Mon: 8:00 AM - 6:00 PM</br>
				Tue: 8:00 AM - 6:00 PM</br>
				Wed: 8:00 AM - 6:00 PM</br>
				Thu: 8:00 AM - 6:00 PM</br>
				Fri: 8:00 AM - 6:00 PM</br>
				Sat: 8:00 AM - 6:00 PM</br>
			</div>
		</div>
		<div class="col-md-7 p-4">
			<div class="google-map">
				<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3864.1727238244707!2d121.03604438885495!3d14.417204599999994!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3397d0366c767411%3A0x1039c643800bbe6f!2sFestival%20Mall!5e0!3m2!1sfil!2sph!4v1689564075636!5m2!1sfil!2sph" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
			</div>
		</div>
	</div>
</div>
<a id="about-us" style="display: block; position: relative; top: -100px;visibility: hidden;"></a>
<div class="container-fluid p-3 p-md-5 bg-body-tertiary">
	<div class="row p-5 bg-white shadow-lg">
		<div class="col-md-6">
			<img src="images/hero1.jpg" class="img-fluid">
		</div>
		<div class="col-md-6">
			<h2>Our Mission</h2>
			<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
		</div>
	</div>
	<div class="row p-5 bg-white shadow-lg mt-3">
		<div class="col-md-6">
			<h2>Our Story</h2>
			<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
		</div>
		<div class="col-md-6">
			<img src="images/hero2.jpg" class="img-fluid">
		</div>
	</div>
	<div class="row p-5 bg-white shadow-lg mt-3">
		<div class="col-md-6">
			<img src="images/hero3.jpg" class="img-fluid">
		</div>
		<div class="col-md-6">
			<h2>Our Services</h2>
			<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
		</div>
	</div>
</div>
<a id="contact-us" style="display: block; position: relative; top: -100px;visibility: hidden;"></a>
<div class="container-fluid bg-primary">
	<div class="d-flex flex-column justify-content-center align-items-center mh-75 p-5">
		<h2 class="h1 text-white">GET IN TOUCH</h2>
		<p class="text-white">Magnam dolores commodi suscipit eius consequatur ex aliquid fuga</p>
		<div class="row bg-white shadow-lg">
			<div class="col-md-4 p-5">
				<h3 class="">Email: </h3>
				<a href="mailto:cakey@gmail.com" class="link-underline link-underline-opacity-0 link-offset-3-hover link-underline-opacity-75-hover">cakey@gmail.com</a><br>
				<a href="mailto:cakey@gmail.com" class="link-underline link-underline-opacity-0 link-offset-3-hover link-underline-opacity-75-hover">mycakey@gmail.com</a>
			</div>
			<div class="col-md-4 p-5">
				<h3 class="">Call: </h3>
				<a href="tel:09112233456" class="link-underline link-underline-opacity-0 link-offset-3-hover link-underline-opacity-75-hover">09112233456</a><br>
				<a href="tel:09112233456" class="link-underline link-underline-opacity-0 link-offset-3-hover link-underline-opacity-75-hover">09223344567</a>
			</div>
			<div class="col-md-4 p-5">
				<h3 class="">Social Media: </h3>
				<a href="https://facebook.com" class="link-underline link-underline-opacity-0 link-offset-3-hover link-underline-opacity-75-hover" target="_blank">Facebook</a><br>
				<a href="https://instagram.com" class="link-underline link-underline-opacity-0 link-offset-3-hover link-underline-opacity-75-hover" target="_blank">Instagram</a>
			</div>
		</div>
	</div>
</div>

<script src="js/index.js"></script>
<?php require_once 'requires/foot.php'; ?>