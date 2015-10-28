<?php
	require_once('core/init.php');
	//include ('includes/functions.php');

	class branch_inventory extends inventory{
		private $table_name1='branch_inventory';

		public function __construct($number=null,$brand_id=null,$branch_identifier=null,$limit=null){
			parent::__construct($number,$brand_id,$branch_identifier,$limit);
		}

		public function array_value(){
			$value=array();
			$value=parent::array_value();
			$value['branch_id']=$this->branch_id;
			return $value;
		}

		public function add_sub_inventory(){
			$myquery="SELECT branch_id,bike_id FROM $this->table_name1 WHERE bike_id='$this->bike_id' AND branch_id='$this->branch_id' ";
			$res=$this->db->select($myquery);
			if($res==false){
				$res=$this->db->insert("branch_inventory",$this->array_value());
				return $res;
			}
			else{
				$update=add_items_branch($this->table_name1,$this->branch_id,$this->bike_id,$this->number_of_items,$this->limit);
				return $update;
			}
		}

		public function show_inventory(){
		 	$branch_id=$_SESSION['uid'];
			$myquery="SELECT no_of_bikes,brand_model FROM bikes join branch_inventory ON bikes.bike_id=branch_inventory.bike_id WHERE branch_id='$branch_id' ";
			$res=$this->db->select($myquery);
			return $res;
		}

		public function limit($table){
			$myquery="SELECT branch_id,bike_limit,bike_id,no_of_bikes FROM $table WHERE bike_id='$this->bike_id' AND branch_id='$this->branch_id' ";
			$res=$this->db->select($myquery);
			if($res[0]['no_of_bikes'] < $res[0]['bike_limit']){
				return true;
			}
			else{
				return false;
			}
		}

		public function transferInfo($Branch_ID){
			$myquery="SELECT $Branch_ID,bike_id,no_of_bikes FROM $this->table_name1 WHERE branch_id='$Branch_ID' ";
			$res=$this->db->select($myquery);
			return $res; 
		}
	}        
?>