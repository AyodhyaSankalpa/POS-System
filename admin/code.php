<?php

include ('../config/function.php');

// save user
if(isset($_POST['saveUser'])){

    $name = validate($_POST['name']);
    $email = validate($_POST['email']);
    $phone = validate($_POST['phone']);
    $password = validate($_POST['password']);
    $is_ban = isset($_POST['is_ban']) ? 1 : 0;
    $created_by = $_SESSION['loggedInUser']['user_id'];

    if($name != '' && $email != '' && $phone != '' && $password != '')
    {   
        
        $emailCheck = mysqli_query($conn, "SELECT * FROM users WHERE email = '$email'");

        if($emailCheck){
            if(mysqli_num_rows($emailCheck) > 0){
                redirect('user-create.php', 'Email already exists', 'warning');
            }
        }

        $bcrypt_password = password_hash($password, PASSWORD_BCRYPT);

        $data = [
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'password' => $bcrypt_password,
            'is_ban' => $is_ban,
            'created_by' => $created_by,
        ];

        $result = insert('users', $data);

        if($result){
            redirect('users.php', 'User added successfully', 'success');
        }else{
            redirect('user-create.php', 'Failed to add user', 'danger');
        }
        
    } else {
        redirect('user-create.php', 'All fields are required', 'warning');
    }

}


// update user
if(isset($_POST['updateUser'])){
    $userId = validate($_POST['userId']);

    $userData = getByID('users', $userId);
    if($userData['status'] != 200){
        redirect('user-edit.php?id='.$userId, 'Please fill the required fields', 'warning');
    }

    $name = validate($_POST['name']);
    $email = validate($_POST['email']);
    $phone = validate($_POST['phone']);
    $password = validate($_POST['password']);
    $is_ban = isset($_POST['is_ban']) ? 1 : 0;
    $updated_by = $_SESSION['loggedInUser']['user_id'];
    $updated_at = date('Y-m-d H:i:s');

    $emailCheck = "SELECT * FROM users WHERE email = '$email' AND id != '$userId'";
    $chekResult = mysqli_query($conn, $emailCheck);
    if($chekResult){
        if(mysqli_num_rows($chekResult) > 0){
            redirect('user-edit.php?id='.$userId, 'Email already exists', 'warning');
        }
    }

    if($password != '')
    {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
    }else{
        $hashedPassword = $userData['data']['password'];
    }

    if($name != '' && $email != '' && $phone != '')
    {

        $data = [
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'password' => $hashedPassword,
            'is_ban' => $is_ban,
            'updated_by' => $updated_by,
            'updated_at' => $updated_at,
        ];

        $result = update('users', $userId, $data);

        if($result){
            redirect('user-edit.php?id='.$userId, 'User updated successfully', 'success');
        }else{
            redirect('user-edit.php?id='.$userId, 'Failed to update user', 'danger');
        }

    }else {
        redirect('user-create.php', 'All fields are required', 'warning');
    }

}

// save category
if(isset($_POST['saveCategory'])){

    $name = validate($_POST['name']);
    $description = validate($_POST['description']);
    $status = isset($_POST['status']) ? 1 : 0;
    $created_by = $_SESSION['loggedInUser']['user_id'];

    if($name != '' && $description != '')
    {
        $data = [
            'name' => $name,
            'description' => $description,
            'status' => $status,
            'created_by' => $created_by,
        ];

        $result = insert('categories', $data);

        if($result){
            redirect('categories.php', 'Category added successfully', 'success');
        }else{
            redirect('category-create.php', 'Failed to add category', 'danger');
        }
    }else {
        redirect('category-create.php', 'All fields are required', 'warning');
    }
}

// update category
if(isset($_POST['updateCategory'])){

    $categoryId = validate($_POST['categoryId']);

    // $categoryData = getByID('categories', $categoryId);
    // if($categoryData['status'] != 200){
    //     redirect('category-edit.php?id='.$categoryId, 'Please fill the required fields', 'warning');
    // }

    $name = validate($_POST['name']);
    $description = validate($_POST['description']);
    $status = isset($_POST['status']) ? 1 : 0;
    $updated_by = $_SESSION['loggedInUser']['user_id'];
    $updated_at = date('Y-m-d H:i:s');

    if($name != '' && $description != '')
    {
        $data = [
            'name' => $name,
            'description' => $description,
            'status' => $status,
            'updated_by' => $updated_by,
            'updated_at' => $updated_at,
        ];

        $result = update('categories', $categoryId, $data);

        if($result){
            redirect('category-edit.php?id='.$categoryId, 'Category updated successfully', 'success');
        }else{
            redirect('category-edit.php?id='.$categoryId, 'Failed to update category', 'danger');
        }
    }else {
        redirect('category-create.php', 'All fields are required', 'warning');
    }
}

