function searchFor(evt, query, page) {
	var keycode = evt.which;
	if(keycode==13) {
		page = page || "musicians";
		window.location="?page="+page+"&q="+query;
		getSearchResults(query, page, category);
	}
}
function composeTo(to, from, reply) {
	document.getElementById('messages').innerHTML='<img src="/img/loading.gif" alt="LoadingÉ" id="main-loading">';
	to = to || false;
	from = from || false;
	reply = reply || false;
	var fd = new FormData();
	fd.append("getCategorySearch","true")
	fd.append("to", to);
	fd.append("from", from);
	fd.append("reply", reply);
	
	if (window.XMLHttpRequest) { // Mozilla, Safari, ...
	    xhr = new XMLHttpRequest();
	} else if (window.ActiveXObject) { // IE
	    xhr = new ActiveXObject("Microsoft.XMLHTTP");
	}
	xhr.onreadystatechange = function() {
		if (xhr.readyState == 4&&xhr.status==200) {
			document.getElementById('messages').innerHTML=xhr.responseText;
		}
	}
	xhr.open("POST", "main/composeMain.php");
	xhr.send(fd);	

}
function ucfirst(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
}
var resultIndex=-1;
function pullUser(str, evt, field) {
	var keycode = evt.which;
	var results = document.getElementsByClassName('compose-result');
	if(keycode==40&&resultIndex<results.length-1&&results.length!=0) {
		if(resultIndex!=-1){
			results[resultIndex].setAttribute('class', 'compose-result');
		}
		resultIndex++;
		results[resultIndex].setAttribute('class', 'compose-result selected');	
	} else if(keycode==38&&resultIndex>-1&&results.length!=0) {
		results[resultIndex].setAttribute('class', 'compose-result');
		resultIndex--;
		if(resultIndex!=-1){
			results[resultIndex].setAttribute('class', 'compose-result selected');
		}
	} else if(keycode==13&&resultIndex!=-1&&results.length!=0) {
		setRecipient(results[resultIndex]);
	} else if(keycode==9&&results.length==1) {
		setRecipient(results[0]);
	} else {
		if (str.length==0) { 
			resultIndex=-1;
		  document.getElementById("compose-results").innerHTML="";
		  document.getElementById("compose-results").style.border="0px";
		  return;
	  }
	  xhr=new XMLHttpRequest();
	  var fd = new FormData();
	  fd.append("query", str);
	  fd.append("pulluser", "pulluser");
		xhr.onreadystatechange=function() {
		  if (xhr.readyState==4 && xhr.status==200) {
		    document.getElementById("compose-results").innerHTML=xhr.responseText;
		    document.getElementById("compose-results").style.border="1px solid #A5ACB2";
			}
	  }
		xhr.open("POST","ajax.php");
		xhr.send(fd);
	}
}
function setRecipient(elem, field) {
	document.getElementById(field+"-container").innerHTML = ucfirst(field)+': <a name="'+elem.name+'" id="'+elem.id+'" onclick="putToFieldBack()">'+elem.innerHTML+'</a>';
  document.getElementById("compose-results").innerHTML="";
  document.getElementById("compose-results").style.border="0px";
	document.getElementById("send").disabled=false;
}

function putToFieldBack(){
	document.getElementById("to-container").innerHTML = 'To: <input type="text" onkeydown="pullUser(this.value, event)" name="to" id="to" placeholder="To">';
	document.getElementById("send").disabled=true ;
	resultIndex=-1;
}
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
			$('.chzn-select').chosen();
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
	var eventForm = document.forms.eventCreateForm;
	var name = document.getElementById('name');
	var starttime = document.getElementById('starttime');
	var endtime = document.getElementById('endtime');
	var starttime = document.getElementById('starttime');
	var description = document.getElementById('description');
	var bands = document.getElementById('bands');
	var venue = document.getElementById('venue');
	var sbutton = document.getElementById('sbutton');
	if(name.value!=""&&starttime.value!=""&&endtime.value!=""&&description.value!="") {
		if(document.getElementById('venue')==null) {
			sbutton.disabled=false;
		}
		else if(bands.selectedIndex!=-1&&venue.selectedIndex!=-1) {
			sbutton.disabled=false;
		} else {
			sbutton.disabled=true;
		}
	} else {
		sbutton.disabled=true;
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
			console.log(xhr.responseText);
			window.location = '?page='+calendar;
		}
	}
	xhr.open("POST", "ajax.php");
	xhr.send(fd);
	console.log("Request Sent!");
}
function updateEvent(id) {
	var eventForm = document.forms.updateEventForm;
	var fd = new FormData(eventForm);
	fd.append('id',id);
	fd.append('updateEvent','asdf');
	var xhr = new XMLHttpRequest();
	xhr.onreadystatechange = function() {
		if (xhr.readyState == 4&&xhr.status==200) {
			console.log(xhr.responseText);
			alert("Updated Event "+xhr.responseText);
		}
	}
	xhr.open("POST", "ajax.php");
	xhr.send(fd);
	console.log("Request Sent!");
}
function pullMainSection(url) {
	var xhr = new XMLHttpRequest();
	xhr.onreadystatechange = function() {
		if (xhr.readyState == 4&&xhr.status==200) {
			document.getElementById('main-content').innerHTML = xhr.responseText;
			console.log('Loaded xhr response text');
			$(".chzn-select").chosen();
			console.log('Loaded Chosen');
		}
	}
	xhr.open("POST", "subpage.php"+url);
	xhr.send();
	console.log("Request Sent!");
}