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
function getEventCreate(day,calendar) {
	day = day || null;
	calendar = calendar || null;
	var fd = new FormData();
	fd.append("getEventCreate","true")
	if(day!=null) { fd.append("day", day); }
	if(calendar!=null) { fd.append("calendar", calendar); }
	
	if (window.XMLHttpRequest) { // Mozilla, Safari, ...
	    xhr = new XMLHttpRequest();
	} else if (window.ActiveXObject) { // IE
	    xhr = new ActiveXObject("Microsoft.XMLHTTP");
	}
	xhr.onreadystatechange = function() {
		if (xhr.readyState == 4&&xhr.status==200) {
			document.getElementById('calendar').innerHTML=xhr.responseText;
			$("#bands").tokenInput("http://middmusic.com/xml.php", {
				queryParam: "bands",
			    preventDuplicates: true,
			    theme: "facebook",
			    animateDropdown: false
			});
			$("#venue").tokenInput("http://middmusic.com/xml.php", {
				queryParam: "venue",
			    tokenLimit: 1,
			    theme: "facebook",
			    animateDropdown: false
			});
			$('#starttime').datetimepicker({
				ampm: true
			});
			$('#endtime').datetimepicker({
				ampm: true
			});
		}
	}
	xhr.open("POST", "ajax.php");
	xhr.send(fd);

}
function validateEventForm() {
	var name = document.getElementById('name');
	var starttime = document.getElementById('starttime');
	var endtime = document.getElementById('endtime');
	var starttime = document.getElementById('starttime');
	var description = document.getElementById('description');
	var bands = document.getElementById('bands');
	var venue = document.getElementById('venue');
	var sbutton = document.getElementById('sbutton');
	if(name.value!=""&&starttime.value!=""&&endtime.value!=""&&description.value!=""&&bands.value!=""&&venue.value!="") {
		sbutton.disabled=false;
	}
}
function createAnEvent(calendar) {
	var fe = document.getElementById('event-create-form');
	var fd = new FormData(fe);
	fd.append('calendar',calendar);
	fd.append('createAnEvent','asdf');
	var xhr = new XMLHttpRequest();
	xhr.onreadystatechange = function() {
		if (xhr.readyState == 4&&xhr.status==200) {
			window.location = '?page='+calendar;
		}
	}
	xhr.open("POST", "ajax.php");
	xhr.send(fd);
	console.log("Request Sent!");
}