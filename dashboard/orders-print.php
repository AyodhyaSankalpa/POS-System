<?php include ('includes/header.php'); ?>
            
    <div class="container-fluid px-4">
        <div class="card mt-4 shadow">
            <div class="card-header">
                <h4 class="mb-0">Print Order
                    <a href="orders.php" class="btn btn-secondary float-end"><i class="fa fa-arrow-left"></i> Back</a>
                </h4>
            </div>
            <div class="card-body">

            <div id="myBillingArea">

                <?php
                    if(isset($_GET['track']))
                    {   
                        $trackingNo = validate($_GET['track']);
                        if($trackingNo == '')
                        {
                            ?>
                                <div class="text-center py-5">
                                    <h5>Pleas provide Tracking Number</h5>
                                    <div class="mt-4">
                                        <a href="orders.php" class="btn btn-primary w-25">Back to Orders</a>
                                    </div>
                                </div>
                            <?php
                            return;
                        }

                        $orderQuery = "SELECT o.*, c.* FROM orders o, customers c 
                                        WHERE c.id = o.customer_id AND o.tracking_no = '$trackingNo' LIMIT 1";

                        $orderQueryRes = mysqli_query($conn, $orderQuery);

                        if(!$orderQueryRes)
                        {
                            echo "<h5>No Record Found!</h5>";
                            return false;
                        }
                        
                        if(mysqli_num_rows($orderQueryRes) > 0)
                        {
                            $orderDataRow = mysqli_fetch_assoc($orderQueryRes);
                            ?>

                                <table style="width: 100%; margin-bottom: 20px;">
                                            <tbody>
                                                <tr>
                                                <td style="text-align: center;" colspan="2">
                                                    <h5 style="font-size: 20px; line-height: 30px; margin: 0; padding: 0;">Company XYZ</h5>
                                                    <p style="font-size: 14px; line-height: 20px; margin: 0; padding: 0;">#555, 123 Main St, Anytown, USA</p>
                                                    <p style="font-size: 14px; line-height: 20px; margin: 0; padding: 0;">Company xyz pvt ltd</p>
                                                </td>
                                                </tr>

                                                <tr>
                                                <td style="font-size: 14px; line-height: 20px; margin: 0; padding: 0;">
                                                    <h5 style="font-size: 20px; line-height: 30px; margin: 0; padding: 0;">Customer Details</h5>
                                                    <p style="font-size: 14px; line-height: 20px; margin: 0; padding: 0;">Customer Name: <?= $orderDataRow['name']; ?></p>
                                                    <p style="font-size: 14px; line-height: 20px; margin: 0; padding: 0;">Customer Email: <?= $orderDataRow['email']; ?></p>
                                                    <p style="font-size: 14px; line-height: 20px; margin: 0; padding: 0;">Customer Phone: <?= $orderDataRow['phone']; ?></p>
                                                </td>

                                                <td align="end" style="font-size: 14px; line-height: 20px; margin: 0; padding: 0;">
                                                    <p style="font-size: 14px; line-height: 20px; margin: 0; padding: 0;">Invoice Details</p>
                                                    <p style="font-size: 14px; line-height: 20px; margin: 0; padding: 0;">Invoice No: <?= $orderDataRow['invoice_no']; ?></p>
                                                    <p style="font-size: 14px; line-height: 20px; margin: 0; padding: 0;">Invoice Date: <?= date('d-m-Y') ?></p>
                                                    <p style="font-size: 14px; line-height: 20px; margin: 0; padding: 0;">Address 1st Floor, 123 Main St, Anytown, USA</p>
                                                </td>
                                                </tr>

                                                <tr>
                                                <!-- <td colspan="2" style="font-size: 14px; line-height: 20px; margin: 0; padding: 0;">
                                                    Additional information or footer text goes here...
                                                </td> -->
                                                </tr>
                                            </tbody>
                                        </table>

                            <?php
                        }
                        else
                        {
                            echo "<h5>No data Found</h5>";
                            return false;
                        }
                        

                        $orderQuery = "SELECT oi.quantity as orderItemQuantity, oi.price as OrderItemprice, o.*, oi.*, p.* 
                                        FROM orders o, order_items oi, products p 
                                        WHERE oi.order_id = o.id AND oi.product_id = p.id 
                                        AND o.tracking_no = '$trackingNo'";

                        $orderQueryRes = mysqli_query($conn, $orderQuery);

                        if($orderQueryRes)
                        {
                            if(mysqli_num_rows($orderQueryRes) > 0)
                            {
                                ?>

                                    <div class="table-responsive mb-3">
                                        <table class="" style="width: 100%;" cellpadding="5">
                                            <thead>
                                                <tr>
                                                    <th align="start" style="border-bottom:1px solid #ccc;" width="5%">ID</th>
                                                    <th align="start" style="border-bottom:1px solid #ccc;">Product Name</th>
                                                    <th align="start" style="border-bottom:1px solid #ccc;" width="10%">Price</th>
                                                    <th align="start" style="border-bottom:1px solid #ccc;" width="10%">Quantity</th>
                                                    <th align="start" style="border-bottom:1px solid #ccc;" width="10%">Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i = 1;

                                                foreach($orderQueryRes as $key => $row) :
                                                    
                                                ?>

                                                    <tr>
                                                        <td style="border-bottom: 1px solid #ccc;"><?= $i++; ?></td>
                                                        <td style="border-bottom: 1px solid #ccc;"><?= $row['name'] ?></td>
                                                        <td style="border-bottom: 1px solid #ccc;"><?= number_format($row['OrderItemprice'], 2) ?></td>
                                                        <td style="border-bottom: 1px solid #ccc;"><?= $row['orderItemQuantity'] ?></td>
                                                        <td style="border-bottom: 1px solid #ccc;" class="fw-bold">
                                                            <?= number_format($row['OrderItemprice'] * $row['orderItemQuantity'], 2) ?>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>

                                                <tr>
                                                    <td colspan="4" align="end" style="font-weight: bold;">Grand Total :</td>
                                                    <td colspan="1" style="font-weight: bold;"><?= number_format($row['total_amount'], 2) ?></td>
                                                </tr>

                                                <tr>
                                                    <td colspan="5">Payment Mode: <?= $row['payment_mode'] ?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                <?php
                            }
                            else
                            {
                                echo "<h5>No data Found</h5>";
                                return false;
                            }
                        }
                        else
                        {
                            echo "<h5>Something went wrong</h5>";
                            return false;
                        }


                    }
                    else
                    {
                        ?>
                            <div class="text-center py-5">
                                <h5>No Tracking Number Found!</h5>
                                <div class="mt-4">
                                    <a href="orders.php" class="btn btn-primary w-25">Back to Orders</a>
                                </div>
                            </div>
                        <?php
                    }
                ?>

            </div>

            <div class="mt-4 text-end">
                <button class="btn btn-info px-4 mx-1" onclick="printMyBillingArea()"> <i class="fa fa-print"></i> Print</button>
                <button class="btn btn-warning px-4 mx-1" onclick="downloadPDF('<?= $orderDataRow['invoice_no']; ?>')"> <i class="fa fa-download"></i> Download PDF</button>
            </div>

            </div>
        </div>
    </div>
          

<?php include ('includes/footer.php'); ?>