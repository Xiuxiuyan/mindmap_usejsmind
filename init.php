<?php
$link=mysqli_connect("localhost","root","","web");//链接数据库
header("Content-type:text/html;charset=utf-8");
if($link)
  {  
    //echo"链接数据库成功";
    $select=mysqli_select_db($link,"web");//选择数据库
    if($select)
    {
      //echo"选择数据库成功！";
	}
  }

?>