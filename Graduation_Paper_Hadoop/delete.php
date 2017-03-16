<?php session_start(); ?>
<?php require_once('connections/thrift.php'); ?>
<?php require_once('action/login.php'); ?>
<?php require_once('connections/mysql.php'); ?>
<?php

		$table_name = 'account';
		$row_name = $_SESSION['login_id']."-".$_GET['num'] ;
		$fam_col_name = 'name:';
		
		$arr13 = $client->get($table_name, $row_name , $fam_col_name);

												
			$mutations = array(
				new Mutation( array(
					'column' => 'name',
					'value' => ''
				) ),
			);
		$client->mutateRow( $table_name, $row_name, $mutations );
		
		header("Location: mylist.php");
	
	
	
	
?>