<?php 
include ('includes/header.php'); 

if(isset($_SESSION['loggedIn']))
{
    ?>
    <script>
        window.location.href = 'index.php';
    </script>
    <?php
}
?>

    
    <div class="py-5">
        <div class="container mt-5">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card shadow rounded-4">

                        

                        <div class="card-header">
                            <h4>Sign Into your POS System</h4>
                        </div>

                        <div class="card-body">

                        <?php alertMessage() ?>

                            <form action="login-code.php" method="POST">
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="email">
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" class="form-control" id="password" name="password">
                                </div>
                                <button type="submit" name="loginBtn" class="btn btn-primary">Login</button>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    


<?php include ('includes/footer.php'); ?>