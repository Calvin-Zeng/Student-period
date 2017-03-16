<?php 
session_start(); 
require_once('connections/thrift.php');
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
if (isset( $_POST['name'])){
$name = $_POST['name'];
$id = $_POST['id'];
$pw = $_POST['password'];
$pw_correct = $_POST['password_correct'];
if (empty($id) || empty($pw)){ 
		  $response["status"] = "infoerror"; 
		  echo json_encode($response);	
		//exit;
	}elseif( $pw != $pw_correct){
			 $response["status"] = "passcorterror"; 
		  echo json_encode($response);
}
else{
	$table_name = 'account';
	$fam_col_name = 'name';
	$arr = $client->get($table_name, $id , $fam_col_name);
		if(@$arr[0]->value){
				  $response["status"] = "samefail"; 
				  echo json_encode($response);
		}else{
			//echo "此帳號未申請過!";
			$fields=array('name','passwd');
			$input=array($name,$pw);
			for($x=0; $x<count($fields);$x++){
					$mutations = array(
						new Mutation( array( 'column' => $fields[$x], 
											'value' => $input[$x]) 
											));
				$client->mutateRow( $table_name, $id, $mutations );
			}
			
			$mutations1 = array(
						new Mutation( array(
				'column' => 'list:list_num',
				'value' => 0
				 ) )
			);
			$client->mutateRow( $table_name, $id, $mutations1 );
				  $response["status"] = "success"; 
				  echo json_encode($response);
		}
	}
}
?>


