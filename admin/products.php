<?php 

include ('includes/header.php');

?>
            
<div class="container-fluid px-4">
    <div class="card mt-4 shadow">
        <div class="card-header">
            <h4 class="mb-0">Products</h4>
            <a href="product-create.php" class="btn btn-primary float-end">
                <i class="fa fa-plus"></i> Add Product
            </a>
        </div>
        <div class="card-body">

            <?php alertMessage(); ?>

            <?php 
                $products = getAll('products');

                if(!$products){
                    echo '<div class="alert alert-danger">Something went wrong!</div>';
                } else {

                    if(mysqli_num_rows($products) > 0){
            ?>

                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $i = 1;
                                foreach($products as $item){ 
                                ?>
                                    <tr>
                                        <td><?= $i++ ?></td>
                                        <td>
                                            <?php if($item['image'] != ''): ?>
                                                <img src="../<?= htmlspecialchars($item['image']) ?>" alt="" width="50px" height="50px">
                                            <?php else: ?>
                                                <p>No Image</p>
                                            <?php endif; ?>
                                        </td>
                                        <td><?= htmlspecialchars($item['name']) ?></td>
                                        <td><?= htmlspecialchars($item['description']) ?></td>
                                        <td><?= htmlspecialchars($item['price']) ?></td>
                                        <td><?= htmlspecialchars($item['quantity']) ?></td>
                                        <td>
                                            <?php if($item['status'] == '1'): ?>
                                                <span class="badge bg-danger">Hidden</span>
                                            <?php else: ?>
                                                <span class="badge bg-success">Visible</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-center">
                                            <a href="product-edit.php?id=<?= $item['id'] ?>" 
                                               class="btn btn-primary btn-sm">
                                                <i class="fa fa-edit"></i> Edit
                                            </a>
                                            <a href="product-delete.php?id=<?= $item['id'] ?>" 
                                               class="btn btn-danger btn-sm"
                                               onclick="return confirm('Are you sure you want to delete <?= htmlspecialchars($item['name']) ?>?')">
                                                <i class="fa fa-trash"></i> Delete
                                            </a>
                                        </td>
                                    </tr>
                                <?php 
                                } 
                                ?>
                            </tbody>
                        </table>

            <?php 
                    } else {
            ?>
                        <div class="alert alert-info text-center py-4">
                            <h5>No products found</h5>
                            <p>Click the "Add Product" button to create one.</p>
                        </div>
            <?php 
                    }
                }
            ?>

        </div>
    </div>
</div>
                
<?php include ('includes/footer.php'); ?>