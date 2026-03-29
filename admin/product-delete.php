<?php

require '../config/function.php';

// delete category
if(isset($_GET['id'])){

    $product_id = validate($_GET['id']);
    $product = getByID('products', $product_id);

    if($product['status'] != 200){
        redirect('products.php', 'Product not found', 'warning');
    }

    $productData = $product['data'];

    // logged user id
    $deleted_by = $_SESSION['loggedInUser']['user_id'];

   
    $deleted_at = date('Y-m-d H:i:s');

    // insert into history table
    $categoryId = $productData['category_id'];
    $name = $productData['name'];
    $description = $productData['description'];

    $historyQuery = "INSERT INTO products_history 
                     (product_id,category_id, name, description, deleted_by, deleted_at)
                     VALUES 
                     ('$product_id','$categoryId','$name','$description','$deleted_by','$deleted_at')";

    mysqli_query($conn, $historyQuery);

    // delete original record
    $result = delete('products', $product_id);
    if($result){
        if(file_exists('../'.$productData['image'])){
            unlink('../'.$productData['image']);
        }

        redirect('products.php', 'Product deleted successfully', 'success');
    }else{
        redirect('products.php', 'Failed to delete product', 'danger');
    }
}

?>