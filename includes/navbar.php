<!-- bootstrap navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-light shadow">
    <div class="container">

        <a class="navbar-brand" href="index.php">POS System</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="index.php">Home</a>
                </li>

                <?php if(isset($_SESSION['loggedIn'])) : ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user fa-fw"></i> 
                            <?php echo isset($_SESSION['loggedInUser']['name']) ? $_SESSION['loggedInUser']['name'] : 'User'; ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <?php if(isset($_SESSION['loggedInUser']['is_admin']) && $_SESSION['loggedInUser']['is_admin'] == 1) : ?>
                                <li><a class="dropdown-item" href="admin/index.php">Dashboard</a></li>
                            <?php else : ?>
                                <li><a class="dropdown-item" href="dashboard/index.php">Dashboard</a></li>
                            <?php endif; ?>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                        </ul>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="login.php">Login</a>
                    </li>
                <?php endif; ?>

            </ul>
        </div>
    </div>
</nav>
