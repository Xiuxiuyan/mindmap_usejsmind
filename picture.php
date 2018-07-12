<meta http-equiv="refresh" content="15">
<?php header("Pragma: no-cache"); ?>
<?php
require("init.php");
function searchCont(){
$link1=mysqli_connect("localhost","root","","web");
if(isset($_GET["filename"])){
	$fname1=$_GET["filename"];
	$str4="select content from file where fname="."'"."$fname1"."'";
    $result4=mysqli_query($link1,$str4);
    $cont=mysqli_fetch_row($result4);
	$content=$cont[0];
	mysqli_close($link1);
	return($content);
	echo $content;   
}
}

$content=searchCont();
//echo($content);
$fname1=$_GET["filename"];

?>


<!DOCTYPE html>
<?php session_start();
$uid=$_SESSION["uid"];
$name=$_SESSION["name"];
require("init.php");
$str1="select name from user where phone in(select fid from friend where uid="."'"."$uid"."')";
$result1=mysqli_query($link,$str1);
$fri=mysqli_fetch_all($result1);
$friend=array_column($fri,'0');
$str2="select fid from cooperation where uid="."'"."$name"."'";
$result2=mysqli_query($link,$str2);
$coo=mysqli_fetch_all($result2);
$coop=array_column($coo,'0');
$str3="select fname from file where uid="."'"."$name"."'";
$result3=mysqli_query($link,$str3);
$file=mysqli_fetch_all($result3);
$fname=array_column($file,'0');
$filename=array_reverse($fname);
$_SESSION["filename"]=$filename;
$str5="select fname from cooperation where uid="."'"."$name"."'";
$result5=mysqli_query($link,$str5);
$cfile=mysqli_fetch_row($result5);
$coopfile=$cfile[0];
mysqli_close($link);
if(!isset($coopfile)){
//	echo"<script type="."\""."text/javascript"."\"".">"."window.location="."\""."app.php"."\""."</script>";
}
?>
<script>
	function saveMap(filename){
		//update();
		var mind_data = jm.get_data('node_array');
		var mind_str = JSON.stringify(mind_data);
		window.location.href="save.php?content="+mind_str+"&filename="+filename;
	/*	$.ajax ({  
        type:"get",  
        url:'save.php',  
        dataType:"text",  
        data: {'content':mind_str,'filename':filename},  
		error: function(){       //出错处理，一般加上，但其实传参没什么出错。
             alert('请求超时');  
         },  
        success: function(){  
        //    alert(eval(data)[4][0]);  
            }  
});  */
	}

