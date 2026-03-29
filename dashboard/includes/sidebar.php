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
                            
                        </div>
                    </div>
                    <div class="sb-sidenav-footer">
                        <div class="small"><?php echo date('Y m d / h:i A'); ?></div>
                        POS System
                    </div>
                </nav>
            </div>