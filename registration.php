<?php
    session_start();
    $GLOBALS['alert_msg'] = null;
    $GLOBALS['error_msg_status'] = null;
?>

<?php
    
    if (isset($_POST['submit'])) {

        require_once('./includes/database_connection.php');

        $blank_error_array = array();
        
        $emp_name = htmlspecialchars($_POST['fullname']);
        $emp_email = htmlentities($_POST['emp_email']);
        $emp_mobile = htmlentities($_POST['emp_mobile']);
        $emp_dob = date('Y-m-d', strtotime(htmlentities($_POST['emp_dob'])));
        
        // Checking validation if any not-null field contain any empty/blank/null value
        if($emp_name === '' || $emp_name === null){
            $blank_error_array["nameerror"] = "Blank Name";
            $GLOBALS['error_msg_status'] = 1;
        }
        if($emp_email === '' || $emp_email === null){
            $blank_error_array["emailerror"] = "Blank Email";
            $GLOBALS['error_msg_status'] = 1;
        }
        if($emp_mobile === '' || $emp_mobile === null){
            $blank_error_array["mobileerror"] = "Blank Mobile No";
            $GLOBALS['error_msg_status'] = 1;
        }
        if($_POST['emp_dob'] === '' || $_POST['emp_dob'] === null){
            $blank_error_array["doberror"] = "Blank DOB";
            $GLOBALS['error_msg_status'] = 1;
        }
        //  If any not-null field is empty/blank/null then store into the $blank_error_array

        $emp_salary = intval(htmlspecialchars($_POST['emp_salary']));
        $emp_skill = htmlentities($_POST['emp_skill']);
        $emp_details = htmlentities($_POST['emp_details']);

        $created_at = date('Y-m-d H:i:s');
        $updated_at = $created_at;
        $status = true;

        $emp_type_id = 2;
        $emp_department = intval($_POST['emp_department']);
        $emp_position = intval($_POST['emp_position']);

        // Uploading File
        // If file not empty i.e. user select a picture
        if(isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK && $GLOBALS['error_msg_status'] === null){
            $target_dir = "./uploads/";
            $target_file = $target_dir . date('Y_m_d_H_i_s') . "_" . basename($_FILES['profile_picture']['name']);

            $fileExtension = pathinfo($target_file, PATHINFO_EXTENSION);

            if ($fileExtension != "jpg" && $fileExtension != "png" && $fileExtension != "jpeg" && $fileExtension != "gif") {
                $GLOBALS['alert_msg'] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                $GLOBALS['error_msg_status'] = 1;
                // exit;
            }

            if (move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $target_file)) {
                $GLOBALS['alert_msg'] = "The file has been uploaded.";
            } else {
                $GLOBALS['alert_msg'] = "Sorry, there was an error uploading your file.";
                $GLOBALS['error_msg_status'] = 1;
                // exit;
            }

            $query = "INSERT INTO employees(employee_name, user_type_id, department_id, position_id, employee_email, employee_phone, salary, employee_details, employee_skils, dob, created_at, updated_at, status, profile_image) VALUES ('$emp_name', '$emp_type_id', '$emp_department', '$emp_position', '$emp_email', '$emp_mobile', '$emp_salary', '$emp_details', '$emp_skill', '$emp_dob', '$created_at', '$updated_at', '$status', '$target_file')";

            // Handling error
            if($GLOBALS['error_msg_status'] === null){
                try {
                    $result = @pg_query($conn, $query);
                    if($result){
                        $GLOBALS['alert_msg'] = "Data inserted successfully";
                    }
                    else{
                        throw new Exception(pg_last_error($conn));
                    }
                } 
                catch(Exception $e){
                    $GLOBALS['alert_msg'] = "An error occurred " . $e->getMessage();
                    $GLOBALS['error_msg_status'] = 1;
                }
            }
        }
        // If file empty i.e. user does not select a picture
        else{
            $query = "INSERT INTO employees(employee_name, user_type_id, department_id, position_id, employee_email, employee_phone, salary, employee_details, employee_skils, dob, created_at, updated_at, status) VALUES ('$emp_name', '$emp_type_id', '$emp_department', '$emp_position', '$emp_email', '$emp_mobile', '$emp_salary', '$emp_details', '$emp_skill', '$emp_dob', '$created_at', '$updated_at', '$status')";
            //exit;

            // Handling error
            if($GLOBALS['error_msg_status'] === null){
                try {
                    $result = @pg_query($conn, $query);
                    if($result){
                        $GLOBALS['alert_msg'] = "Data inserted successfully";
                    }
                    else{
                        throw new Exception(pg_last_error($conn));
                    }
                } 
                catch(Exception $e){
                    $GLOBALS['alert_msg'] = "An error occurred " . $e->getMessage();
                    $GLOBALS['error_msg_status'] = 1;
                }
            }
        }

        pg_close($conn);
    } 
    else {
        $GLOBALS['alert_msg'] = "Form not submitted";
    }
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <link rel="stylesheet" href="./css/bootstrap.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap');
    </style>
    <link rel="stylesheet" href="./css/registration.css">
