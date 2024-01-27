<?php
$server_name = "localhost";
$db_username = "root";
$db_password = "";
$db_name = "dbpharmacy";

 $connection = mysqli_connect($server_name,$db_username,$db_password);
 $dbconfig = mysqli_select_db($connection,$db_name);

 if($dbconfig)
 {
    echo "database Connected";
 }
 else
 {
    echo "database Connection Failed/ tignan mo sa daatabase/dbconfig.php file";
 }


?>