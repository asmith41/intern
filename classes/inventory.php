<?php
	require_once('core/init.php');
	require_once('includes/functions.php');

	class inventory{
		protected $table_name='inventory_table';
		protected $db;
		protected $bike_id;
		protected $number_of_items;
		protected $branch_id;
		protected $limit;
		
		//branch_identifier only null when called by invenoty class object else has value if called by branch inventory 
		//class. or all are null to call show inventory function in this class.
		public function __construct($number=null,$brand_id=null,$branch_identifier=null,$limit_set=null){
			$this->db=database::getInstance();
			$this->bike_id=$brand_id;
			$this->number_of_items=$number;
			$this->branch_id=$branch_identifier;
			$this->limit=$limit_set;

		}
		
		public function array_value(){
			$value=array();
			$value['bike_id']=$this->bike_id;
			$value['no_of_bikes']=$this->number_of_items;
			$value['bike_limit']=$this->limit;
			return $value;
		}	

		public function add_sub_inventory(){
			$myquery="SELECT bike_id FROM $this->table_name WHERE bike_id='".$this->bike_id."' ";
			$res=$this->db->select($myquery);
			//add new input if bikes doesnt exist
			if($res==false){
				$res=$this->db->insert($this->table_name,$this->array_value());
				return $res;
			}
			//update value if the bike already exists
			else{
				$id="bike_id";
				$col_name="no_of_bikes";
				$update=add_items_central($id,$this->table_name,$this->bike_id,$this->number_of_items,$col_name,$this->limit);
				return $update;

			}
		}

		public function show_inventory(){
			$myquery="SELECT no_of_bikes,brand_model FROM bikes join inventory_table ON bikes.bike_id=inventory_table.bike_id ";
			$res=$this->db->select($myquery);
			return $res;
		
		}

		public function limit($table){
			$myquery="SELECT bike_limit,bike_id,no_of_bikes FROM $table WHERE bike_id='$this->bike_id' ";
			$res=$this->db->select($myquery);

			if($res[0]['no_of_bikes'] < $res[0]['bike_limit']){
				return true;
			}
			else{
				return false;
			}
		}

		//to delete branch and update inventory number of bikes 
		public function transferUpdate($Branch_Id,$values){
			$value_array=array();
			if($values!=null){
				foreach ($values as $value) {
					$res=add_items_central('bike_id','inventory_table',$value['bike_id'],$value['no_of_bikes'],'no_of_bikes',null);
					//$res=$this->db->update($this->table_name,'no_of_bike',$value['no_of_bikes'],'bike_id',$value['bike_id']);
					var_dump($value['bike_id']);
					var_dump($value['no_of_bikes']);
				}
				if($res){
					return true;
				}
				return false;
			}
			else{
				return true;
			}
		}

	}	
?>