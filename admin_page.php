
<?php 
    ob_start();
    include 'includes/functions.php';
	include 'templates/header.php'; 
	include 'templates/content_background.php';
    include 'includes/modals.php';
	require_once('core/init.php');
    	

    if(!isset($_SESSION['username'])){
        header("location:index.php");
    }

    elseif($_SESSION['permission']==0){
        header("location:index.php");
    }

    //add bikes ko ho!!
    if(isset($_POST['addbikes'])){
      	$bike_brand_model=$_POST['bike_brand'];
        $BikeObj=new bikes($bike_brand_model);
        $IsInsert=$BikeObj->add_bikes();      
        
        if($IsInsert==true){
        	$_GET['bike_add_success']=1;
?>			<script type="text/javascript">
               	$(document).ready(function() {
        		$(document).scrollTop( $("#add_bikes").offset().top );  
    			});          		
        	</script>
<?php 		
        }
        else{
        	$_GET['bike_add_success']=0;;
?>         	<script type="text/javascript">
               	$(document).ready(function() {
        		$(document).scrollTop( $("#add_bikes").offset().top );  
    			});          		
        	</script>           		
<?php        				
        }
    }

    	//for inventory input of bikes
    	if(isset($_POST['inv_submit'])){
            $brand_id=$_POST['brand_id'];
       	    $numbers=$_POST['number'];
            $limit=$_POST['limit'];
      	    $InvObj=new inventory($numbers,$brand_id,null,$limit);
        	$IsInsert=$InvObj->add_sub_inventory();

        	if($IsInsert==true){
        	   $_GET['inventory_update_success']=1;
?>                  <script type="text/javascript">
               	        $(document).ready(function() {
        			    $(document).scrollTop( $("#add_inv").offset().top );  
    				    });          		
        		    </script>
            		
<?php       }
        	else{
        		$_GET['inventory_update_success']=0;
?>        		<script type="text/javascript">
               		$(document).ready(function() {
        			$(document).scrollTop( $("#add_inv").offset().top );  
    				});          		
        		</script>	
<?php       }
        }

	//header("location:admin_page.php?inventory_update_unsuccess=1");      	
    //for deliver to branch
    if(isset($_POST['branch_inv_submit'])){
       	$branch_id=$_POST['deliver_branch_id'];
        $bike_id=$_POST['deliver_bike_id'];
        $number_increment=$_POST['number_of_bikes'];
        $number_decrement= -1* $_POST['number_of_bikes'];
        //set lilmit for bikes for branch inventory
        $limit=$_POST['limit'];
        //deliver subtracts from the main inventory, if item number results out to be less than zero, it returns false else true else.
        $InvObj=new inventory($number_decrement,$bike_id);
        $result_inventory=$InvObj->add_sub_inventory();
        //check if the transaction is a valid one.
        if($result_inventory){
            $BranchInvObj=new branch_inventory($number_increment,$bike_id,$branch_id,$limit);
            $result_branch_inventory=$BranchInvObj->add_sub_inventory();        
            
            if($result_branch_inventory){
                $_GET['delivered']=1;
 ?>                 <script type="text/javascript">
                        $(document).ready(function() {
                        $(document).scrollTop( $("#deliver_id").offset().top );  
                        });                 
                    </script>
<?php       }

            $IsLimit= $InvObj->limit('inventory_table');
            var_dump($IsLimit);
            if($IsLimit){
            	$_GET['delivered_limit']=1;
?>          		<script type="text/javascript">
               		   $(document).ready(function() {
        			     $(document).scrollTop( $("#deliver_id").offset().top );  
    					});          		
        			 </script>	
<?php       }
        }
        else{
        	$_GET['delivered']=0;
?>          <script type="text/javascript">
               	$(document).ready(function() {
        		$(document).scrollTop( $("#deliver_id").offset().top );  
    		     });          		
        	</script>
<?php		//header("location:admin_page.php?branch_inventory_unsuccess=1");
        }
    }


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
            var_dump($IsInsert);
           	if($IsInsert){
           		$_GET['sell_success']=1;
?>           		
			     <script type="text/javascript">
               		$(document).ready(function() {
        				$(document).scrollTop( $("#sell_id").offset().top );  
    				});          		
        		</script>
			   
<?php      	      
                $IsLimit=$BranchInvObj->limit('branch_inventory');
                if($IsLimit){
                    $_GET['sell_limit']=1;
?>                  <script type="text/javascript">
                        $(document).ready(function() {
                        $(document).scrollTop( $("#sell_id").offset().top );  
                        });              
                    </script>  
<?php           }
            }
        }	
        else{
	       $_GET['sell_success']=0;
?>              <script type="text/javascript">
               	    $(document).ready(function() {
        			    $(document).scrollTop( $("#sell_id").offset().top );  
    			     });          		
        	   </script>
<?php 
            }
    }      
