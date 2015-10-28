
<?php
	session_start();
	require_once ('core/init.php');

	if(isset($_POST['submit'])){
		$username=$_POST['username'];
		$password=md5($_POST['password']);	
		$funObj=new Branch($username,$password,null,null);
		$user=$funObj->login();

		if($user==true){
	  		if($_SESSION['permission']==1){
	  			header("location:admin_page.php");
	  		}
	  		elseif($_SESSION['permission']==0){
	  			header("location:branch_page.php");
	  		}
	  	}		
	  	else{
	  		header("location:index.php?login_failed=1");	
	  	}
	 }
?>