</script>
<html>  
 <link type="text/css" rel="stylesheet" href="jsmind/style/jsmind.css" />
  <head>  
	<meta charset="utf-8">  
    <title><?php echo $fname1?></title>  
    
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
            padding: 10px 20px 0px 20px;
            line-height:30px;
            background-color:#eeeeee;
            height:100%;
            width:160px;
            float:left;
            position: absolute;
        }
        .SideBar h2 {
            color: #000000;
            border-bottom: thin #000000 solid;
            margin-bottom: 10px;
            margin-top: 20px;
        }
        .SideBar ul {
            padding-left: 15px;
        }
        .SideBar li {
            padding-bottom: 8px;
        }
		.xinjian {
			margin-top: 50px;
		}
		a{ text-decoration:none; color:#000000;}
	    </style>
  </head> 
<body>
    <div id='transmit' style="display:none"><?php echo $fname1;?></div>
	<div id="header"><h1>思维导图</h1></div>
    <div class="SideBar">
        <h2><a href="filelist.php">我的文件</a></h2>
        <ul>
          <?php if(isset($filename["0"])):?>
           <li><a href='picture.php?filename=<?php echo $filename["0"]?>'><?php echo $filename["0"];?></a></li>
          <?php endif;?>
          <?php if(isset($filename["1"])):?>
           <li><a href='picture.php?filename=<?php echo  $filename["1"]?>'><?php echo $filename['1'];?></a></li>
          <?php endif;?>
        </ul>
         <h2>协同文件</h2>
        <ul>
          <?php if(isset($coopfile)):?>
           <li><a href='picture.php?filename=<?php echo $coopfile?>'><?php echo $coopfile;?></a></li>
          <?php endif;?>
		</ul>
        <ul>
        	<li class="xinjian">新建思维导图
				<form method="post" action="file.php">
                    <input type="text" name="filename" id="filename" placeholder="请输入文件名">
                    <input type="submit" name="sub" value="新建" onclick="newFile()">
              </form>
			
			</li>
        	<li>打开本地文件
       	      <input type="file" class="file" name="" id="file_input"/>
        	  <button onclick="openFile()">打开</button>
		  </li>
       <li>
       	添加好友
       	<form action="friend.php" method="post">
       	<input type="text" name="friend" placeholder="请输入手机" required="">
       	<input type="submit" name="sub1" value="添加" >
		 </form>
       </li>
        </ul>
        
<div class="friend">
<div id="mainMenu">
  <ul id="menuList">
  <li class="menubar">
   <a href="#" id="productsActuator" class="actuator">用户列表</a>
   <ul id="productsMenu" class="menu">
   <li>
    <a href="#" id="newPhonesActuator" class="actuator">我的好友</a>
    
    <ul id="newPhonesMenu" class="submenu">
     <?php foreach ($friend as $key=>$value):?>
    <li><a href="#" title="邀请加入协同" onClick="invite('<?php echo $value?>')"><?php echo $value;$_SESSION["fid"]=$value;?></a></li>
     <?php endforeach;?>
	</ul>
   </li>
   <li>
    <a href="#" id="compareActuator" class="actuator">正在协同</a>
    <ul id="compareMenu" class="submenu">
     <?php foreach ($coop as $key=>$value):?>
    <li><a href="#" title="结束协同" onClick="dinvite('<?php echo $value;?>')"><?php echo $value;?></a></li>
     <?php endforeach;?>
    </ul>
   </li>
   </ul>
  </li>
  </ul>
 </div>
 </div>

    </div>
    <div id="mainWin">
        <div>
            <input type="text" id="nodeText" placeholder="输入节点内容" >
            <script>var fn= <?php echo "\"".$fname1."\"";?>;</script>
            <button class="btn" onclick="createNewNode(fn);">新建节点</button>
            <button class="btn" id="deleteBtn" onclick="deleteNode(fn)">删除节点</button>
            <button class="btn" onclick="saveFile()">保存为文件</button>
            <button class="btn" onclick="savePic()">保存为图片</button>
			
            
            <button class="btn" onclick="saveMap(fn)">保存到云端</button>
            <button id="zoomInBtn" onclick="zoomIn()" style="margin-left: 10px;">+</button>
            <button id="zoomOutBtn" onclick="zoomOut()">-</button>
            
            <div style="float:right; margin-right: 30px;">
	        	<!-- <img src="headpic.jpeg" width="25px" height="25px" /> --> 
	        	用户名:<?php echo $name;?>
	        </div>
            <div style="float: right; margin-right: 100px; margin-top: 0px;">
				选择样式
                <select onchange="setTheme(this.options[this.options.selectedIndex].value)" style="height:30px; width: 75px;">
                    <option value="primary" selected>primary</option>
                    <option value="asphalt">asphalt</option>
                    <option value="warning">warning</option>
                </select>
            </div>
        </div>
        <div id="jsmind_container"></div>
    </div>
    

<script type="text/javascript" src="./jquery.min.js"></script>
<script type="text/javascript" src="./jsmind/js/jsmind.js"></script>
<script type="text/javascript" src="./jsmind/js/jsmind.draggable.js"></script>
<script type="text/javascript" src="./jsmind/js/jsmind.screenshot.js"></script>
<script type="text/javascript">
	var gbfjdid;
    var id = 1;
    //思维导图所有节点
    var data = [{"id":"root", "isroot":true, "topic":"myMind"},
               ];
    var mind = <?php echo $content?>;//
    var options = {
        container:'jsmind_container',
        editable:true,
        theme:'primary'
    }
    var jm = jsMind.show(options,mind);
	setInterval("test()",2000);
    function test() {
    $.ajax({
        type: "get",
        url: "getContent.php",
        timeout: 60000,
        async: true,
        data: {"filename":fn},
        success: function(data) { 
			var a=jm.get_data('node_array');
			var b=JSON.stringify(a);
			b=b.replace(/\s/ig,'');
			//alert(b);
			var c=data.replace(/\s/ig,'');
			//alert(c);
			if(b!=c){
			 //  alert(data);
			c=JSON.parse(data);
			jm.show(c);
		};
        }
    });
}
	
	//数据库中获取的思维导图
    var dboptions = {
            container:'container',
            editable:true,
            theme:'primary'
        }
	
    var dbmind;
    var mind1;
	
	function showMap(fn)
	{   
		xmlhttp=new XMLHttpRequest();
		xmlhttp.onreadystatechange=function(){
			if(xmlhttp.readyState==4&&xmlhttp.status==200){
				mind1=xmlhttp.responseText;	
				//alert(mind1);
            }
		}
		xmlhttp.open("GET","getContent.php?filename="+fn,false);
		xmlhttp.send();	
		//alert(1);
		return mind1;
	}
	
	function update(fn){
		//showMap(fn);
    	var dbmindStr = showMap(fn);//php获取的数据库里的思维导图的字符串形式
		//alert(dbmindStr);
		dbmind = JSON.parse(dbmindStr);
        var dbmindmap = dbmind.data;//思维导图内容的json格式
    	//alert(JSON.stringify(dbmindmap));
        
        //当前显示的思维导图
        var map_json = jm.get_data('node_array');
        var map = map_json.data;
        //alert(JSON.stringify(map));
        //根据网页更新节点的内容
        /*for(var i=0; i<dbmindmap.length; i++)
            for(var j=0; j<map.length; j++)
                if(dbmindmap[i].id == map[j].id){//找到id相同的节点
                    if(dbmindmap[i].topic != map[j].topic){//网页上节点内容改变
                        //保留网页上的节点内容
                        dbmindmap[i].topic = map[j].topic;
                    }
                    if(dbmindmap[i].parentid != map[j].parentid){//网页上节点拖动，父节点不同
                        //网页中改变后的父节点在数据库中的图里还有的话就改为网页上的父节点
                        for(var k=0; k<dbmindmap.length; k++)
                            if(dbmindmap[k].id == map[j].parentid)
                                dbmindmap[i].parentid = map[j].parentid;
                    }
                    break;
                }*/
        //alert(JSON.stringify(dbmindmap));
        mind = dbmind;
        jm.show(mind);
    }
	
    //新建节点
	function createNewNode(fn){
        update(fn);
		//showMap(fn);
        var text = document.getElementById("nodeText");
	    var newnode = {"id":text.value, "parentid":"root", "topic":text.value};
        if(!newnode.topic)
            alert("请输入节点内容");
        else{
            jm.add_node(newnode.parentid, newnode.id, newnode.topic);
			saveMap(fn);
            //alert(JSON.stringify(jm.get_data('node_array')));
        }
    }
    
    //删除节点
    function deleteNode(fn){
        var map_json = jm.get_data('node_array');
        //alert(JSON.stringify(map_json));
        var _node = jm.get_selected_node();
        var id = _node.id;
        //alert(id);
        var children = _node.children;
        var ci = children.length;
        update(fn);
        if(_node == null)
            alert("请选择一个节点");
        else if(_node.id == "root")
            alert("根节点不能删除");
        else{
            for(var i=0; i<mind.data.length; i++){
                //alert(mind.data[i].id == id);
                if(mind.data[i].id == id){//图中有要删除的节点就删除
                    jm.remove_node(id);
                    //alert(JSON.stringify(jm.get_data('node_array')));
                    break;
                }
            }
            mind = jm.get_data('node_array');
			window.location.href="picture.php?filename=<?php echo $fname1?>";
            jm.show(mind);
        }
		saveMap(fn);
    }
    //保存为jm文件
    function saveFile(){
    	var mind_data = jm.get_data('node_array');
    	var mind_name = mind_data.meta.name;
    	var mind_str = jsMind.util.json.json2string(mind_data);
    	jsMind.util.file.save(mind_str, 'text/jsmind', mind_name + '.jm');
		
    }
	
	
	
    //打开保存好的jm文件
    function openFile(){
    	var file_input = document.getElementById('file_input');
    	var files = file_input.files;
    	if(files.length > 0){
    		var file_data = files[0];
    		jsMind.util.file.read(file_data, function(jsmind_data, jsmind_name){
    			var mind = jsMind.util.json.string2json(jsmind_data);
    			if(!!mind){
    				jm.show(mind);
    			}else{
    				alert("选择的文件不能打开成一个思维导图");
    			}
    		});
    	}else{
    		alert("请先选择一个文件");
    	}
    }
    //保存为png图片
    function savePic(){
    	jm.screenshot.shootDownload();
    }
    
    //缩放（html中未实现）
    var zoomInButton = document.getElementById("zoomInBtn");
    var zoomOutButton = document.getElementById("zoomOutBtn");

    function zoomIn() {
        if (jm.view.zoomIn()) {
            zoomOutButton.disabled = false;
        } else {
            zoomInButton.disabled = true;
        };
    };

    function zoomOut() {
        if (jm.view.zoomOut()) {
            zoomInButton.disabled = false;
        } else {
            zoomOutButton.disabled = true;
        };
    };
    //设置节点样式
    function setTheme(theme){
        jm.set_theme(theme);
    }
    
    function newFile(){
    	//alert("1");
        var filename = document.getElementById("filename");
       // alert(filename.value);
        jm.update_node("root",filename.value);
    }
	
	//显示用户的文件
   
/*function load_jsmind(){
    // jm.set_readonly(true);
    // var mind_data = jm.get_data();
    // alert(mind_data);
    jm.add_node("root","sub23", "new node", {"background-color":"red"});
    jm.remove_node("sub1");
    jm.set_node_color('sub21', 'green', '#ccc');
    }*/
    function invite(fname){
		var se=confirm("邀请该用户加入协同？");
		if(se!="0")
			{
				window.location.href='coop.php?fname='+fname+'&filename=<?php echo $fname1?>';
			}
		else
			{
        	window.location.href="picture.php?filename=<?php echo $fname1?>"
			}
	}
	
	function dinvite(fname){
		var se=confirm("是否将该用户移出协同分组？");
		if(se!="0")
			{
				window.location.href='delete.php?fname='+fname+'&filename=<?php echo $fname1?>';
			}
		else
			{
        	window.location.href="picture.php?filename=<?php echo $fname1?>"
			}
	}
    //load_jsmind();
</script>
<script>
if (!document.getElementById)
 document.getElementById = function() { return null; }
function initializeMenu(menuId, actuatorId) {
 var menu = document.getElementById(menuId);
 var actuator = document.getElementById(actuatorId);
 if (menu == null || actuator == null) return;
 actuator.parentNode.style.backgroundImage = "url()";
 actuator.onclick = function() {
  var display = menu.style.display;
  this.parentNode.style.backgroundImage =
   (display == "block") ? "url()" : "url()";
  menu.style.display = (display == "block") ? "none" : "block";
  return false;
 }
}
 window.onload = function() {
   initializeMenu("productsMenu", "productsActuator");
   initializeMenu("newPhonesMenu", "newPhonesActuator");
   initializeMenu("compareMenu", "compareActuator");
  }
</script>
		
</body>  
</html>  

	