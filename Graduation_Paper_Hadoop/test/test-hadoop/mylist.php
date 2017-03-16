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
<?php
	$table_name = 'account';
	$row_name = $_SESSION['login_id'];
	$fam_col_name = 'list:list_num';
	$arr = $client->get($table_name, $row_name , $fam_col_name);
?>
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
				<h2>新增清單</h2>
				<ul>
					<li>輸入想新增的清單名</li>
				<form id="ki" name="form" method="post" action="mylist.php" >											
						<input name="test_name" type="text"/><input type="submit" id="login" value="新增"  />					
										
				</form>
				</ul>
			</li>
			<!--樣板結束-樣板結束-樣板結束-樣板結束-樣板結束-->
		</div> 
		<div id="content">
			<div class="post">
				<h2 class="title"><a href="#">我的頻道</a></h2>
				<div class="addbox">
					<div class="dropdown">
						<select name="one" class="dropdown-select">
						<option >移置…</option>
							<?php
								   for ($x=1;$x<=$arr[0]->value;$x++){
										$arr5 = $client->get($table_name, $row_name."-".$x , "name");
							?>
						<option value="<?php echo $x ?>" style="background-image:url(images/add.png);"><?php echo $arr5[0]->value?></option>
							<?php
								}
							?>
						</select>
					</div>
					<div class="dropdown">
						<select name="one1" class="dropdown-select">
							<option value="">選取檔案</option>
							<option value="1">全選</option>
							<option value="2">全不選</option>
						</select>
					</div>
				<a href="#"><img  class="addimg" src="images/add.png"    /><a>
				<a href="#"><img  class="addimg" src="images/delete.png"     /><a>
				</div >
				
				<?php 
				for($r=1;$r<=4;$r++){
					for($r1=0;$r1<=10;$r1++){
						$table_name = 'music';
						$row_name = $r ;
						$fam_col_name = 'detail:url';
						//aar8 圖片
						$arr8 = $client->get($table_name, $row_name."-".$r1 , $fam_col_name);
						
						if( @$arr8[0]->value )
						foreach ( $arr8 as $k1=>$v1  ) {     		 
						$t1 =("{$v1->value}");		
						} 		
						else{ break;}
						
				?>				
				<div class="songbox"> 
				<a href="#"><img class="songimg" src="images/<?php echo $t1; ?>.jpg"   /><a><br>
				<p class="links" > <input type="checkbox"    class="songcheck" name="song1" value="<?php echo $_SESSION['login_id']."-".$r1 ?>"/></input><a href="info.php?A=<?echo $row_name."-".$r1;?>&B=<?echo $r; ?>">
				<?php   
						                                                                                                                     
				
						//找歌手
						$table_name = 'music';
						$row_name = $r ;
						$fam_col_name = 'detail:songname';
						$arr81 = $client->get($table_name, $row_name , $fam_col_name);						
						foreach ( $arr81 as $k1=>$v1  ) {     		 
						$t1 =("{$v1->value}"); 	
						} 
						//歌名
						$row_name = $r ;
						$fam_col_name = 'detail:songname';
						$arr80 = $client->get($table_name, $row_name."-".$r1 , $fam_col_name);
						foreach ( $arr80 as $k1=>$v1  ) {     		 
						$t2 =("{$v1->value}"); 	
						}
						
						echo $t1."-".$t2;   //t1 代表 歌手    t2代表 歌名
							
				?> </a></p>
				</div>
				<?php
				}
				}
				?>
			</div>
		</div>
	</div>
</div>
<div id="footer">
	<p>&copy; 2013 Sitename.com. | Photos by <a href="http://fotogrph.com/">Fotogrph</a> | Design by <a href="http://www.freecsstemplates.org/" rel="nofollow">FreeCSSTemplates.org</a></p>
</div>
</body>
</html>