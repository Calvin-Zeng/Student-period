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
			<div class="post">
				<h2 class="title"><a href="#">熱門音樂</a></h2>
				<div class="songbox"> 
				<?php
				$max=0;
				$number[100];  //給detail:hit 存取陣列中
				$number1[100]; //歌曲名 存取陣列中
				$number2[100]; //歌手 存取陣列中
				$a[100];
				$a1[100];
				$a2[100];
				$i=-1;
				for($x=1;$x<5;$x++){
					for($y=0;$y<10;$y++){
					    $table_name = 'music';
						$row_name = $x ;
						$fam_col_name = 'detail:hit';
						$arr = $client->get($table_name, $row_name."-".$y , $fam_col_name);	

						if( $arr[0]->value ){
							foreach ( $arr as $k1=>$v1  ) {     		 
							$t1 =("{$v1->value}"); 	
							} 				
								$i++;
								$number[$i]= $t1;	//給detail:hit 存取陣列中
								$number1[$i]= $row_name."-".$y; //單曲rowkey 存取陣列中
								$number2[$i]= $row_name;  //存取陣列中
						}
						else{ break;}						
					}
				}								
						for($register=0;$register<=$i;$register++){			//把存好的number[]另存到$a[]陣列中
								$a[$register]=$number[$register];
								$a1[$register]=$number1[$register];
								$a2[$register]=$number2[$register];						
						}						
					   ///找 最大值與單曲rowkey
						for($max_rowkey=0;$max_rowkey<=100;$max_rowkey++){
						
							if( $number[$max_rowkey] > $max ){
								$max=$number[$max_rowkey];
								$name=$number1[$max_rowkey];
								$num=$number2[$max_rowkey];
								}														
						}											
					    for($first=0;$first<$i;$first++){   //排序法 把大小作排列
							for($j1=$i;$j1>$first;$j1--){
									if($number[$j1]>$number[$j1-1]){
									$tmp=$number[$j1];
									$number[$j1]=$number[$j1-1];
									$number[$j1-1]=$tmp;
									}
							}	
						}
				?>			
				<a href="#"><img class="songimg" src="images/<?php  echo $name;  ?>.jpg"   /><a><br>
				<p class="links" > <a href="info.php?A=<?echo $name;?>&B=<?echo $num; ?>"> <?php		//列出最大hit的內容				
						$table_name = 'music';
						$row_name = $name  ;
						$fam_col_name = 'detail:songname';
						$arr1 = $client->get($table_name, $row_name , $fam_col_name);	
						foreach ( $arr1 as $k1=>$v1  ) {     		 
						$t3 =("{$v1->value}"); 	
						} 						
						echo $t3;												
				?>
				</a></p>						
				</div>
				<?php
				$add=0;
				for($second=0;$second<6;$second++){   // 列出最2~6名的內容
					$add=$add+1;
						for($third=0;$third<$i+1;$third++){
							    
								if( $number[$add] == $a[$third] ){
									
									$name_other = $a1[$third];
									$num_other = $a2[$third];
									
									break;
								}
						}				
				?>	
				<div class="songbox">
					<img class="musicimg"src="images/<?php  echo $name_other;  ?>.jpg" width="150px"  height="30%" />
					<p class="links" > <a href="info.php?A=<?echo $name_other;?>&B=<?echo $num_other; ?>"> <?php					
						$table_name = 'music';
						$row_name = $name_other  ;
						$fam_col_name = 'detail:songname';
						$arr2 = $client->get($table_name, $row_name , $fam_col_name);	
						foreach ( $arr2 as $k1=>$v1  ) {     		 
						$t4 =("{$v1->value}"); 	
						} 						
						echo $t4;												
				?>
				</a></p>
				</div>
				<?php				
				}
				?>			
			</div>
			<br><br><br><br><br><br><br><br>
			<hr>
			<div class="post">
				<h2 class="title"><a href="#">熱門頻道</a></h2>
				<div class="songbox"> 
				<a href="#"><img class="songimg" src="images/test.jpg"   /><a><br>
				<p class="links" > <a href="info.php"> 黃韻玲-美好歲月 </a></p>
				</div>
				<div class="songbox">
					<img class="musicimg"src="images/test.jpg" width="150px"  height="50%" />
					<p class="links" > <a href="info.php"> 阿禡古老的歌 </a></p>
				</div>
				<div class="songbox">
					<img class="musicimg"src="images/test.jpg" width="150px"  height="50%" />
					<p class="links" > <a href="info.php"> 阿禡古老的歌 </a></p>
				</div>
				<div class="songbox">
					<img class="musicimg"src="images/test.jpg" width="150px"  height="50%" />
					<p class="links" > <a href="info.php"> 阿禡古老的歌 </a></p>
				</div>
				<div class="songbox">
					<img class="musicimg"src="images/test.jpg" width="150px"  height="50%" />
					<p class="links" > <a href="info.php"> 阿禡古老的歌 </a></p>
				</div>
			</div>
		</div>
	</div>
</div>
<div id="footer">
	<p>&copy; 2013 Sitename.com. | Photos by <a href="http://fotogrph.com/">Fotogrph</a> | Design by <a href="http://www.freecsstemplates.org/" rel="nofollow">FreeCSSTemplates.org</a></p>
</div>
</body>
</html>