<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Login</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <style>
        body {
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
            overflow: hidden;
        }

        .login-container {
            background: #FFF;
            border-radius: 20px;
            box-shadow: 0px 4px 50px 0px rgba(0, 0, 0, 0.25);
            padding: 25px;
            max-width: 420px;
        }

        .brand-text {
            font-size: 2em;
        }

        .slogan-text {
            margin-top: 20px;
            color: #FFF;
            text-align: center;
            font-family: Tapestry;
            font-size: 35px;
            font-style: normal;
            font-weight: 400;
            line-height: 35px;
        }

        .btn-primary {
            width: 50%;
            border-radius: 15px;
            box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25);
            display: block;
            margin: 0 auto; /* Set left and right margin to auto */
        }
        /* Change button color */
        .btn-primary {
            background-color: #0C96D4; /* Change the color code to your desired color */
            border-color: #0C96D4; /* Change the border color if needed */
        }

        /* Change button color on hover */
        .btn-primary:hover {
            background-color: #D9D9D9; /* Change the hover color code */
            border-color: #D9D9D9; /* Change the hover border color if needed */
            color: #000000;
        }
    </style>

</head>


<?php
session_start();
?>

<div class="container">

<!-- Outer Row -->
<div class="row justify-content-center">

    <div class="col-xl-6 col-lg-6 col-md-6">

        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div class="row">
                    <!--this is the image code-->
               <!--     <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>      -->
                    <!--this is the image code-->
                    <div class="col-lg-12">
                        <div class="p-5">
                            <div class="text-center">
                            <img src="img/3GMED.png" alt="Logo" class="mb-4" style="width: 200px; height: auto;">
                                <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
                                <p style="color: black;">Input credentials to access your account</p>
                                <hr class="my-4">
                                <?php

                                if(isset($_SESSION['status']) && $_SESSION['status'] !='')
                                {
                                    echo '<h2 class="bg-danger text-white">'.$_SESSION['status'].'</h2>';
                                    unset($_SESSION['status']);
                                }
                                ?>


                            </div>

                            <form class="user" action="logincode.php" method="POST">
                                <div class="form-group">
                                    <input type="email" name="email" class="form-control form-control-user" placeholder="Enter Email Address..." required>
                                </div>
                                <div class="form-group">
                                    <div class="password-container">
                                        <input type="password" name="password" class="form-control form-control-user" id="exampleInputPassword" placeholder="Password" required>
                                        <span class="toggle-password" onclick="togglePasswordVisibility()"><i class="fas fa-eye"></i></span>
                                    </div>
                                </div>
                                <!-- Add the necessary Font Awesome CDN for the eye icon -->
                                <script src="https://kit.fontawesome.com/your-font-awesome-kit-id.js" crossorigin="anonymous"></script>
                                <script>
                                    function togglePasswordVisibility() {
                                        var passwordField = document.getElementById("exampleInputPassword");
                                        var eyeIcon = document.querySelector(".toggle-password i");

                                        if (passwordField.type === "password") {
                                            passwordField.type = "text";
                                            eyeIcon.classList.remove("fa-eye");
                                            eyeIcon.classList.add("fa-eye-slash");
                                        } else {
                                            passwordField.type = "password";
                                            eyeIcon.classList.remove("fa-eye-slash");
                                            eyeIcon.classList.add("fa-eye");
                                        }
                                    }
                                </script>
                                </div>
                                <div class="form-group">
                                    <select name="usertype" class="form-control form-control-user" placeholder="Select User" required>
                                        <option value="" disabled selected>Select User</option>
                                        <option value="admin">Admin</option>
                                        <option value="pharmacy_assistant">Pharmacy Assistant</option>
                                    </select>
                                </div>
                                

                                
                                <button type="submit" name="login_btn" class="btn btn-primary btn-user btn-block"> Login</button>
                                <hr>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>

</div>

<?php
include('includes/scripts.php');
?>
