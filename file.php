<?php
session_start();
$uid=$_SESSION["name"];
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
          $filename = $_POST["filename"];
          //$uphone = $phone;     //用户名不知道怎么来
        if($filename=="")//判断是否填写
        {
          echo"<script type="."\""."text/javascript"."\"".">"."window.alert"."("."\""."请填写文件名！"."\"".")".";"."</script>";
          echo"<script type="."\""."text/javascript"."\"".">"."window.location="."\""."app.php"."\""."</script>";    
          exit;
        }          
            $str="select count(*) from file where fname="."'"."$filename"."' and uid="."'"."$uid"."'";
            $result=mysqli_query($link,$str);
            $pass=mysqli_fetch_row($result);
            $pa=$pass[0];
            if($pa==1)//判断数据库表中是否已存在该文件
            {
                echo"<script type="."\""."text/javascript"."\"".">"."window.alert"."("."\""."该文件已存在"."\"".")".";"."</script>";
                echo"<script type="."\""."text/javascript"."\"".">"."window.location="."\""."app.php"."\""."</script>";   
                exit; 
            }
           $content='{"meta":{"name":"myMind","author":"hizzgdev@163.com","version":"0.2"},"format":"node_array","data":[{"id":"root","topic":"'.$filename.'","expanded":true,"isroot":true}]}';
		  $content=addslashes($content);
		  //echo($content);
		    $sql="insert into file (fname,uid,content) values ("."\""."$filename"."\"".","."\""."$uid"."\"".","."\""."$content"."\"".")";        
 	        echo"<script type="."\""."text/javascript"."\"".">"."window.alert"."("."\""."添加文件成功"."\"".")".";"."</script>";
		     echo"<script type="."\""."text/javascript"."\"".">"."window.location="."\""."picture.php?filename=$filename"."\""."</script>";   
            mysqli_query($link,$sql);
            $close=mysqli_close($link);
           /* if($close)
            {
              
            }*/
        
      }
    }
  }
?>