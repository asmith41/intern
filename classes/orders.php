<?php
	class orders{
		private $table_name='bike_order';
		private $bikes_id;
		private $branch_identifier;
		private $number_of_bikes;
		private $db;

		public function __construct($BikeId=null,$BranchId=null,$Number=null){
			$this->bikes_id=$BikeId;
			$this->branch_identifier=$BranchId;
			$this->number_of_bikes=$Number;
			$this->db=database::getInstance();
		}

		public function array_values(){
			$value=array();
			$value['branch_id']=$this->branch_identifier;
			$value['bike_id']=$this->bikes_id;
			$value['bike_number']=$this->number_of_bikes;
			return $value;
		}


		public function add_order(){
			return $this->db->insert($this->table_name,$this->array_values());
		}

		public function show_orders(){
			$myquery="SELECT bikes.brand_model,branch.branch_name,bike_order.bike_number,bike_order.order_id FROM bike_order join branch on bike_order.branch_id=branch.branch_id join bikes on bike_order.bike_id=bikes.bike_id ";	
			return $this->db->select($myquery);
		}

		public function clear($table_name,$col,$col_value){
			return $this->db->delete($table_name,$col,$col_value);
		}
	}
?>