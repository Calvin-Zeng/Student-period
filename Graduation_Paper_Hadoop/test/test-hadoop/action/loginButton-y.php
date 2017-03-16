<div id="menu-wrapper">
	<div id="menu">
	<ul>
		<li class="current_page_item"><a href="index.php">首頁</a></li>
		<li><a href="mylist.php">我的頻道</a></li>
		<li><a href="music.php">音樂</a></li>
		<li><a href="contact.php">聯絡我們</a></li>
		<li><a href="action/logout.php"><?php echo $_SESSION['login_id']." , ";?>登出</a></li>
	</ul>
	</div>
</div>