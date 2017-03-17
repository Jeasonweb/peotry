<?php
header("Content-Type:application/json;charset=UTF-8");
$pId=$_REQUEST['pId'];
include('common.php');
$sql="SELECT * FROM peotry WHERE pId='$pId'";
$result=mysqli_query($conn,$sql);

	if($result===false)
	{
	echo "操作失败，操作失败语句为$sql";
	}else
	{
		while(($row=mysqli_fetch_assoc($result)))
		{
			$output=$row;			
		}
		if($output)
		{
			echo json_encode($output);
		}else
		{
			echo '请求成功，但结果无效';	
		}
		
	}
?>