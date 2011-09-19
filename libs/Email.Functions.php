<?php

function sendConfirmEmail($username,$code) {
	$email = $username."@middlebury.edu";
	$EmailSubject = 'Please Confirm your MMU Registration'; 
	$mailheader = "From: Midd Music United <noreply@middmusic.com>\r\n";
	$mailheader .= "Reply-To: Midd Music United <noreply@middmusic.com>\r\n"; 
	$mailheader .= "Content-type: text/html; charset=UTF-8\r\n";
	$mailheader .= "Organization: Midd Music United\r\n";
	$mailheader .= "MIME-Version: 1.0\r\n";
	$mailheader .= "X-Priority: 3\r\n";
	$mailheader .= "X-Mailer: PHP". phpversion() ."\r\n";
	$MESSAGE_BODY = 'EOT
	<html>
	<head>
		<title>MMU Confirmation</title>
	</head>
	<body>
		<p>Thank you for registering on Middmusic.com. In order to complete your registration, please click the link below.</p>
		<a href="http://middmusic.com/?page=confirm&code='.$code.'">http://middmusic.com/?page=confirm&code='.$code.'</a>
		
	</body>
	</html>';
	mail($email, $EmailSubject, $MESSAGE_BODY, $mailheader) or die("Could not send Message!");

}

?>