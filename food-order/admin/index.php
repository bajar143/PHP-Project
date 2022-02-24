<?php include('partials/menu.php'); ?>

        <!-- Menu Content Section starts -->
        <div class="main-content">
            <div class="wrapper">
                    <h1>DASHBOARD</h1>

                    <br><br>
                    <?php  
                        if(isset($_SESSION['login']))
                        {
                            echo $_SESSION['login'];
                            unset($_SESSION['login']);
                        }
                    ?>

                    <br><br>
                    
                    <div class="col-4 text-center">

                    <?php
                        //SQL QUERY 
                        $sql = "SELECT * FROM tbl_category";
                        //Execute the Query
                        $res = mysqli_query($conn, $sql);
                        //Count the Rows
                        $count = mysqli_num_rows($res);

                    ?>

                        <h1><?php echo $count; ?></h1>
                        <br />
                        Categories
                    </div>
                    <div class="col-4 text-center">
                    <?php
                        //SQL QUERY 
                        $sql2 = "SELECT * FROM tbl_food";
                        //Execute the Query
                        $res2 = mysqli_query($conn, $sql2);
                        //Count the Rows
                        $count2 = mysqli_num_rows($res2);

                    ?>

                        <h1><?php echo $count; ?></h1>
                        <br />
                        Foods
                    </div>
                    <div class="col-4 text-center">
                    <?php
                        //SQL QUERY 
                        $sql3 = "SELECT * FROM tbl_food";
                        //Execute the Query
                        $res3 = mysqli_query($conn, $sql3);
                        //Count the Rows
                        $count3 = mysqli_num_rows($res3);

                    ?>
                        <h1><?php echo $count; ?></h1>
                        <br />
                        Total Orders
                    </div>
                    <div class="col-4 text-center">
                        <?php 
                            //create Sql Query to Get total Revenue Generated
                            //Aggregate Funtion in SQL
                            $sql4 = "SELECT SUM(total) AS Total FROM tbl_order WHERE status='Delivered'";
                            //Execute the Query
                            $res4 = mysqli_query($conn, $sql4);
                            //Get the Value
                            $row4 = mysqli_fetch_assoc($res4);
                            //Get the Total Revenue
                            $total_revenue = $row4['Total'];

                         ?>
                        <h1><?php echo $total_revenue; ?></h1>
                        <br />
                        Revenue Generated
                    </div>
                    
                    
                    <div class="clearfix"></div>
        
            </div>
        </div>
        <!-- Menu Content Section Ends -->

<?php include('partials/footer.php'); ?>