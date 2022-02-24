<?php include('partials/menu.php')?>

<div class="main-content">
    <div class="wrapper">
    <h1>Change Password</h1>
    <br><br>

    <?php  
        if(isset($_GET['id']))
        {
            $id = $_GET['id'];
        }
    ?>

    <form action="" method="POST">

        <table class="tbl-30">
            <tr>
                <td>Current Password:</td>
                <td>
                    <input type="password" name="current_password" placeholder="Current Password">
                </td>
            </tr>

            <tr>
                <td>New Password:</td>
                <td>
                    <input type="password" name="new_password" placeholder="New Password">
                </td>
            </tr>

            <tr>
                <td>Confirm Password:</td>
                <td>
                    <input type="password" name="confirm_password" placeholder="Confirm Password">
                </td>
            </tr>
            
            <tr>
                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $id ?>">
                        <input type="submit" name="submit" value="Change Password" class="btn-secondary">
                    </td>
                </tr>
            </tr>

        </table>

    </form>

    </div>

</div>

<?php 

    //Check whether the Submit Button is Clicked or not
    if(isset($_POST['submit']))
    {
        //echo "Button Clicked";
        //1. Get the values from form
        $id = $_POST['id'];
        $current_password = md5($_POST['current_password']);
        $new_password = md5($_POST['new_password']);
        $confirm_password = md5($_POST['confirm_password']);

        //2. Check whether the user with current ID and Current Password Exists or Not
        $sql = "SELECT * FROM tbl_admin WHERE id=$id AND password = '$current_password'";

        //Execute the Query
        $res = mysqli_query($conn, $sql);

        if($res==TRUE)
        {
             //Check whether data is available or Not
             $count = mysqli_num_rows($res); //Function to get all the rows in datase

             
             if($count==1)
             {
                //User Exists and Password Can be Changed
                //echo "User Found";
                //Check whether the new password and confirm password match or not
                if($new_password==$confirm_password)
                {
                    //Update the Password
                    $sql2 = "UPDATE tbl_admin SET
                        password='$new_password'
                        WHERE id=$id
                    ";

                    //Execute the Query
                    $res2 = mysqli_query($conn, $sql2);

                    //Check whether the query executed or not
                    if($res2==true)
                    {
                        //Display Success Message
                        //Redirect to Manage Admin Page with Error Message
                        $_SESSION['change-pwd'] ="<div class='success'>Password Change Successfully. </div>";
                        //Redirect to User
                        header('Location:'.SITEURL.'admin/manage-admin.php');

                    }
                    else
                    {
                        //Display Error Message
                        //Redirect to Manage Admin Page with Error Message
                    $_SESSION['change-pwd'] ="<div class='error'>Failed to Change Password. </div>";
                    //Redirect to User
                    header('Location:'.SITEURL.'admin/manage-admin.php');
               
                    }

                }
                else
                {
                    //Redirect to Manage Admin Page with Error Message
                    $_SESSION['pwd-not-match'] ="<div class='error'>Password did not Match. </div>";
                    //Redirect to User
                    header('Location:'.SITEURL.'admin/manage-admin.php');
                }
             }
             else
             {
                 //User Does not Exist Set Message and Redirect
                 $_SESSION['user-not-found'] ="<div class='error'>User Not Found. </div>";
                 //Redirect to User
                 header('Location:'.SITEURL.'admin/manage-admin.php');
             }
        }
        //3. Check whether the New Password Confirm Passowrd Match or not
        //4, Change Password if all above is true 
        
    }

?>


<?php include('partials/footer.php')?>