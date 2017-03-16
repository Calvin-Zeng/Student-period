<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<?php 
require_once('php_python.php'); 
?>
<?php
if (isset( $_POST['singer'])){
$name = $_POST['singer'];
$musicname = $_POST['musicname'];
$lyrics = $_POST['Lyrics'];
$musicimg = $_POST['musicimg'];
$musicimgurl = $_POST['musicimgurl'];
$musicurl = $_POST['musicurl'];
$table = "singer";
$singerid = ppython("module::searchid",$table ,$name);
	if($singerid==0){
		$ret = ppython("module::addsinger",$table,'null',$name,0); //调用Python的add函数
		$singerid = ppython("module::searchid",$table ,$name);
	}
	else{
		$ret = ppython("module::addindex",$table,$name);
		$singerid = ppython("module::searchid",$table ,$name);
	}
	ppython("module::download",$musicimgurl);
	ppython("module::download",$musicurl);
}

?>
<html>
<head>
<link rel="stylesheet" href="a.css" />
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
</head>
<body>
<form action="<?php $_SERVER["PHP_SELF"];?>" method="post">
				  <p>歌手: <input type="text" name="singer" value="測試" /></p>
				  <p>歌名: <input type="text" name="musicname"value="歌名" /></p>
				  <p>歌詞: <textarea name="Lyrics" style="width:400px; height:400px;" rows="15" cols="50" >123</textarea></p>
				  <p>圖片: <input type="text" name="musicimg" />  </p>
				  <p>圖片網址:<input type="text" style="width:400px;" name="musicimgurl" value="http://ccmixter.org/content/stellarartwars/delticccm.jpg"/> </p>
				  <p>歌網址:<input type="text" name="musicurl" style="width:1000px;" value="http://ccmixter.org/content/stellarartwars/stellarartwars_-_This_Is_The_Age_Of_Cocaine.mp3"/></p>
				  <p><select name="musicclass">
										<option >類別…</option>
										<option value="1" >1</option>
										<option value="2">2</option>
										<option value="3">3</option>
										</select>  <input type="text" name="musicclass" /></p>
				  <input type="submit" value="Submit" /> 
 </form>	  
</body>
</html>