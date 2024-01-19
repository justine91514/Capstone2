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

if (isset($_POST['updatecategorybtn'])) {
    $id = $_POST['edit_id'];
    $category = $_POST['edit_category'];

    $query = "UPDATE category_list SET category_name='$category' WHERE id='$id'";
    $query_run = mysqli_query($connection, $query);

    if ($query_run) 
    {
        $_SESSION['success'] = "Your data is updated";
        header('Location: add_category.php');
    } 
    else 
    {
        $_SESSION['status'] = "Your data is not Updated";
        header('Location: add_category.php');
    }
}

if (isset($_POST['updatetypebtn'])) {
    $id = $_POST['edit_id'];
    $category = $_POST['edit_type'];

    $query = "UPDATE product_type_list SET type_name='$category' WHERE id='$id'";
    $query_run = mysqli_query($connection, $query);

    if ($query_run) 
    {
        $_SESSION['success'] = "Your data is updated";
        header('Location: add_product_type.php');
    } 
    else 
    {
        $_SESSION['status'] = "Your data is not Updated";
        header('Location: add_product_type.php');
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



//this code is for add_category.php
if(isset($_POST['categorybtn']))
{
    $category_name = $_POST['category_name'];
   
    if($category_name)
    {
        $query = "INSERT INTO category_list (category_name) VALUES ('$category_name')";
        $query_run = mysqli_query($connection, $query);
    
        if($query_run)
        {
            $_SESSION['success'] = "Category Added";
            header('Location: add_category.php');
        }
        else
        {
            $_SESSION['status'] = "Category NOT Added";
            header('Location: add_category.php');
        }
    }
}
//this code is for product_type_list.php
if(isset($_POST['typebtn']))
{
    $type_name = $_POST['type_name'];
   
    if($type_name)
    {
        $query = "INSERT INTO product_type_list (type_name) VALUES ('$type_name')";
        $query_run = mysqli_query($connection, $query);
    
        if($query_run)
        {
            $_SESSION['success'] = "Product Type Added";
            header('Location: add_product_type.php');
        }
        else
        {
            $_SESSION['status'] = "Product Type NOT Added";
            header('Location: add_product_type.php');
        }
    }
}






if (isset($_POST['add_prod_btn'])) {
    $product_name = $_POST['prod_name'];
    $category_name = $_POST['categories']; // Corrected variable name
    $type = $_POST['type'];
    $measurement = $_POST['measurement'];
    $price = $_POST['price'];
    $prescription = $_POST['prescription'];

    // Check if $category_name is not empty
    if ($category_name) {
        // Corrected query and parameter binding
        $query = "INSERT INTO product_list (prod_name, category_name, type, measurement, price, prescription) VALUES ('$product_name', '$category_name', '$type', '$measurement', '$price', '$prescription')";
        $query_run = mysqli_query($connection, $query);

        if ($query_run)
        {
            $_SESSION['success'] = "Product Added"; // Updated success message
            header('Location: product.php'); // Updated redirection
        } 
        else 
        {
            $_SESSION['status'] = "Product NOT Added"; // Updated error message
            header('Location: product.php'); // Updated redirection
        }
    }
}






if(isset($_POST['logout_btn']))
{
    session_destroy();
    unset($_SESSION['username']);
}















?>
