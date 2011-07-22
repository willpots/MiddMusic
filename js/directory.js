function getSearchResults(query, page) {
	document.getElementById('directory').innerHTML='<img src="http://middmusic.com/img/loading.gif" alt="Hang on, the calendar is loading!" id="main-loading">';
	var fd = new FormData();
	fd.append("getSearchQuery","true")
	fd.append("query", query);
	fd.append("page", page);
	
	if (window.XMLHttpRequest) { // Mozilla, Safari, ...
	    xhr = new XMLHttpRequest();
	} else if (window.ActiveXObject) { // IE
	    xhr = new ActiveXObject("Microsoft.XMLHTTP");
	}
	xhr.onreadystatechange = function() {
		if (xhr.readyState == 4&&xhr.status==200) {
			document.getElementById('directory').innerHTML=xhr.responseText;
		}
	}
	xhr.open("POST", "ajax.php");
	xhr.send(fd);
}
function getCategoryResults( page, cat) {
	document.getElementById('directory').innerHTML='<img src="http://middmusic.com/img/loading.gif" alt="Hang on, the calendar is loading!" id="main-loading">';
	var fd = new FormData();
	fd.append("getCategorySearch","true")
	fd.append("page", page);
	fd.append("cat", cat);
	
	if (window.XMLHttpRequest) { // Mozilla, Safari, ...
	    xhr = new XMLHttpRequest();
	} else if (window.ActiveXObject) { // IE
	    xhr = new ActiveXObject("Microsoft.XMLHTTP");
	}
	xhr.onreadystatechange = function() {
		if (xhr.readyState == 4&&xhr.status==200) {
			document.getElementById('directory').innerHTML=xhr.responseText;
		}
	}
	xhr.open("POST", "ajax.php");
	xhr.send(fd);
}
