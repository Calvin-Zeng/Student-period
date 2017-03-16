<?php 
session_start(); 
require_once('connections/thrift.php');
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
if (isset($_POST['login_id'])){
	$loginid = $_POST['login_id'];
	$loginpw = $_POST['login_password'];
	//@session_start();
	$_SESSION['login_id']=$_POST['login_id']; 
	if ($loginid == '' || $loginpw == ''){
		$response["status"] = "notpass"; 
	    echo json_encode($response);
	}
	else{ 
		$table_name = 'account';
		$fam_col_name = 'name';
		$arr = $client->get($table_name, $loginid, $fam_col_name );

		$table_name = 'account';
		$fam_col_name = 'passwd';
		$arr1 = $client->get($table_name, $loginid, $fam_col_name );
		
		
			if(  @$arr[0]->value != '' && $loginpw == @$arr1[0]->value ){
			//@session_start();
			$response["status"] = "success";
			$response["login"] = "1"; 			
			echo json_encode($response);
		}else{
			  $response["status"] = "fail"; 
			  echo json_encode($response);
		}
	}
}
?>



