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
<?php
	$table_name = 'account';
	$row_name = $_SESSION['login_id'];
	$fam_col_name = 'list:list_num';
	$arr = $client->get($table_name, $row_name , $fam_col_name);
?>
<!-- 加入清單 -->
<?php
if (isset( $_POST['test_name']  )){

		$table_name = 'account';
		$row_name = $_SESSION['login_id'];
		$fam_col_name = 'name';
		$list = 'list:list_num';
		$test_name =$_POST['test_name'];
			
			$arr1 = $client->get($table_name, $row_name , $list);
			foreach ( $arr1 as $k=>$v  ) {		 
			$s = ("{$v->value}"); //從list_num 取數字
			}		
			;			
			$mutations = array(
			new Mutation( array(
				'column' => 'list:list_num',
				'value' => $s+'1'
			) ),
            );
			$client->mutateRow( $table_name, $row_name, $mutations ); //改變list_num的值 			
			///////// 下面開始創account 的rowkey
		    $arr2 = $client->get($table_name, $row_name , $list);
		    foreach ( $arr2 as $k1=>$v1  ) {     		 
			$t =("{$v1->value}"); //從list_num 取數字 放到 XX-XX		
			} 			
			$mutations4 = array(
					new Mutation( array( 'column' => $fam_col_name, 
										'value' => $test_name) 
										));
			$client->mutateRow( $table_name, $row_name."-".$t , $mutations4 );
			
			$mutations10 = array(
					new Mutation( array(
			'column' => 'list:song_num',    //新增list:song_num
			'value' => 0
			 ) )
			 );
			$client->mutateRow( $table_name, $row_name."-".$t, $mutations10 );
			header('refresh:0;url="./mylist.php"');		
}
?>
<!-- 加入清單結束↑ -->
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>MUST CSIE 畢業專題-hadoop</title>
<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700|Archivo+Narrow:400,700" rel="stylesheet" type="text/css">
<link href="css/framework.css" rel="stylesheet" type="text/css" media="screen" />
<link href="css/two-columns.css" rel="stylesheet" type="text/css" media="screen" />
<script src="http://code.jquery.com/jquery-1.6.3.min.js"></script>
<script src="js/login.js"></script>
<meta property="og:title" content="MUST 畢業專題-Hadoop" />
<meta property="og:url" content="http://120.105.81.162/mylist.php" />
<meta property="og:image" content="http://120.105.81.154/qrcode/php/QRcode.php?d=http://120.105.81.162/mylist.php" />

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
				<h2>新增清單</h2>
				<ul>
					<li><h3>輸入想新增的清單名</h3></li>
					<form id="ki" name="form" method="post" action="mylist.php" >											
							<input name="test_name" type="text"/><input type="submit" id="login" value="新增"  />			
					</form>
				</ul>
			</li>
			<li>
				<h2>歌單列表</h2>	
				<ul>
					<!-- 歌單列表開始   -->
					<?php
						for($t=1;$t<=$arr[0]->value;$t++){
						$table_name = 'account';
						$row_name = $_SESSION['login_id']."-".$t ;
						$fam_col_name = 'name:';
						$arr811 = $client->get($table_name, $row_name , $fam_col_name);						
						foreach ( $arr811 as $k1=>$v1  ) {     		 
						$t111 =("{$v1->value}"); 	//t111 代表資料庫輸入清單
						} 

					?>
					<!-- 歌單列表結束  -->
					<?php
						if( $t111 != null ){
					?>
					<li><a href="mylist.php?num=<?echo $t;?>"><?php echo $t111; ?></a>
					<a href="delete.php?num=<?echo $t;?>"><input type="image"   img src="images/deletered.jpg"  width="10%" height="20%" style="float:right;"  onClick="document.formname.submit();" ></a>
					<a href="share.php?id=<?php echo $_SESSION['login_id']?>&num=<?php echo $t?>"onclick="window.open('share.php?id=<?php echo $_SESSION['login_id']?>&num=<?php echo $t?>','popup','width=500,height=500,scrollbars=no,resizable=no,toolbar=no,directories=no,location=no,menubar=no,status=no,left=0,top=0'); return false"><input type="image"   img src="images/qrcode.jpg"  width="10%" height="20%" style="float:right;"  onClick="document.formname.submit();" ></a>
					<a href="./play/index.php?id=<?php echo $_SESSION['login_id']?>&num=<?php echo $t?>"onclick="window.open('./play/index.php?id=<?php echo $_SESSION['login_id']?>&num=<?php echo $t?>','popup','width=500,height=500,scrollbars=no,resizable=no,toolbar=no,directories=no,location=no,menubar=no,status=no,left=0,top=0'); return false"><input type="image"   img src="images/play.png"  width="10%" height="20%" style="float:right;"  onClick="document.formname.submit();" ></a></li>
					<?
						}
					?>
					<?php
						}
					?>
				</ul>
			</li>
			<li>
				<ul>
					<h2>已上傳清單</h2>
					<li><a href="mylist.php?num=<?echo 'a1';?>"><?php echo '上傳的音樂檔案'; ?></a>
				</ul>
			</li>
			<!--樣板結束-樣板結束-樣板結束-樣板結束-樣板結束-->
		</div> 
		<form action="mylist.php" method="Post">
		<div id="content">
			<div class="post">
				<h2 class="title"><a href="#">
				<?php 
					if(!$_GET['num']){ 
						echo '我的頻道';
					} 
					else {
						$table_name = 'account';
						$row_name = $_SESSION['login_id']."-".$_GET['num'];
						$fam_col_name = 'name:';
	
						$arr88 = $client->get($table_name, $row_name, $fam_col_name);
						foreach ( $arr88 as $k1=>$v1  ) {     		 
						$t11 =("{$v1->value}");		
						} 	
						if(  $_GET['num'] != 'a1' ){
						echo '歌單名稱:  '.$t11;
						}
					}  
				?></a></h2>
				<div class="addbox">
						<?php
							if(!$_GET['num']){
						?>
							<div class="dropdown">
									<select name="language[]" class="dropdown-select">
									<option >請選擇移置清單:</option>
										<?php
												$table_name = 'account';
												$row_name = $_SESSION['login_id'];
												$fam_col_name = 'list:list_num';
												$arr = $client->get($table_name, $row_name , $fam_col_name);
												for ($x=1;$x<=$arr[0]->value;$x++){													
													$arr51 = $client->get($table_name, $row_name."-".$x , "name");
													if($arr51[0]->value != null){
										?>
									<option value="<?php echo $row_name."-".$x;     ?>" style="background-image:url(images/add.png);"><?php echo $arr51[0]->value?></option>
										<?php
													
													}
												}
										?>
									</select>
							</div>
						<?php
							}
						?>
						<?php echo "&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp" ; ?>
						<!-- //////// add -->
						<?php
							if(!$_GET['num']){
						?>
							<input type="image"    img src="images/add.png"  width="40px" height="40px"  onClick="document.formname.submit();" >
						<?php							
							$result1 = mysql_query('SELECT sum(`index`) FROM `singer`'); 
							$data1 = mysql_fetch_row($result1);
							$per = 20; //每頁顯示項目數量 
							$pages = ceil($data1[0]/$per)+2;								
								if(!isset($_GET["page"])){ 
								$page=1; //設定起始頁 
								} 
								else { 
								$page = intval($_GET["page"]); //確認頁數只能夠是數值資料 
								$page = ($page > 0) ? $page : 1; //確認頁數大於零 
								$page = ($pages > $page) ? $page : $pages; //確認使用者沒有輸入太神奇的數字 
								}
								$start = ($page-1)*$per; //每頁起始資料序號	
							}
						?>
						<!-- //////// delete -->
						<?php
							if( $_GET['num'] || $_GET['num'] == 'a1' ){
						?>
							<input type="image"   img src="images/delete.png"  width="40px" height="40px" onClick="document.formname.submit();" >
						<?php
							}
						?>
				</div >				
				<?php 	
				$songer[500];
				$song[500];
				$url[500];
				$A[500];
				$B[500];
				$add=0;
				if( !$_GET['num'] ){
					for($r=10001;$r<=(10001+$_SESSION['total']);$r++){
						for($r1=0;$r1<=100;$r1++){
							$table_name = 'music';
							$row_name = $r ;
							$fam_col_name = 'detail:url';
							//aar8 圖片
							$arr8 = $client->get($table_name, $row_name."-".$r1 , $fam_col_name);
							
							if( @$arr8[0]->value ){
								foreach ( $arr8 as $k1=>$v1  ) {     		 
								$t1 =("{$v1->value}");
								$url[$add]=$t1;
								$A[$add]=$row_name."-".$r1;
								$B[$add]=$row_name;
								} 		
								//找歌手
								$table_name = 'music';
								$row_name = $r ;
								$fam_col_name = 'detail:songname';
								$arr81 = $client->get($table_name, $row_name , $fam_col_name);						
								foreach ( $arr81 as $k1=>$v1  ) {     		 
								$t11 =("{$v1->value}"); 	
								$songer[$add]=$t11;
								} 
								//歌名
								$row_name = $r ;
								$fam_col_name = 'detail:songname';
								$arr80 = $client->get($table_name, $row_name."-".$r1 , $fam_col_name);
								foreach ( $arr80 as $k1=>$v1  ) {     		 
								$t22 =("{$v1->value}"); 	
								$song[$add]=$t22;
								}
							}
							else{ break;}
							$add=$add+1;
						}
					}							
				?>				
				<?php
					for($m=$start;$m<($start+$per);$m++){
						if( $url[$m] != ''){
				?>
				<div class="songbox"> 
				<a href="#"><img class="songimg" src="mfs/images/<?php echo $url[$m]; ?>.jpg"   /><a><br>
				<p class="links" > <input type="checkbox"    class="songcheck" name="song[]" value="<?php echo $A[$m] ?>"/></input><a href="info.php?A=<?echo $A[$m];?>&B=<?echo $B[$m];?>" title="<?php echo $song[$m]?>">
				<?php   
						if(strlen($song[$m])>15)
							echo substr($song[$m], 0,15).'...<br>';
						else
							echo substr($song[$m], 0,15).'<br>';
						echo substr($songer[$m], 0,15);
							
				?> </a></p>
				</div>
				<?php
						}
					}	
				}
				?>
				<?php 			
					if( $_GET['num'] && $_GET['num'] != 'a1' ){
						for($r1=1;$r1<=100;$r1++){
						$table_name = 'account';
						$row_name = $_SESSION['login_id']."-".$_GET['num']."-".$r1 ;
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
				<p class="links" > <input type="checkbox"    class="songcheck" name="song1[]" value="<?php echo $t1 ?>"/></input><a href="info.php?A=<?echo $t1;?>&B=<?echo mb_strimwidth($t1, 0, 5); ?>" title="<?php echo $t22 ?>">
				<?php   
						if(strlen($t22)>18)
							echo substr($t22, 0,18).'...<br>';
						else
							echo substr($t22, 0,18).'<br>';
						echo substr($t11, 0,18);
							
				?> </a></p>
				</div>
				<?php
						}
				}
				?>			
				<!-- 抓下拉是選單程式區 //////////////////////////////////////////////////////////////////////////////////////////////////-->				
				<?php
					$mylanguage=$_REQUEST["language"];
					//出來的值 test-x
					$_SESSION['song_num']= implode(">>",$mylanguage);
					$song=$_REQUEST["song"];
					$song1=$_REQUEST["song1"];
					$_SESSION['song_numa']=implode(">>",$song);
					$_SESSION['song_numa1']=implode(">>",$song1);			
				?>
				<?php
					if (isset(  $_SESSION['song_num']   )){
						if(isset(  $_SESSION['song_numa']   )){
							if( $_SESSION['song_num'] !=  "請選擇移置清單:" ){
									for($ttk=0;$ttk<sizeof($song);$ttk++){
											$x = 0;
										for($leo=1;$leo<=50;$leo++){										
											$table_name = 'account';
											$row_name = $_SESSION['song_num']."-".$leo ;
											$fam_col_name = 'song:index';
											//aar8 圖片
											$arr8 = $client->get($table_name, $row_name, $fam_col_name);
											
					                        foreach ( $arr8 as $k1=>$v1  ) {     		 
											$t1 =("{$v1->value}");} 

											if( $song[$ttk] == $t1 ){
												$x=1;
												echo "<script language=\"javascript\">"; 
												echo "window.alert('有歌曲以輸入過..')"; 
												echo "</script>";
												break;
											}	
										}
												if($x == 0){
												$table_name = 'account';
												$row_name = $_SESSION['song_num'];
												$fam_col_name = 'list:song_num';												
												$arr13 = $client->get($table_name, $row_name , $fam_col_name);
												foreach ( $arr13 as $k=>$v  ) {		 
												$ss = ("{$v->value}"); //從song_num 取數字
												}		
												;											
												$mutations = array(
												new Mutation( array(
													'column' => 'list:song_num',
													'value' => $ss+'1'
												) ),
												);
												$client->mutateRow( $table_name, $row_name, $mutations ); //改變song_num的值 																								
												///////// 下面開始創account 的rowkey
												$arr22 = $client->get($table_name, $row_name , $fam_col_name);
												foreach ( $arr22 as $k1=>$v1  ) {     		 
												$tt =("{$v1->value}"); //從song_num 取數字 放到 XX-XX		
												} 							
												$mutations110 = array(
														new Mutation( array(
												'column' => 'song:index',    //新增list:song_num
												'value' => $song[$ttk]		//------------checkbox 歌曲編號
												 ) )
												 );
												$client->mutateRow( $table_name, $row_name."-".$tt, $mutations110 );							
												}								
									}
							}
						}
					}						
				?>
				<?php 
				//checkbox判斷有值嗎
				if( $_GET['num'] ){$_SESSION['a'] = $_GET['num'];}	
				//刪除歌曲
				if( $_SESSION['song_numa1'] ){					
					for($r1=1;$r1<=100;$r1++){				
							$table_name = 'account';
							$row_name = $_SESSION['login_id']."-".$_SESSION['a']."-".$r1 ;
							$fam_col_name = 'song:index';
							$arr8 = $client->get($table_name, $row_name, $fam_col_name);							
							if( @$arr8[0]->value  ){
								foreach ( $arr8 as $k=>$v  ) {		 
								$ss = ("{$v->value}"); 
								};							
								for($k=0;$k<sizeof($song1);$k++){
									if( $ss == $song1[$k] ){
									$mutations = array(
									new Mutation( array(
										'column' => 'song:index',
										'value' => '00000-0'
									) ),
									);
									$client->mutateRow( $table_name, $row_name, $mutations );  
									}
								}
							}
							else{ break; }
					}	
				}
				?>
				<?php
				//上傳音樂
				if( $_GET['num'] == 'a1'){
						
						$x= $_SESSION['login_id'];
						$sql="select * from `my_list` where name='$x' ";
						$query=mysql_query($sql);
						while ($rs=mysql_fetch_array($query)){
						//echo var_dump($rs);						
				?>				
				<div class="songbox"> 
				<a href="#"><img class="songimg" src="images/<?php echo 'music'; ?>.jpg"   /><a><br>
				<p class="links" > <input type="checkbox"    class="songcheck" name="song2[]" value="<?php echo $rs['index'] ?>"/></input><a href="info.php?A=<?echo $rs['songr'];?>&B=<?echo $rs['song'];?>&C=<?echo '1';?>&D=<?echo $rs['index'];?>" title="<?php echo $rs['song'] ?>">
				<?php   				
						echo $rs['song'].'<br>';	
						echo $rs['songr'];	

				?> </a></p>
				</div>
				<?php
					}					
				}
				?>
				<?php
					$song2=$_REQUEST["song2"];
					$_SESSION['song_num1']=implode($song2);
					if( $_SESSION['song_num1'] != '' ){					
						for($x=0;$x<sizeof($song2);$x++){
							$x1= $_SESSION['login_id'];
							$x2= $song2[$x];
							unlink("./mfs/user/".$x1."/".$x2);
							$sql="DELETE FROM `my_list` WHERE name='$x1' and `index`='$x2'";
							mysql_query($sql);

						}					
					}		
				?>
			</div>				
		</div>
	</div>
	<h2><center>
	<!-- 分頁 -->
	<?php
		if(!$_GET['num']){
			echo '        '.'<<   ';
			for($i=1;$i<=$pages;$i++) { 
					echo '<a href="?page='.$i.'">' .'     '.$i.'     '. '</a>'; 
			}
					echo '        '.'  >>  ';
		}
	?>
	<!-- 分頁結束 -->
	</center></h2>
</div>
<div id="footer">
	<p>&copy; 2013 Sitename.com. | Photos by <a href="http://fotogrph.com/">Fotogrph</a> | Design by <a href="http://www.freecsstemplates.org/" rel="nofollow">FreeCSSTemplates.org</a></p>
</div>
</form>
</body>
</html>