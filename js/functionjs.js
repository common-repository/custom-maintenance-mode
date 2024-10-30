// JavaScript Document

function autofillcheck(id)
{               
		var anew = document.getElementById('wpspandntset[enable]').checked;
	
		switch(anew)
		{
			case true:
			  var tbox = document.getElementById('divone').style.display = 'inline';
			  var rads=document.getElementById('wpspandnt_settingurl').checked;
			  switch(rads)
				{
					case true:
					  var tbox = document.getElementById('countdown').style.display = 'inline';
					  break;
	
					case false:
					  var tbox = document.getElementById('countdown').style.display = 'none';
					  break;
					
					default: 'code to be executed if n is different from case 1 and 2';
				}
			  break;
	
			case false:			
			  var tbox = document.getElementById('divone').style.display = 'none';
			  document.getElementById('countdown').style.display = 'none';
			  break;
			
			default: 'code to be executed if n is different from case 1 and 2';
		}
}

function changeurlandpage(rads)
{
                switch(rads)
                {
					case 'page':
					  document.getElementById('rdpages').style.display = 'inline';
					  document.getElementById('rdurl').style.display = 'none';
                                          document.getElementById('rdmedia').style.display = 'none';
					  break;
	
					case 'url':
					  document.getElementById('rdpages').style.display = 'none';
					  document.getElementById('rdurl').style.display = 'inline';
                                          document.getElementById('rdmedia').style.display = 'inline';
					  break;
					
					default: 'code to be executed if n is different from case 1 and 2';
                }
                
}
  
function checkUrl()
{
var Url=document.getElementById('redirect_url').value;
if (Url==/^(http[s]?:\/\/){0,1}(www\.){0,1}[a-zA-Z0-9\.\-]+\.[a-zA-Z]{2,5}[\.]{0,1}/) {return true; } 
else
{
alert("Please enter a valid URL, remember including http://");	
document.getElementById('url').focus();
return false;
}
}

/*<![CDATA[*/
function selectedradio(rad)
{
 				var rads=document.getElementById('wpspandnt_settingurl').checked;
 
                switch(rads)
                {
					case true:
					  var tbox = document.getElementById('countdown').style.display = 'inline';
					  break;
	
					case false:
					  var tbox = document.getElementById('countdown').style.display = 'none';
					  break;
					
					default: 'code to be executed if n is different from case 1 and 2';
                }
}
/*]]>*/  