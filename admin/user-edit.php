<?php include ('includes/header.php'); ?>
            
    <div class="container-fluid px-4">
        <div class="card mt-4 shadow">
            <div class="card-header">
                <h4 class="mb-0">Edit User</h4>
                <a href="users.php" class="btn btn-secondary float-end"><i class="fa fa-arrow-left"></i> Back</a>
            </div>
            <div class="card-body">
                
            <?php alertMessage(); ?>

                <form action="code.php" method="POST">

                <?php
                
                    if(isset($_GET['id']))
                    {
                        if($_GET['id'] != '')
                        {
                            $userId = $_GET['id'];
                        }
                        else
                        {
                            echo '<h5>No ID Found</h5>';
                            return false;
                        }
                    }
                    else
                    {
                        echo '<h5>Invalid ID in URL</h5>';
                        return false;
                    }

                    $userData = getById("users", $userId);
                    if($userData){
                        if($userData['status'] == 200){

                            $user = $userData['data'];
                            ?>

                            <input type="hidden" name="userId" value="<?= $user['id'] ?>">

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="name">Name <span class="text-danger">*</span></label>
                                            <input type="text" name="name" id="name" value="<?= $userData['data']['name'] ?>"  class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="email">Email <span class="text-danger">*</span></label>
                                            <input type="email" name="email" id="email" value="<?= $userData['data']['email'] ?>" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="phone">Phone <span class="text-danger">*</span></label>
                                            <input type="number"  maxlength="10" name="phone" value="<?= $userData['data']['phone'] ?>" id="phone" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="password">Password <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <input type="password" name="password" id="password" class="form-control">
                                                <!-- eye icon -->
                                                <span class="input-group-text border-start-0" id="password-toggle" style="cursor: pointer; background-color: transparent;">
                                                    <i class="fa fa-eye"></i>
                                                </span>
                                            </div>
                                            <small class="text-muted">Password must be at least 6 characters long.</small>
                                        </div>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label for="">Is Ban</label>
                                        <input type="checkbox" name="is_ban" id="is_ban" <?= $userData['data']['is_ban'] == '1' ? 'checked' : '' ?> class="form-check-input">
                                    </div>
                                    <div class="col-md-12 mb-3 text-end">
                                        <button type="submit" name="updateUser" class="btn btn-primary">Update User</button>
                                    </div>
                                </div>

                            <?php
                        }else{
                            echo '<h5>'.$userData['message'].'</h5>';
                            return false;
                        }
                    }else{
                        echo '<h5>Something went wrong</h5>';
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