<?php include('partials-front/menu.php') ?>

    <?php  
        //Check whether food id is set or not
        if(isset($_GET['food_id']))
        {
            //Get the food id and detials of the selected food
            $food_id = $_GET['food_id'];

            //Get the Details of the Selected Food
            $sql = "SELECT * FROM tbl_food WHERE id=$food_id";
                
            //Execute the Query 
            $res = mysqli_query($conn, $sql);

            //Get the Value From Database
            $count = mysqli_num_rows($res);

            //Check whether the data is available or not
            if($count==1)
            {
                //We have Data
                $row = mysqli_fetch_assoc($res);
                $title = $row['title'];
                $price = $row['price'];
                $image_name = $row['image_name'];
            }
            else  
            {
                //Food not available
                //Get the Data from Database
                header('Location:'.SITEURL);
            }


        }    
        else 
        {
            //Redirect to home page
            header('Location:'.SITEURL);
        }

    ?>

    <!-- fOOD sEARCH Section Starts Here -->
    <section class="food-search">
        <div class="container">
            
            <h2 class="text-center text-white">Fill this form to confirm your order.</h2>

            <form action="" method="POST" class="order">
                <fieldset>
                    <legend>Selected Food</legend>

                    <div class="food-menu-img">
                        <?php  
                        
                            //Check whether th image is available or not
                            if($image_name=="")
                            {
                                //image is not Available
                                echo "<div class='error'>Image is Not Available</div>";
                            }
                            else  
                            {
                                //image is available
                                ?>
                                <img src="<?php echo SITEURL; ?>images/food/<?php echo $image_name; ?>" alt="Chike Hawain Pizza" class="img-responsive img-curve">
                                <?php
                            }
                        
                        ?>

                    </div>
    
                    <div class="food-menu-desc">
                        <h3><?php echo $title; ?></h3>
                        <input type="hidden" name="food" value="<?php echo $title; ?>">
                        
                        <p class="food-price"><?php echo $price; ?></p>
                        <input type="hidden" name="price" value="<?php echo $price; ?>">
                       
                        <div class="order-label">Quantity</div>
                        <input type="number" name="qty" class="input-responsive" value="1" required>
                        
                    </div>

                </fieldset>
                
                <fieldset>
                    <legend>Delivery Details</legend>
                    <div class="order-label">Full Name</div>
                    <input type="text" name="full-name" placeholder="E.g. Vijay Thapa" class="input-responsive" required>

                    <div class="order-label">Phone Number</div>
                    <input type="tel" name="contact" placeholder="E.g. 9843xxxxxx" class="input-responsive" required>

                    <div class="order-label">Email</div>
                    <input type="email" name="email" placeholder="E.g. hi@vijaythapa.com" class="input-responsive" required>

                    <div class="order-label">Address</div>
                    <textarea name="address" rows="10" placeholder="E.g. Street, City, Country" class="input-responsive" required></textarea>

                    <input type="submit" name="submit" value="Confirm Order" class="btn btn-primary">
                </fieldset>

            </form>

            <?php 
            
                //Check whether submit button is clicked or not
                if(isset($_POST['submit']))
                {
                    //Get all the details from the Form
                    
                    $food = $_POST['food'];
                    $price = $_POST['price'];
                    $qty = $_POST['qty'];

                    $total = $price * $qty; //total = price x qty

                    $order_date = date("Y-m-d h:i:sa"); //order date
    
                    $status = "Ordered";    //Ordered, on Delievery, Delvered, Canceled

                    $customer_name = $_POST['full-name'];
                    $customer_contact = $_POST['contact'];
                    $customer_email = $_POST['email'];
                    $customer_address = $_POST['address'];

                    //Save the ORder in Databae
                    //Create Sql to save the Data
                    $sql2 = "INSERT INTO tbl_order SET
                        food = '$food',
                        price = '$price',
                        qty = '$qty',
                        total = '$total',
                        order_date = '$order_date',
                        status = '$status',
                        customer_name = '$customer_name',
                        customer_contact = '$customer_contact',
                        customer_address = '$customer_address',
                        customer_email = '$customer_email'
                    ";
                    
                    //echo $sql2; die();

                    //Execute the Query
                    $res2 = mysqli_query($conn, $sql2);

                
                    //Chech=k whether exxecuted or not
                    if($res2==true)
                    {
                        //food Updated
                        $_SESSION['order'] = "<div class='success text-center'>Food Ordered Successfully.</div>";
                        header('Location:'.SITEURL);
                    }
                    else  
                    {
                        //Failed to update food
                        $_SESSION['order'] = "<div class='error text-center'>Failed to Ordered food.</div>";
                        header('Location:'.SITEURL);
                    }

                }
            
            ?>

        </div>
    </section>
    <!-- fOOD sEARCH Section Ends Here -->


<?php include('partials-front/footer.php') ?>