<?php include ('includes/header.php'); ?>


<!-- Modal -->
<div class="modal fade" id="addCustomerModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Add Customer</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="orders-code.php" method="POST">
            <div class="row">
                <div class="mb-3">
                    <label for="name">Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" id="c_name" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="email">Email (Optional)</label>
                    <input type="email" name="email" id="c_email" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="phone">Phone <span class="text-danger">*</span></label>
                    <input type="text" name="phone" id="c_phone" class="form-control">
                </div>
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary saveCustomer">Save changes</button>
      </div>
    </div>
  </div>
</div>

            
    <div class="container-fluid px-4">

        <div class="card mt-4 shadow">
            <div class="card-header">
                <h4 class="mb-0">Create Order</h4>
                <a href="orders.php" class="btn btn-secondary float-end"><i class="fa fa-arrow-left"></i> Back</a>
            </div>
            <div class="card-body">
                
            <?php alertMessage(); ?>

                <form action="orders-code.php" method="POST">
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            
                                <label for="name">Select Product <span class="text-danger">*</span></label>
                                <select name="product_id" class="form-select mySelect2">
                                    <option value="">-- Select Product --</option>
                                    <?php

                                        $products = getAll('products');

                                        if($products){
                                            if(mysqli_num_rows($products) > 0){
                                                foreach($products as $prodItem){
                                                    ?>

                                                        <option value="<?= $prodItem['id'] ?>"><?= $prodItem['name'] ?></option>

                                                    <?php
                                                }
                                            }else{
                                               echo '<option value="">No product found</option>'; 
                                            }
                                        }else {
                                            echo '<option value="">Something Went Wrong</option>';
                                        }

                                    ?>
                                </select>
                            
                        </div>

                        <div class="col-md-2 mb-3">
                            
                                <label for="description">Quantity <span class="text-danger">*</span></label>
                                <input type="number" name="quantity" value="1" class="form-control"> 
                            
                        </div>
                        <div class="col-md-3 mb-3 text-end">
                            <br>
                            <button type="submit" name="addItem" class="btn btn-primary">Add Item</button>
                        </div>
                    </div>
                </form>
                
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header">
                <h4 class="mb-0">Order Items</h4>
            </div>
            <div class="card-body" id="productArea">
                <?php
                
                if(isset($_SESSION['productItems']))
                {
                    $sessionProducts = $_SESSION['productItems'];
                    if(empty($sessionProducts)){
                        unset($_SESSION['productItemIds']);
                        unset($_SESSION['productItems']);
                    }
                 ?>
                 
                    <div class="table-responsive mb-3" id="productContent">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Product Name</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Total Price</th>
                                    <th>Remove</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $i = 1;
                                    foreach($sessionProducts as $key => $item) : 
                                    
                                ?>
                                    <tr>
                                        <td class="text-center"><?= $i++; ?></td>
                                        <td><?= $item['name']; ?></td>
                                        <td><?= $item['price']; ?></td>
                                        <td>
                                            <div class="input-group qtyBox">
                                                <input type="hidden" value="<?= $item['product_id']; ?>" class="prodId">
                                                <button class="input-group-text decrement">-</button>
                                                <input type="text" value="<?= $item['quantity']; ?>" class="qty quantityInput">
                                                <button class="input-group-text increment">+</button>
                                            </div>
                                        </td>
                                        <td><?= number_format($item['price'] * $item['quantity'], 0); ?></td>
                                        <td class="text-center">
                                            <a href="order-item-delete.php?index=<?= $key; ?>" class="btn btn-danger btn-sm">
                                                <i class="fa fa-close"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-2">
                        <hr>
                        <div class="row">
                            <div class="col-md-4">
                                <label for="name">Select Payment Method</label>                                
                                <select id="payment_mode" class="form-select">
                                    <option value="">-- Select Payment Method --</option>
                                    <option value="cash">Cash</option>
                                    <option value="card">Card</option>
                                    <option value="online">Online</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="">Enter Customer Phone Number</label>
                                <input type="text" class="form-control" id="cphone" placeholder="Enter Customer Phone">
                            </div>
                            <div class="col-md-4">
                                <br>
                                <button type="submit" class="btn btn-warning w-100 proceedToPlace">Proceed to place order</button>
                            </div>
                        </div>
                    </div>

                 <?php   
                }
                else{
                    echo '<h4 class="text-center">No items added yet!</h4>';
                }

                ?>
            </div>            
        </div>

    </div>

    <?php include ('includes/footer.php'); ?>