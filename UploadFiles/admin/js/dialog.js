/**
 * 
 * @version        $Id: dialog.js
 * @package        Mi.Administrator
 * @copyright      Copyright (c)  2010, Missra
 * @license        http://help.missra.com/usersguide/license.html
 * @link           http://www.missra.com
 */
 
document.write("<style type=\"text/css\">.close{float:right;cursor:default;}</style>")

function editTitle(aid){
    var show = document.getElementById("show_news");
    var myajax = new MiAjax(show,false,false,"","","");
    myajax.SendGet2("catalog_edit.php?dopost=time&id="+aid);
    MiXHTTP = null;
}

function $Mi(id){ return document.getElementById(id)}
function AlertMsg(title,id){
    var msgw,msgh,msgbg,msgcolor,bordercolor,titlecolor,titlebg,content; 
	//弹出窗口设置
	msgw = 600;		//窗口宽度 
	msgh = 400;		//窗口高度 
	msgbg = "#FFF";			//内容背景
	msgcolor = "#000";		//内容颜色
	bordercolor = "#ccc"; 	//边框颜色 
	titlecolor = "#353535";	//标题颜色
	titlebg = "url(images/tbg.gif)";		//标题背景
	//遮罩背景设置  	
	content = "<div id=show_news>对不起，载入失败</div>";	
	var sWidth,sHeight; 
	//sWidth = document.body.offsetWidth - 17;
	if(screen.availHeight > document.body.scrollHeight){
		sHeight = screen.availHeight;	//少于一屏
	}else{
		sHeight = document.body.scrollHeight;	//多于一屏 
	}
	//创建遮罩背景 
	var maskObj = document.createElement("div"); 
	maskObj.setAttribute('id','maskdiv'); 
	maskObj.style.position = "fixed"; 
	maskObj.style.top = "0"; 
	maskObj.style.left = "0"; 
	maskObj.style.right = "0"; 
	maskObj.style.bottom = "0"; 
	maskObj.style.background = "#333"; 
	maskObj.style.filter = "Alpha(opacity=30);"; 
	maskObj.style.opacity = "0.3"; 
	//maskObj.style.width = sWidth + "px"; 
	maskObj.style.height = sHeight + "px"; 
	maskObj.style.zIndex = "10000"; 
	document.body.appendChild(maskObj); 
	//创建弹出窗口
	var msgObj = document.createElement("div") 
	msgObj.setAttribute("id","msgdiv"); 
	msgObj.style.position ="absolute";
	msgObj.style.top = (document.body.offsetHeight) / 2.5 + "px";
	msgObj.style.left = (document.body.offsetWidth - msgw) / 2 + "px";
	// msgObj.style.top = "100px";
	// msgObj.style.left = "100px";
	msgObj.style.width = msgw + "px";
	msgObj.style.height = msgh + 10 + "px";
	msgObj.style.fontSize = "12px";
	msgObj.style.background = msgbg;
	msgObj.style.border = "1px solid " + bordercolor; 
	msgObj.style.zIndex = "10001"; 
	//创建标题
	var thObj = document.createElement("div");
	thObj.setAttribute("id","msgth"); 
	thObj.className = "DragAble";
	thObj.title = "按住鼠标左键可以拖动窗口！";
	thObj.style.cursor = "move";
	thObj.style.height = "30px";
	thObj.style.lineHeight = "30px";
	thObj.style.padding = "5px 15px";
	thObj.style.color = titlecolor;
	thObj.style.fontWeight = 'bold';
	thObj.style.background = titlebg;
	var titleStr = "<a class='close' title='关闭' style='cursor:pointer' onclick='CloseMsg()'>关闭</a>"+"<span>"+ title +"</span>";
	thObj.innerHTML = titleStr;
	//创建内容
	var bodyObj = document.createElement("div");
	bodyObj.setAttribute("id","msgbody"); 
	bodyObj.style.padding = "0px";
	bodyObj.style.lineHeight = "1.5em";
	var txt = document.createTextNode(content);
	bodyObj.appendChild(txt);
	bodyObj.innerHTML = content;
	//生成窗口
	document.body.appendChild(msgObj);
	$Mi("msgdiv").appendChild(thObj);
	$Mi("msgdiv").appendChild(bodyObj);
	editTitle(id);
}
function CloseMsg(){
	//移除对象
	document.body.removeChild($Mi("maskdiv")); 
	$Mi("msgdiv").removeChild($Mi("msgth")); 
	$Mi("msgdiv").removeChild($Mi("msgbody")); 
	document.body.removeChild($Mi("msgdiv")); 
}
//拖动窗口
var ie = document.all;   
var nn6 = document.getElementById&&!document.all;   
var isdrag = false;   
var y,x;   
var oDragObj;   
  
function moveMouse(e) {   
	if (isdrag) {   
		oDragObj.style.top  = (nn6 ? nTY + e.clientY - y : nTY + event.clientY - y)+"px";   
		oDragObj.style.left  = (nn6 ? nTX + e.clientX - x : nTX + event.clientX - x)+"px";   
		return false;   
	}   
}   
  
function initDrag(e) {   
	var oDragHandle = nn6 ? e.target : event.srcElement;   
	var topElement = "HTML";   
	while (oDragHandle.tagName != topElement && oDragHandle.className != "DragAble") {   
		oDragHandle = nn6 ? oDragHandle.parentNode : oDragHandle.parentElement;   
	}   
	if (oDragHandle.className=="DragAble") {   
		isdrag = true;   
		oDragObj = oDragHandle.parentNode;   
		nTY = parseInt(oDragObj.style.top);   
		y = nn6 ? e.clientY : event.clientY;   
		nTX = parseInt(oDragObj.style.left);   
		x = nn6 ? e.clientX : event.clientX;   
		document.onmousemove = moveMouse;   
		return false;   
	}   
}   
document.onmousedown = initDrag;   
document.onmouseup = new Function("isdrag=false");  
