<?php

	class sales extends branch_inventory{
		protected $table_name='sales';

		function __construct($number=null,$brand_id=null,$branch_identifier=null){
			parent::__construct($number,$brand_id,$branch_identifier);	
		} 

		function array_value(){
			$value=array();
			$value['branch_id']=$this->branch_id;
			$value['bike_id']=$this->bike_id;
			$value['no_of_bikes']=$this->number_of_items;
			//$value['branch_id']=$this->branch_id;
			var_dump($value);
			return($value);
		}

		function add_sales(){
			return $this->db->insert($this->table_name,$this->array_value() );	
		}

		function transaction(){
			$my_query="SELECT bikes.brand_model,branch.branch_name,sales.no_of_bikes FROM sales join branch on branch.branch_id=sales.branch_id join bikes on bikes.bike_id=sales.bike_id ";
			return $this->db->select($my_query);
			
		}
	}
?>


