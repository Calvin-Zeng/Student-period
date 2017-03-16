<?php session_start(); ?>
<?php require_once('connections/thrift.php'); ?>
<?php require_once('connections/mysql.php'); ?>
<?php
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
?>
<?php
	  if(isset($_POST['contact_message']))
	  {
		  $con=$_POST['contact_message'];	
		  $title= $_POST['id'];
		  $sql="insert into `account`  (`id`,`name`,`dates`,`contents`,`reply`) values (null,'$title',now(), '$con' ,'' )";
		  mysql_query($sql);
		  $response["status"] = "pass"; 
		  echo json_encode($response);
	  }  
	
	
	
		if(isset($_POST['login_id']))
		{
			$_SESSION['login_id']=$_POST['login_id'];
			$name=$_SESSION['login_id'];
			$sql="select * from `account` where name= '".$name."'";
			$query=mysql_query($sql);
			while ($rs=mysql_fetch_array($query)){
			$data_array[] = array (
										"name" => $rs["name"],
										"dates" => $rs["dates"],
										"contents" => $rs["contents"],
										"reply" => $rs["reply"]
								);
					}
			echo json_encode($data_array);
		}
?>