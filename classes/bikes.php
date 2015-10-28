<?php
	class bikes{
		private $table_name='bikes';
		private $brand_name;
		private $db;

		public function __construct($bike_brand){
			$this->db=database::getInstance();
			$this->bike_name=$bike_brand;

		}

            public function array_values(){
            	$value=array();
			$value['brand_model']=$this->bike_name;
			return $value;
            }

		public function add_bikes(){
			$myquery="SELECT bike_id,brand_model FROM $this->table_name WHERE brand_model='".$this->bike_name."' ";
			$res=$this->db->select($myquery);
			if($res==false){
				$res=$this->db->insert($this->table_name,$this->array_values());
				return $res;
			}
			else{
			return false;
			}
		}
	}
?>