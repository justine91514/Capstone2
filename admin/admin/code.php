<?php
include('security.php');

$connection = mysqli_connect("localhost", "root", "", "dbdaluyon");

if(isset($_POST['registerbtn']))
{
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $cpassword = $_POST['confirmpassword'];
    $usertype = $_POST['usertype'];

    if($password === $cpassword)
    {
        $query = "INSERT INTO register (username, email, password,usertype) VALUES ('$username', '$email', '$password','$usertype')";
        $query_run = mysqli_query($connection, $query);
    
        if($query_run)
        {
            $_SESSION['success'] = "Admin Profile Added";
            header('Location: register.php');
        }
        else
        {
            $_SESSION['status'] = "Admin Profile NOT Added";
            header('Location: register.php');
        }
    
    }
    else{
        $_SESSION['status'] = "Password and confirm password does not match";
        header('Location: register.php');
    }
}

if(isset($_POST['updatebtn']))
{
    $id = $_POST['edit_id'];
    $username = $_POST['edit_username'];
    $email = $_POST['edit_email'];
    $password = $_POST['edit_password'];
    $usertypeupdate= $_POST['update_usertype'];

    $query = "UPDATE register SET username='$username', email='$email', password='$password', usertype='$usertypeupdate' WHERE id='$id' ";
    $query_run = mysqli_query($connection, $query);
    if($query_run)
    {
        $_SESSION['success'] = "Your data is updated";
        header('Location: register.php');
    }
    else
    {
        $_SESSION['status'] = "Your data is not Updated";
        header('Location: register.php');
    }
}



if(isset($_POST['delete_btn']))
{
    $id = $_POST['delete_id'];

    $query = "DELETE FROM register WHERE id='$id'";
    $query_run = mysqli_query($connection, $query);

    if($query_run)
    {
        $_SESSION['success'] = "Your data is Deleted";
        header('Location: register.php');
    }
    else
    {
        $_SESSION['status'] = "Your data is Not Deleted";
        header('Location: register.php');
    }
}


//this code is for the login
if(isset($_POST['login_btn']))
{
    $email_login = $_POST['email'];
    $password_login = $_POST['password'];

    $query = "SELECT * FROM register WHERE email='$email_login' AND password='$password_login' ";
    $query_run = mysqli_query($connection, $query);

    if(mysqli_fetch_array($query_run))
    {
        $_SESSION['username'] = $email_login;
        header('Location: index.php');
    }
    else
    {
        $_SESSION['status'] = 'email id  /password  is invalid';
        header('Location: login.php');
    }
}


if(isset($_POST['logout_btn']))
{
    session_destroy();
    unset($_SESSION['username']);
}















?>
