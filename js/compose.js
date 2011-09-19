function sendMessage() {
	var formCompose = document.forms.composeMessage;
	var fd = new FormData(formCompose);
	fd.append("sendmessage", "sendmessage");
	var xhr = new XMLHttpRequest();
	xhr.onreadystatechange=function() {
		if (xhr.readyState==4 && xhr.status==200) {
			console.log(xhr.responseText);
			window.location = '?page=profile';
		}
	}  
  
	xhr.open("POST", "/ajax.php");
	xhr.send(fd);
	document.getElementById('main-content').innerHTML = '<img src="/img/loading.gif" alt="Hang on, the calendar is loading!" id="main-loading">';
}
