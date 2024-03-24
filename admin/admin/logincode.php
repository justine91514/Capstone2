<?php
include('security.php');

$connection = mysqli_connect("localhost", "root", "", "dbpharmacy");

if (isset($_POST['login_btn'])) {
    $email_login = $_POST['email'];
    $password_login = $_POST['password'];

    $query = "SELECT * FROM register WHERE email='$email_login' AND password='$password_login'";
    $query_run = mysqli_query($connection, $query);
    $user = mysqli_fetch_array($query_run);

    if ($user) {
        $_SESSION['username'] = $email_login;
        $_SESSION['usertype'] = $user['usertype']; // Set the usertype in the session
    
        if ($user['usertype'] == "admin") {
            header('Location: index.php');
        } elseif ($user['usertype'] == "pharmacy_assistant") {
            header('Location: pos.php');
        }
    } else {
        $_SESSION['status'] = 'Email or password is invalid';
        header('Location: login.php');
    }
}
?>
