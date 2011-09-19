function updateMyProfile() {
	console.log("Sending!");
	var fe = document.forms.updateUser;
	var fd = new FormData(fe);
	fd.append("userupdate","true");
	document.getElementById('edit').innerHTML='<img src="http://middmusic.com/img/loading.gif" alt="Hang on, we are updating your profile!" id="main-loading">';
    xhr = new XMLHttpRequest();
	xhr.onreadystatechange = function() {
		if (xhr.readyState == 4&&xhr.status==200) {
			pullMainSection('?page=edit');
		}
	};
	xhr.open("POST", "ajax.php");
	xhr.send(fd);
}
var resultIndex=-1;
function instrumentSearch(evt,q) { 
	var keycode = evt.which;
	var results = document.getElementsByClassName('inst-result');
	if(keycode==40&&resultIndex<results.length-1&&results.length!==0) {
		if(resultIndex!=-1){
			results[resultIndex].setAttribute('class', 'inst-result');
		}
		resultIndex++;
		results[resultIndex].setAttribute('class', 'inst-result selected');	
	} else if(keycode==38&&resultIndex>-1&&results.length!==0) {
		results[resultIndex].setAttribute('class', 'inst-result');
		resultIndex--;
		if(resultIndex!=-1){
			results[resultIndex].setAttribute('class', 'inst-result selected');
		}
	} else if(keycode==13&&resultIndex!=-1&&results.length!==0) {
		var elem = results[resultIndex];
		document.getElementById('inst-search-results').style.display = "none";
		addInstrument(elem);
	} else if(keycode==9&&results.length==1) {
		var elem = results[0];
		document.getElementById('inst-search-results').style.display = "none";
		addInstrument(elem);
	} else {
		if(q!=="") {
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
function uploadImage() {
	console.log('Changing picture.');
	var fd = new FormData(document.getElementById('uploadpic'));
	fd.append("uploadPix","true");
	var xhr = new XMLHttpRequest();
	xhr.onreadystatechange = function() {
		if (xhr.readyState == 4&&xhr.status==200) {
			document.getElementById('profilepic').src=xhr.responseText;
			console.log("Changed");
			console.log(xhr.responseText);
		}
	}

	xhr.open("POST", "ajax.php");
	xhr.send(fd);
}
function updateBand() {
	console.log("Function called!");
	var fe = document.getElementById('updateBand');
	var fd = new FormData(fe);
	fd.append("updatingband","asdf");
	var xhr = new XMLHttpRequest();
	xhr.onreadystatechange = function() {
		if (xhr.readyState == 4&&xhr.status==200) {
			console.log(xhr.responseText);
			window.location = "?page=profile";
		}
	}

	xhr.open("POST", "/ajax.php");
	xhr.send(fd);
}
function addPopAct(evt) {
	evt.preventDefault();
	var keycode = evt.which;
	var addpopact = document.getElementById('addpopact');
	var value=addpopact.value;
	if(keycode==13&&value!="") {
		addpopact.value = "Loading";
		console.log("Starting!");
		var fd = new FormData();
		fd.append("addpopact",value);
		var xhr = new XMLHttpRequest();
		xhr.onreadystatechange = function() {
			if (xhr.readyState == 4&&xhr.status==200) {
				document.getElementById('popacts-container').innerHTML = xhr.responseText;
				console.log(xhr.responseText);
				addpopact.value = "";
				$('.chzn-select').chosen();
			}
		}
	
		xhr.open("POST", "/ajax.php");
		xhr.send(fd);
	}
	return false;
}
function deleteEvent(id) {
	var r=confirm("Are you sure you want to delete this message?");
	if (r==true) {
		var fd = new FormData();
		fd.append("deleteevent","asdf");
		fd.append("id",id);
		var xhr = new XMLHttpRequest();
		xhr.onreadystatechange = function() {
			if (xhr.readyState == 4&&xhr.status==200) {
				console.log(xhr.responseText);
				window.location = "?page=calendar";
			}
		}
	
		xhr.open("POST", "/ajax.php");
		xhr.send(fd);
	} else {
		console.log("Cancelled");
	}
}