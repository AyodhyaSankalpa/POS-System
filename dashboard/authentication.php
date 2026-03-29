<?php

if(isset($_SESSION['loggedIn']))
{
    $email = validate($_SESSION['loggedInUser']['email']);

    $query = "SELECT * FROM users WHERE email='$email' LIMIT 1";
    $result = mysqli_query($conn, $query);

    if(mysqli_num_rows($result) == 0)
    {
        logoutSession();
        redirect('../login.php','Access Denied','danger');
    }
    else
    {
        $row = mysqli_fetch_assoc($result);

        // check banned
        if($row['is_ban'] == 1)
        {
            logoutSession();
            redirect('../login.php','Your Account has been banned. Contact your Admin.','danger');
        }

        // ADMIN ACCESS CHECK
        if($row['is_admin'] != 0)
        {
            redirect('../index.php','You are not authorized to access Dashboard','danger');
        }
    }
}
else
{
    redirect('../login.php','You are not logged in','danger');
}

?>