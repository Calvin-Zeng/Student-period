<?php 
	session_start(); 
	require_once('connections/thrift.php'); 
	require_once('connections/mysql.php'); 
	header('Content-Type: application/json');
	header('Access-Control-Allow-Origin: *');


	$_SESSION['login_id']=$_POST['login_id'];
	$table_name = 'account';
	$row_name = $_SESSION['login_id'];
	$fam_col_name = 'list:list_num';
	$arr = $client->get($table_name, $row_name , $fam_col_name);


if (isset( $_POST['test_name'])){

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
			$response["status"] = "listadd";		
			echo json_encode($response);
			
}





	
				
					

						if(!$_GET['num']&&!$_POST['test_name']&&!$_POST['addsong']&&!$_GET['delete']&&!$_POST['num'])
						{
						$x=$_SESSION['login_id'];
						for($t=1;$t<=$arr[0]->value;$t++){
						$table_name = 'account';
						$row_name = $x."-".$t ;
						$fam_col_name = 'name:';
						$arr811 = $client->get($table_name, $row_name , $fam_col_name);						
						foreach ( $arr811 as $k1=>$v1  ) {     		 
						$t111 =("{$v1->value}"); 	//t111 代表資料庫輸入清單
						
						} 
						if( $t111 != null ){
						$list_array[] = array (
							"listname" => $t111,
							"num" => $t
							);
						}
					
					}
					echo json_encode($list_array);
					}

			
				 //顯示指定歌單裡的歌曲 //功能正常
					if( $_GET['num']&&!$_GET['delete']&&!$_POST['addsong'] ){
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
										$B=mb_strimwidth($t1, 0, 5);										
										$song_array[] = array (
											"songname" => $t22,
											"A" => $t1,
											"B" => $B
										);
										}	
										
								}
								
								else{
									continue;
								}
								
							}
					else{ break;}						
						}
						echo json_encode($song_array);
				}
					
			
			
	
							if( $_POST['addsong']){		
								$addsong=$_POST['addsong'];
								$addnum=$_POST['num'];
											$x = 0;
										for($leo=1;$leo<=50;$leo++){										
											$table_name = 'account';
											$row_name = $_SESSION['login_id']."-".$addnum."-".$leo ;

											$fam_col_name = 'song:index';
											//aar8 圖片
											$arr8 = $client->get($table_name, $row_name, $fam_col_name);
											
					                        foreach ( $arr8 as $k1=>$v1  ) {     		 
											$t1 =("{$v1->value}");} 

											if( $addsong == $t1 ){
												$x=1;
												$response["status"] = "haveadd";		
												echo json_encode($response);
												break;
											}
								
										}
												if($x == 0){
												$table_name = 'account';
												$row_name = $_SESSION['login_id']."-".$addnum; // ex.test-1
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
												'value' => $addsong		//------------ 歌曲編號
												 ) )
												 );
												$client->mutateRow( $table_name, $row_name."-".$tt, $mutations110 );
												$response["ok"] = "addok";		
												echo json_encode($response);	
												
												
												}								
							
								
					}								
			
				//刪除歌曲	 功能正常~~~~~~~~~~~~~~~~~~~~~~~~
				if( $_GET['delete']&&$_GET['num'] )
				//刪除歌曲				
					for($r1=1;$r1<=100;$r1++){				
							$table_name = 'account';
							$row_name = $_SESSION['login_id']."-".$_GET['num']."-".$r1 ;
							$fam_col_name = 'song:index';
							$arr8 = $client->get($table_name, $row_name, $fam_col_name);							
							if( @$arr8[0]->value  ){
								foreach ( $arr8 as $k=>$v  ) {		 
								$ss = ("{$v->value}"); 
								};							
									if( $ss == $_GET['delete'] ){
									$mutations = array(
									new Mutation( array(
										'column' => 'song:index',
										'value' => '00000-0'
									) ),
									);
									$client->mutateRow( $table_name, $row_name, $mutations );
									$response["status"] = "deleted";		
									echo json_encode($response);		
									}
								
							} 
							else{ break; }
					}	
				
?>
				
			
	
			