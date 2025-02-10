<?php
    session_start();
    $GLOBALS['input_field_error_satus'] = null; //  Blank/empty input field.
    $GLOBALS['database_error_status'] = null;   //  Duplicate entry/connection error etc.
    $GLOBALS['invalid_user_error_status'] = null;   //  Invalid user_id/password/user_type_id etc.
    $GLOBALS['alert_msg'] = null;
    $error_array = array();
?>

<?php
    if(isset($_POST['submit'])){
        require_once('./include/database_connection.php');

        $user_id = htmlspecialchars($_POST['user_id']);
        $user_pass = htmlspecialchars($_POST['user_pass']);
        $user_type_id = htmlspecialchars($_POST['user_type_id']);

        if($user_id === '' || $user_id === null){
            $error_array['blank_user_id'] = "Blank User_ID";
            $GLOBALS['alert_msg'] = "Blank User_ID";
        }
        if($user_pass === '' || $user_pass === null){
            $error_array['blank_user_pass'] = "Blank User Password";
            $GLOBALS['alert_msg'] = "Blank User Password";
        }
        if($user_type_id === '' || $user_type_id === null){
            $error_array['blank_user_type_id'] = "Blank user_type_id";
            $GLOBALS['alert_msg'] = "Blank User Type";
        }

        if(!empty($error_array)){
            // echo print_r($error_array);
            $GLOBALS['input_field_error_satus'] = 1;
        }

        if($GLOBALS['input_field_error_satus'] === null && $GLOBALS['database_error_status'] === null && $GLOBALS['invalid_user_error_status'] === null){
            $query = "SELECT user_id, user_type_id, username, user_password, full_name FROM users WHERE username = '$user_id'";

            $result = pg_query($conn, $query);

            if($result !== false){
                $data = pg_fetch_assoc($result);
                if($data){
                    if($data['user_password'] === $user_pass && $data['user_type_id'] === $user_type_id){
                        $_SESSION['user_id'] = $user_id;
                        $_SESSION['fullname'] = $data['full_name'];
                        $GLOBALS['alert_msg'] = "Successfully LoggedIn";
                    }
                    else{
                        $GLOBALS['invalid_user_error_status'] = 1;
                        $GLOBALS['alert_msg'] = "Invalid username or password or user type";
                    }
                }
                else{
                    $GLOBALS['alert_msg'] = "Username do not Match";
                }
            }
            else{
                $GLOBALS['invalid_user_error_status'] = 1;
                $GLOBALS['alert_msg'] = "User does not exist";
                $GLOBALS['alert_msg'] = "Query not Executed";
            }
        }
        
        pg_close($conn);
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="./css/bootstrap.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap');
    </style>
    <link rel="stylesheet" href="./css/index.css">
</head>

<body>
    <?php if(!isset($_POST['submit']) || $GLOBALS['input_field_error_satus'] !== null || $GLOBALS['database_error_status'] !== null || $GLOBALS['invalid_user_error_status'] !== null): ?>
        <div class="container d-flex justify-content-center align-items-center" style="height: 100vh;">
            <div class="container d-flex reg-box">
                <div class="container">
                    <div class="container fs-2 my-5 text-center">
                        Singin
                    </div>
                    <div class="container">
                        <form action="./login.php" method="post">
                            <div class="mb-3">
                                <label for="user_id" class="form-label px-3">User ID/Email</label>
                                <input type="email" class="form-control p-3" id="user_id" name="user_id" placeholder="User ID/Email">
                            </div>
                            <div class="mb-3">
                                <label for="user_pass" class="form-label px-3">Password</label>
                                <input type="password" class="form-control p-3" id="user_pass" name="user_pass" placeholder="Password">
                            </div>
                            <div class="mb-3">
                                <label for="user_type_id" class="form-label px-3">User Type</label>
                                <select class="form-select p-3" id="user_type_id" name="user_type_id" aria-label="Default select example">
                                    <option selected>Select User Type</option>
                                    <option value="1">Admin</option>
                                    <option value="2">User</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-success mb-3" name="submit">Submit</button>
                        </form>
                    </div>
                </div>
                <div class="container bg-success text-light d-flex flex-column justify-content-center align-items-center">
                    <h2 class="mb-5">Welcome</h2>
                    <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Sequi, possimus.</p>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <?php if(isset($_SESSION['user_id'])): ?>
        <div class="container d-flex justify-content-center align-items-center" style="height: 100vh;">
            <div class="alert alert-success alert-dismissible fade show d-flex flex-column justify-content-center align-items-center my-5 alert-box" role="alert">
                <strong class="fs-2"><?php echo $GLOBALS['alert_msg'] ?></strong>
                <img src="./images/success_img.png" alt="Image not found" height="300" width="300">
                <form action="./logout.php" method="post">
                    <button type="submit" class="btn btn-success mb-3 p-3" name="submit">Logout</button>
                </form>
            </div>
        </div>
    <?php endif; ?>

    <?php
        if($GLOBALS['input_field_error_satus'] !== null || $GLOBALS['database_error_status'] !== null || $GLOBALS['invalid_user_error_status'] !== null){
            print_r($GLOBALS['input_field_error_satus']);
            print_r($GLOBALS['database_error_status']);
            print_r($GLOBALS['invalid_user_error_status']);
            echo "<h1>".$GLOBALS['alert_msg']."</h1>";
        }
    ?>

    <script src="./js/bootstrap.bundle.min.js"></script>
</body>
</html>