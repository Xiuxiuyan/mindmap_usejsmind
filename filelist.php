<?php 
session_start();
$filename=$_SESSION["filename"];
?>
<html>  
 <link type="text/css" rel="stylesheet" href="jsmind/style/jsmind.css" />
  <head>  
	<meta charset="utf-8">  
    <title>思维导图</title>  
    
    <style type="text/css">
        #header{
            background-color:black;
            color:white;
            text-align:center;
            padding:0.5px;
            height: 85px;
        }
        #mainWin{
            margin-left: 200px;
            margin-top: 20px;
        }
	     #jsmind_container{
	         width:100%;
	         height:500px;
	         border:solid 1px #ccc;
	         background:#f4f4f4;
	     }
        #nodeText{
            height:25px;
            margin-left: 20px;
        }
	    .btn{
            width: 100px;
            line-height: 38px;
            text-align: center;
            font-weight: bold;
            border-radius: 5px;
            margin:0 10px 10px 10px;
            position: relative;
            overflow: hidden;
	     	color: black;
            border:1px solid #dce1e6;
            box-shadow: 0 1px 2px #fff inset,0 -1px 0 #a8abae inset;
            background: #e4e8ec;/*-webkit-linear-gradient(top,#f2f3f7,#e4e8ec);
            background: -moz-linear-gradient(top,#f2f3f7,#e4e8ec);
            background: linear-gradient(top,#f2f3f7,#e4e8ec);*/
	     }
        .btn:active{
            top:1px;
            color: floralwhite;
            box-shadow: 0 1px 3px #114566 inset,0 3px 0 #fff;
            background: #6699CC;
        }
        #deleteBtn:active{
            background: #CC0000
        }
        .SideBar{
            padding: 10px 20px 10px 20px;
            line-height:30px;
            background-color:#eeeeee;
            height:100%;
            width:100%;
            float:left;
            position: absolute;
        }
        .SideBar h2 {
            color: #6B6E3F;
            border-bottom: thin #6B6E3F solid;
            margin-bottom: 10px;
			margin-left: 100px;
            margin-top: 20px;
			margin-right: 100px;
        }
        .SideBar ul {
            padding-left: 15px;
        }
        .SideBar li {
            padding-bottom: 8px;
        }
		.flist{ 
			width: 30%;
			height: 100%;
			position: absolute;
			top:100px;
    		left: 13%;
		}
	    </style>
  </head> 
<body>
	<div id="header"><h1>思维导图</h1></div>
    <div class="SideBar">
        <h2>我的文档</h2>
        <div class="flist">
        <?php foreach ($filename as $key=>$value):?>
        <li ><a href='picture.php?filename=<?php echo $value?>'><?php echo $value;?></a></li>
        <?php endforeach;?>
        <?php if(isset($filename["0"])==0):?>
        <li style="font-size: 30px">无文件，请新建文件</li>
        <?php endif;?>
        </div>
     </div>