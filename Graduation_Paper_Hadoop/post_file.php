<?php session_start(); ?>
<?php 
require_once('./adddata/php_python.php'); 
?>
<?php

// If you want to ignore the uploaded files, 
// set $demo_mode to true;

$demo_mode = false;
//$upload_dir = 'uploads/';
$upload_dir = './mfs/user/'.$_SESSION['login_id'].'/';
$oldumask = umask(0);
if (!is_dir('./mfs/user/'.$_SESSION['login_id'])) {      //檢察upload資料夾是否存在
	
	if (!mkdir($upload_dir, 0777))  //不存在的話就創建upload資料夾
	die ("上傳目錄不存在，並且創建失敗");
	
}

$allowed_ext = array('mp3');


if(strtolower($_SERVER['REQUEST_METHOD']) != 'post'){
	exit_status('Error! Wrong HTTP method!');
}


if(array_key_exists('pic',$_FILES) && $_FILES['pic']['error'] == 0 ){
	
	$pic = $_FILES['pic'];

	if(!in_array(get_extension($pic['name']),$allowed_ext)){
		exit_status('Only '.implode(',',$allowed_ext).' files are allowed!');
	}	

	if($demo_mode){
		
		// File uploads are ignored. We only log them.
		
		$line = implode('		', array( date('r'), $_SERVER['REMOTE_ADDR'], $pic['size'], $pic['name']));
		file_put_contents('log.txt', $line.PHP_EOL, FILE_APPEND);
		
		exit_status('Uploads are ignored in demo mode.');
	}
	
	
	// Move the uploaded file from the temporary 
	// directory to the uploads folder:
	$table="my_list";
	if(move_uploaded_file($pic['tmp_name'], $upload_dir.$pic['name'])){
		ppython("module::addlistid",$table,'null',$_SESSION['login_id'],$pic['name']);
		umask($oldumask);
		exit_status('File was uploaded successfuly!');
	}
	
}

exit_status('Something went wrong with your upload!');


// Helper functions

function exit_status($str){
	echo json_encode(array('status'=>$str));
	exit;
}

function get_extension($file_name){
	$ext = explode('.', $file_name);
	$ext = array_pop($ext);
	return strtolower($ext);
}
?>