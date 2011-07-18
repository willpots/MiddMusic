function showResult(str, e, uid)
{
	var x;
	var ls = document.getElementById("livesearch");
	var keynum;
	//Process Key Input	
	if(window.event) { // IE
		keynum = e.keyCode
	}
	else if(e.which) { // Netscape/Firefox/Opera
		keynum = e.which
	}
    var curr = $('#livesearch').find('.current');
	if(keynum==38) { //Up Arrow

        if(curr.length)
        {                            
                $(curr).attr('class', 'result');
                $(curr).prev().attr('class', 'result current');
        }
        else{
            $('#livesearch div:last-child').attr('class', 'result current');
        }           

	} else if(keynum==40) { //Down Arrow
	
        if(curr.length)
        {
                $(curr).attr('class', 'result');
                $(curr).next().attr('class', 'result current');
        }
        else{
            $('#livesearch div:first-child').attr('class', 'result current');
        }     
        
	} else if(keynum==13) { //Enter Key
		if(getElementsByClassName('current').length>0) { 
			var current = getElementsByClassName('current')[0];
			var curid = current.getAttribute('id');
			
			
			xmlhttp=new XMLHttpRequest();
			xmlhttp.onreadystatechange=function()
			{
				if (xmlhttp.readyState==4 && xmlhttp.status==200)
				{
				
					

				}
			}
			xmlhttp.open("GET","inst.php?instid="+curid+"&u="+uid, true);
			xmlhttp.send();
		
		}
	} else { //Any other key
		ls.innerHTML="";
		if (str.length==0)
		{
			ls.innerHTML="";
			ls.style.border="0px";
			return;
		}
		xmlhttp=new XMLHttpRequest();
		xmlhttp.onreadystatechange=function()
		{
			if (xmlhttp.readyState==4 && xmlhttp.status==200)
			{
				
				xmlDoc=xmlhttp.responseXML;
				x = xmlDoc.getElementsByTagName("inst");
				if(x.length==0)
				{
					ls.innerHTML="Not found!";
					ls.style.border="1px solid red";
				}
				else{			
		 			for(i=0;i<x.length;i++)
					{
						var div = document.createElement('div');
						div.innerHTML = x[i].childNodes[0].nodeValue;
						div.setAttribute('id', "result"+i);
						div.setAttribute('class', "result");
						ls.appendChild(div);
					}					
				}
				
			}
		}
		xmlhttp.open("GET","get.php?q="+str+"&u="+uid, true);
		xmlhttp.send();
	}
	return;	
}
