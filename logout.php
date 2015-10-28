<?php
  require_once('core/init.php');

  $Logout_Obj=new Branch();
  $logout=$Logout_Obj->logout();
  
  if($logout==true){
  	header("location:index.php");
  }

?>