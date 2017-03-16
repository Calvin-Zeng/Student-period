<div id="menu-wrapper">
	<div id="menu">
	<ul>
		<li class="current_page_item"><a href="index.php">首頁</a></li>
		<li> <a href="#" id="loginButton"><span>登入</span></a>
		<div id="loginBox">                
		<form id="loginForm" name="form" method="post" action="<?php $_SERVER["PHP_SELF"];?>" >
			<fieldset id="body">
				<fieldset>
				<label for="email">帳號</label>
				<input name="login_id" type="text" class="text-field" />
				</fieldset>
			<fieldset>
				<label for="password">密碼</label>
				<input name="login_password" type="password" class="text-field" />
			</fieldset>
				<input type="submit" id="login" value="登入"  />
				<input type="button" id="login" value="註冊" onclick="location.href='register.php'" />
			</fieldset>
		</form>
		</div>
		</li>
	</ul>
	</div>
</div>