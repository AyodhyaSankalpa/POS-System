<?php

require_once 'config/function.php';

if(isset($_POST['loginBtn']))
{
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    if($email != '' && $password != '')
    {
        $query = "SELECT * FROM users WHERE email = '$email' LIMIT 1";
        $result = mysqli_query($conn, $query);
        
        if($result)
        {
            if(mysqli_num_rows($result) == 1){

                $row = mysqli_fetch_assoc($result);
                $hashedPassword = $row['password'];

                if(!password_verify($password,$hashedPassword)){

                    redirect('login.php','Invalid Email or Password','danger');
                }

                if($row['is_ban'] == 1){
                    redirect('login.php','Your Account has been banned. Contact your Admin.','danger');
                }

                $_SESSION['loggedIn'] = true;
                $_SESSION['loggedInUser'] = [
                    'user_id' => $row['id'],
                    'name' => $row['name'],
                    'email' => $row['email'],
                    'phone' => $row['phone'],
                    'is_admin' => $row['is_admin']
                ];

                // ROLE BASED REDIRECT
                if($row['is_admin'] == '1'){
                    redirect('admin/index.php','Logged In Successfully');
                }else{
                    redirect('dashboard/index.php','Logged In Successfully');
                }

            }else {
                redirect('login.php','Invalid Email or Password','danger');
            }
        }
        else
        {
            redirect('login.php', 'Something went wrong','warning');
        }
    }
    else
    {
        redirect('login.php', 'All fields are required','danger');
    }
}

?>