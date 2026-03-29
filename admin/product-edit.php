<?php include ('includes/header.php'); ?>
            
    <div class="container-fluid px-4">
        <div class="card mt-4 shadow">
            <div class="card-header">
                <h4 class="mb-0">Edit Product</h4>
                <a href="products.php" class="btn btn-secondary float-end"><i class="fa fa-arrow-left"></i> Back</a>
            </div>
            <div class="card-body">
                
            <?php alertMessage(); ?>

                <form action="code.php" method="POST" enctype="multipart/form-data">

                <?php
                
                    $paramValue = checkParamId('id');
                    if(!is_numeric($paramValue)){
                        echo "<h5 class='text-danger'>Invalid ID</h5>";
                        return false;
                    }

                    $product = getById('products',$paramValue);
                    if($product)
                    {
                        if($product['status'] == 200)
                        {
                            ?>

                            <div class="row">
                                
                            <input type="hidden" name="product_id" value="<?= $product['data']['id'] ?>">

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
                                                            ?>
                                                                <option value="<?= $item['id'] ?>" <?= $item['id'] == $product['data']['category_id'] ? 'selected' : '' ?>><?= $item['name'] ?></option>
                                                            <?php
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
                                        <input type="text" name="name" id="name" value="<?= $product['data']['name'] ?>" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="description">Description <span class="text-danger">*</span></label>
                                        <textarea name="description" id="description" class="form-control"><?php echo $product['data']['description']; ?></textarea>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="price">Price <span class="text-danger">*</span></label>
                                        <input type="number"  maxlength="10" name="price" id="price" value="<?= $product['data']['price'] ?>" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="quantity">Quantity <span class="text-danger">*</span></label>
                                        <input type="number" name="quantity" id="quantity" value="<?= $product['data']['quantity'] ?>" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="image">Image</label>
                                    <input type="file" name="image" id="image" accept=".jpg,.jpeg,.png" class="form-control">                                    
                                    <img src="../<?= $product['data']['image'] ?>" alt="Product Image" class="img-fluid mt-2" width="100px" height="100px">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="status">Status (Checked = Hidden, Unchecked = Visible)</label>
                                    <br>
                                    <input type="checkbox" name="status" id="status" class="form-check-input" <?= $product['data']['status'] == 1 ? 'checked' : '' ?>>
                                </div>
                                <div class="col-md-12 mb-3 text-end">
                                    <button type="submit" name="updateProduct" class="btn btn-primary">Update</button>
                                </div>
                            </div>

                        <?php
                        }
                        else
                        {
                            echo "<h5>". $product['message'] ."</h5>";
                            return false;
                        }
                    }
                    else
                    {
                        echo "<h5>Something went wrong</h5>";
                        return false;
                    }

                ?>

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