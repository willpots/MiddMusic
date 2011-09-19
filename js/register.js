var validEmail = false;
var validPW = false;
function checkEmail() {
	var un = document.getElementById('username').value;
	var fd = new FormData;
	var xhr = new XMLHttpRequest;
	fd.append("checkemail", un);
	xhr.onreadystatechange=function() {
		if (xhr.readyState==4 && xhr.status==200) {
			if(xhr.responseText=="true"&&un!="") {
				document.getElementById('username').style.border=""
				validEmail = true;
				if(validPW==true&&validEmail==true) {
					document.getElementById('SUBMITREGISTER').disabled=false;
				}
			} else {
				document.getElementById('username').style.border="2pt solid red"
				validEmail = false;
				document.getElementById('SUBMITREGISTER').disabled=true;
			}
		}
	}   
	xhr.open("POST", "/ajax.php");
	xhr.send(fd);
}
function checkPassword() {
	var pw1 = document.getElementById('password').value;
	var pw2 = document.getElementById('password2').value;
	if(pw1!=pw2||pw1==""||pw2=="") {
		document.getElementById('password2').style.border="2pt solid red";
		validPW = false;
	} else {
		document.getElementById('password2').style.border="";
		validPW = true;
	}
}
function validateForm() {
	checkPassword();
	checkEmail();
	if(validPW==true&&validEmail==true) {
		document.getElementById('SUBMITREGISTER').disabled=false;
	} else {
		document.getElementById('SUBMITREGISTER').disabled=true;
	}
}
$(document).ready(function() {
	checkPassword();
});