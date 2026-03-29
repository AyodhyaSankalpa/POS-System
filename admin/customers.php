<?php 

include ('includes/header.php');

?>
            
<div class="container-fluid px-4">
    <div class="card mt-4 shadow">
        <div class="card-header">
            <h4 class="mb-0">Customers</h4>
            <a href="customer-create.php" class="btn btn-primary float-end">
                <i class="fa fa-plus"></i> Add Customer
            </a>
        </div>
        <div class="card-body">

            <?php alertMessage(); ?>

            <?php 
                $customers = getAll('customers');

                if(!$customers){
                    echo '<div class="alert alert-danger">Something went wrong!</div>';
                } else {

                    if(mysqli_num_rows($customers) > 0){
            ?>

                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $i = 1;
                                foreach($customers as $item){ 
                                ?>
                                    <tr>
                                        <td><?= $i++ ?></td>
                                        <td><?= htmlspecialchars($item['name']) ?></td>
                                        <td><?= htmlspecialchars($item['email'] ?: '-') ?></td>
                                        <td><?= htmlspecialchars($item['phone'] ?: '-') ?></td>
                                        <td>
                                            <?php if($item['status'] == '1'): ?>
                                                <span class="badge bg-danger">Hidden</span>
                                            <?php else: ?>
                                                <span class="badge bg-success">Visible</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-center">
                                            <a href="customer-edit.php?id=<?= $item['id'] ?>" 
                                               class="btn btn-primary btn-sm">
                                                <i class="fa fa-edit"></i> Edit
                                            </a>
                                            <a href="customer-delete.php?id=<?= $item['id'] ?>" 
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
                            <h5>No customers found</h5>
                            <p>Click the "Add Customer" button to create one.</p>
                        </div>
            <?php 
                    }
                }
            ?>

        </div>
    </div>
</div>
                
<?php include ('includes/footer.php'); ?>