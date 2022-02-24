<?php include('partials/menu.php'); ?>


        <!-- Menu Content Section starts -->
        <div class="main-content">
            <div class="wrapper">
                    <h1>Manage Admin</h1>
                    <br />
                    
                    <?php 
                        if(isset($_SESSION['add']))
                        {
                            echo $_SESSION['add'];  //Displaying Session Message
                            unset($_SESSION['add']); //Removing Session Message
                        }
                        if(isset($_SESSION['delete']))
                        {
                            echo $_SESSION['delete'];
                            unset($_SESSION['delete']);
                        }

                        if(isset($_SESSION['update']))
                        {
                            echo $_SESSION['update'];
                            unset($_SESSION['update']);
                        }

                        if(isset($_SESSION['user-not-found']))
                        {
                            echo $_SESSION['user-not-found'];
                            unset($_SESSION['user-not-found']);
                        }

                        if(isset($_SESSION['pwd-not-match']))
                        {
                            echo $_SESSION['pwd-not-match'];
                            unset($_SESSION['pwd-not-match']);
                        }

                        if(isset($_SESSION['change-pwd']))
                        {
                            echo $_SESSION['change-pwd'];
                            unset($_SESSION['change-pwd']);
                        }
                    
                    ?>
                    <br> <br> <br>
                    <!-- Button to Add Admin -->
                    <a href="add-admin.php" class="btn-primary">Add Admin</a>
                    <br /><br />

                    <table class="tbl-full">
                        <tr>
                            <th>S.N.</th>
                            <th>Full Name</th>
                            <th>Username</th>
                            <th>Actions</th>
                        </tr>

                        <?php
                            //Query to Get all Admin 
                            $sql = "SELECT * FROM tbl_admin";
                            //Execute the Query
                            $res = mysqli_query($conn, $sql);

                            //Check Whether the Query is Executed or Not
                            if($res==TRUE)
                            {
                                //Coun the Rows to check whether we have data in database or Not
                                $count = mysqli_num_rows($res); //Function to get all the rows in datase
                                
                                $sn=1; //Create a vairable to auto arrange numbering of id

                                //Check the num of rows
                                if($count>0)
                                {
                                    //We have data in Database
                                    while($rows=mysqli_fetch_assoc($res))
                                    {
                                        //Using while loop to get all data from database.
                                        //And while loop will ru as long as we have data in database

                                        //Get individual Data
                                        $id=$rows['id'];
                                        $full_name=$rows['full_name'];
                                        $username=$rows['username'];

                                        //Display the Values in our table
                                        ?>

                                        <tr>
                                            <td><?php echo $sn++; ?></td>
                                            <td><?php echo $full_name; ?></td>
                                            <td><?php echo $username; ?></td>
                                            <td>
                                            <a href="<?php echo SITEURL; ?>admin/update-password.php?id=<?php echo $id; ?>" class="btn-primary">Change Password</a>
                                            <a href="<?php echo SITEURL; ?>admin/update-admin.php?id=<?php echo $id; ?>" class="btn-secondary">Update Admin</a>
                                            <a href="<?php echo SITEURL; ?>admin/delete-admin.php?id=<?php echo $id; ?>" class="btn-danger">Delete Admin</a>
                                            </td>
                                        </tr>

                                        <?php
                                    }
                                }
                                else
                                {
                                    //We dont  have data in Database
                                }
                            }
                        ?>

                        
                    </table>

                   
            </div>
        </div>
        <!-- Menu Content Section Ends -->

        <?php include('partials/footer.php'); ?>