<?php session_start(); ?>
<?php
header("Cache-Control: no-cache, must-revalidate");
header("Content-Type:text/html; charset=utf-8");
 
 @mysql_connect("localhost:3306", "root","mustcsie") or die("mysql connect fail");
 @mysql_selectdb("hadoop") or  die("DB connect fail");
 mysql_set_charset("utf8");
?>
<?php

$i=0;
$sql = "select name from `singer`";
$result = mysql_query($sql) or die('MySQL query error');
    while($row = mysql_fetch_array($result)){

		$i=$i+1;
    }
$_SESSION['total']=$i;


?>