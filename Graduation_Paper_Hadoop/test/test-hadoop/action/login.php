<?php
if (isset($_POST['login_id'])){
	$loginid = $_POST['login_id'];
	$loginpw = $_POST['login_password'];
	//@session_start();
	$_SESSION['login_id']=$_POST['login_id'];
	if ($loginid == '' || $loginpw == ''){
		echo "<script language=\"javascript\">"; 
		echo "window.alert('請填入資料!')"; 
		echo "</script>";
	}
	else{ 
		$table_name = 'account';
		$fam_col_name = 'name';
		$arr = $client->get($table_name, $loginid, $fam_col_name );
		$arr1 = $client->get($table_name, $loginpw, $fam_col_name );
		if($loginid = @$arr[0]->value && $loginpw = @$arr1[0]->value ){
			//@session_start();
			$_SESSION['login']="1";
			echo "<script language=\"javascript\">"; 
			echo "window.alert('登入成功')"; 
			echo "</script>"; 
		}else{
			echo "<script language=\"javascript\">"; 
			echo "window.alert('帳號或密碼錯誤')"; 
			echo "</script>"; 
		}
	}
}
?>