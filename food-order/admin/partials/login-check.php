<?php 

    //Authorization -Access Control
    //Check whether the user is logged in or not
    if(!isset($_SESSION['user']))  //If user session in not set
    {
        //User is not logged in
        //Redirect to login page with meesage
        $_SESSION['no-login-message'] = "<div class='error text-center'>Please login to access Admin panel. </div>";
        //Redirect to login page
        header('Location:'.SITEURL.'admin/login.php');
    }
    else 
    {

    }


?>