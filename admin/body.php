<div class="container-fluid px-4">

<div class="mt-3">
    <?php alertMessage() ?>
</div>

    <h1 class="mt-4">Dashboard</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Dashboard</li>
    </ol>

        <div class="row mb-3">
            <div class="col-md-3 mb-3">
                <div class="card card-body p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-sm mb-0 text-capitalize">Total Categories</p>
                            <h5 class="fw-bold mb-0">
                                <?= getCount('categories'); ?>
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
                            <p class="text-sm mb-0 text-capitalize">Total Products</p>
                            <h5 class="fw-bold mb-0">
                                <?= getCount('products'); ?>
                            </h5>
                        </div>
                        <div class="text-success">
                            <i class="fa fa-box fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card card-body p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-sm mb-0 text-capitalize">Total Customers</p>
                            <h5 class="fw-bold mb-0">
                                <?= getCount('customers'); ?>
                            </h5>
                        </div>
                        <div class="text-info">
                            <i class="fa fa-users fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="card card-body p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-sm mb-0 text-capitalize">Total Users</p>
                            <h5 class="fw-bold mb-0">
                                <?php
                                    $users = "SELECT * FROM users WHERE is_admin='0'";
                                    $result = mysqli_query($conn, $users);
                                    $totalUsers = mysqli_num_rows($result);
                                    echo $totalUsers;
                                ?>
                            </h5>
                        </div>
                        <div class="text-danger">
                            <i class="fa fa-user fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
           

            <div class="col-md-12 mb-3">
                <hr>
                 <h5>Orders</h5>
            </div>

            <div class="col-md-3 mb-3">
                <div class="card card-body p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-sm mb-0 text-capitalize">Today Orders</p>
                            <h5 class="fw-bold mb-0">
                                <?php
                                    $todayOrders = "SELECT * FROM orders WHERE order_date = CURDATE()";
                                    $result = mysqli_query($conn, $todayOrders);
                                    $totalTodayOrders = mysqli_num_rows($result);
                                    echo $totalTodayOrders;
                                ?>
                            </h5>
                        </div>
                        <div class="text-warning">
                            <i class="fa fa-shopping-cart fa-2x"></i>
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
                                <?= getCount('orders'); ?>
                            </h5>
                        </div>
                        <div class="text-warning">
                            <i class="fa fa-shopping-cart fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>


        </div>

        

        <?php
        // Query for Today Orders by Category
        $todayCategoryQuery = "
            SELECT c.name as category_name, SUM(oi.quantity) as total_quantity 
            FROM orders o 
            JOIN order_items oi ON o.id = oi.order_id 
            JOIN products p ON oi.product_id = p.id 
            JOIN categories c ON p.category_id = c.id 
            WHERE o.order_date = CURDATE() 
            GROUP BY c.id
        ";
        $todayCategoryResult = mysqli_query($conn, $todayCategoryQuery);
        $categories = [];
        $quantities = [];
        if($todayCategoryResult){
            while($row = mysqli_fetch_assoc($todayCategoryResult)){
                $categories[] = $row['category_name'];
                $quantities[] = $row['total_quantity'];
            }
        }

        // Query for All Orders by Month
        $monthlyOrdersQuery = "
            SELECT DATE_FORMAT(order_date, '%b-%Y') as month_name, COUNT(id) as total_orders 
            FROM orders 
            GROUP BY DATE_FORMAT(order_date, '%Y-%m'), month_name
            ORDER BY DATE_FORMAT(order_date, '%Y-%m')
        ";
        $monthlyOrdersResult = mysqli_query($conn, $monthlyOrdersQuery);
        $months = [];
        $ordersCount = [];
        if($monthlyOrdersResult){
            while($row = mysqli_fetch_assoc($monthlyOrdersResult)){
                $months[] = $row['month_name'];
                $ordersCount[] = $row['total_orders'];
            }
        }
        ?>

        <div class="row">
            <div class="col-xl-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-chart-bar me-1"></i>
                        Today Orders (Category wise)
                    </div>
                    <div class="card-body"><canvas id="todayOrdersChart" width="100%" height="40"></canvas></div>
                </div>
            </div>
            <div class="col-xl-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-chart-area me-1"></i>
                        All Orders (Monthly)
                    </div>
                    <div class="card-body"><canvas id="allOrdersChart" width="100%" height="40"></canvas></div>
                </div>
            </div>
        </div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    if (typeof Chart === 'undefined') {
        console.error("Chart.js is not loaded!");
        return;
    }

    // Set new default font family and font color to mimic Bootstrap's default styling
    Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
    Chart.defaults.global.defaultFontColor = '#292b2c';

    // Bar Chart - Today Orders by Category
    var ctxBar = document.getElementById("todayOrdersChart");
    var todayOrdersChart = new Chart(ctxBar, {
      type: 'bar',
      data: {
        labels: <?php echo json_encode($categories); ?>,
        datasets: [{
          label: "Sale Quantity",
          backgroundColor: "rgba(2,117,216,1)",
          borderColor: "rgba(2,117,216,1)",
          data: <?php echo json_encode($quantities); ?>,
        }],
      },
      options: {
        scales: {
          xAxes: [{
            gridLines: {
              display: false
            },
            ticks: {
              maxTicksLimit: 10
            }
          }],
          yAxes: [{
            ticks: {
              min: 0,
              maxTicksLimit: 5
            },
            gridLines: {
              display: true
            }
          }],
        },
        legend: {
          display: false
        }
      }
    });

    // Area Chart - All Orders Monthly
    var ctxArea = document.getElementById("allOrdersChart");
    var allOrdersChart = new Chart(ctxArea, {
      type: 'line',
      data: {
        labels: <?php echo json_encode($months); ?>,
        datasets: [{
          label: "Orders Count",
          lineTension: 0.3,
          backgroundColor: "rgba(2,117,216,0.2)",
          borderColor: "rgba(2,117,216,1)",
          pointRadius: 5,
          pointBackgroundColor: "rgba(2,117,216,1)",
          pointBorderColor: "rgba(255,255,255,0.8)",
          pointHoverRadius: 5,
          pointHoverBackgroundColor: "rgba(2,117,216,1)",
          pointHitRadius: 50,
          pointBorderWidth: 2,
          data: <?php echo json_encode($ordersCount); ?>,
        }],
      },
      options: {
        scales: {
          xAxes: [{
            gridLines: {
              display: false
            },
            ticks: {
              maxTicksLimit: 12
            }
          }],
          yAxes: [{
            ticks: {
              min: 0,
              maxTicksLimit: 5
            },
            gridLines: {
              color: "rgba(0, 0, 0, .125)",
            }
          }],
        },
        legend: {
          display: false
        }
      }
    });

});
</script>

    </div>