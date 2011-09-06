function deleteMessage(tofrom,id) {
	var r=confirm("Are you sure you want to delete this message?");
	if (r==true) {
		var fd = new FormData();
		var xhr = new XMLHttpRequest();
		fd.append('id',id);
		fd.append('tofrom',tofrom);
		fd.append('deleteMessage','true');
		var xhr = new XMLHttpRequest();
		xhr.onreadystatechange = function() {
			if (xhr.readyState == 4&&xhr.status==200) {
				//console.log(xhr.responseText);
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