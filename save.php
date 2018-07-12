<?php
      session_start();
        $fname=$_GET["filename"];
    	$uid=$_SESSION["name"];
        $fid=$_SESSION["fid"];
        //echo $fid;
		$con=$_GET["content"];
      // echo($fname);
      // echo($uid);
     //  echo($con);
		$content=addslashes($con);
        require("init.php");
		  //echo($content);
		$sql="update file set content="."\""."$content"."\""." WHERE (fname="."\""."$fname"."\""." and uid="."\""."$uid"."\"".") or (fname="."\""."$fname"."\""." and uid="."\""."$fid"."\"".")";
         mysqli_query($link,$sql);
        $close=mysqli_close($link);
            if($close)
            {
             echo"<script type="."\""."text/javascript"."\"".">"."window.location="."\""."picture.php?filename=$fname"."\""."</script>";    
            }
	?>