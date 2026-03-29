<?php

require '../config/function.php';

// delete category
if(isset($_GET['id'])){

    $categoryId = validate($_GET['id']);
    $category = getByID('categories', $categoryId);

    if($category['status'] != 200){
        redirect('categories.php', 'Category not found', 'warning');
    }

    $categoryData = $category['data'];

    // logged user id
    $deleted_by = $_SESSION['loggedInUser']['user_id'];

   
    $deleted_at = date('Y-m-d H:i:s');

    // insert into history table
    $name = $categoryData['name'];
    $description = $categoryData['description'];

    $historyQuery = "INSERT INTO categories_history 
                     (category_id, name, description, deleted_by, deleted_at)
                     VALUES 
                     ('$categoryId','$name','$description','$deleted_by','$deleted_at')";

    mysqli_query($conn, $historyQuery);

    // delete original record
    $result = delete('categories', $categoryId);

    if($result){
        redirect('categories.php', 'Category deleted successfully', 'success');
    }else{
        redirect('categories.php', 'Failed to delete category', 'danger');
    }
}

?>