<?php include('../config/constants.php'); ?>


<html>
    <head>
        <title>Login - Food Order System</title>
        <link rel="stylesheet" href="../css/admin.css">
    </head>

    <body>
        
        <div class="login">
            <h1 class="text-center">Login</h1>
            <br><br>

            <?php  
                if(isset($_SESSION['login']))
                {
                    echo $_SESSION['login'];
                    unset($_SESSION['login']);
                }

                if(isset($_SESSION['login']))
                {
                    echo $_SESSION['no-login-message'];
                    unset($_SESSION['no-login-message']);
                } 

            ?>
            <br><br>

            <!-- Login Form Starts Here -->
            <form action=""method="POST" class="text-center">
                Username: <br>
                <input type="text" name="username" placeholder="Enter Username"> <br><br>

                Password: <br>
                <input type="password" name="password" placeholder="Enter Password"> <br><br>
               
                <input type="submit" name="submit" value="Login" class="btn-primary">
                <br><br>
        </form>
        <!-- Login Form Ends Here -->

            <p class="text-center">Create By - <a href="www.aryanraj.com">Aryan Raj</a></p>
        </div>

    </body>
</html>

<?php  

    //Check whether the submit button is clicked or not
    if(isset($_POST['submit']))
    {
        //Process for Login
        //1. Get the Data from Login Form
        $username = $_POST['username'];
        $password = md5($_POST['password']);

        //2. SQL to check whether the user with username and password exists or not
        $sql = "SELECT * FROM tbl_admin WHERE username='$username' AND password='$password'";

        //Execute the Query
        $res = mysqli_query($conn, $sql);

        //4. Count rows to check whether the user exists or not
        $count = mysqli_num_rows($res);

        if($count==1)
        {
            //User Available and Login Success
            $_SESSION['login'] = "<div class='success'>Login Successfully.</div>";
            $_SESSION['user'] = $username; //To check whether the user is logged in or not and logout will unset it
            //Redirect to Home Page/Dashboard
            //header('location:'.SITEURL.'admin/');
            header('Location:'.SITEURL.'admin/');
        }
        else
        {
            //User not available and Login failed
            $_SESSION['login'] = "<div class='error text-center'>Username or Password did not Match.</div>";
            //Redirect to Home Page/Dashboard
            //header('location:'.SITEURL.'admin/login.php');
            header('Location:'.SITEURL.'admin/login.php');
        }


    }

?>