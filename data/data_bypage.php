<?php
 /**分页查询数据，由main.html调用**/
 header('Content-Type:application/json');
$output = [];

$count = 10; //一次最多查询 5 条
@$start = $_REQUEST['start'];  //@符号可以压制当前行产生的错误提示

if(empty($start)) {
    $start = 0; //默认从 0 开始
 }
include('common.php');
$pageSize=10;
 $sql = "SELECT peotry.pContent,peotry.pComment,peotry.pAuthor,peotry.pKind,peotry.pTitle,peotry.pId  FROM  peotry WHERE  LIMIT $start,$pageSize";
 $result = mysqli_query($conn, $sql);
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