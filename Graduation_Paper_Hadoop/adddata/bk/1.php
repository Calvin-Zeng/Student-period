				  <?php
				  $category = $_POST['musicclass'];
				  //echo $category ;
				  if($category=="類別"){
				  echo "請選";
				  }
				  
				  
				  ?>
				  <meta http-equiv="content-type" content="text/html; charset=utf-8" />
				  <form action="<?php $_SERVER["PHP_SELF"];?>" method="post">
				  <p><select name="musicclass">
										<option >類別</option>
										<option value="POP111111" >POP</option>
										<option value="R&B">R&B</option>
										<option value="hiphop">hiphop</option>
										</select>
										
														  <input type="submit" value="Submit" /> 
 </form>	