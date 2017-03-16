<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<?php session_start(); ?>
<?php require_once('connections/thrift.php'); ?>
<html>
<head>
    <title></title>
    <link rel="stylesheet" type="text/css" href="./plugin/css/style.css">
    <link rel="stylesheet" type="text/css" href="css/demo.css">
    <script type="text/javascript" src="js/jquery-1.6.1.min.js"></script>
    <script type="text/javascript" src="./plugin/jquery-jplayer/jquery.jplayer.js"></script>
    <script type="text/javascript" src="./plugin/ttw-music-player-min.js"></script>
	<?php
	$col="";
	for($r1=1;$r1<=100;$r1++){
		$table_name = 'account';
		$row_name = $_GET['id']."-".$_GET['num']."-".$r1 ;
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
	$x=mb_strimwidth($t1, 0, 5);
	$col.="{mp3:'../mfs/file/".$t1.".mp3',title:'".substr($t22, 0,18).'...<br>'."',artist:'".$t11."',rating:4,buy:'http://120.105.81.162/info.php?A=".$t1."&B=".$x."',price:'detail',duration:'',cover:'../mfs/images/".$t1.".jpg'}";
	$col.=",";
	}
	$col=substr($col,0,strlen($col)-1);
	$oldumask = umask(0);
	if (!is_dir("./js/".$_GET['id'])) {      //檢察upload資料夾是否存在
		if (!mkdir("./js/".$_GET['id'], 0777))  //不存在的話就創建upload資料夾
		die ("上傳目錄不存在，並且創建失敗");
	}
	$fp = fopen('./js/'.$_GET['id'].'/'.$_GET['num'].'.js', 'w');
	fwrite($fp, "var myPlaylist = [".$col."];");
	fclose($fp);
    ?>
	<script type="text/javascript" src="js/<?php echo $_GET['id']?>/<?php echo $_GET['num']?>.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            var description = '';

            $('body').ttwMusicPlayer(myPlaylist, {
                autoPlay:false, 
                description:description,
                jPlayer:{
                    swfPath:'./plugin/jquery-jplayer' //You need to override the default swf path any time the directory structure changes
                }
            });
        });
    </script>
</head>
<body>

<div id="title"></div>
</body>
</html>