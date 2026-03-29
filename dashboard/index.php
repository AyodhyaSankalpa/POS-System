<?php include('includes/header.php'); ?>

<div class="container-fluid px-4">

    <div class="mt-3">
        <?php alertMessage() ?>
    </div>

    <h1 class="mt-4">Dashboard</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Dashboard</li>
    </ol>

        <div class="row">
            <div class="col-md-3 mb-3">
                <div class="card card-body p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-sm mb-0 text-capitalize">Monthly Orders</p>
                            <h5 class="fw-bold mb-0">
                                <?php 
                                
                                    $user_id =  $_SESSION['loggedInUser']['user_id'];

                                    $todayOrders = "SELECT * FROM orders WHERE order_date = CURDATE() AND order_placed_by_id = '$user_id'";
                                    $result = mysqli_query($conn, $todayOrders);
                                    $totalTodayOrders = mysqli_num_rows($result);
                                    echo $totalTodayOrders;

                                ?>
                            </h5>
                        </div>
                        <div class="text-primary">
                            <i class="fa fa-list fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card card-body p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-sm mb-0 text-capitalize">Total Orders</p>
                            <h5 class="fw-bold mb-0">
                                <?php
                                
                                    $user_id =  $_SESSION['loggedInUser']['user_id'];

                                    $totalOrders = "SELECT * FROM orders WHERE order_placed_by_id = '$user_id'";
                                    $result = mysqli_query($conn, $totalOrders);
                                    $totalOrders = mysqli_num_rows($result);
                                    echo $totalTodayOrders;

                                ?>
                            </h5>
                        </div>
                        <div class="text-success">
                            <i class="fa fa-box fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php include('includes/footer.php'); ?>