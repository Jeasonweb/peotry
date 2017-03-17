<?php
/**根据关键字查询数据**/
header('Content-Type:application/json');
$output = [];
@$kw = $_REQUEST['kw'];      //搜索关键字
$pKind=$_REQUEST['pkind'];
$cId=$pKind+1;
if( empty($kw) ){
    echo '[]';  //若客户端未提交kw，则直接返回一个空数组
    return;
}
@$start = $_REQUEST['start'];  //@符号可以压制当前行产生的错误提示
if( empty($start) ){  //若$start变量为空（即客户端未提交该变量）
    $start = 0;     //若客户端未提交其实行号则从第0行开始读取记录
}
$pageSize = 10;  //一次可以向客户端返回的最大的记录数
include('common.php');

$sql = "SELECT category.ckind,category.cintro,peotry.pContent,peotry.pComment,peotry.pAuthor,peotry.pKind,peotry.pTitle,peotry.pId  FROM  category,peotry WHERE peotry.pKind=category.cid AND category.cid='$cId' AND peotry.pTitle LIKE '%$kw%' LIMIT $start,$pageSize";
$result = mysqli_query($conn, $sql);
//var_dump($result); //提示：若显示bool(false)说明SQL语句语法错误
while( true ){
    //从结果集中读取一行记录
    $row = mysqli_fetch_assoc($result);
    if(! $row ){  //没有获取到更多记录行
        break;
    }
    $output[] = $row;
}

echo json_encode($output);
?>