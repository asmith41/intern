<?php
include('core/init.php'); 
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Multi Branch Cycle Record</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
			<link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
			<link rel="stylesheet" type="text/css" href="assets/css/style.css"> 
	<style>
		body{ 
    		background-image: url('assets/images/b.jpg');
    		background-repeat: no-repeat;
    		background-attachment: fixed;
		}
	</style>
	</head>
	<body>
		<div class="container-fluid">
			<div class="col-md-4"></div>
			<div class ="col-md-4">
				<div id="in-border">
					<p id="p1">BIKES</p>
					<form action="login.php" method="POST">
  						<div class="form-group">
    						<label for="exampleInputEmail1">User Name</label>
    						<input name="username" type="text" class="form-control" id="exampleInputEmail1" placeholder="Username" required>
  						</div>
  					
  						<div class="form-group">
    						<label for="exampleInputPassword1">Password</label>
    						<input name="password" type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" required>
  						</div>

						<?php 
							if (isset($_GET['login_failed']) && $_GET['login_failed'] == '1') {
								echo '<span class="label label-danger">Please check for the valid credential</span>';
							}
							elseif(isset($_GET['login_failed']) && $_GET['login_failed'] == '2'){
								echo '<span class="label label-danger">you are already loged in</span>';	
							}		 
						?>		
						<input type="submit" name="submit" id="button1" value ="Login" class="btn btn-primary">
					</form>
				</div>
			</div>
		</div>
	</body>
</html>
