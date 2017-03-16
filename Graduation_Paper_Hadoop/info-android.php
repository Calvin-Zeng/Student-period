<?php 
session_start(); 
require_once('connections/thrift.php'); 
require_once('action/login.php'); 
require_once('connections/mysql.php'); 

header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
							$singern;
							$songn;
							$songcr;
							$singercr;
							$songurl;
			
							//找歌手
							$table_name = 'music';
							$row_name =$_GET['B'];
							$fam_col_name = 'detail:songname';
							$arr81 = $client->get($table_name, $row_name , $fam_col_name);						
							foreach ( $arr81 as $k1=>$v1  ) {     		 
							$t1 =("{$v1->value}"); 	
							} 
							$singern=$t1; //儲存歌手名
					
					//找歌名					
					$table_name = 'music';
					$row_name = $_GET['A'] ;
					$fam_col_name = 'detail:songname';
					$arr80 = $client->get($table_name, $row_name , $fam_col_name);
						foreach ( $arr80 as $k1=>$v1  ) {     		 
							$t2 =("{$v1->value}"); 	
							$songn=$t2;
						}								
						//單曲點擊次數
					
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
						$songcr=$t;
						} 
						//歌手點擊率 值
						
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
						$singercr=$t1;
						} 
				
									//歌的url

									$table_name = 'music';
									$row_name = $_GET['A'] ;
									$fam_col_name = 'detail:url';
									//aar8 圖片
									$arr8 = $client->get($table_name, $row_name , $fam_col_name);
							
									
									foreach ( $arr8 as $k1=>$v1  ) {     		 
									$t1 =("{$v1->value}");	
									$songurl=$t1;
									
									} 		
			$info_array[] = array (
							"singern" => $singern,
							"songn" => $songn,
							"songcr" => $songcr,
							"singercr" => $singercr,
							"songurl" => $songurl
					);

			echo json_encode($info_array);
?>		

	
			

		