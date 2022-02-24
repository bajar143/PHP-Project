<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Food</h1>

        <br /><br />

        <?php 
            if(isset($_SESSION['upload']))
            {
                echo $_SESSION['upload'];
                unset($_SESSION['upload']);
            }
        ?>


        <form action="" method="POST" enctype="multipart/form-data">
            <table class="tbl-30">
                    <tr>
                        <td>Title: </td>
                        <td>
                            <input type="text" name="title" placeholder="Title of the Food">
                        </td>
                    </tr>

                    <tr>
                        <td>Description: </td>
                        <td>
                            <textarea name="description" cols="30" rows="5" placeholder="Description of the Food"></textarea>
                        </td>
                    </tr>

                    <tr>
                        <td>Price: </td>
                        <td>
                            <input type="number" name="price" ></input>
                        </td>
                    </tr>

                    <tr>
                        <td>Select Image:</td>
                        <td>
                            <input type="file" name="image">
                        </td>
                    </tr>

                    <tr>
                        <td>Category:</td>
                        <td>
                            <select name="category">

                                <?php 
                                    //Create PHP code to display categories from Database
                                    //1.Create SQL to get all active categories from databse
                                    $sql = "SELECT * FROM tbl_category WHERE active='Yes'";

                                    //Execute Query
                                    $res = mysqli_query($conn, $sql);

                                    //Count Rows to check whether we have Categories or not
                                    $count = mysqli_num_rows($res);

                                    //If count is greater than zero, we have categories else we don't have categories
                                    if($count>0)
                                    {
                                        //We have Categories
                                        while($row=mysqli_fetch_assoc($res))
                                        {
                                            //Get the details of Category
                                            $id = $row['id'];
                                            $title = $row['title'];
                                            ?>

                                            <option value="<?php echo $id; ?>"><?php echo $title; ?></option>

                                            <?php 
                                        }

                                    }
                                    else  
                                    {
                                        //We don't have Category
                                        ?>
                                        <option value="0">No Category Found</option>
                                        <?php
                                    }


                                    //2.Display on Dropdown
                                ?>

                            </select>
                        </td>
                    </tr>

                    <tr>
                        <td>Featured: </td>
                        <td>
                            <input type="radio" name="featured" value="Yes"> Yes
                            <input type="radio" name="featured" value="No"> NO
                        </td>
                    </tr>

                    <tr>
                        <td>Active: </td>
                        <td>
                            <input type="radio" name="active" value="Yes"> Yes
                            <input type="radio" name="active" value="No"> NO
                        </td>
                    </tr>

                    <tr>
                        <td colspan="2">
                            <input type="submit" name="submit" value="Add Food" class="btn-secondary">
                        </td>
                    </tr>
                       
            </table>
        </form>


        <?php  
        
            //Check Whether the button is Clicked or not
            if(isset($_POST['submit']))
            {
                //Add the food in Database
                //echo "Clicked";
                
                //1. Get the Data from form 
                $title = $_POST['title'];
                $description = $_POST['description'];
                $price = $_POST['price'];
                $category = $_POST['category'];
                
                //Check whether radio button for featured and active are checked or not
                if(isset($_POST['featured']))
                {
                    $featured = $_POST['featured'];
                }
                else
                {
                    $featured = "No"; //Setting the Default Value
                }

                if(isset($_POST['active']))
                {
                    $active = $_POST['active'];
                }
                else
                {
                    $active = "No"; //Setting the Default Value
                }


                //2. Upload the Image if select
                //Check whether the select image is selected or not and upload the image only if the image is selected
                if(isset($_FILES['image']['name']))
                {
                    //Get the Details of the selected Image
                    $image_name = $_FILES['image']['name'];

                    //Check whether the Image is Selected or not and upload image only if Selected
                    if($image_name!= "")
                    {
                        //Image is Selected
                        //A.Rename the Image
                        //Get the extension of selected image (jpg, png, gif, etc.) "Aryan-raj.jpg" Aryan-raj jpg
                        $ext = end(explode('.', $image_name));

                        //Create new name for image
                        $image_name = "Food-Name-".rand(0000,9999).".".$ext; //New Image Name May be "Food-Name-567.jpg"


                            //B. Upload the Image
                            //Get the Src Path and Destination path

                            //Src Path is the current location of the image
                            $src = $_FILES['image']['tmp_name'];
                            //Src Path and Destination path
                            $dst = "../images/food/".$image_name;

                            //Finally Upload the food image
                            $upload = move_uploaded_file($src, $dst);

                            // Check whether image is uploaded or not
                            if($upload==false)
                            {
                                //Failed to Upload the Image
                                $_SESSION['upload'] = "<div class='error'>Failed to Upload Image.</div>";
                                //Redirect to Add Category Page
                                header('Location:'.SITEURL.'admin/add-food.php');
                                //Stop the Process
                                die();
                            }


                        }
                
                    }

                else
                {
                    $image_name = " ";  //Setting Default Value as blank
                }

                    //3. Insert Into Database
                    //2. Create SQL Query to Save Food in Database
                    //For Numerical Value we don't need to pass it inside quotes '' But for String value it is compulsary to add quotes''
                    $sql2 = " INSERT INTO tbl_food SET
                        title = '$title',
                        description = '$description',
                        price = $price,
                        image_name ='$image_name',
                        category_id = $category,
                        featured = '$featured',
                        active = '$active'
                    ";

                //3. Execute the Query and Save in Database
                //$res2 = mysqli_query($conn, $sql2);
                $res2 = mysqli_query($conn, $sql2);

                //4. Check whether the data inserted or not
                if($res2 == true)
                {
                    //Data inserted Successfully
                    $_SESSION['add'] = "<div class='success'>Food Added Successfully.</div>";
                    header('Location:'.SITEURL.'admin/manage-food.php');
                }
                else
                {
                    //Failed to Inset Data
                    $_SESSION['add']= "<div class'error'>Failed to Add Food.</div>";
                    header('Location:'.SITEURL.'admin/manage-food.php');
                }
             

            }

        ?>

    </div>
</div>



<?php include('partials/footer.php'); ?>