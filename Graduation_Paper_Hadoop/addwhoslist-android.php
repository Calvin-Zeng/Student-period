<?php
session_start(); 
	require_once('connections/thrift.php'); 
	require_once('connections/mysql.php'); 
	header('Content-Type: application/json');
	header('Access-Control-Allow-Origin: *');

	
	$_SESSION['login_id']=$_POST["login_id"];
	$_SESSION['id']=$_POST["whoid"];
	$_SESSION['num']=$_POST["listnum"];
	$num[100];
	if(isset($_POST['login_id'])){
		if( $_SESSION['login_id'] !=  $_SESSION['id'] ){		
			if($_SESSION['id'] != ''){
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
				$table_name = 'account';
				$row_name =  $_SESSION['id'].'-'.$_SESSION['num'];
				$fam_col_name = 'name';
				$arr111 = $client->get($table_name, $row_name , $fam_col_name);
				foreach ( $arr111 as $k=>$v  ) {		 
				$s1 = ("{$v->value}"); //從list_num 取數字
				}
				
				$mutations4 = array(
						new Mutation( array( 'column' => $fam_col_name, 
											'value' => $s1) 
											));
				$client->mutateRow( $table_name, $_SESSION['login_id']."-".$t , $mutations4 );
				
				$mutations10 = array(
						new Mutation( array(
				'column' => 'list:song_num',    //新增list:song_num
				'value' => 0
				 ) )
				 );
				$client->mutateRow( $table_name, $_SESSION['login_id']."-".$t, $mutations10 );		
				
				for($a=1;$a<=50;$a++){		
					$table_name = 'account';
					$row_name = $_SESSION['id'].'-'.$_SESSION['num'].'-'.$a;
					$fam_col_name = 'song:index';				
					$arr1110 = $client->get($table_name, $row_name , $fam_col_name);
					if( @$arr1110[0]->value ){
						foreach ( $arr1110 as $k=>$v  ) {		 
						$s19 = ("{$v->value}"); 
						}
						$num[$a]=$s19;
					}
				}
				
				for($a1=1;$a1<=50;$a1++){	
					$table_name = 'account';
					$row_name = $_SESSION['login_id']."-".$t;
					$fam_col_name = 'list:song_num';

					$arr1 = $client->get($table_name, $row_name , $fam_col_name);
					foreach ( $arr1 as $k=>$v  ) {		 
					$s5 = ("{$v->value}"); 
					}		
					;			
					$mutations = array(
					new Mutation( array(
					'column' => 'list:song_num',
					'value' => $s5+'1'
					) ),
					);
					$client->mutateRow( $table_name, $row_name, $mutations ); 	
					$f=$s5+1;
						if( $num[$a1] != '' ){
							$mutations41 = array(
									new Mutation( array( 'column' => 'song:index', 
														'value' => $num[$a1]) 
														));
							$client->mutateRow( $table_name, $_SESSION['login_id'].'-'.$t.'-'.$f , $mutations41 );	
						}
						else{
						$_SESSION['id'] = '';
						$_SESSION['num'] = '';
						$response["status"] = "whoslistadd";		
						echo json_encode($response);
						break;
						}
				}	
			
			}
		}
		else{
			$_SESSION['id'] = '';
			$_SESSION['num'] = '';
			$response["status"] = "sameperson";		
			echo json_encode($response);

		}
		
	}
?>
