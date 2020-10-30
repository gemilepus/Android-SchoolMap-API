<?php
	//資料庫主機設定
    $dbhost = '127.0.0.1';
    $dbuser = 'root';
    $dbpass = '';
    $dbname = 'login-register-system';
	$db_link = @mysqli_connect( $dbhost, $dbuser, $dbpass);
	if (!$db_link) die("資料連結失敗！");
	//設定字元集與編碼
	mysqli_query($db_link, "SET NAMES utf8");
?>
