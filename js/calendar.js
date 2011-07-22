//Here are all relevant calendar scripts
$(function(){

});

function getCalendarMonth(month, calendar) {
	document.getElementById('calendar').innerHTML='<img src="http://middmusic.com/img/loading.gif" alt="Hang on, the calendar is loading!" id="main-loading">';
	var fd = new FormData();
	fd.append("getMonthView","true")
	fd.append("month", month);
	fd.append("calendar", calendar)
	
	if (window.XMLHttpRequest) { // Mozilla, Safari, ...
	    xhr = new XMLHttpRequest();
	} else if (window.ActiveXObject) { // IE
	    xhr = new ActiveXObject("Microsoft.XMLHTTP");
	}
	xhr.onreadystatechange = function() {
		if (xhr.readyState == 4&&xhr.status==200) {
			document.getElementById('calendar').innerHTML=xhr.responseText;
		}
	}
	xhr.open("POST", "ajax.php");
	xhr.send(fd);
}

function getCalendarDay(day, calendar) {
	document.getElementById('calendar').innerHTML='<img src="http://middmusic.com/img/loading.gif" alt="Hang on, the calendar is loading!" id="main-loading">';
	var fd = new FormData();
	fd.append("getDayView","true")
	fd.append("day", day);
	fd.append("calendar", calendar)
	
	if (window.XMLHttpRequest) { // Mozilla, Safari, ...
	    xhr = new XMLHttpRequest();
	} else if (window.ActiveXObject) { // IE
	    xhr = new ActiveXObject("Microsoft.XMLHTTP");
	}
	xhr.onreadystatechange = function() {
		if (xhr.readyState == 4&&xhr.status==200) {
			document.getElementById('calendar').innerHTML=xhr.responseText;
		}
	}
	xhr.open("POST", "ajax.php");
	xhr.send(fd);
}

