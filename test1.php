
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>无标题文档</title>
</head>
   <button onClick="showMap('bbb')">显示</button>
   <span id="textHint"></span>
<body>
</body>
</html>
<script>
function showMap(fn)
	{
		xmlhttp=new XMLHttpRequest();
		xmlhttp.onreadystatechange=function()
		{
			if(xmlhttp.readyState==4&&xmlhttp.status==200)
				{
					var mind=xmlhttp.responseText;
					alert(mind);
				}
		}
		xmlhttp.open("GET","getContent.php?filename="+"bbb",true);
		xmlhttp.send();
		//jm.show(mind);
		alert(JSON.stringify(mind));
		return mind;
	}
	
</script>