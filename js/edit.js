function updateUser() {
	var pagesObj = document.getElementById("class"); 
	var fd = new FormData();
	fd.append("userupdate","true");
	fd.append("firstname", document.getElementById('firstname').value);
	fd.append("lastname", document.getElementById('lastname').value);
	fd.append("info", document.getElementById('info').value);
	fd.append("class", pagesObj.options[pagesObj.selectedIndex].value);
	document.getElementById('edit').innerHTML='<img src="http://middmusic.com/img/loading.gif" alt="Hang on, we are updating your profile!" id="calendar-loading">';
	 	
	if (window.XMLHttpRequest) { // Mozilla, Safari, ...
	    xhr = new XMLHttpRequest();
	} else if (window.ActiveXObject) { // IE
	    xhr = new ActiveXObject("Microsoft.XMLHTTP");
	}
	xhr.onreadystatechange = function() {
		if (xhr.readyState == 4&&xhr.status==200) {
			document.getElementById('edit').innerHTML=xhr.responseText;
		}
	}
	xhr.open("POST", "ajax.php");
	xhr.send(fd);
}
var resultIndex=-1;
function instrumentSearch(evt,q) { 
	var keycode = evt.which;
	var results = document.getElementsByClassName('inst-result');
	if(keycode==40&&resultIndex<results.length-1&&results.length!=0) {
		if(resultIndex!=-1){
			results[resultIndex].setAttribute('class', 'inst-result');
		}
		resultIndex++;
		results[resultIndex].setAttribute('class', 'inst-result selected');	
	} else if(keycode==38&&resultIndex>-1&&results.length!=0) {
		results[resultIndex].setAttribute('class', 'inst-result');
		resultIndex--;
		if(resultIndex!=-1){
			results[resultIndex].setAttribute('class', 'inst-result selected');
		}
	} else if(keycode==13&&resultIndex!=-1&&results.length!=0) {
		var elem = results[resultIndex];
		document.getElementById('inst-search-results').style.display = "none";
		addInstrument(elem);
	} else if(keycode==9&&results.length==1) {
		var elem = results[0];
		document.getElementById('inst-search-results').style.display = "none";
		addInstrument(elem);
	} else {
		if(q!="") {
			document.getElementById('inst-search-results').style.display = "block";
			var fd = new FormData();
			fd.append("instrumentSearch","true");
			fd.append("q", q);
			document.getElementById('inst-search-results').innerHTML='<img src="http://middmusic.com/img/loading.gif" alt="Loading…" id="sidebar-loading">';
			
			if (window.XMLHttpRequest) { // Mozilla, Safari, ...
			    xhr = new XMLHttpRequest();
			} else if (window.ActiveXObject) { // IE
			    xhr = new ActiveXObject("Microsoft.XMLHTTP");
			}
			xhr.onreadystatechange = function() {
				if (xhr.readyState == 4&&xhr.status==200) {
					document.getElementById('inst-search-results').innerHTML=xhr.responseText;
				}
			}
			xhr.open("POST", "ajax.php");
			xhr.send(fd);
		} else {
			document.getElementById('inst-search-results').style.display = "none";
		}
	}
}
function addInstrument(elem) {
	var fd = new FormData();
	var id = elem.id;
	fd.append("addInstrument","true");
	fd.append("id", id);
	document.getElementById('instrument-list').innerHTML='<img src="http://middmusic.com/img/loading.gif" alt="Loading…" id="sidebar-loading">';
	 	
	if (window.XMLHttpRequest) { // Mozilla, Safari, ...
	    xhr = new XMLHttpRequest();
	} else if (window.ActiveXObject) { // IE
	    xhr = new ActiveXObject("Microsoft.XMLHTTP");
	}
	xhr.onreadystatechange = function() {
		if (xhr.readyState == 4&&xhr.status==200) {
			document.getElementById('instrument-list').innerHTML=xhr.responseText;
		}
	}
	xhr.open("POST", "ajax.php");
	xhr.send(fd);
}
function removeInstrument(elem) {
	var fd = new FormData();
	var id = elem.id;
	fd.append("removeInstrument","true");
	fd.append("id", id);
	document.getElementById('instrument-list').innerHTML='<img src="http://middmusic.com/img/loading.gif" alt="Loading…" id="sidebar-loading">';
	
	if (window.XMLHttpRequest) { // Mozilla, Safari, ...
	    xhr = new XMLHttpRequest();
	} else if (window.ActiveXObject) { // IE
	    xhr = new ActiveXObject("Microsoft.XMLHTTP");
	}
	xhr.onreadystatechange = function() {
		if (xhr.readyState == 4&&xhr.status==200) {
			document.getElementById('instrument-list').innerHTML=xhr.responseText;
		}
	}
	xhr.open("POST", "ajax.php");
	xhr.send(fd);
}