// save product
if(isset($_POST['saveProduct'])){

    $categoryId = validate($_POST['category_id']);
    $name = validate($_POST['name']);
    $description = validate($_POST['description']);
    $price = validate($_POST['price']);
    $quantity = validate($_POST['quantity']);
    $status = isset($_POST['status']) ? 1 : 0;
    $created_by = $_SESSION['loggedInUser']['user_id'];

    if($_FILES['image']['size'] > 0){

        $path = "../assets/uploads/products";
        $image_ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $filename = time().'.'.$image_ext;

        // RESIZE IMAGE HERE
        list($width, $height) = getimagesize($_FILES['image']['tmp_name']);

        $new_width = 600;
        $new_height = 600;

        $src = imagecreatefromstring(file_get_contents($_FILES['image']['tmp_name']));
        $tmp = imagecreatetruecolor($new_width, $new_height);

        imagecopyresampled($tmp, $src, 0, 0, 0, 0, $new_width, $new_height, $width, $height);

        imagejpeg($tmp, $path."/".$filename, 80);

        $finalImage = "assets/uploads/products/".$filename;
    }
    else
    {
        $finalImage = '';
    }


    if($name != '' && $description != '' && $price != '' && $quantity != '')
    {
        $data = [
            'category_id' => $categoryId,
            'name' => $name,
            'description' => $description,
            'price' => $price,
            'quantity' => $quantity,
            'status' => $status,
            'image' => $finalImage,
            'created_by' => $created_by,
        ];

        $result = insert('products', $data);

        if($result){
            redirect('products.php', 'Product added successfully', 'success');
        }else{
            redirect('product-create.php', 'Failed to add product', 'danger');
        }
    }else {
        redirect('product-create.php', 'All fields are required', 'warning');
    }

}

// update product
if(isset($_POST['updateProduct'])){

    $product_id = validate($_POST['product_id']);

    $productData = getById('products',$product_id);
    if(!$productData){
        redirect('products.php', 'Product not found', 'danger');
    }
 
    $categoryId = validate($_POST['category_id']);
    $name = validate($_POST['name']);
    $description = validate($_POST['description']);
    $price = validate($_POST['price']);
    $quantity = validate($_POST['quantity']);
    $status = isset($_POST['status']) ? 1 : 0;
    $updated_by = $_SESSION['loggedInUser']['user_id'];

    if($_FILES['image']['size'] > 0){

        $path = "../assets/uploads/products";
        $image_ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $filename = time().'.'.$image_ext;

        // RESIZE IMAGE HERE
        list($width, $height) = getimagesize($_FILES['image']['tmp_name']);

        $new_width = 600;
        $new_height = 600;

        $src = imagecreatefromstring(file_get_contents($_FILES['image']['tmp_name']));
        $tmp = imagecreatetruecolor($new_width, $new_height);

        imagecopyresampled($tmp, $src, 0, 0, 0, 0, $new_width, $new_height, $width, $height);

        imagejpeg($tmp, $path."/".$filename, 80);

        $finalImage = "assets/uploads/products/".$filename;

        $deleteImage = "../".$productData['data']['image'];
        if(file_exists($deleteImage)){
            unlink($deleteImage);
        }
    }
    else
    {
        $finalImage = $productData['data']['image'];
    }

    if($name != '' && $description != '' && $price != '' && $quantity != '')
    {
        $data = [
            'category_id' => $categoryId,
            'name' => $name,
            'description' => $description,
            'price' => $price,
            'quantity' => $quantity,
            'status' => $status,
            'image' => $finalImage,
            'updated_by' => $updated_by,
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        $result = update('products', $product_id, $data);

        if($result){
            redirect('product-edit.php?id='.$product_id, 'Product updated successfully', 'success');
        }else{
            redirect('product-edit.php?id='.$product_id, 'Failed to update product', 'danger');
        }
    }

}

// save customer
if(isset($_POST['saveCustomer'])){

    $name = validate($_POST['name']);
    $email = validate($_POST['email']);
    $phone = validate($_POST['phone']);
    $status = isset($_POST['status']) ? 1 : 0;
    $created_by = $_SESSION['loggedInUser']['user_id'];

    if($name != '' && $email != '' && $phone != '')
    {
        $emailCheck = mysqli_query($conn, "SELECT * FROM customers WHERE email = '$email'");
        if(mysqli_num_rows($emailCheck) > 0){
            redirect('customer-create.php', 'Email already exists', 'danger');
        }

        $phoneCheck = mysqli_query($conn, "SELECT * FROM customers WHERE phone = '$phone'");
        if(mysqli_num_rows($phoneCheck) > 0){
            redirect('customer-create.php', 'Phone number already exists', 'danger');
        }

        $data = [
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'status' => $status,
            'created_by' => $created_by,
        ];

        $result = insert('customers', $data);

        if($result){
            redirect('customers.php', 'Customer added successfully', 'success');
        }else{
            redirect('customer-create.php', 'Failed to add customer', 'danger');
        }
    }else {
        redirect('customer-create.php', 'All fields are required', 'warning');
    }
}

// update customer
if(isset($_POST['updateCustomer'])){

    $customerId = validate($_POST['customerId']);
    $name = validate($_POST['name']);
    $email = validate($_POST['email']);
    $phone = validate($_POST['phone']);
    $status = isset($_POST['status']) ? 1 : 0;
    $updated_by = $_SESSION['loggedInUser']['user_id'];

    if($name != '' && $email != '' && $phone != '')
    {
        $emailCheck = mysqli_query($conn, "SELECT * FROM customers WHERE email = '$email' AND id != '$customerId'");
        if(mysqli_num_rows($emailCheck) > 0){
            redirect('customer-edit.php?id='.$customerId, 'Email already exists', 'danger');
        }

        $phoneCheck = mysqli_query($conn, "SELECT * FROM customers WHERE phone = '$phone' AND id != '$customerId'");
        if(mysqli_num_rows($phoneCheck) > 0){
            redirect('customer-edit.php?id='.$customerId, 'Phone number already exists', 'danger');
        }

        $data = [
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'status' => $status,
            'updated_by' => $updated_by,
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        $result = update('customers', $customerId, $data);

        if($result){
            redirect('customer-edit.php?id='.$customerId, 'Customer updated successfully', 'success');
        }else{
            redirect('customer-edit.php?id='.$customerId, 'Failed to update customer', 'danger');
        }
    }else {
        redirect('customer-edit.php?id='.$customerId, 'All fields are required', 'warning');
    }
}