?>

<!-- for deleting the branch -->
<?php
    if(isset($_POST['delete'])){
        $branch_id=$_POST['branch_id'];

        $BranchInvObj=new branch_inventory();
        $TransInfo=$BranchInvObj->transferInfo($branch_id);
       
        $InvObj=new inventory();
        $IsTransfer=$InvObj->transferUpdate($branch_id,$TransInfo);
        var_dump($IsTransfer);

        
        if($IsTransfer){
            $BranchObj=new branch();
            $res=$BranchObj->delete($branch_id);

            if($res){
                $_GET['deleted']=1;
?>              <script type="text/javascript">
                    $(document).ready(function() {
                    $(document).scrollTop( $("#del_bikes").offset().top );  
                    });                 
                </script>           
<?php       }
            else{
                $_GET['deleted']=0; 
?>              <script type="text/javascript">
                    $(document).ready(function() {
                    $(document).scrollTop( $("#del_bikes").offset().top );  
                    });                 
                </script>
 <?php  
            }
        }
    }
?>
<!-- checking empty space in the input form -->
<script type="text/javascript">
    function required(t) {
    var inputs = $(t).find('input[required]');
    var result = true;
    inputs.each(function(index){
        var tex = $(this).val();
        if(/^\s+$/.test(tex)) {
            alert("You cannot enter just spaces as input.");
            result = false;
            return false;
        }
    });
        return result;
    }
</script>

<?php

//for registrating new branch
    if(isset($_POST['add_branch'])){
        $branch_un=$_POST['branch_un'];
        $branch_pw=md5($_POST['branch_pw']);
        $branch_loc=$_POST['branch_loc'];
        $branch_name=$_POST['branch_name'];
        //echo "asd";
        $funObj=new Branch($branch_un,$branch_pw,$branch_name,$branch_loc);
        $user=$funObj->Register();

            if($user==true){
                $_GET['registered']=1;
                //header("location:admin_page.php?registration_failed=1");
?>              <script>
                    $(document).ready(function() {
                    $(document).scrollTop( $("#add_branch1").offset().top );  
                    });           
                </script>
<?php       }
            else{
                $_GET['registered']=0;
                //header("location:admin_page.php?registration_success=1");
?>              <script>
                    $(document).ready(function() {
                    $(document).scrollTop( $("#add_branch1").offset().top );  
                    });           
                </script>
<?php       }
    }
?>


