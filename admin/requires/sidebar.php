<div class="position-fixed bg-primary d-flex flex-column vh-100 offcanvas-lg offcanvas-start w-270px overflow-y-scroll" id="sidebar">
	<div class="offcanvas-header pb-0">
		<button type="button" class="btn-close" data-bs-dismiss="offcanvas" data-bs-target="#sidebar" aria-label="Close"></button>
	</div>
	<a href="./" class="p-3 text-center"><img src="../images/logo2.svg" class="img-fluid" style="height: 100px;" ></a>
	<a href="./" class="text-white h6 p-3 link-underline-light link-underline-opacity-0 link-underline-opacity-100-hover link-offset-3
	<?php echo $_SESSION['PAGE'] == 'dashboard' ? 'bg-secondary' : ''; ?>">
		<i class="fas fa-home"></i> Dashboard
	</a>
	<a href="#product-categories-collapse" class="text-white h6 p-3 link-underline-light link-underline-opacity-0 link-underline-opacity-100-hover link-offset-3
	<?php echo $_SESSION['PAGE'] == 'product_categories' ? 'bg-secondary' : ''; ?>" data-bs-toggle="collapse" role="button">
		<i class="fas fa-th-list"></i> Product Categories <i class="fas fa-caret-down <?php echo $_SESSION['PAGE'] == 'product_categories' ? '' : 'fa-rotate-90'; ?>" style="float:right;"></i>
	</a>
	<div class="collapse <?php echo $_SESSION['PAGE'] == 'product_categories' ? 'show' : ''; ?>" id="product-categories-collapse">
		<div class="p-2 <?php echo $_SESSION['PAGE_DROPDOWN'] == 'add_product_categories' ? 'bg-secondary' : ''; ?>" style="font-size: .9rem;">
			<i class="fas fa-arrow-right text-white" style="font-size: .8rem;"></i>
			<a href="add-product-categories.php" class="text-white p-3 link-underline-light link-underline-opacity-0 link-underline-opacity-100-hover link-offset-3">Add Product Categories</a>
		</div>
		<div class="p-2 <?php echo $_SESSION['PAGE_DROPDOWN'] == 'manage_product_categories' ? 'bg-secondary' : ''; ?>" style="font-size: .9rem;">
			<i class="fas fa-arrow-right text-white" style="font-size: .8rem;"></i>
			<a href="manage-product-categories.php" class="text-white  p-3 link-underline-light link-underline-opacity-0 link-underline-opacity-100-hover link-offset-3">Manage Product Categories</a>
		</div>
	</div>
	
	<a href="#product-collapse" class="text-white h6 p-3 link-underline-light link-underline-opacity-0 link-underline-opacity-100-hover link-offset-3
	<?php echo $_SESSION['PAGE'] == 'products' ? 'bg-secondary' : ''; ?>" data-bs-toggle="collapse" role="button">
		<i class="fas fa-birthday-cake"></i> Products<i class="fas fa-caret-down <?php echo $_SESSION['PAGE'] == 'products' ? '' : 'fa-rotate-90'; ?>" style="float:right;"></i>
	</a>
	<div class="collapse <?php echo $_SESSION['PAGE'] == 'products' ? 'show' : ''; ?>" id="product-collapse">
		<div class="p-2 <?php echo $_SESSION['PAGE_DROPDOWN'] == 'add_products' ? 'bg-secondary' : ''; ?>" style="font-size: .9rem;">
			<i class="fas fa-arrow-right text-white" style="font-size: .8rem;"></i>
			<a href="add-products.php" class="text-white p-3 link-underline-light link-underline-opacity-0 link-underline-opacity-100-hover link-offset-3">Add Products</a>
		</div>
		<div class="p-2 <?php echo $_SESSION['PAGE_DROPDOWN'] == 'manage_products' ? 'bg-secondary' : ''; ?>" style="font-size: .9rem;">
			<i class="fas fa-arrow-right text-white" style="font-size: .8rem;"></i>
			<a href="manage-products.php" class="text-white  p-3 link-underline-light link-underline-opacity-0 link-underline-opacity-100-hover link-offset-3">Manage Products</a>
		</div>
	</div>
	
	<a href="#order-collapse" class="text-white h6 p-3 link-underline-light link-underline-opacity-0 link-underline-opacity-100-hover link-offset-3
	<?php echo $_SESSION['PAGE'] == 'orders' ? 'bg-secondary' : ''; ?>" data-bs-toggle="collapse" role="button">
		<i class="fas fa-cart-plus"></i> Orders<i class="fas fa-caret-down <?php echo $_SESSION['PAGE'] == 'orders' ? '' : 'fa-rotate-90'; ?>" style="float:right;"></i>
	</a>
	<div class="collapse <?php echo $_SESSION['PAGE'] == 'orders' ? 'show' : ''; ?>" id="order-collapse">
		<div class="p-2 <?php echo $_SESSION['PAGE_DROPDOWN'] == 'manage_orders' ? 'bg-secondary' : ''; ?>" style="font-size: .9rem;">
			<i class="fas fa-arrow-right text-white" style="font-size: .8rem;"></i>
			<a href="manage-orders.php" class="text-white p-3 link-underline-light link-underline-opacity-0 link-underline-opacity-100-hover link-offset-3">Manage Orders</a>
		</div>
	</div>
	
	<a href="#customer-collapse" class="text-white h6 p-3 link-underline-light link-underline-opacity-0 link-underline-opacity-100-hover link-offset-3
	<?php echo $_SESSION['PAGE'] == 'customers' ? 'bg-secondary' : ''; ?>" data-bs-toggle="collapse" role="button">
		<i class="fas fa-users"></i> Customers<i class="fas fa-caret-down <?php echo $_SESSION['PAGE'] == 'customers' ? '' : 'fa-rotate-90'; ?>" style="float:right;"></i>
	</a>
	<div class="collapse <?php echo $_SESSION['PAGE'] == 'customers' ? 'show' : ''; ?>" id="customer-collapse">
		<div class="p-2 <?php echo $_SESSION['PAGE_DROPDOWN'] == 'add_customers' ? 'bg-secondary' : ''; ?>" style="font-size: .9rem;">
			<i class="fas fa-arrow-right text-white" style="font-size: .8rem;"></i>
			<a href="add-customers.php" class="text-white p-3 link-underline-light link-underline-opacity-0 link-underline-opacity-100-hover link-offset-3">Add Customers</a>
		</div>
		<div class="p-2 <?php echo $_SESSION['PAGE_DROPDOWN'] == 'manage_customers' ? 'bg-secondary' : ''; ?>" style="font-size: .9rem;">
			<i class="fas fa-arrow-right text-white" style="font-size: .8rem;"></i>
			<a href="manage-customers.php" class="text-white  p-3 link-underline-light link-underline-opacity-0 link-underline-opacity-100-hover link-offset-3">Manage Customers</a>
		</div>
	</div>
	
	<a href="#admin-collapse" class="text-white h6 p-3 link-underline-light link-underline-opacity-0 link-underline-opacity-100-hover link-offset-3
	<?php echo $_SESSION['PAGE'] == 'admins' ? 'bg-secondary' : ''; ?>" data-bs-toggle="collapse" role="button">
		<i class="fas fa-user-cog"></i> Admins<i class="fas fa-caret-down <?php echo $_SESSION['PAGE'] == 'admins' ? '' : 'fa-rotate-90'; ?>" style="float:right;"></i>
	</a>
	<div class="collapse <?php echo $_SESSION['PAGE'] == 'admins' ? 'show' : ''; ?>" id="admin-collapse">
		<div class="p-2 <?php echo $_SESSION['PAGE_DROPDOWN'] == 'add_admins' ? 'bg-secondary' : ''; ?>" style="font-size: .9rem;">
			<i class="fas fa-arrow-right text-white" style="font-size: .8rem;"></i>
			<a href="add-admins.php" class="text-white p-3 link-underline-light link-underline-opacity-0 link-underline-opacity-100-hover link-offset-3">Add Admins</a>
		</div>
		<div class="p-2 <?php echo $_SESSION['PAGE_DROPDOWN'] == 'manage_admins' ? 'bg-secondary' : ''; ?>" style="font-size: .9rem;">
			<i class="fas fa-arrow-right text-white" style="font-size: .8rem;"></i>
			<a href="manage-admins.php" class="text-white  p-3 link-underline-light link-underline-opacity-0 link-underline-opacity-100-hover link-offset-3">Manage Admins</a>
		</div>
	</div>
</div>