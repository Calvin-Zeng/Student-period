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
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>MUST CSIE 畢業專題-hadoop</title>
<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700|Archivo+Narrow:400,700" rel="stylesheet" type="text/css">
<link href="css/framework.css" rel="stylesheet" type="text/css" media="screen" />
<link href="css/two-columns.css" rel="stylesheet" type="text/css" media="screen" />
<script src="http://code.jquery.com/jquery-1.6.3.min.js"></script>
<script src="js/login.js"></script>
<script src="js/html5media.min.js"></script>
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
				<h2 class="title"><a href="#"><?php   
                        //找歌手
						$table_name = 'music';
						$row_name =$_GET['B'];
						$fam_col_name = 'detail:songname';
						$arr81 = $client->get($table_name, $row_name , $fam_col_name);						
						foreach ( $arr81 as $k1=>$v1  ) {     		 
						$t1 =("{$v1->value}"); 	
						} 
						//找歌名
						$table_name = 'music';
						$row_name = $_GET['A'] ;
						$fam_col_name = 'detail:songname';
						$arr80 = $client->get($table_name, $row_name , $fam_col_name);
						foreach ( $arr80 as $k1=>$v1  ) {     		 
						$t2 =("{$v1->value}"); 	
						}
						
						echo $t1."-".$t2;   //t1 代表 歌手    t2代表 歌名
							
				?> </a></h2>
				<h3>單曲點擊次數:<?php   
				
					$table_name = 'music';
					$row_name = $_GET['A'];
					$list = 'detail:hit';
					
					//改變是單曲點擊率
					$arr1 = $client->get($table_name, $row_name , $list);
					foreach ( $arr1 as $k=>$v  ) {		 
					$s = ("{$v->value}"); //從detail:hit 取數字 
					};
			
					$mutations = array(
					new Mutation( array(
					'column' => 'detail:hit',
					'value' => $s+'1'
					) ),
					);
					$client->mutateRow( $table_name, $row_name, $mutations ); //改變detail:hit的值
					
					$arr11 = $client->get($table_name, $row_name , $list);
					foreach ( $arr11 as $k1=>$v1  ) {     		 
					$t =("{$v1->value}"); //從detail:hit 取數字 放到 相對的rowkey	
					} 
					echo $t; //單曲點擊率 值
					?></h3>
					
				<h3>歌手點擊次數:<?php 	
					
					$table_name = 'music';
					$row_name = $_GET['B'];
					$list = 'detail:hit';
					//改變是歌手點擊率
					$arr2 = $client->get($table_name, $row_name , $list);
					foreach ( $arr2 as $k=>$v  ) {		 
					$s1 = ("{$v->value}"); //從detail:hit 取數字 
					};
			
					$mutations = array(
					new Mutation( array(
					'column' => 'detail:hit',
					'value' => $s1+'1'
					) ),
					);
					$client->mutateRow( $table_name, $row_name, $mutations ); //改變detail:hit的值 
					
					$arr21 = $client->get($table_name, $row_name , $list);
					foreach ( $arr21 as $k1=>$v1  ) {     		 
					$t1 =("{$v1->value}"); //從detail:hit 取數字 放到 相對的rowkey		
					} 
					echo $t1; //歌手點擊率 值
					?></h3>
	
				<div class="entry">
					<?php 

								$table_name = 'music';
								$row_name = $_GET['A'] ;
								$fam_col_name = 'detail:url';
								//aar8 圖片
								$arr8 = $client->get($table_name, $row_name , $fam_col_name);
						
								
								foreach ( $arr8 as $k1=>$v1  ) {     		 
								$t1 =("{$v1->value}");		
								} 		
								
					?>	
					<div class="infosongbox"> 
						<audio  src="./uploads/<?php echo $t1; ?>.mp3" controls preload></audio><br><br><br>
					</div>
					<div class="songinfobox">
						<p><h2>歌手:</h2></p>
						<h2><label for="author"><?php
						
						
						$table_name = 'music';
						$row_name = $_GET["B"];
						$fam_col_name = 'detail:songname';
						$arr = $client->get($table_name, $row_name , $fam_col_name);						
						foreach ( $arr as $k1=>$v1  ) {     		 
						$t1 =("{$v1->value}"); 	
						} 
						echo $t1;
						?></label></h2>
											
						<p><h2>歌名:</h2></p>
						<h2><label for="songname" ><?php
						$table_name = 'music';
						$row_name = $_GET['A']; 
						$fam_col_name = 'detail:songname';
						$arr1 = $client->get($table_name, $_GET['A'] , $fam_col_name);
						foreach ( $arr1 as $k1=>$v1  ) {     		 
						$t2 =("{$v1->value}"); 	
						}
						echo $t2;	
						
						?></label></h2>
						
						<p><h2>歌詞:</h2></p>

						<label for="songlyric"><?php
						
						$table_name = 'music';
						$row_name = $_GET['A']; 
						$fam_col_name = 'detail:lyrics';
						$arr2 = $client->get($table_name, $_GET['A'] , $fam_col_name);
						foreach ( $arr2 as $k1=>$v1  ) {     		 
						$t3 =("{$v1->value}"); 	
						}
						echo $t3;	
						
						?></label>
						
					</div>
					<!---entry end --->
				</div>
		</div>
	</div>
</div>
<div id="footer">
	<p>&copy; 2013 Sitename.com. | Photos by <a href="http://fotogrph.com/">Fotogrph</a> | Design by <a href="http://www.freecsstemplates.org/" rel="nofollow">FreeCSSTemplates.org</a></p>
</div>
</body>
</html>