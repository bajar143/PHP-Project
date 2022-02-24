<?php include('partials/menu.php'); ?>

<?php 

    if(isset($_GET['id']))
    {
        $id = $_GET['id'];
        $sql = "SELECT * FROM tbl_food WHERE id= $id";
        $res2= mysqli_query($conn, $sql);
        $row2 = mysqli_fetch_assoc($res2);

        $title = $row2['title'];
        $description = $row2['description'];
        $price = $row2['price'];
        $current_image = $row2['image_name'];
        $current_category = $row2['category_id'];
        $featured = $row2['featured'];
        $active = $row2['active']; 



    }
    else 
    {
        header('Location:'.SITEURL.'admin/manage-food.php');
    }


?>

<div class="main-conetent">
    <div class="wrapper">
        <h1>Update Food</h1>
        <br><br>

        <form action="" method="POST" enctype="multipart/form-data">

        <table class="tbl-30">

            <tr>
                <td>Title: </td>
                <td>
                    <input type="text" name ="title" value="<?php echo $title?>">
                </td>
            </tr>
            <tr>
                <td>Description: </td>
                <td>
                    <textarea name="description" cols="30" rows="5"><?php echo $description;?></textarea>
                </td>
            </tr>

            <tr>
                <td>Price:</td>
                <td>
                <input type="number" name="price" value="<?php echo $price;?>">;
                </td>
            </tr>

            <tr>
                <td>Current Image:</td>
                <td>
                    <?php 
                        if($current_image =="")
                        {
                            echo"<div class='error'>Image not Available.</div>";
                        }
                        else 
                        {
                            ?>
                            <img src="<?php echo SITEURL; ?>images/food/<?php echo $current_image; ?>"width="150px">
                            <?php 

                        }

                    ?>

                </td>
            </tr>

            <tr>
                <td>Select New Image</td>
                <td>
                    <input type="file" name="image">
                </td>
            </tr>

            <tr>
                <td>Category:</td>
                <td>
                <select name="category">

                    <?php  

                        $sql = "SELECT * FROM tbl_category WHERE active='Yes'";
                        $res = mysqli_query($conn, $sql);
                        $count = mysqli_num_rows($res);

                        if($count>0)
                        {
                            while($row=mysqli_fetch_assoc($res))
                            {
                                $category_title = $row['title'];
                                $category_id = $row['id'];

                                //echo "<option value='$category_id'>$category_title</option>";
                                ?>
                                <option <?php if($current_category==$category_id){echo "selected";}?> value="<?php echo $category_id; ?>"><?php echo $category_title; ?></option>
                                <?php
                            }
                        }
                        else 
                        {
                           echo"<option value='0'>Category Not Available</option>";
                        }

                    ?>

                </select>
                </td>
            </tr>

            <tr>
                        <td>Featured: </td>
                        <td>
                            <input <?php if($featured=="Yes"){echo "checked";} ?> type="radio" name="featured" value="Yes"> Yes

                            <input <?php if($featured=="No"){echo "checked";} ?> type="radio" name="featured" value="No"> No
                        </td>
                    </tr>
                
                    <tr>
                        <td>Active: </td>
                        <td>
                            <input <?php if($active=="Yes"){echo "checked";} ?> type="radio" name="active" value="Yes"> Yes

                            <input <?php if($active=="No"){echo "checked";} ?> type="radio" name="active" value="No"> No
                        </td>
                    </tr>
                
                    <tr>
                        <td>
                            <input type="hidden" name="id" value="<?php echo $id; ?>"> 
                            <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">
                            <input type="submit" name="submit" value="Update food" class="btn-secondary">
                            
                        </td>
                    </tr>


        </table>

        </form>
        <?php  
        
            if (isset($_POST['submit']))
            {
                //echo "checked";
                //Get all the detials from the form
                $id = $_POST['id'];
                $title = $_POST['title'];
                $description = $_POST['description'];
                $price = $_POST['price'];
                $current_image = $_POST['current_image'];
                $category = $_POST['category'];

                $featured = $_POST['featured'];
                $active = $_POST['active'];
                
                //2. Updating New Image if Selected
                //Check whether the upload button is clicked or not
                if(isset($_FILES['image']['name']))
                {
                    //Upload Button Clicked
                    $image_name = $_FILES['image']['name'];  //New image name
                    
                    //2. Check whether the image is available or not
                    if($image_name != "")
                    {
                        //Image Available 

                        //A. Upload the New image

                        //Auto Rename our Image
                        //Get the Extension of our image(jpg,png,gif,etc) eg. "specialfood1.jpg"
                        $ext = end(explode('.', $image_name));

                        //Rename the Image
                        $image_name = "Food_Name_".rand(0000, 9999).'.'.$ext; // e.g Food_food_834.jpg
                        

                        $src_path = $_FILES['image']['tmp_name'];

                        $dest_path = "../images/food/".$image_name;

                        //Finally upload the Image
                        $upload = move_uploaded_file($src_path, $dest_path);

                        // Check whether the image is uploaded or not
                        //And if the image is not uploaded then we will stop the process and redirect with error messaage
                        if($upload==false)
                        {
                            //Set image
                            $_SESSION['upload'] = "<div class='error'>Failed to Upload Image.";
                            //Redirect to Manage food Page
                            header('Location:'.SITEURL.'admin/manage-food.php');
                            //Stop the Process
                            die();
                        } 

                        //B. Remove the Current Image if available
                        if($current_image !="")
                        {

                            $remove_path = "../images/food/".$current_image;

                            $remove = unlink($remove_path);
    
                            //Check whether the image is removed or not 
                            //If failed to remove then display message and stop the process
                            if($remove==false)
                            {
                                //Failed to remove image 
                                $_SESSION['remove-failed'] = "<div class='error'>Failed to remove Current Image.</div>";
                                header('Location:'.SITEURL.'admin/manage-food.php');
                                die(); //stop the process
                            }
                        }
                    }
                    else 
                    {
                        $image_name = $current_image;
                    }
                }
            else 
            {
                 $image_name = $current_image;
            }
            
                //4. Update the Database
                $sql3 = "UPDATE tbl_food SET
                    title = '$title',
                    description='$description',
                    price=$price,
                    image_name='$image_name',
                    category_id='$category',
                    featured = '$featured',
                    active = '$active'
                    WHERE id =$id
                ";

                //Execute the Query
                $res3 = mysqli_query($conn, $sql3);

                //4. Redirect to Manage food with Message 
                //Chech=k whether exxecuted or not
                if($res3==true)
                {
                    //food Updated
                    $_SESSION['update'] = "<div class='success'>Food Updated Successfully.</div>";
                    header('Location:'.SITEURL.'admin/manage-food.php');
                }
                else  
                {
                    //Failed to update food
                    $_SESSION['update'] = "<div class='error'>Failed to Update food.</div>";
                    header('Location:'.SITEURL.'admin/manage-food.php');
                }

                
            }                        

        ?>



    </div>
</div>



<?php include('partials/footer.php'); ?>
