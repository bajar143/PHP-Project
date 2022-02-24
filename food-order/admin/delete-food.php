<?php
    //Include Constans Page
    include('../config/constants.php');

    //echo "Delete Food Page"

    if(isset($_GET['id']) && isset($_GET['image_name'])) //Either use '&&' or 'AND'
    {
            //Process to Delete
            //echo "Prcoess to Delete";

            //1. Get ID and Image name
            $id = $_GET['id'];
            $image_name = $_GET['image_name'];
    
            //2. Remove the Image if avialable
            //Check whether the image is avialble or not and Delete only if available
           
            if($image_name != "")
            {
                //Image is Available. So remove it
                $path = "../images/food/".$image_name;
                //Remove the Image
                $remove = unlink($path);

                 //If failed to remove image then add an error message and stop the process
                if($remove==false)
                {
                    //failed to remove image
                    //Set the Session Message
                    $_SESSION['remove'] = "<div class='error'>Failed to Remove Image File</div>";
                    //Redirect to Manage Food Page
                    header('Location:'.SITEURL. 'admin/manage-food.php');
                    //Stop the Process
                    die();

                }
            }

            //3. Delete Food From Database
            //SQL Query to Delete Data from Database
            $sql = "DELETE FROM tbl_food WHERE id=$id";

            //Execute the Query
             $res = mysqli_query($conn, $sql);

                //Check whether the data is delete from database or not
                //4. Redirect to mange Food with Session Message
                if($res==true)
                {
                    //Set Success Message and Redirect 
                    $_SESSION['delete'] = "<div class='success'>Food Deleted Successfully.</div>";
                    //Redirect to Manage Food Page
                    header('Location:'.SITEURL. 'admin/manage-food.php');

                }
                else 
                {
                    //Set Fail to Delete food with Message and Redirect 
                    $_SESSION['delete'] = "<div class='error'>Failed to Deleted Food.</div>";
                    //Redirect to Manage Category Pae
                    header('Location:'.SITEURL. 'admin/manage-food.php');
                }

                

            }


    else
    {
            //Redirect to Manage Food Page
            //echo "Redirect";
            $_SESSION['delete']= "<div class'error'>Unauthorized Access.</div>";
            header('Location:'.SITEURL.'admin/manage-food.php');

    }
 
 
 
?>



<?php include('partials/footer.php'); ?>