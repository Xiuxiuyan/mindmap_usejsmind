<?php 
 require('init.php');
    $fname1=$_GET['filename'];
	$str="select content from file where fname="."'"."$fname1"."'";
    $result=mysqli_query($link,$str);
    $cont=mysqli_fetch_row($result);
	$content=$cont[0];
    $close=mysqli_close($link);
    //$content=addslashes($content);
	echo $content;
?>