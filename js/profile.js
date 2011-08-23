function deleteMessage(id) {
	var r=confirm("Are you sure you want to delete this message?");
	if (r==true) {
		var fd = new FormData();
		var xhr = new XMLHttpRequest();
		fd.append('id',id);
		fd.append('deleteMessage','true');
		var xhr = new XMLHttpRequest();
		xhr.onreadystatechange = function() {
			if (xhr.readyState == 4&&xhr.status==200) {
				window.location = '?page=profile';
			}
		}
		xhr.open("POST", "ajax.php");
		xhr.send(fd);
		console.log("Request Sent!");
	} else {
		console.log("Cancelled!");
	}
}