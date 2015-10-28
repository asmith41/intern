<?php
	session_start();
	require_once('core/init.php');
      if(isset($_POST['update_password']) ){
		$user_id=$_SESSION['uid'];
		$new_password=md5($_POST['newPwd']);
		$BranchObj=new branch(null,$new_password,null,null);
		$res=$BranchObj->updatePwd($user_id);
		if($res){
			$_GET['update_success']=1;
			header("location:branch_page.php?update_success=1");
		}
		else{
			header("location:branch_page.php?update_success=0");
		}
	}
?>


