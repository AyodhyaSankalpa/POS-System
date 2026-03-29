<?php include ('includes/header.php'); ?>
            
    <div class="container-fluid px-4">
        <div class="card mt-4 shadow">
            <div class="card-header">
                <h4 class="mb-0">Edit Customer</h4>
                <a href="customers.php" class="btn btn-secondary float-end"><i class="fa fa-arrow-left"></i> Back</a>
            </div>
            <div class="card-body">
                
            <?php alertMessage(); ?>

                <form action="code.php" method="POST">
                    <?php
                        $paramValue = checkParamId('id');
                        if($paramValue == 'invalid'){
                            echo '<div class="alert alert-danger">Invalid ID</div>';
                            return false;
                        }

                        $customer = getById('customers', $paramValue);
                        if($customer['status'] == '200')
                        {
                            ?>

                                <input type="hidden" name="customerId" value="<?= $customer['data']['id'] ?>">

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="name">Name <span class="text-danger">*</span></label>
                                            <input type="text" name="name" id="name"  class="form-control" value="<?= $customer['data']['name'] ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="email">Email <span class="text-danger">*</span></label>
                                            <input type="email" name="email" id="email" class="form-control" value="<?= $customer['data']['email'] ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="phone">Phone <span class="text-danger">*</span></label>
                                            <input type="number"  maxlength="10" name="phone" id="phone" class="form-control" value="<?= $customer['data']['phone'] ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-6 mt-2">
                                        <div class="mb-3">
                                            <label for="status">Status (Checked = Hidden, Unchecked = Visible)</label>
                                            <br>
                                            <input type="checkbox" name="status" id="status" class="form-check-input" <?= $customer['data']['status'] == '1' ? 'checked' : '' ?>>
                                        </div>
                                    </div>
                                    <div class="col-md-12 mb-3 text-end">
                                        <button type="submit" name="updateCustomer" class="btn btn-primary">Update Customer</button>
                                    </div>
                                </div>

                            <?php

                        }else{
                            echo '<div class="alert alert-danger">'.$customer['message'].'</div>';
                            return false;
                        }

                    ?>
                    


                </form>
                
            </div>
        </div>
    </div>
          

<?php include ('includes/footer.php'); ?>