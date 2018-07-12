<?php
$link=mysqli_connect("localhost","root","","web");//链接数据库
header("Content-type:text/html;charset=utf-8");
if($link)
  {  
    echo"链接数据库成功";
    $select=mysqli_select_db($link,"web");//选择数据库
    if($select)
    {
      echo"选择数据库成功！";
      if(isset($_POST["sub"]))
      {
		$phone=$_POST["phone"];
        $name=$_POST["name"];
        $password1=$_POST["upwd"];//获取表单数据
        $password2=$_POST["cpwd"];
        if($phone==""||$name==""||$password1=="")//判断是否填写
        {
          echo"<script type="."\""."text/javascript"."\"".">"."window.alert"."("."\""."请填写完成！"."\"".")".";"."</script>";
          echo"<script type="."\""."text/javascript"."\"".">"."window.location="."\""."register.html"."\""."</script>";    
          exit;
        }
        if($password1==$password2)//确认密码是否正确
        {
        $str="select count(*) from user where phone="."'"."$phone"."' or name="."'"."$name"."'";
        $result=mysqli_query($link,$str);
        $pass=mysqli_fetch_row($result);
        $pa=$pass[0];
        if($pa==1)//判断数据库表中是否已存在该用户名
        {
        
        echo"<script type="."\""."text/javascript"."\"".">"."window.alert"."("."\""."该用户名已被注册"."\"".")".";"."</script>";
        echo"<script type="."\""."text/javascript"."\"".">"."window.location="."\""."register.html"."\""."</script>";   
        exit; 
        }
        $sql="insert into user values("."\""."$phone"."\"".","."\""."$name"."\"".","."\""."$password1"."\"".")";//将注册信息插入数据库表中
        //echo"$sql";
        mysqli_query($link,$sql);
        mysqli_query('SET NAMES UTF8');
        $close=mysqli_close($link);
        if($close)
        {
          //echo"数据库关闭";
          //echo"注册成功！";
          echo"<script type="."\""."text/javascript"."\"".">"."window.location="."\""."return.html"."\""."</script>";    
        }
        }
        else
        {
          echo"<script type="."\""."text/javascript"."\"".">"."window.alert"."("."\""."密码不一致！"."\"".")".";"."</script>";
          echo"<script type="."\""."text/javascript"."\"".">"."window.location="."\""."register.html"."\""."</script>";    
        }
      }
    }
  }
?>