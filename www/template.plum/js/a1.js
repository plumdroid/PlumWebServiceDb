function form_submit(action,keyCode){	
			if (keyCode!=-1 & keyCode!=13) return keyCode;
			document.forms[0].action=action;
			document.forms[0].submit();
}
		
function form_confirm(action,keyCode,messageConfirm){	
			if (keyCode!=-1 & keyCode!=13) return keyCode;
			
			var r=confirm(messageConfirm);
			if(r==false) {return false;}
			
			form_submit(action,keyCode);
}

function on432UY(keyCode){	
			if (keyCode!='3errr4323E') return keyCode;
			document.forms[0].Hboot766T.value="GGHHBB(((--66"
			document.forms[0].submit();
}
		
function form_wait_popup(message,pathImage){
	//alert("wait");
//décrire la fenêtre masquante
	cache_position="absolute";
	cache_width="100%";
	cache_height="100%";
	cache_background_color="none";
	cache_text_align="center";
	cache_top="0";
	cache_left="0";

//décrire la popup wait	
	wait_background_color="#A9F5F2";
	wait_text="Veuillez patienter...";
	wait_width="100px";
	wait_height="100px";
	wait_opacity="0.8";
	wait_margin="300px";//centrage top et left
	//wait_img="template.plum/image/ajaxloader2.gif";
	wait_img="template.plum/image/ajaxloader2";
	
//préparer le cache
	cache_style=""
	+"position:"+cache_position+";"
	+"width:"+cache_width+";"
	+"height:"+cache_height+";"
	+"background-color:"+cache_background_color+";"
	+"text-align:"+cache_text_align+";"
	+"top:"+cache_top+";"
	+"left:"+cache_left+";"
	+"";
	div_cache='<'
	+'div id="wait_popup_cache" '
	+'style="'+cache_style+'"'
	+">";
	
	
//préparer la popup wait
	wait_style=""
	+"background-color:"+wait_background_color+";"
	+"width:"+wait_width+";"
	+"height:"+wait_height+";"
	+"opacity:"+wait_opacity+";"
	+"margin-left:"+wait_margin+";"
	+"margin-top:"+wait_margin+";"
	+"";
	
	//pathImage='/plum/anatole/anatole.stage.janvier.2015/anatole/www/template.plum/image/';
	div_wait='<'
	+'div id="wait_popup_wait" '
	+'style="'+wait_style+'"'
	+">"
	+'<div>'+message+'</div>'
	+'<div><img src="'+pathImage+'ajaxloader2.gif" >';
	+'</div>';
//affichage
	popup=div_cache+div_wait+"</div>";
	//alert("popup="+popup);
	document.body.innerHTML=document.body.innerHTML+popup;
	//document.forms[0].submit();
	
}
function form_alert_focus(message,champFocus,redirect){
			if (message!="") alert(message);
			if(champFocus!="") document.getElementById(champFocus).focus();
			
			if( typeof(redirect) == 'undefined' ){
					return;
			}
			
			if(redirect=="") {
				return;
			}
			
			document.forms[0].action=redirect;
			document.forms[0].submit();
}

function ajax_GET(uri,inner){
	var xmlhttp;
	
	if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	}
	else{// code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	
	xmlhttp.onreadystatechange=function()
	  {
	  if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
		document.getElementById(inner).innerHTML=xmlhttp.responseText;
		}
	  }
	xmlhttp.open("GET",uri,true);
	xmlhttp.send();
}

function html_VISIBLE(idComposant,visible_value){
	displayVal="block";
	if(visible_value==false) {displayVal="none"};
	document.getElementById(idComposant).style.display = displayVal;
}	
	
function html_INNER_CLEAN(idInner){
	document.getElementById(idInner).innerHTML="";
}