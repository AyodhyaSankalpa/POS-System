<?php include ('includes/header.php'); ?>
            
    <div class="container-fluid px-4">
        <div class="card mt-4 shadow">
            <div class="card-header">
                <h4 class="mb-0">Add Product</h4>
                <a href="products.php" class="btn btn-secondary float-end"><i class="fa fa-arrow-left"></i> Back</a>
            </div>
            <div class="card-body">
                
            <?php alertMessage(); ?>

                <form action="code.php" method="POST" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name">Select Category <span class="text-danger">*</span></label>
                                <select name="category_id" id="category_id" class="form-select">
                                    <option value="">Select Category</option>
                                    <?php 
                                        $categories = getAll('categories');
                                        if($categories){                                            
                                            if(mysqli_num_rows($categories) > 0){
                                                foreach($categories as $item){
                                                    echo '<option value="'.$item['id'].'">'.$item['name'].'</option>';
                                                }
                                            }else{
                                                echo "<option value=''>No Categories Found</option>";
                                            }
                                        }else { 
                                            echo "<option value=''>Somthing went wrong</option>";
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name">Product Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" id="name"  class="form-control">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="description">Description <span class="text-danger">*</span></label>
                                <textarea name="description" id="description" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="price">Price <span class="text-danger">*</span></label>
                                <input type="number"  maxlength="10" name="price" id="price" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="quantity">Quantity <span class="text-danger">*</span></label>
                                <input type="number" name="quantity" id="quantity" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="image">Image</label>
                            <input type="file" name="image" id="image" accept=".jpg,.jpeg,.png" class="form-control">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="status">Status (Checked = Hidden, Unchecked = Visible)</label>
                            <br>
                            <input type="checkbox" name="status" id="status" class="form-check-input">
                        </div>
                        <div class="col-md-12 mb-3 text-end">
                            <button type="submit" name="saveProduct" class="btn btn-primary">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
          
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const passwordToggle = document.getElementById('password-toggle');
        const passwordInput = document.getElementById('password');

        if (passwordToggle && passwordInput) {
            passwordToggle.addEventListener('click', function() {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);

                if (type === 'text') {
                    this.innerHTML = '<i class="fa fa-eye-slash"></i>';
                } else {
                    this.innerHTML = '<i class="fa fa-eye"></i>';
                }
            });
        }
    });
</script>
<?php include ('includes/footer.php'); ?>