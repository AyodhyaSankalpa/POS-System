<?php include ('includes/header.php'); ?>
            
    <div class="container-fluid px-4">
        <div class="card mt-4 shadow">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-4">
                       <h4 class="mb-0">Orders</h4> 
                    </div>
                    <div class="col-md-8">
                        <form action="" method="GET">
                            <div class="row g-1">
                                <div class="col-md-3">
                                    <input type="text"
                                        class="form-control"
                                        id="trackingSearch"
                                        placeholder="Search Tracking No."
                                        value="<?= isset($_GET['tracking_no']) ? htmlspecialchars($_GET['tracking_no']) : '' ?>"
                                        autocomplete="off"
                                    />
                                </div>
                                <div class="col-md-3">
                                    <input type="date"
                                        class="form-control" 
                                        name="date" 
                                        value="<?= isset($_GET['date']) ? $_GET['date'] : '' ?>"
                                    />
                                </div>
                                <div class="col-md-3">
                                    <select name="payment_status" class="form-select">
                                        <option value="">Select Payment Status</option>
                                        <option value="cash" <?= (isset($_GET['payment_status']) && $_GET['payment_status'] == 'cash') ? 'selected' : ''; ?>>Cash</option>
                                        <option value="card" <?= (isset($_GET['payment_status']) && $_GET['payment_status'] == 'card') ? 'selected' : ''; ?>>Card</option>
                                        <option value="online" <?= (isset($_GET['payment_status']) && $_GET['payment_status'] == 'online') ? 'selected' : ''; ?>>Online</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <button type="submit" class="btn btn-primary">Filter</button>
                                    <a href="orders.php" class="btn btn-warning">Reset</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="card-body">

                <?php

                    if(isset($_GET['date']) || isset($_GET['payment_status'])){
                        $orderDate = validate($_GET['date']);
                        $paymentStatus = validate($_GET['payment_status']);
                    
                        if($orderDate != '' && $paymentStatus == '')
                        {
                            $query = "SELECT o.*, c.* FROM orders o, customers c 
                                    WHERE c.id = o.customer_id AND o.order_date = '$orderDate' ORDER BY o.id DESC";

                        }elseif($orderDate == '' && $paymentStatus != ''){

                            $query = "SELECT o.*, c.* FROM orders o, customers c 
                                    WHERE c.id = o.customer_id AND o.payment_mode = '$paymentStatus' ORDER BY o.id DESC";

                        }elseif($orderDate != '' && $paymentStatus != ''){

                            $query = "SELECT o.*, c.* FROM orders o, customers c 
                                    WHERE c.id = o.customer_id 
                                    AND o.order_date = '$orderDate' 
                                    AND o.payment_mode = '$paymentStatus' ORDER BY o.id DESC";
                        
                        }
                        else{

                            $query = "SELECT o.*, c.* FROM orders o, customers c 
                                    WHERE c.id = o.customer_id ORDER BY o.id DESC";

                        }
                    }
                    else
                    {
                        $query = "SELECT o.*, c.* FROM orders o, customers c 
                                    WHERE c.id = o.customer_id ORDER BY o.id DESC";
                    }

                    $orders = mysqli_query($conn, $query);
                    if($orders){

                        if(mysqli_num_rows($orders) > 0)
                        {
                            ?>

                               <table class="table table-striped table-borderd align-items-center justify-content-center" id="ordersTable">
                                    <thead>
                                        <tr>
                                            <th>Tracking No.</th>
                                            <th>C Name</th>
                                            <th>C Phone</th>
                                            <th>Order Date</th>
                                            <th>Order Status</th>
                                            <th>Payment Mode</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="ordersTableBody">
                                        <?php foreach($orders as $orderItem) : ?>
                                            <tr>
                                                <td class="fw-bold"><?= $orderItem['tracking_no']; ?></td>
                                                <td><?= $orderItem['name']; ?></td>
                                                <td><?= $orderItem['phone']; ?></td>
                                                <td><?= date('d M, Y', strtotime($orderItem['order_date'])); ?></td>
                                                <td><?= $orderItem['order_status']; ?></td>
                                                <td><?= $orderItem['payment_mode']; ?></td>
                                                <td>
                                                    <a href="orders-view.php?track=<?= $orderItem['tracking_no']; ?>" class="btn btn-info mb-0 px-2 btm-sm">View</a>
                                                    <a href="orders-print.php?track=<?= $orderItem['tracking_no']; ?>" class="btn btn-primary mb-0 px-2 btm-sm">Print</a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                               </table>

                               <p id="noTrackingResult" class="text-muted" style="display:none;">No matching tracking number found.</p>

                            <?php
                        }
                        else
                        {
                            echo "<h5>No Record Available</h5>";
                        }

                    }
                    else
                    {
                        echo "<h5>Somthing went wrong</h5>";;
                    }
                ?>

            </div>
        </div>
    </div>

<script>
    document.getElementById('trackingSearch').addEventListener('input', function () {
        const searchValue = this.value.trim().toLowerCase();
        const rows = document.querySelectorAll('#ordersTableBody tr');
        let visibleCount = 0;

        rows.forEach(function (row) {
            const trackingNo = row.cells[0].textContent.trim().toLowerCase();
            if (trackingNo.includes(searchValue)) {
                row.style.display = '';
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        });

        const noResult = document.getElementById('noTrackingResult');
        noResult.style.display = visibleCount === 0 ? 'block' : 'none';
    });
</script>

<?php include ('includes/footer.php'); ?>