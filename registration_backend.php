<?php
    require_once('./database_connection.php');

    $emp_name = htmlspecialchars($_POST['fullname']);
    $emp_email = htmlentities($_POST['emp_email']);
    $emp_password = htmlentities($_POST['emp_password']);
    $emp_mobile = htmlentities($_POST['emp_mobile']);
    $emp_dob = date('Y-m-d',strtotime(htmlentities($_POST['emp_dob'])));
    $emp_skill = htmlentities($_POST['emp_skill']);
    $emp_details = htmlentities($_POST['emp_details']);

    $query = "INSERT INTO employees(employee_name, employee_email, employee_phone, employee_details, employee_skils, dob) VALUES ('$emp_name', '$emp_email', '$emp_mobile', '$emp_details', '$emp_skill', '$emp_dob')" ;
    //exit;


    $result = pg_query($conn, $query);
    if($result){
        echo "Data inserted successfully";
    }
    else{
        echo "An error occur";
    }

    pg_close($conn);
?>