<?php 
session_start(); 
require_once('connections/thrift.php');
require_once('connections/mysql.php'); 
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");

		$table_name = 'account';
		$row_name = $_POST['login_id']."-".$_GET['num'] ;
		$fam_col_name = 'name:';
		
		$arr13 = $client->get($table_name, $row_name , $fam_col_name);

												
			$mutations = array(
				new Mutation( array(
					'column' => 'name',
					'value' => ''
				) ),
			);
		$client->mutateRow( $table_name, $row_name, $mutations );
		$response["status"] = "listdelete";		
		echo json_encode($response);
	
	
	
	
?>