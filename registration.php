<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <link rel="stylesheet" href="./css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/registration.css">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap');
    </style>
</head>

<body>
    <div class="container-fluid d-flex justify-content-center align-items-center" style="height: 100%;">
        <div class="container p-5 form-container" style="height: max-content;">
            <h2 class="text-center mb-5">Signup</h2>
            <form class="row needs-validation" action="./registration_backend.php" method="post" novalidate>
                <div class="mb-3 col-6">
                    <label for="fullname" class="form-label">Full Name</label>
                    <input type="text" class="form-control p-3" id="fullname" name="fullname" required>
                </div>
                <!-- <div class="mb-3 col-6">
                    <label for="emp_id" class="form-label">Employee ID</label>
                    <input type="text" class="form-control p-3" id="emp_id" required>
                </div> -->
                <div class="mb-3 col-6">
                    <label for="emp_mail" class="form-label">Email address</label>
                    <input type="text" class="form-control p-3" id="emp_mail" name="emp_email" aria-describedby="emailHelp" required>
                </div>
                <div class="mb-3 col-6">
                    <label for="emp_pass" class="form-label">Password</label>
                    <input type="password" class="form-control p-3" id="emp_pass" name="emp_password" required>
                </div>
                <div class="mb-3 col-6">
                    <label for="emp_mob" class="form-label">Mobile</label>
                    <input type="tel" class="form-control p-3" id="emp_mob" name="emp_mobile" required>
                </div>
                <div class="mb-3 col-6">
                    <label for="emp_dob" class="form-label">DOB</label>
                    <input type="date" class="form-control p-3" id="emp_dob" name="emp_dob" required>
                </div>
                <div class="mb-3 col-6">
                    <select class="form-select p-3" name="emp_skill" aria-label="Default select example">
                        <option selected>Select Your Skill</option>
                        <option value="frontend">Frontend Developer</option>
                        <option value="backend">Backend Developer</option>
                        <option value="fullstack">Fullstack Developer</option>
                    </select>
                </div>
                <div class="mb-3 form-floating">
                    <textarea class="form-control" id="emp_details" name="emp_details" placeholder="Describe yourself"></textarea>
                    <label for="emp_details">Describe yourself</label>
                </div>
                <div class="mb-3 col-6">
                    <button type="submit" class="btn btn-primary mb-2">Submit</button>
                </div>
                
            </form>
        </div>
    </div>

    <script src="./js/bootstrap.bundle.min.js"></script>
    <script src="./js/jquery.js"></script>
    <script src="./js/index.js"></script>

    <script>
        check_validation();
    </script>
</body>

</html>