<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
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
if (empty($id) || empty($pw))
{
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
		echo "<script language=\"javascript\">"; 
		echo "window.alert('註冊成功!')"; 
		echo "</script>"; 
	}
}
}
?>
<?php
if (isset( $_POST['login_id']  )){
$loginid = $_POST['login_id'];
$loginpw = $_POST['login_password'];
@session_start();
$_SESSION['login_id']=$_POST['login_id'];
if ($loginid == '' || $loginpw == '')
{
    echo "<script language=\"javascript\">"; 
		echo "window.alert('請填入資料!')"; 
		echo "</script>";
}
else{ 
$table_name = 'account';
$fam_col_name = 'name';
$arr = $client->get($table_name, $loginid, $fam_col_name );
$arr1 = $client->get($table_name, $loginpw, $fam_col_name );
	if($loginid = @$arr[0]->value && $loginpw = @$arr1[0]->value ){
	    @session_start();
        $_SESSION['login']="1";
		echo "<script language=\"javascript\">"; 
		echo "window.alert('登入成功')"; 
		echo "</script>"; 
}else
{
echo "<script language=\"javascript\">"; 
		echo "window.alert('帳號或密碼錯誤')"; 
		echo "</script>"; 
}
}
}
?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="keywords" content="" />
<meta name="description" content="" />
<title>明新科技大學-Hadoop畢業專題</title>
<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700|Archivo+Narrow:400,700" rel="stylesheet" type="text/css">
<link href="register.css" rel="stylesheet" type="text/css" media="screen" />
 <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js?ver=1.4.2"></script>
    <script src="js/login.js"></script>

</head>
<body>
<div id="menu-wrapper">
	<div id="menu">
		<ul>
			<li class="current_page_item"><a href="index.php">首頁</a></li>
			<li><a href="search.php">搜尋紀錄</a></li>
			<li><a href="chanel.php">我的頻道</a></li>
			<li><a href="music.php">音樂</a></li>
			<li><a href="contact.php">聯絡我們</a></li>
			<li> <a href="#" id="loginButton"><span>Login</span><em></em></a>
            <div id="loginBox">       
					 <form id="loginForm" name="form" method="post" action="<?php $_SERVER["PHP_SELF"];?>" >
                        <fieldset id="body">
                            <fieldset>
                                <label for="email">帳號</label>
								<input name="login_id" type="text" class="text-field" />
                            </fieldset>
                            <fieldset>
                                <label for="password">密碼</label>
                                <input name="login_password" type="password" class="text-field" />
                            </fieldset>
                            <input type="submit" id="login" value="Sign in"  />
							 <input type="button" id="login" value="Register" onclick="location.href='register.php'" />
							</fieldset>	
                    </form>
              </div>
			</li>
	  	</ul>
	</div>
	<!-- end #menu --> 
</div>



	<!-- end #header -->
	<div id="page">
		<div id="page-bgtop">
			<div id="page-bgbtm">
			
				<!-- end #sidebar -->
			

				<div id="content">
							<!-- Register box-->
		<form class="register" name="form" method="post" action="<?php $_SERVER["PHP_SELF"];?>">

	<h2>Register</h2>

	<input name="name" type="text" class="text-field" placeholder="姓名" />
    <input name="id" type="text" class="text-field" placeholder="帳號" />
    <input name="password" type="password" class="text-field" placeholder="密碼" />
    <input name="password_correct" type="password" class="text-field" placeholder="請再輸入一次密碼" />
    <input name="Submit" type="submit" value="Register Account" class="button" />

</form>
			<!-- Register box End -->
			<div class="post">
						<div class="entry">
							</div>
					</div>
				
			  </div>
				<!-- end #content -->
				<div style="clear: both;">&nbsp;</div>
			</div>
		</div>
	</div>
	
	<!-- end #page --> 
</div>
<div id="footer">
	<p>&copy; 2013 Sitename.com. | Photos by <a href="http://fotogrph.com/">Fotogrph</a> | Design by <a href="http://www.freecsstemplates.org/" rel="nofollow">FreeCSSTemplates.org</a></p>
</div>
<!-- end #footer -->


</body>
</html>
