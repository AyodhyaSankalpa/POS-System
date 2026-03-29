<?php include ('includes/header.php'); ?>

<style>
    .hero-section {
        background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80') center/cover no-repeat;
        min-height: calc(100vh - 56px); /* Adjust based on navbar height */
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
    }
    
    .hero-content {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 20px;
        padding: 4rem 3rem;
        text-align: center;
        max-width: 650px;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
    }
    
    .hero-content h1 {
        font-weight: 800;
        margin-bottom: 20px;
        font-size: 3.2rem;
        letter-spacing: 1px;
    }
    
    .hero-content p {
        font-size: 1.15rem;
        color: #f8f9fa;
        margin-bottom: 35px;
        line-height: 1.6;
    }
    
    .btn-custom {
        padding: 12px 35px;
        font-size: 1.15rem;
        font-weight: 600;
        border-radius: 50px;
        transition: all 0.3s ease;
        background: linear-gradient(45deg, #0d6efd, #0dcaf0);
        border: none;
        color: white;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
    }
    
    .btn-custom:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(13, 110, 253, 0.5);
        color: white;
    }
</style>

<div class="hero-section">
    <div class="container d-flex justify-content-center">
        <div class="hero-content">
            <h1>Point of Sale System</h1>
            <p>Streamline your business operations with our modern, efficient, and easy-to-use Point of Sale solution designed for seamless transactions.</p>
            <a href="login.php" class="btn btn-custom">
                Get Started <i class="fas fa-arrow-right ms-2"></i>
            </a>
        </div>
    </div>
</div>
    


<?php include ('includes/footer.php'); ?>