<?php

require_once('core/init.php');

	$db=database::getInstance();

	function add_sub(inventory $obj){
		return $obj->add_sub_inventory();
	}

	function drop_down_join_where($table_id1, $reference_column1, $table_name1, $table_id2, $column2, $table_name2 ){
		global $db;
		if(isset($table_id2)){
			$myquery="SELECT $table_name2.$table_id2,$column2 
			FROM $table_name2 inner join $table_name1 on $table_name2.$table_id2 =$table_name1.$reference_column1 WHERE branch_id=$table_id1 ";
			$values=$db->select($myquery);
			$rows=count($values);
			for($i=0;$i<$rows;$i++){
				echo "<option value= '".$values[$i][$table_id2]."'>".$values[$i][$column2]."</option> ";
			}
		}

	}

	function drop_down_join($table_id1, $reference_column1, $table_name1, $table_id2, $column2, $table_name2 ){
		global $db;
		if(isset($table_id2)){
			$myquery="SELECT $table_name2.$table_id2,$column2 
			FROM $table_name2 inner join $table_name1 on $table_name2.$table_id2 =$table_name1.$reference_column1 ";
			$values=$db->select($myquery);
			$rows=count($values);

			for($i=0;$i<$rows;$i++){
				echo "<option value= '".$values[$i][$table_id2]."'>".$values[$i][$column2]."</option> ";
			}
		}
	}

	function drop_down( $id, $column, $table ){
		global $db;
		$myquery="SELECT $id,$column FROM $table";
      	$values=$db->select($myquery);	
      	$rows=count($values);
      	for($i=0;$i<$rows;$i++){
            	echo "<option value= '".$values[$i][$id]."'>".$values[$i][$column]."</option> ";
            }
	
	}
      
 	function add_items_central($id,$table_name,$id_value,$item_number,$col_name,$limit){
 			global $db;

 			$myquery="SELECT $col_name FROM $table_name WHERE $id = ".$id_value." ";
 			$res=$db->select($myquery);
 			$item_number=$item_number + $res[0][$col_name];
 			//$limit=$res[0]['bike_limit'];
 	
 		//check if the value is negative
 		if(($item_number)<=0){
 			return false;
 		}
 		//update values
 		else{
 			if(isset($limit)){
 				$res=$db->update_central($table_name,$col_name,$item_number,$id,$id_value,$limit);
				return true;
			}
			else{
				$res=$db->update_central($table_name,$col_name,$item_number,$id,$id_value);
				return true;
			}
		}
	}

	function add_items_branch($table_name,$branch_id,$bike_id,$item_number,$limit){
		global $db;
		$myquery="SELECT bike_id,branch_id,no_of_bikes from $table_name WHERE branch_id= '$branch_id' AND bike_id= '$bike_id' ";
		$res=$db->select($myquery);
		$item_number=$item_number + $res[0]['no_of_bikes'];

		if($item_number<=0){
			return false;
		}
		else{
			if(isset($limit)){
				$res=$db->update_branch($table_name,$branch_id,$bike_id,$item_number,$limit);
				return $res;
			}
			else{
				$res=$db->update_branch($table_name,$branch_id,$bike_id,$item_number);
				return $res;	
			}
		}
	}
?>