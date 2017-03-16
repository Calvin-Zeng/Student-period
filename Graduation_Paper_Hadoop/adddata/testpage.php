<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<?php require_once('connections/thrift.php'); ?>
<?php 
require_once('php_python.php'); 
?>
<?php
if (isset( $_POST['singer'])&&$_POST['musicclass']!="類別"){
$name = $_POST['singer'];
$musicname = $_POST['musicname'];
$lyrics = $_POST['Lyrics'];
$musicimgurl = $_POST['musicimgurl'];
$musicurl = $_POST['musicurl'];
$category = $_POST['musicclass'];
$table = "singer";
$fristsingerid = ppython("module::search",$table ,$name,'id');
 	if($fristsingerid){
		ppython("module::addindex",$table,$name);
	}
	else{
		ppython("module::addid",$table,'null',$name,0); //调用Python的add函数
	}
	$singerid = ppython("module::search",$table ,$name,'id');
	$singerindex = ppython("module::search",$table ,$name,'index');
	//Hbase-語法
	$table_name = 'music';
	$mutations = array(
					new Mutation( array(
			'column' => 'detail:songname',
			'value' => $name
			 ) )
	);
	$mutations1 = array(
					new Mutation( array(
			'column' => 'detail:hit',
			'value' => 0
			 ) )
	);
	$mutations2 = array(
					new Mutation( array(
			'column' => 'detail:songname',
			'value' => $musicname
			 ) )
	);
	$mutations3 = array(
					new Mutation( array(
			'column' => 'detail:lyrics',
			'value' => $lyrics
			 ) )
	);
	$mutations4 = array(
					new Mutation( array(
			'column' => 'detail:url',
			'value' => ($singerid+10000)."-".$singerindex
			 ) )
	);
	if(!$fristsingerid){
		//歌手名
		$client->mutateRow( $table_name, $singerid+10000, $mutations );
		//歌手點擊率
		$client->mutateRow( $table_name, $singerid+10000, $mutations1 );
	}
	//歌曲名
	$client->mutateRow( $table_name, ($singerid+10000)."-".$singerindex, $mutations2 );
	//歌曲點擊率
	$client->mutateRow( $table_name, ($singerid+10000)."-".$singerindex, $mutations1 );
	//歌詞
	$client->mutateRow( $table_name, ($singerid+10000)."-".$singerindex, $mutations3 );
	//URL
	$client->mutateRow( $table_name, ($singerid+10000)."-".$singerindex, $mutations4 );
	//
	ppython("module::download",$musicimgurl,($singerid+10000)."-".$singerindex);
	ppython("module::download",$musicurl,($singerid+10000)."-".$singerindex);
	$table = "category";
	$fristcategory = ppython("module::search",$table ,$category,'id');
 	if($fristcategory){
		ppython("module::addindex",$table,$category);
	}
	else{
		ppython("module::addid",$table,'null',$category,0);
	}
	$classid = ppython("module::search",$table ,$category,'id');
	$classindex = ppython("module::search",$table ,$category,'index');
	$table_name = 'category';
	$mutations5 = array(
					new Mutation( array(
			'column' => 'index',
			'value' => ($singerid+10000)."-".$singerindex
			 ) )
	);
	$client->mutateRow( $table_name, ($classid+10000)."-".$classindex, $mutations5 );
}
else{
echo "有少填!";
}
?>
<html>
<head>
<link rel="stylesheet" href="a.css" />
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
</head>
<body>
<form action="<?php $_SERVER["PHP_SELF"];?>" method="post">
				  <p>歌手: <input type="text" name="singer"  /></p>
				  <p>歌名: <input type="text" name="musicname" /></p>
				  <p>歌詞: <textarea name="Lyrics" style="width:400px; height:400px;" rows="15" cols="50" ></textarea></p>
				  <p>圖片網址:<input type="text" style="width:400px;" name="musicimgurl" /> </p>
				  <p>歌網址:<input type="text" name="musicurl" style="width:1000px;" /></p>
				  <p><select name="musicclass">
										<option >類別</option>
										<option value="POP" >POP</option>
										<option value="R&B">R&B</option>
										<option value="hiphop">hiphop</option>
										</select></p>
				  <input type="submit" value="Submit" /> 
 </form>	  
</body>
</html>