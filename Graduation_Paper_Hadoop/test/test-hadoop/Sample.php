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
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>MUST CSIE 畢業專題-hadoop</title>
<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700|Archivo+Narrow:400,700" rel="stylesheet" type="text/css">
<link href="css/framework.css" rel="stylesheet" type="text/css" media="screen" />

<script src="http://code.jquery.com/jquery-1.6.3.min.js"></script>
<script src="js/login.js"></script>
</head>

<body>

<div id="menu-wrapper">
	<div id="menu">
	<ul>
		<li class="current_page_item"><a href="index.php">首頁</a></li>
		<li><a href="search.php">搜尋紀錄</a></li>
		<li><a href="mylist.php">我的頻道</a></li>
		<li><a href="music.php">音樂</a></li>
		<li><a href="contact.php">聯絡我們</a></li>
		<li> <a href="#" id="loginButton"><span>登入</span></a>
			<div id="loginBox">                
				<form id="loginForm" name="form" method="post" action="<?php $_SERVER["PHP_SELF"];?>" >
					<fieldset id="body">
						<fieldset>
						<label for="email">帳號</label>
						<input name="id" type="text" class="text-field" />
						</fieldset>
					<fieldset>
						<label for="password">密碼</label>
						<input name="password" type="password" class="text-field" />
					</fieldset>
						<input type="submit" id="login" value="登入"  />
						<input type="button" id="login" value="註冊" onclick="location.href='register.php'" />
					</fieldset>	
				</form>
			</div>
		</li>
	</ul>
	</div>
</div>
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
		</div>
	</div>
</div>
<div id="footer">
	<p>&copy; 2013 Sitename.com. | Photos by <a href="http://fotogrph.com/">Fotogrph</a> | Design by <a href="http://www.freecsstemplates.org/" rel="nofollow">FreeCSSTemplates.org</a></p>
</div>
</body>
</html>