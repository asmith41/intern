<?php
require_once('core/init.php');

	class Branch{
		public $db;
		private $username;
		private $password;
		private $branch_name;
		private $branch_location;
		private $table='branch';

		function __construct($un=null,$pwd=null,$branch_n=null,$branch_location=null){

			$this->username=$un;
			$this->password=$pwd;
			$this->branch_name=$branch_n;
			$this->branch_location=$branch_location;
			$this->db=database::getInstance();
		}

		public function login(){
		
			$my_query="SELECT username,password,branch_id,permission FROM branch WHERE username='".$this->username."' AND password='".$this->password."' ";
			$res=$this->db->select($my_query);
			if($res!=false){		
				$_SESSION['login']=true;
				$_SESSION['uid']=$res[0]['branch_id'];
				$_SESSION['username']=$res[0]['username'];
				$_SESSION['permission']=$res[0]['permission'];	
				return true;
			}
			else{					
				return false;
			}
		}

		public function array_values(){
			$value=array();
			$value['username']=$this->username;
			$value['password']=$this->password;
			$value['branch_name']=$this->branch_name;
			$value['location']=$this->branch_location;
			return $value;
		}

		 public function Register(){
		 	$my_query="SELECT username FROM branch WHERE username='".$this->username."' ";
		 	$res=$this->db->select($my_query);
			if($res==false){
				$res=$this->db->insert($this->table,$this->array_values());
				return $res;	
			}
			else{
				return false;
			}		 	
		 }

		 public function logout(){
		 	session_unset();
		 	session_destroy();
		 	return true;
		 }

		public function delete($branch_id){
			$my_query="SELECT branch_id from branch WHERE branch_id='$branch_id' ";
			$res=$this->db->select($my_query);
			if($res){
				$res=$this->db->delete($this->table,'branch_id',$branch_id);
				return($res);
			}
			else{
				return false;
			}
		}

		public function updatePwd($branch_id){
			$my_query="SELECT password from $this->table WHERE branch_id='$branch_id'";
			$res_select=$this->db->select($my_query);
			$res_update=$this->db->update_central($this->table,'password',$this->password,'branch_id',$branch_id,null);
			return($res_update);
		}

	}
?>

	