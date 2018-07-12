<?php
  session_start();
  $uid=$_SESSION['name'];
  if(isset($_GET["fname"])){
  $name=$_GET["fname"];
  $filename=$_GET["filename"];
  //echo $filename;
  require("init.php");
  $str="select count(*) from cooperation where fid="."'"."$name"."'";
  $result=mysqli_query($link,$str);
  $count=mysqli_fetch_row($result);
  $cnt=$count[0];
  if($cnt==1)//判断是否存在该用户
    {
      echo"<script type="."\""."text/javascript"."\"".">"."window.alert"."("."\""."已邀请该用户"."\"".")".";"."</script>";
      echo"<script type="."\""."text/javascript"."\"".">"."window.location="."\""."app.php"."\""."</script>";   
      exit; 
    }
  $sql="insert into cooperation (uid,fid) values ("."\""."$uid"."\"".","."\""."$name"."\"".")";
  mysqli_query($link,$sql);
$sql1="insert into cooperation (uid,fid) values ("."\""."$name"."\"".","."\""."$uid"."\"".")";
  mysqli_query($link,$sql1);
  echo"<script type="."\""."text/javascript"."\"".">"."window.alert"."("."\""."邀请成功"."\"".")".";"."</script>";
 // echo"<script type="."\""."text/javascript"."\"".">"."window.location="."\""."app.php"."\""."</script>"; 
  $sql2="update cooperation set fname="."\""."$filename"."\""." WHERE uid="."\""."$name"."\""." and fid="."\""."$uid"."\""."";
      mysqli_query($link,$sql2);
	  $sql2="update cooperation set fname="."\""."$filename"."\""." WHERE uid="."\""."$uid"."\""." and fid="."\""."$name"."\""."";
      mysqli_query($link,$sql2);
}
  else{
	  print("error");
  }
  $close=mysqli_close($link);
            if($close)
            {
              echo"<script type="."\""."text/javascript"."\"".">"."window.location="."\""."picture.php?filename=$filename"."\""."</script>";    
            }
?>