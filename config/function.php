<?php

session_start();

require 'dbcon.php';

// input validation
function validate($inputData){

    global $conn;

    $validatedData = mysqli_real_escape_string($conn, $inputData);

    return trim($validatedData);
    
}   

// redirect with message
function redirect($url, $status, $status_type = 'success'){

    $_SESSION['status'] = $status;
    $_SESSION['status_type'] = $status_type;
    header('Location: '.$url);
    exit(0);

}

//Display message
function alertMessage(){
    
    if(isset($_SESSION['status'])){
        $status = $_SESSION['status'];
        $status_type = isset($_SESSION['status_type']) ? $_SESSION['status_type'] : 'success';
        
        echo '<div class="alert alert-'.$status_type.' alert-dismissible fade show" role="alert">
                <h6>'.$status.'</h6>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>';
              
        unset($_SESSION['status']);
        unset($_SESSION['status_type']);
    }

}

// Insert record using this function
function insert($tableName, $data){

    global $conn;

    $table = validate($tableName);
    $columns = array_keys($data);
    $values = array_values($data);
    
    $finalColumns = implode(',', $columns);
    $finalValues = "'" .implode("', '", $values). "'";

    $query = "INSERT INTO $table ($finalColumns) VALUES ($finalValues)";

    $result = mysqli_query($conn, $query);

    return $result;

}

// Update record using this function
function update($tableName, $id, $data){

    global $conn;

    $table = validate($tableName);
    $id = validate($id);
    
    $updateDataString = "";

    foreach ($data as $column => $value) {

        $updateDataString .= $column.'='."'$value',";

    }

    $finalUpdateData = substr(trim($updateDataString), 0, -1);

    $query = "UPDATE $table SET $finalUpdateData WHERE id = '$id'";

    $result = mysqli_query($conn, $query);

    return $result;

}

// Get all data from a table
function getAll($tableName, $status = NULL){

    global $conn;

    $table = validate($tableName);
    $status = validate($status);

    if($status == 'status'){
        $query = "SELECT * FROM $table WHERE status = '10'";
    }else{
        $query = "SELECT * FROM $table";
    }

    return mysqli_query($conn, $query);

}

// Get single data from a table
function getByID($tableName, $id){

    global $conn;

    $table = validate($tableName);
    $id = validate($id);

    $query = "SELECT * FROM $table WHERE id = '$id' LIMIT 1";

    $result = mysqli_query($conn, $query);

    if($result){
        
        if(mysqli_num_rows($result) == 1){

            $row  = mysqli_fetch_assoc($result);
            $response = [
                'status' => 200,
                'data' => $row,
                'message' => 'Record found',
            ];
            return $response;
            
        }
        else{

            $response = [
                'status' => 404,
                'message' => 'No data found'
            ];
            return $response;

        }

    }else{
        $response = [
            'status' => 500,
            'message' => 'Something went wrong'
        ];
        return $response;
    }

}

// Delete record using this function
function delete($tableName, $id){

    global $conn;

    $table = validate($tableName);
    $id = validate($id);

    $query = "DELETE FROM $table WHERE id = '$id'";

    $result = mysqli_query($conn, $query);

    if($result){
        
        $response = [
            'status' => 200,
            'message' => 'Record deleted successfully'
        ];
        return $response;
        
    }else{
        $response = [
            'status' => 500,
            'message' => 'Something went wrong'
        ];
        return $response;
    }

}

//check parameter
function checkParamId($type){

    if(isset($_GET[$type]))
    {
        if($_GET[$type] != '')
        {
            return $_GET[$type];
        }
        else
        {
            echo '<h5>No ID Found</h5>';
        }
    }
    else
    {
        echo '<h5>No Id Given</h5>';
    }

}

//logout session
function logoutSession(){

    unset($_SESSION['loggedIn']);
    unset($_SESSION['loggedInUser']);
}


function jsonResponse($status, $status_type, $message){
    
    $response = [
        'status' => $status,
        'status_type' => $status_type,
        'message' => $message,
    ];
    echo json_encode($response);
    return;
}

// Count data from a table
function getCount($tableName){

    global $conn;

    $table = validate($tableName);

    $query = "SELECT * FROM $table";

    $result = mysqli_query($conn, $query);

    if($result){
        
        $totalCount = mysqli_num_rows($result);
        return $totalCount;
        
    }else{

        return 'Something went wrong';
    }

}
?>