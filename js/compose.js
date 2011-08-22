function sendMessage() {
	var fd = new FormData();
	var from = document.getElementById('from');
	from = from.options[from.selectedIndex].value;
	console.log(from);
	fd.append("msgto", document.getElementById('to').value);
	fd.append("msgfrom", from);
	fd.append("subject", document.getElementById('subject').value);
	fd.append("content", document.getElementById('msgcontent').value);
	fd.append("sendmessage", "sendmessage");
	var xhr = new XMLHttpRequest();
	xhr.onreadystatechange=function() {
		if (xhr.readyState==4 && xhr.status==200) {
			alert("Message sent successfully!");
			window.location = "?page=profile";
		}
	}  
  
	xhr.open("POST", "/ajax.php");
	xhr.send(fd);
}
