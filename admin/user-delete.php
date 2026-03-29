<?php

require '../config/function.php';

$paramResult = checkParamId('id');

if(is_numeric($paramResult)){

    $userId = validate($paramResult);
    
    $user = getByID('users', $userId);

    if($user['status'] == 200)
    {
        
        $userDeleteRes = delete('users', $userId);

        if($userDeleteRes){
            redirect('users.php', 'User deleted successfully', 'success');
        }else{
            redirect('users.php', 'Something went wrong', 'danger');
        }
        
    }else{
        redirect('users.php', $user['message'], 'danger');
    }

}else{

    redirect('users.php', 'Something went wrong', 'danger');
}

?>