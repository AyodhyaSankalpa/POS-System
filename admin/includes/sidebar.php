<?php 
$page = substr(basename($_SERVER['PHP_SELF']), 0, -4);
?>
<div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">

                            <div class="sb-sidenav-menu-heading">Core</div>

                            <a class="nav-link <?php echo $page == 'index' ? 'cus-active' : ''; ?>" href="index.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Dashboard
                            </a>

                            <a class="nav-link <?php echo $page == 'order-create' ? 'cus-active' : ''; ?>" href="order-create.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-cart-plus"></i></div>
                                Create Orders
                            </a>

                            <a class="nav-link <?php echo $page == 'orders' ? 'cus-active' : ''; ?>" href="orders.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-list"></i></div>
                                Orders
                            </a>

                            <div class="sb-sidenav-menu-heading">Interface</div>
                            
                            <!-- Users -->
                            <a class="nav-link <?php echo ($page == 'users' || $page == 'user-create') ? 'cus-active' : 'collapsed'; ?>" 
                               href="#" 
                               data-bs-toggle="collapse" 
                               data-bs-target="#collapseUsers" 
                               aria-expanded="<?php echo ($page == 'users' || $page == 'user-create') ? 'true' : 'false'; ?>" 
                               aria-controls="collapseUsers">
                                <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                                Users
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse <?php echo ($page == 'users' || $page == 'user-create') ? 'show' : ''; ?>" id="collapseUsers" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link <?php echo $page == 'users' ? 'cus-active' : ''; ?>" href="users.php">View Users</a>
                                    <a class="nav-link <?php echo $page == 'user-create' ? 'cus-active' : ''; ?>" href="user-create.php">Add User</a>
                                </nav>
                            </div>


                            <!-- Category -->
                            <a class="nav-link <?php echo $page == 'categories' ? 'cus-active' : 'collapsed'; ?>" href="#" data-bs-toggle="collapse" data-bs-target="#collapseCategory" aria-expanded="false" aria-controls="collapseCategory">
                                <div class="sb-nav-link-icon"><i class="fas fa-list"></i></div>
                                Category
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                             <div class="collapse <?php echo ($page == 'categories' || $page == 'category-create') ? 'show' : ''; ?>" id="collapseCategory" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link <?php echo $page == 'categories' ? 'cus-active' : ''; ?>" href="categories.php">View Category</a>
                                    <a class="nav-link <?php echo $page == 'category-create' ? 'cus-active' : ''; ?>" href="category-create.php">Add Category</a>
                                </nav>
                            </div>

                            <!-- Products -->
                            <a class="nav-link <?php echo $page == 'products' ? 'cus-active' : 'collapsed'; ?>" href="#" data-bs-toggle="collapse" data-bs-target="#collapseProducts" aria-expanded="false" aria-controls="collapseProducts">
                                <div class="sb-nav-link-icon"><i class="fas fa-box"></i></div>
                                Products
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse <?php echo ($page == 'products' || $page == 'product-create') ? 'show' : ''; ?>" id="collapseProducts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link <?php echo $page == 'products' ? 'cus-active' : ''; ?>" href="products.php">View Products</a>
                                    <a class="nav-link <?php echo $page == 'product-create' ? 'cus-active' : ''; ?>" href="product-create.php">Add Product</a>
                                </nav>
                            </div>

                            <!-- Customer -->
                            <a class="nav-link <?php echo ($page == 'customers' || $page == 'customer-create') ? 'cus-active' : 'collapsed'; ?>" 
                               href="#" 
                               data-bs-toggle="collapse" 
                               data-bs-target="#collapseCustomers" 
                               aria-expanded="<?php echo ($page == 'customers' || $page == 'customer-create') ? 'true' : 'false'; ?>" 
                               aria-controls="collapseCustomers">
                                <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                                Customers
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse <?php echo ($page == 'customers' || $page == 'customer-create') ? 'show' : ''; ?>" id="collapseCustomers" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link <?php echo $page == 'customers' ? 'cus-active' : ''; ?>" href="customers.php">View Customers</a>
                                    <a class="nav-link <?php echo $page == 'customer-create' ? 'cus-active' : ''; ?>" href="customer-create.php">Add Customer</a>
                                </nav>
                            </div>        

                            <!-- Reports -->
                            <a class="nav-link <?php echo $page == 'ai-report' ? 'cus-active' : 'collapsed'; ?>" href="ai-report.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-chart-line"></i></div>
                                Reports
                            </a>
                        </div>
                    </div>
                    <div class="sb-sidenav-footer">
                        <div class="small"><?php echo date('Y m d / h:i A'); ?></div>
                        POS System
                    </div>
                </nav>
            </div>