<?php
include('security.php');

$connection = mysqli_connect("localhost", "root", "", "dbpharmacy");

if (isset($_POST['login_btn'])) {
    $email_login = $_POST['email'];
    $password_login = $_POST['password'];
    $usertype_login = $_POST['usertype']; // Corrected variable name

    $query = "SELECT * FROM register WHERE email='$email_login' AND password='$password_login' AND usertype='$usertype_login'";
    $query_run = mysqli_query($connection, $query);
    $usertypes = mysqli_fetch_array($query_run);

    if ($usertypes) {
        $_SESSION['username'] = $email_login;
        $_SESSION['user_type'] = $usertype_login; // Set the usertype in the session
    
        if ($usertype_login == "admin") {
            header('Location: index.php');
        } elseif ($usertype_login == "pharmacy_assistant") {
            header('Location: pos.php');
        }
    } else {
        $_SESSION['status'] = 'Email or password is invalid';
        header('Location: login.php');
    }
}
?>
