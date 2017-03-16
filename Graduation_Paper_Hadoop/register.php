<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<!--
Design by Free CSS Templates
http://www.freecsstemplates.org
Released for free under a Creative Commons Attribution 2.5 License

Name       : Heavenly Bliss  
Description: A two-column, fixed-width design with dark color scheme.
Version    : 1.0
Released   : 20130517

-->
<?php session_start(); ?>
<?php require_once('connections/thrift.php'); ?>
<?php require_once('action/login.php'); ?>
<?php require_once('connections/mysql.php'); ?>
<?php
if (isset( $_POST['name'])){
$name = $_POST['name'];
$id = $_POST['id'];
$pw = $_POST['password'];
$pw_correct = $_POST['password_correct'];
if (empty($id) || empty($pw)){
		echo "<script language=\"javascript\">"; 
		echo "window.alert('請務必填齊必要資料')"; 
		echo "</script>"; 
		//exit;
	}elseif( $pw != $pw_correct){
		echo "<script language=\"javascript\">"; 
		echo "window.alert('密碼沒有相符合')"; 
		echo "</script>"; 
}
else{
	$table_name = 'account';
	$fam_col_name = 'name';
	$arr = $client->get($table_name, $id , $fam_col_name);
		if(@$arr[0]->value){
			echo "<script language=\"javascript\">"; 
			echo "window.alert('此帳號已申請過')"; 
			echo "</script>"; 
			//echo "此帳號已申請過!";
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
			
			echo "<script language=\"javascript\">"; 
			echo "window.alert('註冊成功!')"; 
			echo "</script>"; 
						
			$url = "http://120.105.81.162/";
			echo "<script type='text/javascript'>";
			echo "window.location.href='$url'";
			echo "</script>"; 
			
		}
	}
}
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>MUST CSIE 畢業專題-hadoop</title>
<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700|Archivo+Narrow:400,700" rel="stylesheet" type="text/css">
<link href="css/framework.css" rel="stylesheet" type="text/css" media="screen" />
<link href="css/index.css" rel="stylesheet" type="text/css" media="screen" />
<link href="css/register.css" rel="stylesheet" type="text/css" media="screen" />
<script src="http://code.jquery.com/jquery-1.6.3.min.js"></script>
<script src="js/login.js"></script>
</head>

<body>

<?php
if (isset($_SESSION['login'])){
	require_once('action/loginButton-y.php');
}
else{
	require_once('action/loginButton-n.php');
}
?>

<div id="banner-wrapper">
	<div id="banner"><a href="#"><img src="images/banner_img.jpg" width="100%" height="200"/></a></div>
</div>
<div id="wrapper"> 
	<div id="page">
		<!--首頁沒有sidebar
 		<div id="sidebar">
		</div> 
		-->
		<div id="content">
			<form class="register" name="form" method="post" action="<?php $_SERVER["PHP_SELF"];?>">
				<h2>Register</h2>
				<input name="name" type="text" class="text-field" placeholder="姓名" />
				<input name="id" type="text" class="text-field" placeholder="帳號" />
				<input name="password" type="password" class="text-field" placeholder="密碼" />
				<input name="password_correct" type="password" class="text-field" placeholder="請再輸入一次密碼" />
				<input name="Submit" type="submit" value="Register Account" class="button" />
			</form>
		</div>
	</div>
</div>
<div id="footer">
	<p>&copy; 2013 Sitename.com. | Photos by <a href="http://fotogrph.com/">Fotogrph</a> | Design by <a href="http://www.freecsstemplates.org/" rel="nofollow">FreeCSSTemplates.org</a></p>
</div>
</body>
</html>