<!-- main body starts -->
    <div class="container-fluid">
        <div class="col-lg-2 col-xs-6 del">
                <a href="#add_bikes">
                    <img src="assets/images/q.png" class="img-responsive img-circle inset" width="210em">
                        <h4 id="image_h1">ADD BIKES</h4>
                </a>
        </div>
        <div class="col-lg-2 col-xs-6 del">
            <a href="#add_branch1">
                <img src="assets/images/aa.png" class="img-responsive img-circle inset" width="210em">
                <h4 id="image_h1">ADD BRANCH</h4> 
            </a>
        </div>

        <div class='clearfix visible-xs-block visible-sm-block visible-md-block'></div>

        <div class="col-lg-2 col-xs-6 del">
            <a href="#deliver1" >
                <img src="assets/images/e.jpg" class="img-responsive img-circle inset" width="210em">
                <h4 id="image_h1">DELIVER</h4>
            </a>
        </div>
        <div class="col-lg-2 col-xs-6 del">
            <a href="#"  data-toggle="modal" data-target="#myModal">
                <img src="assets/images/w.png" class="img-responsive img-circle inset" width="210em">
                <h4 id="image_h1">VIEW STOCK</h4>
            </a>         
        </div>

         <div class='clearfix visible-xs-block visible-sm-block'></div>

        <div class="col-lg-2 col-xs-6 del">
            <a href="#add_to_inventory">
                <img src="assets/images/z.png" class="img-responsive img-circle inset" width="210em">
                <h4 id="image_h1">ADD TO INVENTORY</h4>
            </a>
        </div>
        <div class="col-lg-2 col-xs-6 del">
            <a href="#sell_bikes11">
                <img src="assets/images/x.png" class="img-responsive img-circle inset" width="210em">
                <h4 id="image_h1">SELL</h4>
            </a>       
        </div>

         <div class='clearfix visible-xs-block visible-sm-block visible-lg-block'></div>

        <div class="col-lg-2 col-xs-6 del">
            <a href="#del_bikes">
                <img src="assets/images/del.png" class="img-responsive img-circle inset" width="210em">
                <h4 id="image_h1">DELETE BRANCH</h4>
            </a>           
        </div>

        <div class="col-lg-2 col-xs-6 del">
            <a href="#" data-toggle="modal" data-target="#myModal_report">
                <img src="assets/images/rep.png" class="img-responsive img-circle inset" width="210em">
                <h4 id="image_h1">REPORT</h4>
            </a>           
        </div>

         <div class='clearfix visible-xs-block visible-sm-block'></div>

        <div class="col-md-12 jumbotron" id="back">
            <h1 id="jomboH">WELCOME TO MANAGE YOUR STORE</h1>
            <p id="jomboP">Please select the above listed icons to perform specified action</p>   
        </div>
    </div>

      
 
    <!-- for the form to add bikes -->
    <div class="container-fluid form-background">
        <div id="ad" class="row">
        	<a id="add_bikes" href="#add_bikes" name="add_bikes"><p id="p1" class='label-style'>Add new bike information</p></a>
            <div class="col-md-6 col-md-offset-3 form-center">
                <form action="admin_page.php" onsubmit="return required(this)" method="POST">
                    <div class="form-group">
                        <label class='label-style'>Enter bike brand followed by an underscore and a model</label>
                        <input name="bike_brand" type="text" class="form-control" id="button1" placeholder="example :: giant_xtc2014" required>           
                    </div>
                        
                    <button type="submit" name="addbikes" class="btn btn-primary button1" id="AddBike">Add Bike</button>
            
                    <?php
                        if(isset($_GET['bike_add_success']) && ($_GET['bike_add_success']=='1')){
                            echo '<span class="label label-primary">successfully action completed</span>';
                        }
                        elseif(isset($_GET['bike_add_success']) && ($_GET['bike_add_success']=='0') ){
                            echo '<span class ="label label-danger">acition failed, please try again with unique bike information</span>';
                        }
                    ?>                
                      
                    <!-- <button type="submit" name="add" class="btn btn-primary" id="button1">confirm</button> -->
                </form>
            </div>            
        </div>
    </div> 

    <!--for the form to add branch  -->
    <div class="container-fluid form-background">
        <div class="row">
            <a href="#add_branch1" id="add_branch1"><p id="p1" class='label-style'>Add Branch</p></a>
            <div class="col-md-6 col-md-offset-3 form-center">
                <form action="admin_page.php" onsubmit="return confirm() && required(this) " method="POST">
                    <div id="error-div"></div>
                        <div class="form-group">
                            <label class='label-style'>Branch name</label>
                                <input name="branch_name" type="text" class="form-control" id="exampleInputEmail1" placeholder="Enter name of the branch" required>
                            
                                <label class='label-style'>Enter location of the branch</label>
                                <input name="branch_loc" type="text" class="form-control" id="exampleInputPassword1" placeholder="location" required>

                                <label class='label-style'>Enter Username</label>
                                <input name="branch_un" type="text" class="form-control" id="exampleInputPassword1" placeholder="username" required>
                    
                                <label class='label-style'>Enter Password</label>
                                <input name="branch_pw" type="password" class="form-control" id="password" placeholder="password" required>

                                <label class='label-style' for="exampleInputEmail1">Re-enter Password</label>
                                <input name="branch_pw" type="password" class="form-control" id="RePassword" placeholder="password" required>
                                

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
                            <button type="add_branch" name="add_branch" class="btn btn-primary button1" id="add_branch">Add Branch</button>
                            <?php if (isset($_GET['registered']) && $_GET['registered'] == '0') {
                                        echo '<span class="label label-danger">registration unsucess, please try again</span>';
                                    }
                                    elseif(isset($_GET['registered']) && $_GET['registered']=='1'){
                                        echo '<span class="label label-primary">new branch success</span>';
                                    }
                            ?>
                    </form>
            </div>            
        </div>
    </div>


    <!-- form to deliver to branch inventory -->
    <div class="container-fluid form-background">
        <div class="row">
            <a href="#deliver1" id="deliver_id" name="deliver1"><p id="p1" class='label-style'>Deliver Bikes to branch</p></a>
            <div class="col-md-6 col-md-offset-3 form-center">
                <form action="admin_page.php" method="POST">
                    <div class="form-group">
                        <label class='label-style'>Branch name to deliver to</label>                                
                        
                        <select name="deliver_branch_id" class="form-control">
                            <?php
                                drop_down("branch_id","branch_name","branch");
                            ?>
                        </select>           
                        </br>
                        <label class='label-style'>Choose the bike model to deliver</label>
                            <select name="deliver_bike_id" class="form-control">                              
                                <?php
                                    drop_down_join("inventory_id","bike_id","inventory_table","bike_id","brand_model","bikes");
                                ?>
                            </select>
                        </br>
                        <!-- <input type="text" class="form-control" id="exampleInputPassword1" placeholder="brand of the bike" required> --> 
                        <label class='label-style'>Enter the number of the bikes to deliver</label>
                            <input name="number_of_bikes" type="number" class="form-control" id="exampleInputPassword1" placeholder="no of bikes" min="1" required>
                            <label class='label-style'>Enter the limit number for the bike</label>
                            <input name="limit" type="number" class="form-control" placeholder="limit number of the bike for the branch" min="1" required>
                    </div>                      
                    
                    <button type="submit" name="branch_inv_submit" class="btn btn-primary button1" id="branch_inventory">Deliver</button>    
                        <?php                                
                            if(isset($_GET['delivered']) &&($_GET['delivered']=='1') ){
                            	echo "<span class='label label-primary'>action bike delivery completed</span>";
                            }
                            if(isset($_GET['delivered_limit']) && ($_GET['delivered_limit']=='1') ){
                                echo "<span class='label label-danger'>LIMIT ALERT, you have limited number of selected bikes</span>";
                            }
                            elseif(isset($_GET['delivered']) && ($_GET['delivered']=='0') ){
                                echo "<span class='label label-danger'>action bike delivery failes</span>";
                            }                                                              
                        ?>
                </form>
            </div>            
        </div>
    </div>

    <!-- form to add bikes to inventory -->
    <div class="container-fluid form-background">
        <div class="row">
            <a id="add_inv" href="#add_to_inventory" name="add_to_inventory"><p id="p1" class='label-style'>Add to inventory</p></a>
            <div class="col-md-6 col-md-offset-3 form-center">
                <form action="admin_page.php" method="POST">
                    <div class="form-group">
                        <label class='label-style'>Bike brand to enter to inventory</label>
                        <!--  <input name= "brand_id" type="text" class="form-control" id="exampleInputEmail1" placeholder="Enter brand of the bike" required> -->  
                        <select name="brand_id" class="form-control">
                            <?php  
                                drop_down("bike_id","brand_model","bikes");
                            ?>
                        </select>
                        
                        <label class='label-style'>enter numbers of bikes</label>
                        <input name="number" type="number" class="form-control" id="exampleInputPassword1" placeholder="no. of bikes" min='1' required>
                        <label class='label-style'>set the alert limit number for the bike</label>
                        <input name="limit" type='number' class="form-control" placeholder="enter limit" min='1' required>
                    </div>
                        
                    <button name="inv_submit" type="submit" class="btn btn-primary button1" id="inventory">Add To Inventory</button>
                        
                    <?php 
                        if(isset($_GET['inventory_update_success']) && ($_GET['inventory_update_success'])=='1'){
                            echo '<span class="label label-primary">inventory successfully updated</span>';
                        }
                        elseif(isset($_GET['inventory_update_unsuccess']) && ($_GET['inventory_update_unsuccess'])=='1'){
                            echo '<span class="label label-primary">inventory update fails</span>';
                        }
                    ?>
                </form>
            </div>            
         </div>
    </div> 


    <!-- form to sell bikes -->
    <div class="container-fluid form-background">
        <div class="row">
            <a id="sell_id" href="#sell_bikes11" name="sell_bikes11"><p id="p1" class='label-style'>sell bike</p></a>
            <div class="col-md-6 col-md-offset-3 form-center">
                <form action="admin_page.php" method="POST">
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
                        <input name="numbers" type="number" class="form-control" id="exampleInputPassword1" placeholder="no. of bikes" min='1' required>

                    </div>
                    
                    <button name="sell_button" type="submit" class="btn btn-primary button1" id="sell_bikes">Sell</button>
                    
                  	<?php
                  		if(isset($_GET['sell_success']) && ($_GET['sell_success']=='1') ){
                  			echo "<span class='label label-primary'>Sell update success<span>";
                  		}
                        if(isset($_GET['sell_limit']) && ($_GET['sell_limit'])=='1' ){
                            echo "<span class='label label-danger'>you have reached the bike limit</span>";
                        }
                  		if(isset($_GET['sell_success']) && ($_GET['sell_success']=='0' ) ) {
                  			echo "<span class='label label-danger'>Sell update failed<span>";
                  		}
                  	?>      

                </form>
            </div>            
        </div>
    </div> 


    <!-- for the form to delete bikes -->
    <div class="container-fluid form-background">
        <div class="row">
            <a id="del_bikes" href="#del_bikes" name="del_bikes"><p id="p1" class='label-style'>Choose a branch to delete</p></a>
            <div class="col-md-6 col-md-offset-3 form-center">
                <form action="admin_page.php" method="POST">
                    <div class="form-group">
                        <label class='label-style'>choose the bike branch you want to delete</label>           
                    </div>
                    
                    <select name="branch_id" class="form-control">
                        <?php  
                            drop_down("branch_id","branch_name","branch");
                        ?>
                    </select></br>
                              
                    <button name="delete" class="btn btn-danger button1">Delete</button>
                    
                    <?php
                        if(isset($_GET['deleted']) && ($_GET['deleted']=='1')){
                            echo '<span class="label label-primary">branch successfully deleted</span>';
                        }
                        elseif(isset($_GET['deleted']) && ($_GET['deleted'])=='0' ){
                            echo '<span class ="label label-danger">acition failed, please try again</span>';
                        }
                    ?>                  
                    <!-- <button type="submit" name="add" class="btn btn-primary" id="button1">confirm</button> -->
                </form>
            </div>            
        </div>
    </div> 
    <?php include 'templates/footer.php'; ?>