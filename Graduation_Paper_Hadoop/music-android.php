<?php
 session_start(); 
require_once('connections/thrift.php');  
require_once('connections/mysql.php'); 
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
		//取得排行榜的資料
				$d[100];
				$songd[100];
				$singerd[100];
				//$_GET 的singer 編號取得資料
				$songname[100];
				$songA[100];
				//$_GET 選單的資料
				$panelsingern[100];
				$panelsingerurl[100];
				if( !$_GET['singer'] ){
				if( !$_GET['singer'] ){
					$max=0;
					$number[100];  //給detail:hit 存取陣列中
					$number1[100]; //歌曲名 存取陣列中
					$number2[100]; //歌手 存取陣列中
					$a[100];
					$a1[100];
					$a2[100];
					$i=-1;
					for($x=10001;$x<10100;$x++){
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
				//列出最大hit的內容	
						if( !$_GET['singer'] ){
							$table_name = 'music';
							$row_name = $name  ;
							$fam_col_name = 'detail:songname';
							$arr1 = $client->get($table_name, $row_name , $fam_col_name);	
							foreach ( $arr1 as $k1=>$v1  ) {     		 
							$t3 =("{$v1->value}"); 	
							} 	
						}
						//列出最大hit的內容				
							if( !$_GET['singer'] ){			
							}
							$d[0]=$name;
							$songd[0]=$t3; //熱門音樂 第一名											
				}
				$add=0;
				for($second=0;$second<6;$second++){   // 列出最2~6名的內容
					$add=$add+1;
						for($third=0;$third<$i+1;$third++){
							    
								if( $number[$add] == $a[$third] ){
									
									$name_other = $a1[$third];
									$num_other = $a2[$third];
									$d[$add]=$a1[$third];
									break;
								}
						}				
						if( !$_GET['singer'] ){
							$table_name = 'music';
							$row_name = $name_other  ;
							$fam_col_name = 'detail:songname';
							$arr2 = $client->get($table_name, $row_name , $fam_col_name);	
							foreach ( $arr2 as $k1=>$v1  ) {     		 
							$t4 =("{$v1->value}"); 
							$songd[$add]=$t4; //熱門音樂 第2~6名
							} 
						}
				if( !$_GET['singer'] ){
				}
				}			
					for($p=0;$p<7;$p++){						
					}								
			}
			if( !$_GET['singer'] ){
				//把POP的資料全部放在 陣列中
				$mm=0;
				$b[100];
				$b1[100];
				$b2[100];
				$d[100];
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
						$table_name = 'music';
						$row_name = $b1[0] ;
						$fam_col_name = 'detail:songname';
						$arr21 = $client->get($table_name, $row_name , $fam_col_name);	
						foreach ( $arr21 as $k1=>$v1  ) {     		 
						$t41 =("{$v1->value}"); 	
						$songd[7]=$t41; //熱門頻道pop區 第一名
						} 
					for($no=0;$no<11;$no++){
						$table_name = 'music';
						$row_name = $b1[$no] ;
						$fam_col_name = 'detail:songname';
						$arr20 = $client->get($table_name, $row_name , $fam_col_name);	
						foreach ( $arr20 as $k1=>$v1  ) {     		 
						$t400 =("{$v1->value}");
						$songd[$no+7]=$t400; //熱門頻道r&b區 第2~6名
						} 
				}
				$d[100];
				$h=0;
				for($o=7;$o<14;$o++){
					$d[$o]=$b1[$h];
					$h=$h+1;
					}
				}
			if( !$_GET['singer'] ){
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
						$table_name = 'music';
						$row_name = $b1[0] ;
						$fam_col_name = 'detail:songname';
						$arr21 = $client->get($table_name, $row_name , $fam_col_name);	
						foreach ( $arr21 as $k1=>$v1  ) {     		 
						$t41 =("{$v1->value}");	
						$songd[14]=$t41;
						//熱門頻道r&b區 第一名
						} 
					for($no=1;$no<7;$no++){
					
						$table_name = 'music';
						$row_name = $b1[$no] ;
						$fam_col_name = 'detail:songname';
						$arr20 = $client->get($table_name, $row_name , $fam_col_name);	
						foreach ( $arr20 as $k1=>$v1  ) {     		 
						$t400 =("{$v1->value}"); 
						$songd[$no+14]=$t400;
						//熱門頻道r&b區 第2~6名
						} 
				}
				$d[100];
				$h=0;
				for($o=14;$o<21;$o++){
				
					$d[$o]=$b1[$h];
					$h=$h+1;
				}
			}
			if( !$_GET['singer'] ){
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
						$table_name = 'music';
						$row_name = $b1[0] ;
						$fam_col_name = 'detail:songname';
						$arr21 = $client->get($table_name, $row_name , $fam_col_name);	
						foreach ( $arr21 as $k1=>$v1  ) {     		 
						$t41 =("{$v1->value}");
						$songd[21]=$t41;//熱門頻道hiphop區 第一名
						} 
					for($no=1;$no<7;$no++){
						$table_name = 'music';
						$row_name = $b1[$no] ;
						$fam_col_name = 'detail:songname';
						$arr20 = $client->get($table_name, $row_name , $fam_col_name);	
						foreach ( $arr20 as $k1=>$v1  ) {     		 
						$t400 =("{$v1->value}");	
						$songd[$no+21]=$t400;//熱門頻道hiphop區 第2~6名						
						} 
				}
			}
			$d[100];
				$h=0;
				for($o=21;$o<28;$o++){
				
					$d[$o]=$b1[$h];
					$h=$h+1;
				}
				if( !$_GET['singer'] && !$_GET['panel'] ){  
				for($r=0;$r<28;$r++){
				$singer=mb_strimwidth($d[$r], 0, 5);
				$music_array[] = array (
								"mname" => $d[$r],
								"msinger" => $singer,
								"nsong" => $songd[$r]
						);
				}			
				echo json_encode($music_array);
				}
			 // 印出 $_GET 指定歌手 名稱 與 參數
			if( $_GET['singer'] ){  
			
					for($no=0;$no<100;$no++){
						$table_name = 'music';
						$row_name = $_GET['singer'].'-'.$no  ;
						$fam_col_name = 'detail:songname';
						$arr20 = $client->get($table_name, $row_name , $fam_col_name);	
						if( @$arr20[0]->value ){
						foreach ( $arr20 as $k1=>$v1  ) {     		 
						$t400 =("{$v1->value}"); 	
						$singerurlname[$no]=$t400;
						$songA[$no]=$_GET['singer'].'-'.$no;
						$singer_array[] = array (
						"songname" => $singerurlname[$no],
						"songA" => $songA[$no],
						"songB" => $_GET['singer']
								);
								}
							}
						}
						echo json_encode($singer_array);
			}
			 // panel  印出所有歌手名字+編號 
					if($_GET['panel'])
					{
						$i=0;
						for($t=10001;$t<=(10001+$_SESSION['total']);$t++){
							$table_name = 'music';
							$row_name = $t ;
							$fam_col_name = 'detail:songname';
							$arr811 = $client->get($table_name, $row_name , $fam_col_name);	
							if( @$arr811[0]->value ){
							foreach ( $arr811 as $k1=>$v1  ) {     		 
							$t111 =("{$v1->value}");//歌手名
							$panelsingern[$i]=$t111;
							$panelsingerurl[$i]=$t;
							$panel_array[] = array (
							"singername" => $panelsingern[$i],
							"singerurl" => $panelsingerurl[$i]
								);
							$i=$i+1;	
								} 
							}
						}
						echo json_encode($panel_array);
					}
?>
			

