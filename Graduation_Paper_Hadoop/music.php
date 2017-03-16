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
<?php if(!isset($_SESSION['login_id'])){
	header("Location: http://120.105.81.162/");
}
?>
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
				<h2>歌手清單</h2>
				<ul>
				<li><a href="music.php?singer=<?echo '' ;?>"> <h3><?php  echo '音樂分類區' ; ?></h3></a></li>
					<?php
					for($t=10001;$t<=(10001+$_SESSION['total']);$t++){
						$table_name = 'music';
						$row_name = $t ;
						$fam_col_name = 'detail:songname';
						$arr811 = $client->get($table_name, $row_name , $fam_col_name);	

						if( @$arr811[0]->value ){
							foreach ( $arr811 as $k1=>$v1  ) {     		 
							$t111 =("{$v1->value}"); 	
							} 
					?>
						<li><a href="music.php?singer=<?echo $t;?>"><?php echo $t111; ?></a></li>
					<?
						}
					?>
					<?php
					}
					?>
				</ul>
			</li>
			<!--樣板結束-樣板結束-樣板結束-樣板結束-樣板結束-->
		</div> 
		<div id="content">
			<?php 
				if( !$_GET['singer'] ){
			?>
			<div class="post">
				<h2 class="title"><a href="#"><?php if( !$_GET['singer'] ){ echo '熱門音樂'; } ?></a></h2>
				<?php
				if( !$_GET['singer'] ){
				?>
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
						for($x=10001;$x<(10001+$_SESSION['total']);$x++){
							for($y=0;$y<100;$y++){
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
				<?php //列出最大hit的內容	
					if( !$_GET['singer'] ){
						$table_name = 'music';
						$row_name = $name  ;
						$fam_col_name = 'detail:songname';
						$arr1 = $client->get($table_name, $row_name , $fam_col_name);	
						foreach ( $arr1 as $k1=>$v1  ) {     		 
						$t3 =("{$v1->value}"); 	
						} 		
					}
				?>
				<a href="#"><img class="songimg" src="mfs/images/<?php if( !$_GET['singer'] ){  echo $name; }?>.jpg"   /><a><br>
				<p class="links" > <a href="info.php?A=<?echo $name;?>&B=<?echo $num; ?>" title="<?php  echo $t3  ?>"> <?php		//列出最大hit的內容				
						if( !$_GET['singer'] ){			
						echo substr($t3, 0,18).'...';
						}											
				?>
				</a></p>						
				</div>
				<?php
				}
				?>
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
				<?php
						if( !$_GET['singer'] ){
							$table_name = 'music';
							$row_name = $name_other  ;
							$fam_col_name = 'detail:songname';
							$arr2 = $client->get($table_name, $row_name , $fam_col_name);	
							foreach ( $arr2 as $k1=>$v1  ) {     		 
							$t4 =("{$v1->value}"); 	
							} 
						}
				?>
				<?php
					if( !$_GET['singer'] ){
				?>
				<div class="songbox">
					<img class="musicimg"src="mfs/images/<?php if( !$_GET['singer'] ){  echo $name_other; } ?>.jpg" width="160px"  height="160px" />
					<p class="links" > <a href="info.php?A=<?echo $name_other;?>&B=<?echo $num_other; ?>" title="<?php echo $t4 ?>"> <?php		
						if( !$_GET['singer'] ){
						echo substr($t4, 0,12).'...';
						}										
				?>
				</a></p>
				</div>
				<?php
					}			
				}
				?>			
			</div>
			<?
			}
			?>
			<?php
			if( !$_GET['singer'] ){
			?>
			<br><br><br><br><br><br><br>
			<hr>
			<?php
				//把POP的資料全部放在 陣列中
				$mm=0;
				$b[100];
				$b1[100];
				$b2[100];
					for($c=0;$c<=100;$c++){
						$table_name = 'category';
						$row_name = '10001'.'-'.$c ;
						$fam_col_name = 'index:';
						$arrc = $client->get($table_name, $row_name , $fam_col_name);		

						if( $arrc[0]->value  ){
							foreach ( $arrc as $k1=>$v1  ) {     		 
								$tc =("{$v1->value}"); 	
								$b1[$c]=$tc;  //進入陣列
								$mm=$mm+1;
							}
								
								$table_name = 'music'; //找出pop的index中的hit
								$row_name = $tc ;
								$fam_col_name = 'detail:hit';
								$arrcc = $client->get($table_name, $row_name , $fam_col_name);		

						
								foreach ( $arrcc as $k1=>$v1  ) {     		 
								$tc1 =("{$v1->value}"); 	
								$b[$c]=$tc1;  //存取
								} 				
						}
						else{ break;}		
					}				
			?>
			<?php
						for($first1=0;$first1<$mm;$first1++){   //排序法 把大小作排列
							for($j11=$mm;$j11>$first1;$j11--){
									if($b[$j11]>$b[$j11-1]){
									$tmep=$b[$j11];
									$b[$j11]=$b[$j11-1];
									$b[$j11-1]=$tmep;
									
									$tmep1=$b1[$j11];
									$b1[$j11]=$b1[$j11-1];
									$b1[$j11-1]=$tmep1;
									}
							}	
						}		
			?>			
			<div class="post">
				<h2 class="title"><a href="#">熱門頻道POP區</a></h2>
				<div class="songbox"> 
				<?php
				
						$table_name = 'music';
						$row_name = $b1[0] ;
						$fam_col_name = 'detail:songname';
						$arr21 = $client->get($table_name, $row_name , $fam_col_name);	
						foreach ( $arr21 as $k1=>$v1  ) {     		 
						$t41 =("{$v1->value}"); 	
						} 				
				?>
				<a href="#"><img class="songimg" src="mfs/images/<?php  echo $b1[0]; ?>.jpg"   /><a><br>
				<p class="links" > <a href="info.php?A=<?echo $b1[0];?>&B=<?echo mb_strimwidth($b1[0], 0, 5); ?>" title="<?php echo $t41 ?>"> <?php		//列出最大hit的內容													
						echo substr($t41, 0,18).'...';											
				?>
				</a></p>						
				</div>			
				<?php
					for($no=1;$no<7;$no++){
					
						$table_name = 'music';
						$row_name = $b1[$no] ;
						$fam_col_name = 'detail:songname';
						$arr20 = $client->get($table_name, $row_name , $fam_col_name);	
						foreach ( $arr20 as $k1=>$v1  ) {     		 
						$t400 =("{$v1->value}"); 	
						} 
				?>
				<div class="songbox">
					<img class="musicimg"src="mfs/images/<?php  echo $b1[$no];  ?>.jpg" width="160px"  height="160px" />
					<p class="links" > <a href="info.php?A=<?echo $b1[$no];?>&B=<?echo mb_strimwidth($b1[$no], 0, 5); ?>" title="<?php echo $t400 ?>"> <?php								
						echo substr($t400, 0,12).'...';										
				?>
				</a></p>
				</div>
				<?php
				}?>
			</div>
			<br><br><br><br><br><br><br><br><br>			
			<hr>
				<?php
				}
				?>
			<?php
			if( !$_GET['singer'] ){
			?>
			<?php
				//把POP的資料全部放在 陣列中
				$mm=0;
				$b[100];
				$b1[100];
				$b2[100];
					for($c=0;$c<=100;$c++){
						$table_name = 'category';
						$row_name = '10002'.'-'.$c ;
						$fam_col_name = 'index:';
						$arrc = $client->get($table_name, $row_name , $fam_col_name);		
						if( $arrc[0]->value  ){
							foreach ( $arrc as $k1=>$v1  ) {     		 
								$tc =("{$v1->value}"); 	
								$b1[$c]=$tc;  //進入陣列
								$mm=$mm+1;
							}
								
								$table_name = 'music'; //找出pop的index中的hit
								$row_name = $tc ;
								$fam_col_name = 'detail:hit';
								$arrcc = $client->get($table_name, $row_name , $fam_col_name);							
								foreach ( $arrcc as $k1=>$v1  ) {     		 
								$tc1 =("{$v1->value}"); 	
								$b[$c]=$tc1;  //存取
								} 				
						}
						else{ break;}		
					}				
			?>
			<?php				
						for($first1=0;$first1<$mm;$first1++){   //排序法 把大小作排列
							for($j11=$mm;$j11>$first1;$j11--){
									if($b[$j11]>$b[$j11-1]){
									$tmep=$b[$j11];
									$b[$j11]=$b[$j11-1];
									$b[$j11-1]=$tmep;
									
									$tmep1=$b1[$j11];
									$b1[$j11]=$b1[$j11-1];
									$b1[$j11-1]=$tmep1;
									}
							}	
						}		
			?>				
			<div class="post">
				<h2 class="title"><a href="#">熱門頻道R&B區</a></h2>
				<div class="songbox"> 
				<?php
				
						$table_name = 'music';
						$row_name = $b1[0] ;
						$fam_col_name = 'detail:songname';
						$arr21 = $client->get($table_name, $row_name , $fam_col_name);	
						foreach ( $arr21 as $k1=>$v1  ) {     		 
						$t41 =("{$v1->value}"); 	
						} 			
				?>
				<a href="#"><img class="songimg" src="mfs/images/<?php  echo $b1[0]; ?>.jpg"   /><a><br>
				<p class="links" > <a href="info.php?A=<?echo $b1[0];?>&B=<?echo mb_strimwidth($b1[0], 0, 5); ?>" title="<?php echo $t41 ?>"> <?php		//列出最大hit的內容				
										
						echo substr($t41, 0,18).'...';
						//echo $t3;												
				?>
				</a></p>						
				</div>				
				<?php
					for($no=1;$no<7;$no++){
					
						$table_name = 'music';
						$row_name = $b1[$no] ;
						$fam_col_name = 'detail:songname';
						$arr20 = $client->get($table_name, $row_name , $fam_col_name);	
						foreach ( $arr20 as $k1=>$v1  ) {     		 
						$t400 =("{$v1->value}"); 	
						} 
				?>
				<div class="songbox">
					<img class="musicimg"src="mfs/images/<?php  echo $b1[$no];  ?>.jpg" width="160px"  height="160px" />
					<p class="links" > <a href="info.php?A=<?echo $b1[$no];?>&B=<?echo mb_strimwidth($b1[$no], 0, 5); ?>" title="<?php echo $t400 ?>"> <?php								
						echo substr($t400, 0,12).'...';
						//echo $t4;												
				?>
				</a></p>
				</div>
				<?php
				}?>
			</div>		
			<br><br><br><br><br><br><br><br><br>
			<hr>
			<?php
			}
			?>
			<?php
			if( !$_GET['singer'] ){
			?>
			<?php
				//把POP的資料全部放在 陣列中
				$mm=0;
				$b[100];
				$b1[100];
				$b2[100];
					for($c=0;$c<=100;$c++){
						$table_name = 'category';
						$row_name = '10003'.'-'.$c ;
						$fam_col_name = 'index:';
						$arrc = $client->get($table_name, $row_name , $fam_col_name);		

						if( $arrc[0]->value  ){
							foreach ( $arrc as $k1=>$v1  ) {     		 
								$tc =("{$v1->value}"); 	
								$b1[$c]=$tc;  //進入陣列
								$mm=$mm+1;
							}							
								$table_name = 'music'; //找出pop的index中的hit
								$row_name = $tc ;
								$fam_col_name = 'detail:hit';
								$arrcc = $client->get($table_name, $row_name , $fam_col_name);		

						
								foreach ( $arrcc as $k1=>$v1  ) {     		 
								$tc1 =("{$v1->value}"); 	
								$b[$c]=$tc1;  //存取
								} 				
						}
						else{ break;}		
					}				
			?>
			<?php				
						for($first1=0;$first1<$mm;$first1++){   //排序法 把大小作排列
							for($j11=$mm;$j11>$first1;$j11--){
									if($b[$j11]>$b[$j11-1]){
									$tmep=$b[$j11];
									$b[$j11]=$b[$j11-1];
									$b[$j11-1]=$tmep;
									
									$tmep1=$b1[$j11];
									$b1[$j11]=$b1[$j11-1];
									$b1[$j11-1]=$tmep1;
									}
							}	
						}		
			?>				
			<div class="post">
				<h2 class="title"><a href="#">熱門頻道HipHop區</a></h2>
				<div class="songbox"> 
				<?php			
						$table_name = 'music';
						$row_name = $b1[0] ;
						$fam_col_name = 'detail:songname';
						$arr21 = $client->get($table_name, $row_name , $fam_col_name);	
						foreach ( $arr21 as $k1=>$v1  ) {     		 
						$t41 =("{$v1->value}"); 	
						} 				
				?>
				<a href="#"><img class="songimg" src="mfs/images/<?php  echo $b1[0]; ?>.jpg"   /><a><br>
				<p class="links" > <a href="info.php?A=<?echo $b1[0];?>&B=<?echo mb_strimwidth($b1[0], 0, 5); ?>" title="<?php echo $t41 ?>"> <?php		//列出最大hit的內容														
						echo substr($t41, 0,18).'...';											
				?>
				</a></p>						
				</div>				
				<?php
					for($no=1;$no<7;$no++){				
						$table_name = 'music';
						$row_name = $b1[$no] ;
						$fam_col_name = 'detail:songname';
							$arr20 = $client->get($table_name, $row_name , $fam_col_name);	
							foreach ( $arr20 as $k1=>$v1  ) {     		 
							$t400 =("{$v1->value}"); 	
							} 
				?>
				<div class="songbox">
					<img class="musicimg"src="mfs/images/<?php  echo $b1[$no];  ?>.jpg" width="160px"  height="160px" />
					<p class="links" > <a href="info.php?A=<?echo $b1[$no];?>&B=<?echo mb_strimwidth($b1[$no], 0, 5); ?>" title="<?php echo $t400 ?>"> <?php								
						echo substr($t400, 0,12).'...';
						//echo $t4;												
				?>
				</a></p>
				</div>
				<?php
					}
				?>
			</div>
			<?php
			}
			?>		
			<?php
			if( $_GET['singer'] ){
			?>
			<div class="post">
				<h2 class="title"><a href="#">歌手單曲</a></h2>
				<?php
					for($no=0;$no<100;$no++){
					
						$table_name = 'music';
						$row_name = $_GET['singer'].'-'.$no  ;
						$fam_col_name = 'detail:songname';
						$arr20 = $client->get($table_name, $row_name , $fam_col_name);	
						if( @$arr20[0]->value ){
							foreach ( $arr20 as $k1=>$v1  ) {     		 
							$t400 =("{$v1->value}"); 	
							} 
				?>
				<div class="songbox">
					<img class="musicimg"src="mfs/images/<?php  echo $_GET['singer'].'-'.$no ;  ?>.jpg" width="160px"  height="160px" />
					<p class="links" > <a href="info.php?A=<?echo $_GET['singer'].'-'.$no;?>&B=<?echo $_GET['singer']; ?>" title="<?php echo $t400 ?>"> <?php													
						if(strlen($t400)>10)
							echo substr($t400, 0,10).'...<br>';
						else
							echo substr($t400, 0,10).'<br>';					
				?>
				</a></p>
				</div>
				<?php
						}
					}
				?>
			</div>
			<?php
			}
			?>	
		</div>
	</div>
</div>
<div id="footer">
	<p>&copy; 2013 Sitename.com. | Photos by <a href="http://fotogrph.com/">Fotogrph</a> | Design by <a href="http://www.freecsstemplates.org/" rel="nofollow">FreeCSSTemplates.org</a></p>
</div>
</body>
</html>