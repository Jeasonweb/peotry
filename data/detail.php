<?php
header("Content-Type:application/json;charset=UTF-8");
#$uname=$_REQUEST['uname'];
$currPage=$_REQUEST['currPage'];
if(!$currPage)
{
$currPage=1;
}
$pKind=$_REQUEST['pkind'];
include('common.php');
$output=["totalRecord"=>0,"pageSize"=>1,"pageCount"=>0,"currPage"=>intVal($currPage),'data'=>[]];
$sql="SELECT COUNT(*) FROM peotry WHERE pKind='$pKind'";
$output['totalRecord']=intVal(mysqli_fetch_assoc(mysqli_query($conn,$sql))['COUNT(*)']);
$start=($currPage-1)*$output['pageSize'];
$output['pageCount']=ceil($output['totalRecord']/$output['pageSize']);
$sql="SELECT * FROM peotry WHERE pKind='$pKind' LIMIT $start,$output[pageSize]";
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