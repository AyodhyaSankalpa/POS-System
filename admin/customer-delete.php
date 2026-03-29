<?php

require '../config/function.php';

// delete category
if(isset($_GET['id'])){

    $customerId = validate($_GET['id']);
    $customer = getByID('customers', $customerId);

    if($customer['status'] != 200){
        redirect('customers.php', 'Customer not found', 'warning');
    }

    $customerData = $customer['data'];

    // logged user id
    $deleted_by = $_SESSION['loggedInUser']['user_id'];

   
    $deleted_at = date('Y-m-d H:i:s');

    // insert into history table
    $name = $customerData['name'];
    $email = $customerData['email'];
    $phone = $customerData['phone'];

    $historyQuery = "INSERT INTO customers_history 
                     (customer_id, name, email, phone, deleted_by, deleted_at)
                     VALUES 
                     ('$customerId','$name','$email','$phone','$deleted_by','$deleted_at')";

    mysqli_query($conn, $historyQuery);

    // delete original record
    $result = delete('customers', $customerId);

    if($result){
        redirect('customers.php', 'Customer deleted successfully', 'success');
    }else{
        redirect('customers.php', 'Failed to delete customer', 'danger');
    }
}

?>