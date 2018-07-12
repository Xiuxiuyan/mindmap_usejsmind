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
            border-bottom: thin #6B6E3F solid;
            margin-bottom: 10px;
            margin-top: 20px;
        }
        .SideBar ul {
            padding-left: 15px;
        }
        .SideBar li {
            padding-bottom: 8px;
        }
		a{ text-decoration:none; color:#000000;}
	    </style>
  </head> 
<body>
	<div id="header"><h1>思维导图</h1></div>
    <div class="SideBar">
        <h2><a href="filelist.php">我的文件</a></h2>
        <ul>
          <?php if(isset($filename["0"])):?>
           <li><a href='picture.php?filename=<?php echo $filename["0"]?>'><?php echo $filename["0"];?></a></li>
          <?php endif;?>
          <?php if(isset($filename["1"])):?>
           <li><a href='picture.php?filename=<?php echo $filename["1"]?>'><?php echo $filename['1'];?></a></li>
          <?php endif;?>
        </ul>
         <h2>协同文件</h2>
        <ul>
          <?php if(isset($coopfile)):?>
           <li><a href='picture.php?filename=<?php echo $coopfile?>'><?php echo $coopfile;?></a></li>
          <?php endif;?>
        </ul>
        <ul>
        	<li>新建思维导图
				<form method="post" action="file.php">
                    <input type="text" name="filename" id="filename" placeholder="请输入文件名">
                    <input type="submit" name="sub" value="新建" onclick="newFile()">
              </form>
			
			</li>
        	<!--<li>打开本地文件
       	      <input type="file" class="file"/>
        	  <button onclick="openFile()">打开</button>
		  </li>-->
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
    <li><a href="#" title="邀请加入协同" onClick="cooenable()"><?php echo $value;?></a></li>
     <?php endforeach;?>
	</ul>
   </li>
	   <script>
	   function cooenable(){
		   alert("请先打开或新建一个文件");
	   }
	   </script>
   <!--<li>
    <a href="#" id="compareActuator" class="actuator">正在协同</a>
    <ul id="compareMenu" class="submenu">
     <?php foreach ($coop as $key=>$value):?>
    <li><a href="#" title="邀请加入协同" onClick="dinvite('<?php echo $value?>')"><?php echo $value;?></a></li>
     <?php endforeach;?>
    </ul>
   </li>-->
   </ul>
  </li>
  </ul>
 </div>
 </div>

    </div>
    <div id="mainWin">
        <div>
            <input type="text" id="nodeText" placeholder="输入节点内容" >
            <button class="btn" onclick="createNewNode()">新建节点</button>
            <button class="btn" id="deleteBtn" onclick="deleteNode()">删除节点</button>
            <button class="btn" onclick="saveFile()">保存为文件</button>
            <button class="btn" onclick="savePic()">保存为图片</button>
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
<script type="text/javascript" src="./jsmind/js/jsmind.js"></script>
<script type="text/javascript" src="./jsmind/js/jsmind.draggable.js"></script>
<script type="text/javascript" src="./jsmind/js/jsmind.screenshot.js"></script>
<script type="text/javascript">
	var gbfjdid;
    var id = 1;
    //思维导图所有节点
    var data = [
               ];
    
    var mind = {
        "meta":{
            "name":"myMind",
            "author":"hizzgdev@163.com",
            "version":"0.2",
        },
        "format":"node_array",
        "data":data,
    };
    var options = {
        container:'jsmind_container',
        editable:true,
        theme:'primary'
    }
    var jm = jsMind.show(options,mind);
	            
    //新建节点
	function createNewNode(){
        var text = document.getElementById("nodeText");
        //alert(text.value);
	    var newnode = {"id":text.value, "parentid":"1", "topic":text.value};
        if(!newnode.topic)
            alert("请输入节点内容");
        else{
            jm.add_node(newnode.parentid, newnode.id, newnode.topic);
        }
    }
    
    //删除节点
    function deleteNode(){
        var _node = jm.get_selected_node();

        var children = _node.children;
        var ci = children.length;
        
        if(_node == null)
            alert("请选择一个节点");
        else if(_node.id == "root")
            alert("根节点不能删除");
        else{
             for(var i=0; i<data.length; i++){//仅删除了一个节点，此节点的子节点未删除
            	 //alert(data[i].id);
            // alert(data[i].id == _node.id);
            	if(data[i].id == _node.id){
            		alert(data[i].id);
            		data.splice(i,1);
            	}
            } 
            var j;
            //删除data中所有子节点
            for(i=0; i<data.length; i++){
            	for(j=0; j<ci; j++){
            		if(data[i].id == children[j].id)
            			data.splice(i,1);
            	}
        	}
            jm.remove_node(_node);
        }
        /* var dataStr = JSON.stringify(data);
        alert(dataStr); */
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
				window.location.href='coop.php?fname='+fname;
			}
		else
			{
        	window.location.href="app.php"
			}
	}
	
	function dinvite(fname){
		var se=confirm("是否将该用户移出协同分组？");
		if(se!="0")
			{
				window.location.href='delete.php?fname='+fname;
			}
		else
			{
        	window.location.href="app.php"
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