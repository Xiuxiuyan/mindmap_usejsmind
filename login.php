<?php
session_start();
$link=mysqli_connect("localhost","root","","web");//链接数据库

header("Content-type:text/html;charset=utf-8");
if($link)
{ echo("连接成功");
  $select=mysqli_select_db($link,"web");
  if($select)
  {
	echo("选择成功");
    if(isset($_POST["sub1"]))
    {
      $phone=$_POST["phone1"];
	  $_SESSION["uid"]=$phone;
      $password=$_POST["password1"];
      if($phone==""||$password=="")//判断是否为空
      {
        echo"<script type="."\""."text/javascript"."\"".">"."window.alert"."("."\""."请填写正确的信息！"."\"".")".";"."</script>";
        echo"<script type="."\""."text/javascript"."\"".">"."window.location="."\""."login.html"."\""."</script>";
        exit;
      }
      $str="select password from user where phone="."'"."$phone"."'";
      mysqli_query('SET NAMES UTF8');     $result=mysqli_query($link,$str);
      $pass=mysqli_fetch_row($result);
	  $pa=$pass[0];  
	  $str1="select name from user where phone="."'"."$phone"."'";
      mysqli_query('SET NAMES UTF8');     $result=mysqli_query($link,$str1);
      $name=mysqli_fetch_row($result);
	  $na=$name[0];
	  session_start();
	  $_SESSION["name"]="$na";
if(empty($_SESSION["name"]))               //判断session里面是不是存储到值，如果没有存储，让其跳转到登录界面
{
    header("location:login.html");
    exit;
}
      if($pa==$password)//判断密码与注册时密码是否一致
      {
        echo"登录成功！";
        echo"<script type="."\""."text/javascript"."\"".">"."window.location="."\""."success.html"."\""."</script>";
      }
      {  
        echo"<script type="."\""."text/javascript"."\"".">"."window.alert"."("."\""."登录失败！"."\"".")".";"."</script>";
        echo"<script type="."\""."text/javascript"."\"".">"."window.location="."\""."login.html"."\""."</script>";
      }
    }
    else
	{ echo("表单提交失败");}
  }
}
?>