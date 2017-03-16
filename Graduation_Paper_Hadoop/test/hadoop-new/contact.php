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
if(!empty($_POST['button'])){
	@session_start(); 
	@$a =$_SESSION['login'];
	if( $a == 1){	
	  $con=$_POST['contact_message'];	
	  $title= $_SESSION['login_id'];
      $sql="insert into `account`  (`id`,`name`,`dates`,`contents`,`reply`) values (null,'$title',now(), '$con' ,'' )";
      mysql_query($sql);
	}
	else{
	    echo "<script language=\"javascript\">";
		echo "window.alert('登入帳號')";
		echo "</script>";
	}
}

?>	
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>MUST CSIE 畢業專題-hadoop</title>
<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700|Archivo+Narrow:400,700" rel="stylesheet" type="text/css">
<link href="css/framework.css" rel="stylesheet" type="text/css" media="screen" />
<link href="css/contact-form.css" type="text/css" rel="stylesheet">
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

		<div id="content">
		</div>
		-->
		<?php
		@session_start();
		$x= $_SESSION['login_id'];
		$sql="select * from `account` where name='$x' ";
		$query=mysql_query($sql);
		while ($rs=mysql_fetch_array($query)){
		?>
		<div class="commentbox">
			<div class="formfield">
				<label class="commenttitle" >Name：</label><label class="commenttitle" for="name"><?php echo $rs['name']?></label>
			</div >
			<div class="formfield">
				<label class="commenttitle" >Date：</label><label class="commenttitle" for="date"><?php echo $rs['dates']?></label>
			</div >
			<div class="formfield">
				<label class="commenttitle" >Message：</label><label class="commenttitle" for="Message"><?php echo $rs['contents']?></label>
			</div >
			<div class="formfield">
				<label class="commenttitle" >Reply:</label><label class="commenttitle" for="Reply"><?php echo $rs['reply']?></label>
			</div >
		</div>	
		<hr>
		<?php
		}
		?>
		<div class="form-wrapper">
			<form action="contact.php" method="post" id="comment">
				<fieldset>
					<legend>聯絡我們</legend>
					<div class="formfield">
						<label class="title" for="contact_message"></label>
						<textarea name="contact_message" class="required" ></textarea>
					</div><!-- /.formfield -->
				</fieldset>
				<div class="formfield">
					<input type="submit" class="button" name="button" value="comment" />
				</div><!-- /.formfield -->
			</form><!-- /#email -->	
		</div> <!-- .form-wrapper -->
	</div>
</div>
<div id="footer">
	<p>&copy; 2013 Sitename.com. | Photos by <a href="http://fotogrph.com/">Fotogrph</a> | Design by <a href="http://www.freecsstemplates.org/" rel="nofollow">FreeCSSTemplates.org</a></p>
</div>
</body>
</html>