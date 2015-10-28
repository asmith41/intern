
<?php
	require_once 'core/init.php';

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
?>			<script>
				$(document).ready(function() {
        				$(document).scrollTop( $("#add_branch1").offset().top );  
    				});        		
			</script>
<?php		}
		else{
			$_GET['registered']=0;
			//header("location:admin_page.php?registration_success=1");
?>			<script>
				$(document).ready(function() {
        				$(document).scrollTop( $("#add_branch1").offset().top );  
    				});        		
			</script>
<?php		}
	}
?>



