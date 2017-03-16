<?php
require_once('adddata/php_python.php'); 
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");

if ($_FILES) {
   // 上傳檔案的目錄
	$dirname = "photouploads"; //指定上傳資料夾
	// 儲存上傳的圖檔
   mkdir($dirname, 0777, true); 
  //$file = $dirname . "/" . "123" . ".jpg"; 
  $tmp_name = $_FILES["file"]["tmp_name"];
  $name = $_FILES["file"]["name"];
  $file=$dirname . "/" .$name;
 //$file = $dirname . "/" . $_FILES['file']['tmp_name'] . ".jpg"; 
@move_uploaded_file($tmp_name, $file);
/*
$x=ppython("module::search","http://120.105.81.162/photouploads/"+$name+"","123");
echo json_encode($x);*/
}

if($_GET["url"]){
$x=ppython("module::search",$_GET['url'],"123");
echo $x;
}


?>