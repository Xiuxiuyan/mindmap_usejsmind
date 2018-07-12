<?php
  session_start();
  $uid=$_SESSION['name'];
  if(isset($_GET["fname"])){
	  $name=$_GET["fname"];
	  $filename=$_GET["filename"];
  require("init.php");
  $sql="delete from	cooperation where uid="."\""."$uid"."\""." and fid="."\""."$name"."\""."";
  mysqli_query($link,$sql);
$sql1="delete from cooperation where uid="."\""."$name"."\""." and fid="."\""."$uid"."\""."";
  mysqli_query($link,$sql1);
  echo"<script type="."\""."text/javascript"."\"".">"."window.alert"."("."\""."移除成功"."\"".")".";"."</script>";
  echo"<script type="."\""."text/javascript"."\"".">"."window.location="."\""."app.php"."\""."</script>";
  }
  else{
	  print("error");
  }
?>