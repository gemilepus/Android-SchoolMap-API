<?php
    include("../connMysqlObj.php");
	$seldb = @mysqli_select_db($db_link, "login-register-system");
	if (!$seldb) die("資料庫選擇失敗！");

	$sql_query = "SELECT * FROM info ";
	$result = mysqli_query($db_link, $sql_query);

$code=array();
$code['android']=array();

while($row_result=mysqli_fetch_assoc($result)){

$row_array['head']=$row_result['head'];

$row_array['type']= $row_result['type'];

$row_array['text']= $row_result['text'];

array_push($code['android'],$row_array);

}

echo json_encode($code);
?>
	