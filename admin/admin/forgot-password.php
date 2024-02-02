<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Include your head content, such as meta tags and stylesheets -->
    <!-- ... -->
</head>

<body>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-auto mt-auto">
            <div class="login-container">
                <div class="card-body p-0">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="text-center">
                                <h1 class="h1 mb-4" style="color: black; font-weight: bold;">Forgot Password?</h1>
                                <p style="color: black;">Enter your email to receive a password reset link.</p>
                                <hr class="my-4">
                                <?php
                                if (isset($_SESSION['reset_status']) && $_SESSION['reset_status'] != '') {
                                    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                            ' . $_SESSION['reset_status'] . '
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>';
                                    unset($_SESSION['reset_status']);
                                }
                                ?>
                            </div>
                            <form class="user" action="reset-password.php" method="POST">
                                <div class="form-group custom-width">
                                    <div class="input-group">
                                        <input type="email" name="email" class="form-control" placeholder="Enter your email..." required>
                                    </div>
                                </div>
                                <button type="submit" name="reset_btn" class="btn btn-primary btn-user btn-block"> Reset Password</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Include your necessary scripts -->
<!-- ... -->

</body>

</html>
