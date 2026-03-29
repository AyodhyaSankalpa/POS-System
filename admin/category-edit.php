<?php include ('includes/header.php'); ?>
            
    <div class="container-fluid px-4">
        <div class="card mt-4 shadow">
            <div class="card-header">
                <h4 class="mb-0">Edit Category</h4>
                <a href="categories.php" class="btn btn-secondary float-end"><i class="fa fa-arrow-left"></i> Back</a>
            </div>
            <div class="card-body">
                
            <?php alertMessage(); ?>

                <form action="code.php" method="POST">

                <?php
                
                    $parmValue = checkParamId('id');
                    
                     if(!is_numeric($parmValue)){
                        echo '<h5>'. $parmValue .'</h5>';
                        return false;
                     }

                     $category = getById("categories", $parmValue);
                     
                    if($category['status'] == 200){
                        
                ?>

                <input type="hidden" name="categoryId" value="<?= $category['data']['id'] ?>">
                
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name">Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" value="<?= $category['data']['name'] ?>" id="name"  class="form-control">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="description">Description <span class="text-danger">*</span></label>
                                <textarea name="description" id="description" class="form-control" rows="3"><?= $category['data']['description'] ?></textarea>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="">Status (Unchecked = Visible, Checked = Hidden)</label>
                            <br>
                            <input type="checkbox" name="status" id="status" class="form-check-input" <?= $category['data']['status'] == '1' ? 'checked' : '' ?>>
                        </div>
                        <div class="col-md-12 mb-3 text-end">
                            <button type="submit" name="updateCategory" class="btn btn-primary">Update Category</button>
                        </div>
                    </div>
                <?php
                }
                else
                {
                    echo '<h5>'. $category['message'] .'</h5>';
                    return false;
                }
                ?>
                    

                </form>
            </div>
        </div>
    </div>

    <?php include ('includes/footer.php'); ?>