</head>

<body>
    <?php if((!isset($_POST['submit']))): ?>
        <div class="container-fluid d-flex justify-content-center align-items-center">
            <div class="container p-5 form-container d-flex flex-column justify-content-center align-items-center my-5" style="height: max-content;">
                <h2 class="text-center mb-5">Employee Registration</h2>
                <div class="container mt-5 w-100">
                    <form class="row needs-validation" action="" method="post" enctype="multipart/form-data" novalidate>
                        <div class="mb-3 col-6">
                            <label for="fullname" class="form-label">Full Name</label>
                            <input type="text" class="form-control p-3" id="fullname" name="fullname" required>
                        </div>
                        <div class="mb-3 col-6">
                            <label for="emp_mail" class="form-label">Email address</label>
                            <input type="text" class="form-control p-3" id="emp_mail" name="emp_email" aria-describedby="emailHelp" required>
                        </div>
                        <div class="mb-3 col-6">
                            <label for="emp_mobile" class="form-label">Mobile</label>
                            <input type="tel" class="form-control p-3" id="emp_mobile" name="emp_mobile" required>
                        </div>
                        <div class="mb-3 col-6">
                            <label for="emp_dob" class="form-label">DOB</label>
                            <input type="date" class="form-control p-3" id="emp_dob" name="emp_dob" required>
                        </div>
                        <div class="mb-3 col-6">
                            <label for="emp_salary" class="form-label">Salary</label>
                            <input type="text" class="form-control p-3" id="emp_salary" name="emp_salary" required>
                        </div>
                        <div class="mb-3 col-6">
                        <label for="emp_skill" class="form-label">Skill</label>
                            <select class="form-select p-3" id="emp_skill" name="emp_skill" aria-label="Default select example">
                                <option selected>Select Your Skill</option>
                                <option value="frontend">Frontend Developer</option>
                                <option value="backend">Backend Developer</option>
                                <option value="fullstack">Fullstack Developer</option>
                            </select>
                        </div>
                        <div class="mb-3 col-6">
                        <label for="emp_department" class="form-label">Department</label>
                            <select class="form-select p-3" id="emp_department" name="emp_department" aria-label="Default select example">
                                <option selected>Your Department</option>
                                <option value="1">Technical Services</option>
                                <option value="2">Finance</option>
                                <option value="3">Accounting</option>
                                <option value="4">Sales</option>
                                <option value="5">Human Resources(HR)</option>
                            </select>
                        </div>
                        <div class="mb-3 col-6">
                        <label for="emp_position" class="form-label">Position</label>
                            <select class="form-select p-3" id="emp_position" name="emp_position" aria-label="Default select example">
                                <option selected>Your Position</option>
                                <option value="1">Manager</option>
                                <option value="2">Senior Developer</option>
                                <option value="3">Junior Developer</option>
                                <option value="4">Sales Man</option>
                            </select>
                        </div>
                        <div class="mb-3 col-6">
                            <label for="profile_picture" class="form-label">Upload Profile Picture</label>
                            <input type="file" class="form-control p-3" id="profile_picture" name="profile_picture">
                        </div>
                        <div class="mb-3 form-floating">
                            <textarea class="form-control" id="emp_details" name="emp_details" placeholder="Describe yourself"></textarea>
                            <label for="emp_details">Describe yourself</label>
                        </div>
                        <div class="mb-3 col-6">
                            <button type="submit" class="btn btn-primary mb-2" name="submit">Submit</button>
                        </div>  
                    </form>
                </div>
            </div>
        </div>
    <?php endif ?>



    <?php if (isset($_POST['submit']) && $GLOBALS['error_msg_status'] === null): ?>
        <div class="container d-flex justify-content-center align-items-center" style="height: 100vh;">
            <div class="alert alert-success alert-dismissible fade show d-flex flex-column justify-content-center align-items-center my-5 alert-box" role="alert">
                <strong class="fs-2"><?php echo $GLOBALS['alert_msg'] ?></strong>
                <img src="./images/success_img.png" alt="Image not found" height="300" width="300">
            </div>
        </div>
    <?php elseif(isset($_POST['submit']) && $GLOBALS['error_msg_status'] !== null): ?>
        <div class="container d-flex justify-content-center align-items-center" style="height: 100vh;">
            <div class="alert alert-danger d-flex flex-column justify-content-center align-items-center alert-box" role="alert">
                <strong class="fs-2"><?php echo $GLOBALS['alert_msg'] ?></strong>
                <img src="./images/error_msg.jpg" alt="Image not found" height="150" width="150" class="mb-3">
                <?php if(!empty($blank_error_array)): ?>
                    <div class="container error-msg-box">
                        <?php foreach($blank_error_array as $error_msg): ?>
                            <p><?php echo $error_msg ?></p>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>

    <script src="./js/bootstrap.bundle.min.js"></script>
    <script src="./js/jquery.js"></script>
    <script src="./js/index.js"></script>
    
</body>
</html>