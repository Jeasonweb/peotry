<?php
$host='127.0.0.1';
$aname='root';
$apwd='';
$dbname='Peotries';
$port=3306;
$conn=mysqli_connect($host,$aname,$apwd,$dbname,$port);
//$conn = mysqli_connect(SAE_MYSQL_HOST_M, SAE_MYSQL_USER, SAE_MYSQL_PASS, SAE_MYSQL_DB, SAE_MYSQL_PORT);
$sql="SET NAMES UTF8";
mysqli_query($conn,$sql);
?>