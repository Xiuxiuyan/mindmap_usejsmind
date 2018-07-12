<?php
session_start();
$uid=$_SESSION["uid"];
$link=mysqli_connect("localhost","root","","web");//链接数据库
header("Content-type:text/html;charset=utf-8");
if($link)
  {  
    echo"链接数据库成功";
    $select=mysqli_select_db($link,"web");//选择数据库
    if($select)
    {
      echo"选择数据库成功！";
      if(isset($_POST["sub1"]))
      {  
		  $fid=$_POST["friend"];         
            $str="select count(*) from user where phone="."'"."$fid"."'";
            $result=mysqli_query($link,$str);
            $count=mysqli_fetch_row($result);
            $cnt=$count[0];
            if($cnt==0)//判断是否存在该用户
            {
                echo"<script type="."\""."text/javascript"."\"".">"."window.alert"."("."\""."该用户不存在"."\"".")".";"."</script>";
                echo"<script type="."\""."text/javascript"."\"".">"."window.location="."\""."app.php"."\""."</script>";   
                exit; 
            }
		  $str3="select count(*) from friend where uid ="."'"."$uid"."' and fid="."'"."$fid"."'";
        $result3=mysqli_query($link,$str3);
        $count1=mysqli_fetch_row($result3);
        $cnt1=$count1[0];
        if($cnt1==1)//判断朋友列表中是否已存在该用户名
        {
        
        echo"<script type="."\""."text/javascript"."\"".">"."window.alert"."("."\""."该用户名已是您的好友"."\"".")".";"."</script>"; 
	    echo"<script type="."\""."text/javascript"."\"".">"."window.location="."\""."app.php"."\""."</script>";   
        exit;
        }
            
            $sql="insert into friend (uid,fid) values ("."\""."$uid"."\"".","."\""."$fid"."\"".")";
            mysqli_query($link,$sql);
		    $sql1="insert into friend (uid,fid) values ("."\""."$fid"."\"".","."\""."$uid"."\"".")";
            mysqli_query($link,$sql1);
		  echo"<script type="."\""."text/javascript"."\"".">"."window.alert"."("."\""."添加成功"."\"".")".";"."</script>";
            mysqli_query('SET NAMES UTF8');
		   $str1="select fid from friend where uid="."'"."$uid"."'";
	  /*$result1=mysqli_query($link,$str1);
      $fri=mysqli_fetch_all($result1);
	  $friend=array_column($fri,'0');
		  $str2="select name from user where phone="."'"."$friend"."' ";
	  $result2=mysqli_query($link,$str2);
      $fname=mysqli_fetch_row($result2);
	  $_SESSION["friend"]=$friend;
	  foreach($friend as $value){
		  echo "<script type="."\""."text/javascript"."\"".">"."window.alert"."("."\""."$value"."\"".")".";"."</script>";
	  }*/
            $close=mysqli_close($link);
            if($close)
            {
              echo"<script type="."\""."text/javascript"."\"".">"."window.location="."\""."app.php"."\""."</script>";    
            }
        
      }
    }
	 
	  
  }
?>