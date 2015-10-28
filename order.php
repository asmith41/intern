<?php
	require_once('core/init.php');
	session_start();

	if(isset($_POST['submit_order'])){
		$branch_id=$_SESSION['uid'];
		$bike_id=$_POST['bike_order'];
		$number=$_POST['num'];
		var_dump($branch_id);
		var_dump($bike_id);
		var_dump($number);

		$OrderObj=new orders($bike_id,$branch_id,$number);
		$res=$OrderObj->add_order();
		
		if($res){
			header("location:branch_page.php?make_order=1");
		}
	}

	if(isset($_POST['clear_order'])){
		$col_value=$_POST['clear_order'];
		$OrderObj=new orders();
		var_dump($OrderObj);
		$res=$OrderObj->clear('bike_order','order_id',$col_value);
		var_dump($res);
		if($res){
			header("location:admin_page.php?clear_order=1");
		}
	}


?>