<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">  
        <h1>Add Category</h1>

        <br><br>

        <?php 
        
            if(isset($_SESSION['add']))
            {
                echo($_SESSION['add']);
                unset($_SESSION['add']);
            }

            if(isset($_SESSION['upload']))
            {
                echo($_SESSION['upload']);
                unset($_SESSION['upload']);
            }
            

        ?>
        <br><br>

        <!-- Add Category Form Stats -->
        <form action="" method="POST" enctype="multipart/form-data">

            <table class="tbl-30">
                <tr>
                    <td>Title: </td>
                    <td>
                        <input type="text" name="title" placeholder="Category">
                    </td>
                </tr>

                <tr>
                    <td>Select Image:</td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>
               
                <tr>
                    <td>Featured: </td>
                    <td>
                        <input type="radio" name="featured" value="Yes"> Yes
                        <input type="radio" name="featured" value="No"> No
                    </td>
                </tr>
              
                <tr>
                    <td>Active: </td>
                    <td>
                        <input type="radio" name="active" value="Yes"> Yes
                        <input type="radio" name="active" value="No"> No
                    </td>
                </tr>
              
                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Category" class="btn-secondary"> 
                    </td>
                    
                </tr>
                
                
               
            </table>

        </form>
        <!-- Add Catrgory Form Ends -->

        <?php  
        
            //Check whether the Submit Button is Clicked or not
            if(isset($_POST['submit']))
            {
                //echo "Clicked";

                //1. Get the Value from Category Form
                $title = $_POST['title'];

                //For Radio input, we need to check whether the button is select or not
                if(isset($_POST['featured']))
                {
                    //Get the Value from Form
                    $featured = $_POST['featured'];

                }
                else
                {
                    //Set the Defualt Value
                    $featured = "No";
                }

                if(isset($_POST['active']))
                {
                    $active = $_POST['active'];
                }
                else 
                {
                    $active = "No";
                }

                //Check whether the image is select or not ad set the value for image name a/c
                //print_r($_FILES['image']);

                //die(); // Break the Code Here

                if (isset($_FILES['image']['name']))
                {
                    //Upload the image
                    //To upload the image we need image name, source path, destination path
                    $image_name = $_FILES['image']['name'];

                    //Upload the Image only if image is selected
                    if($image_name != "")
                    {  
                    
                        
                        //Auto Rename our Image
                        //Get the Extension of our image(jpg,png,gif,etc) eg. "specialfood1.jpg"
                        $ext = end(explode('.', $image_name));

                        //Rename the Image
                        $image_name = "Food_Category_".rand(000, 999).'.'.$ext; // e.g Food_Category_834.jpg
                        

                        $source_path = $_FILES['image']['tmp_name'];

                        $destination_path = "../images/category/".$image_name;

                        //Finally upload the Image
                        $upload = move_uploaded_file($source_path, $destination_path);

                        // Check whether the image is uploaded or not
                        //And if the image is not uploaded then we will stop the process and redirect with error messaage
                        if($upload==false)
                        {
                            //Set image
                            $_SESSION['upload'] = "<div class='error'>Failed to Upload Image.";
                            //Redirect to Add Category Page
                            header('Location:'.SITEURL.'admin/add-category.php');
                            //Stop the Process
                            die();
                        }
                    }

                }
                else
                {
                    //Dont't Upload Image and set the image_name Variable
                    $image_name="";

                }

                //2. Create SQL Query to Insert Category into Database
                $sql = "INSERT INTO tbl_category SET
                    title='$title',
                    image_name='$image_name',
                    featured='$featured',
                    active='$active'
                ";

                //3. Execute the Query and Save in Database
                $res = mysqli_query($conn, $sql); 

                //4. Check whether the query executed or not and data added or not
                if($res==true)
                {
                    //Query Executed and Category Added
                    $_SESSION['add']= "<div class='success'>Category Added Successfully.</div>";
                    //Redirect to Manage Category page
                    header('location:'.SITEURL.'admin/manage-category.php');
                }
                else
                {
                    //Failed to Add Category
                    $_SESSION['add']= "<div class'error'>Failed to Add Category.</div>";
                    //Redirect to Manage Category page
                    header('location:'.SITEURL.'admin/add-category.php');
                }
                

            }
        
        
        ?>

    </div>

</div>

<?php include('partials/footer.php'); ?>