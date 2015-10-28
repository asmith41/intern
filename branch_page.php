<?php include 'templates/header.php'; 
        ob_start();
        require_once ('includes/functions.php');
        require_once('core/init.php');
       
	
	if(!isset($_SESSION['username']) ){
        header("location:index.php");
    }
    elseif($_SESSION['permission']==1){
    	header("location:index.php");
    }
    include 'templates/content_background.php';
    include 'includes/modals.php';

        //for the sale table for selling of the bike
        if(isset($_POST['sell_button'])){
            $numbers=$_POST['numbers'];
                $number_decrement= -1 * $_POST['numbers'];
                $bike_id=$_POST['bike_id'];
                $branch_id=$_SESSION['uid'];

                $BranchInvObj = new branch_inventory($number_decrement,$bike_id,$branch_id);
                $result_branch_inventory=$BranchInvObj->add_sub_inventory();
            
                //chek if the transaction is valid and perform operation
                if($result_branch_inventory){
                    $SaleObj=new sales($numbers,$bike_id,$branch_id);
                    $IsInsert=$SaleObj->add_sales();
                    //var_dump($IsInsert);
                    if($IsInsert){
                        $_GET['sell_success']=1;
?>                  
                        <script type="text/javascript">
                            $(document).ready(function() {
                            $(document).scrollTop( $("#sell_id").offset().top );  
                            });                 
                        </script>
            
<?php           
                        $IsLimit= $BranchInvObj->limit('branch_inventory');
                        //var_dump($IsLimit);
                        if($IsLimit){
                            $_GET['delivered_limit']=1;
?>                          <script type="text/javascript">
                                $(document).ready(function() {
                                $(document).scrollTop( $("#sell_id").offset().top );  
                                });                 
                            </script>   
<?php                   }
                    }
                }

                else{
                    $_GET['sell_success']=0;
?>                      <script type="text/javascript">
                            $(document).ready(function() {
                                $(document).scrollTop( $("#sell_id").offset().top );  
                            });                 
                        </script>
<?php               }
        }   
         
?>

<!-- not working -->
<?php
     if(isset($_GET['update_success']) && ($_GET['update_success']=='1')){
?>      <script type="text/javascript">
            var orderDiv = document.getElementById('update-div');
            orderDiv.className = "alert alert-primary";
            orderDiv.innerHTML = "password has been updated";
        </script>
<?php
            
    }
?>



	<body>
    	<?php include 'templates/user_content.php'; ?>
        <div class="container-fluid form-background">
            <div id="order-div"></div>
            <div class="row">
                <a id="sell_id" href="#sell_bikes" name="sell_bikes1"><p id="p1" class='label-style'>sell bike</p></a>
                <div class="col-md-6 col-md-offset-3 form-center">
                    <form action="branch_page.php" method="POST">
                        <div class="form-group">
                            <label class='label-style'>Enter the brand of bike to sell</label>
                            
                            <select name="bike_id" class="form-control">
                                <?php
                                    $branch_id=$_SESSION['uid'];
                                    drop_down_join_where($branch_id,"bike_id","branch_inventory","bike_id","brand_model","bikes");
                                ?>
                            </select>
                            <!-- <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Enter brand of the bike" required> -->
                                          
                            <label class='label-style'>enter numbers of to sell</label>
                            <input name="numbers" type="number" class="form-control" id="exampleInputPassword1" placeholder="no. of bikes" required>

                        </div>

                    
                        <button name="sell_button" type="submit" class="btn btn-primary button1" id="sell_bikes">upload</button>
                    
                        <?php
                            if(isset($_GET['sell_success']) && ($_GET['sell_success']=='1') ){
                                echo "<span class='label label-primary'>Sell update success</span>";
                            }
                            if(isset($_GET['sell_success']) && ($_GET['sell_success']=='0' ) ) {
                                echo "<span class='label label-danger'>Sell update failed</span>";
                            }
                            if(isset($_GET['delivered_limit']) && ($_GET['delivered_limit'])=='1' ){
                                echo "<span id='sell_alert' class='label label-danger'>Selected bike has crossed limited number</span>";
                            }
                        ?>      
                    </form>
                </div> 
                </div>
                </div>

                 <div class="row">
                 <div id="update-div"></div>
                    <a href="#changePwd" name="changePwd"><p id="p1" class='label-style'>Update Password</p></a>
                    <div class="col-md-6 col-md-offset-3 form-center">
                        <form action="newPwd.php" method="POST" onsubmit="return confirm()">
                            <div class="form-group">
                                <div id="error-div"></div>
                                
                                <label class='label-style'>Enter the new password</label>
                                <input id='password' type="password" class="form-control" placeholder="Enter new password" required>
                                          
                                <label class='label-style'>Please re-enter the new Password</label>
                                <input id='RePassword' name="newPwd" type="password" class="form-control" placeholder="re-enter password" required>

                                <script type="text/javascript">
                                    function confirm() {
                                        var password = document.getElementById('password').value;
                                        var repassword = document.getElementById('RePassword').value;
                                        if (password == repassword) {
                                            return true;
                                        }
                                        var errorDiv = document.getElementById('error-div');
                                        errorDiv.className = "alert alert-danger";
                                        errorDiv.innerHTML = "the passwords didn't match, please try again";
                                        return false;
                                    }
                                </script>

                            </div>


                    
                            <button name="update_password" type="submit" class="btn btn-primary button1" id="sell_bikes">Update</button>
                    
                            <?php
                                
                                if(isset($_GET['update_success']) && ($_GET['update_success'])=='1' ){
                                    echo "<span class='alert alert-success'>Password updated successfully</span>";
                                }
                                echo "<span></br></br></br></br></br></span>";
                            ?>      
                        </form>
                    </div>      
                </div>

<?php include 'templates/footer.php'; ?>
</body>