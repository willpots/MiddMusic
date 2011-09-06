function sendMessage() {
	var formCompose = document.forms.composeMessage;
	var fd = new FormData(formCompose);
	console.log(from);
	fd.append("sendmessage", "sendmessage");
	var xhr = new XMLHttpRequest();
	xhr.onreadystatechange=function() {
		if (xhr.readyState==4 && xhr.status==200) {
			console.log(xhr.responseText);
			alert("Message sent successfully!");
			//window.location = "?page=profile";
		}
	}  
  
	xhr.open("POST", "/ajax.php");
	xhr.send(fd);
}
