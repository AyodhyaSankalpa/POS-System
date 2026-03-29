<?php include ('includes/header.php'); ?>
            
    <div class="container-fluid px-4">
        <div class="card mt-4 shadow">
            <div class="card-header">
                <h4 class="mb-0">Users</h4>
                <a href="user-create.php" class="btn btn-primary float-end"><i class="fa fa-plus"></i> Add User</a>
            </div>
            <div class="card-body">

            <?php alertMessage(); ?>

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Is Ban</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                       
                            <?php 
                                $users = getAll('users');
                                $i = 1;

                                if(!$users){
                                    echo '<h4>Somthing went wrong</h4>';
                                    return false;
                                }

                                if(mysqli_num_rows($users) > 0){
                                    $hasUsers = false;
                                    foreach($users as $user){
                                        if($user['is_delete'] != 1){
                                            $hasUsers = true;
                                ?>
                                <tr>
                                    <td><?= $i++ ?></td>
                                    <td><?= $user['name'] ?></td>
                                    <td><?= $user['email'] ?></td>
                                    <td><?= $user['phone'] ?></td>
                                    <td><?= $user['is_ban'] == '1' ? '<span class="badge bg-danger">Yes</span>' : '<span class="badge bg-success">No</span>' ?></td>
                                    <td class="text-center">
                                        <a href="user-edit.php?id=<?= $user['id'] ?>" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i> Edit</a>
                                        <a href="user-delete.php?id=<?= $user['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this user?')"><i class="fa fa-trash"></i> Delete</a>
                                    </td>
                                </tr>
                                <?php
                                        }
                                    }

                                    if(!$hasUsers){
                                        echo '<tr><td class="text-center" colspan="4">No users found</td></tr>';
                                    }
                                }
                                else{
                                ?>
                                <tr>
                                    <td colspan="4">No users found</td>
                                </tr>
                                <?php
                                }
                                ?>
                            
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>
                
<?php include ('includes/footer.php'); ?>