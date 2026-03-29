<?php include ('includes/header.php'); ?>
            
    <div class="container-fluid px-4">
        <div class="card mt-4 shadow">
            <div class="card-header">
                <h4 class="mb-0">Add Customer</h4>
                <a href="customers.php" class="btn btn-secondary float-end"><i class="fa fa-arrow-left"></i> Back</a>
            </div>
            <div class="card-body">
                
            <?php alertMessage(); ?>

                <form action="code.php" method="POST">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name">Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" id="name"  class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="email">Email <span class="text-danger">*</span></label>
                                <input type="email" name="email" id="email" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="phone">Phone <span class="text-danger">*</span></label>
                                <input type="number"  maxlength="10" name="phone" id="phone" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6 mt-2">
                            <div class="mb-3">
                                <label for="status">Status (Checked = Hidden, Unchecked = Visible)</label>
                                <br>
                                <input type="checkbox" name="status" id="status" class="form-check-input">
                            </div>
                        </div>
                        <div class="col-md-12 mb-3 text-end">
                            <button type="submit" name="saveCustomer" class="btn btn-primary">Add Customer</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
          

<?php include ('includes/footer.php'); ?>