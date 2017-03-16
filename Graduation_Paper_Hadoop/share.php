<?php session_start(); ?>
<?php require_once('connections/thrift.php'); ?>
<?php require_once('action/login.php'); ?>
<?php require_once('connections/php_python.php');  ?>
<html>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<meta property="og:title" content="MUST 畢業專題-Hadoop" />
<meta property="og:image" content="http://120.105.81.162/qrcode/img/<?php echo ppython("module::make","http://120.105.81.162/share.php?id=".$_GET['id']."&num=".$_GET['num'],"123");?>.jpg" />

<head>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/zh_TW/all.js#xfbml=1";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
</head>
<body>
<div id="fb-root"></div>
<div class="fb-share-button" data-href="http://120.105.81.162/share.php?id=<?php echo  $_GET['id']?>&num=<?php echo  $_GET['num']?>" data-type="button_count"></div>
<br><h2> 分享音樂清單</h2>
<?php
	if(!$_SESSION['login_id'] || $_GET['id'] != $_SESSION['login_id']){
?>
<form id="ki" name="form" method="post" action="index.php" >											
	<input  name="submit "type="submit" id="login" value="加入清單"  />			
</form>
<?php
	}
?>
<img src="http://120.105.81.162/qrcode/img/<?php echo ppython("module::make","http://120.105.81.162/share.php?id=".$_GET['id']."&num=".$_GET['num'],"123");?>.jpg"/>

</body>
</html>
<?php
	$_SESSION['id']=$_GET['id'];
	$_SESSION['num']=$_GET['num'];
?>
<?php
	echo '<br>';
	$table_name = 'account';
	$row_name = $_SESSION['id']."-".$_SESSION['num'];
	$fam_col_name = 'name:';
	$fam_col_name1 = 'song:index';
	$arr88 = $client->get($table_name, $row_name, $fam_col_name);
	foreach ( $arr88 as $k1=>$v1  ) {     		 
		$t11 =("{$v1->value}");		
	} 	
	echo '<h2>'.'分享ID:'.$_SESSION['id'].'<br>清單名稱:'.$t11.'</h2>';
?>
<?php 			

		for($r1=1;$r1<=100;$r1++){
		$table_name = 'account';
		$row_name = $_SESSION['id']."-".$_SESSION['num']."-".$r1 ;
		$fam_col_name = 'song:index';
		//aar8 圖片
		$arr8 = $client->get($table_name, $row_name, $fam_col_name);
			if( @$arr8[0]->value ){
				foreach ( $arr8 as $k1=>$v1  ) {     		 
				$t1 =("{$v1->value}");		
				} 		
				if( mb_strimwidth($t1, 0, 5) > 00000 ){
					//找歌手
					$table_name = 'music';
					$row_name = mb_strimwidth($t1, 0, 5) ;
					$fam_col_name = 'detail:songname';
					$arr81 = $client->get($table_name, $row_name , $fam_col_name);						
						foreach ( $arr81 as $k1=>$v1  ) {     		 
						$t11 =("{$v1->value}"); 	
						} 
					//歌名
					$row_name = $t1 ;
					$fam_col_name = 'detail:songname';
					$arr80 = $client->get($table_name, $row_name , $fam_col_name);
						foreach ( $arr80 as $k1=>$v1  ) {     		 
						$t22 =("{$v1->value}"); 	
						}	
				}
				else{
					continue;
				}
			}
	else{ break;}						
?>				
<div class="songbox"> 
<a href="#"><img class="songimg" src="mfs/images/<?php echo $t1; ?>.jpg"   /><a><br>
<p class="links" > 
<?php   
		echo '歌手名:'.$t22.'<br>';
		echo '歌曲名:'.$t11;
?> </a></p>
</div>
<?php
		}
?>	




