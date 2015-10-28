
	
		<?php
        	require_once('core/init.php');	
		?>	
		<!-- model to show stock of inventory for admin-->
		<div id="myModal" class="modal fade" role="dialog">
    		<div class="modal-dialog modal-lg">
        		<!-- Modal content-->
        		<div class="modal-content">
            		<div class="modal-header">
                		<button type="button" class="close" data-dismiss="modal">&times;</button>
                		<h4 class="modal-title">STOCK</h4>
            		</div>
            		<!-- contents of model here -->
            		<div class="modal-body">
                		<?php
                			$db=database::getInstance();
                    		// $number,$brand_id,$branch_identifier=null
                			$InvObj=new inventory();
                			$values_central=$InvObj->show_inventory();
                            $BranchInvObj=new branch_inventory();
                            $values_branch=$BranchInvObj->show_inventory();
                        ?>
					    <!-- shows central inventory stock -->
                		<h4>Central Inventory</h4>
                		<table class="table table-bordered">
                    		<tr>
                        			<th>SN</th>
                        			<th>Bike</th>
                        			<th>Quantity in numbers</th>
                    		</tr>

                    		<?php
                        		$i=1;
                                    if($values_central){
                                        foreach($values_central as $value){
                            			    echo <<<ABC
                            			    <tr>
                            				    <td>$i</td>
                            				    <td>{$value['brand_model']}</td>
                                			    <td>{$value['no_of_bikes']}</td>
                            			     </tr>
ABC;
                        				    $i++;
                        			    }
                                    }    
                    		?>
                        </table>
                    	<table class="table table-bordered">
                    		<h4>Branch Inventory</h4>
                    		<tr>
                        			<th>SN</th>
                        			<th>Bike</th>
                        			<th>Quantity in numbers</th>
                    		</tr>
                   			<?php
                        		$i=1;
                                    if($values_branch){
                        			    foreach($values_branch as $value){
                            			    echo <<<ABC
                           			     <tr>
                             				<td>$i</td>
                             				<td>{$value['brand_model']}</td>
                            				<td>{$value['no_of_bikes']}</td>
                           				</tr>
ABC;
                       					$i++;
                       				    }   
                    		        }
                            ?>
                    	</table>
            			
                    </div>        
                         <div class="modal-footer">
               		       <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
           	            </div>
        	   </div>
            </div>
        </div>



<!--branch inventory -->
<div id="myModal_branch" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">STOCK</h4>
            </div>
            <!-- contents of model here -->
            <div class="modal-body">
                <?php
                    $db=database::getInstance();
                    $BranchInvObj=new branch_inventory();
                    $values_branch=$BranchInvObj->show_inventory();
                ?>
                <!-- shows branch inventory stock -->

                 <table class="table table-bordered">
                    <h4>Branch Inventory</h4>
                    <tr>
                        <th>SN</th>
                        <th>Bike</th>
                        <th>Quantity in numbers</th>
                    </tr>
                <?php
                    $i=1;
                    if($values_branch){
                        foreach($values_branch as $value){
                            echo <<<ABC
                            <tr>
                                <td>$i</td>
                                <td>{$value['brand_model']}</td>
                                <td>{$value['no_of_bikes']}</td>
                            </tr>
ABC;
                            $i++;
                        }
                    }   
                ?>
                </table>
            </div>
        
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>  

<!-- shows total sales information -->
<div id="myModal_report" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">SALES REPORT</h4>
            </div>
            <!-- contents of model here -->
            <div class="modal-body">
                <?php
                    $db=database::getInstance();
                    $SalesObj=new sales();
                    $values=$SalesObj->transaction();
                ?>
                <!-- shows sales information -->

                <table class="table table-bordered">
                    <tr>
                        <th>SN</th>
                        <th>Branch name</th>
                        <th>Bike</th>
                        <th>Number Of Sales</th>
                    </tr>
                <?php
                    $i=1;
                    foreach($values as $value){
                        echo <<<ABC
                            <tr>
                                <td>$i</td>
                                <td>{$value['branch_name']}</td>
                                <td>{$value['brand_model']}</td>
                                <td>{$value['no_of_bikes']}</td>
                            </tr>
ABC;
                            $i++;
                    }
                                       
                ?>
                </table>
            </div>
        
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- model to send message -->
<div id="myModalSendMessage" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Message</h4>
            </div>
            <!-- contents of model here -->
            <div class="modal-body">
                <form action='order.php' method='POST'>
                    <label>choose which bike to make order</label>
                    <select name="bike_order" class="form-control">
                        <?php
                            $branch_id=$_SESSION['uid'];
                            drop_down_join_where($branch_id,"bike_id","branch_inventory","bike_id","brand_model","bikes");
                        ?>
                    </select>
                    <label>Enter the number of the items</label>
                    <input name="num" type="number" class="form-control" placeholder="number of bikes" required>
                    <!-- <intput name="number" type="number" class="form-control" required> -->

                    <!-- <intput name='makeorder' type="text" class="form-control" id="" placeholder="" required>            -->
                    <div class="modal-footer">
                        <button name='submit_order' type="submit" class="btn btn-primary">Make Order</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel Order</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>        

<!-- model to view message -->
<div id="myModalViewMessage" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Orders</h4>
            </div>
            <!-- contents of model here -->
            <div class="modal-body">
                <?php
                    $OrdersObj=new orders();
                    $res=$OrdersObj->show_orders();

                    if($res){
?>                      <table class="table table-bordered">
                            <tr>
                                <th>SN</th>
                                <th>Branch name</th>
                                <th>Bike</th>
                                <th>Number</th>
                            </tr>
                            <?php
                                $i=1;
                                foreach($res as $value){
                                    echo <<<ABC
                                    <tr>
                                        <td>$i</td>
                                        <td>{$value['branch_name']}</td>
                                        <td>{$value['brand_model']}</td>
                                        <td>{$value['bike_number']} 
                                            <form action='order.php' method='POST'>
                                                <button type='submit' name='clear_order' value='{$value['order_id']}' class='btn btn-primary'>checked</button>
                                            </form></td>
                                    </tr>
ABC;
                                    $i++;
                                }
                                       
                            ?>
                        </table>      
<?php                    }
?>          

                <div class="modal-footer">
                    <!-- <form action='order.php' method='POST'>
                        <button type="submit" name='clear_order' class="btn btn-danger">Clear Orders</button>
                    </form> -->    
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>

