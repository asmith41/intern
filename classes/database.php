<?php
	class database{
		public $db_connect;
		protected static $instance;

		private function __construct(){			
			require_once('config.php');
			$this->db_connect=new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME) or die(mysql_error());;
			if ($this->db_connect->connect_errno) {
				echo "Failed to connect to MySQL: " . $db_connect->connect_error;
			}
		}

		public static function getInstance(){
			if (!isset(static::$instance)) {
				static::$instance = new Database();
			}
			return static::$instance;
		}

		protected function do_query($my_query){
			$query1=$this->db_connect->query($my_query);
			
			$data=array();
			if (is_object($query1)) {
				while($row = $query1->fetch_assoc()){
					$data[]=$row;
				}
				return $data;
			}
			return $query1;
		}

		public function select($my_query){
			$result=$this->do_query($my_query);

			if(count($result)>0){
				return $result;
			}
			else{
				return false;
			}
		}

		function insert($table,$values){
			$my_query="INSERT INTO ".$table." SET ";
			foreach($values as $key => $value){
				$my_query.=$key."='".$value."',";
			}
			$my_query=substr($my_query, 0 , -1);
			return $this->do_query($my_query);			
		}

		function update_central($table,$column,$value,$id_col,$id,$limit=null){
			if(isset($limit)){
				$my_query="UPDATE $table  SET $column ='$value',bike_limit='$limit' WHERE $id_col='$id' ";
				return $this->do_query($my_query);
			}
			else{
				$my_query="UPDATE $table  SET $column ='$value' WHERE $id_col='$id' ";
				return $this->do_query($my_query);
			}
		}

		function update_branch($table_name,$branch_id,$bike_id,$item_number,$limit=null){
			if(isset($limit)){
				$my_query="UPDATE $table_name SET no_of_bikes='$item_number',bike_limit= '$limit' WHERE branch_id='$branch_id' AND bike_id='$bike_id' ";
				return $this->do_query($my_query);			
			}
			else{
				$my_query="UPDATE $table_name SET no_of_bikes='$item_number' WHERE branch_id='$branch_id' AND bike_id='$bike_id' ";
				return $this->do_query($my_query);	
			}	
		}

		function delete($table_name,$column,$col_value){
			$my_query="DELETE FROM $table_name WHERE $column='$col_value' ";
			return $this->do_query($my_query);
		}
	}

	
?>
 