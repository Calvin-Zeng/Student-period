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
	$table_name = 'account';
	$row_name = $_SESSION['login_id'];
	$fam_col_name = 'list:list_num';
	$arr = $client->get($table_name, $row_name , $fam_col_name);
?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>MUST CSIE 畢業專題-hadoop</title>
<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700|Archivo+Narrow:400,700" rel="stylesheet" type="text/css">
<link href="css/framework.css" rel="stylesheet" type="text/css" media="screen" />
<link href="css/two-columns.css" rel="stylesheet" type="text/css" media="screen" />
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
 		<div id="sidebar">
			<!--樣板-樣板-樣板-樣板-樣板-樣板-樣板-樣板-->
			<li>
				<h2>Archives</h2>
				<ul>
					<li><a href="#">Aliquam libero</a></li>
					<li><a href="#">Consectetuer adipiscing elit</a></li>
					<li><a href="#">Metus aliquam pellentesque</a></li>
					<li><a href="#">Suspendisse iaculis mauris</a></li>
					<li><a href="#">Urnanet non molestie semper</a></li>
					<li><a href="#">Proin gravida orci porttitor</a></li>
				</ul>
			</li>
			<!--樣板結束-樣板結束-樣板結束-樣板結束-樣板結束-->
		</div> 
		<div id="content">
			<div class="post">
				<h2 class="title"><a href="#">我的頻道</a></h2>
				<div class="addbox">
					<div class="dropdown">
						<select name="one" class="dropdown-select">
						<option >移置…</option>
							<?php
								   for ($x=1;$x<=$arr[0]->value;$x++){
										$arr1 = $client->get($table_name, $_SESSION['login_id']."-".$x , "name");
							?>
						<option value="<?php echo $x ?>" style="background-image:url(images/add.png);"><?php echo $arr1[0]->value?></option>
							<?php
								}
							?>
						</select>
					</div>
					<div class="dropdown">
						<select name="one1" class="dropdown-select">
							<option value="">選取檔案</option>
							<option value="1">全選</option>
							<option value="2">全不選</option>
						</select>
					</div>
				<a href="#"><img  class="addimg" src="images/add.png"    /><a>
				<a href="#"><img  class="addimg" src="images/delete.png"     /><a>
				</div >
				<div class="songbox"> 
				<a href="#"><img class="songimg" src="images/test.jpg"   /><a><br>
				<p class="links" > <input type="checkbox"    class="songcheck" name="song1" value="黃韻玲-美好歲月"/></input><a href="info.php"> 黃韻玲-美好歲月 </a></p>
				</div>
				<div class="songbox"> 
				<a href="#"><img class="songimg" src="images/test.jpg"   /><a><br>
				<p class="links" > <input type="checkbox"    class="songcheck" name="song1" value="黃韻玲-美好歲月"/></input><a href="info.php"> 黃韻玲-美好歲月 </a></p>
				</div>
			</div>
		</div>
	</div>
</div>
<div id="footer">
	<p>&copy; 2013 Sitename.com. | Photos by <a href="http://fotogrph.com/">Fotogrph</a> | Design by <a href="http://www.freecsstemplates.org/" rel="nofollow">FreeCSSTemplates.org</a></p>
</div>
</body>
</html>