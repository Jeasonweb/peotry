<?php
header("Content-Type:application/json;charset=UTF-8");
//$uname=$_REQUEST['uname'];
$pKind=$_REQUEST['pkind'];
$cId=$pKind+1;
include('common.php');
@$start = $_REQUEST['start'];
if(empty($start)) {
    $start = 0; //默认从 0 开始
 }
//$sql="SELECT ckind FROM category WHERE cid='$cId'";
$sql="SELECT ckind,cintro FROM category WHERE cid='$cId'";
$myCategory=mysqli_fetch_assoc(mysqli_query($conn,$sql))['ckind'];
$cintro=mysqli_fetch_assoc(mysqli_query($conn,$sql))['cintro'];
$output=["totalRecord"=>0,"pkind"=>$myCategory,"cintro"=>$cintro,'data'=>[]];

$sql="SELECT COUNT(*) FROM peotry WHERE pKind='$pKind'";
$output['totalRecord']=intVal(mysqli_fetch_assoc(mysqli_query($conn,$sql))['COUNT(*)']);
$pageSize=10;
$sql="SELECT * FROM peotry WHERE pKind='$pKind' LIMIT $start,$pageSize";
$result=mysqli_query($conn,$sql);

if($result===false)
{
echo "操作失败，操作失败语句为$sql";
}else
{
	$output['data']=[];
	while(($row=mysqli_fetch_assoc($result)))			
		{
			
			$output['data'][]=$row;
			
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