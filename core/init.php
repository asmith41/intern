<?php
ini_set('error_reporting',E_ALL);
spl_autoload_register (function ($class){
	require_once 'classes/'. $class . '.php';
});
?>