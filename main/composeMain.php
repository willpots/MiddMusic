<?php 
/***************************************************************************
 * Middlebury Music United 																*
 * This code is proprietary and property of William S. Potter.					*
 * It has been licensed for use to Middlebury College in this installation.*
 * Use of this code requires consent from William S. Potter						*
 * will@middpoint.com																		*
 ***************************************************************************/

if(isset($_COOKIE['mu_id'] )) {
	if(isset($_POST['to'])) $to = $_POST['to'];
	else $to = "";
	if($to==false) $to="";
	
	?>
	<div class="section-title">COMPOSE</div>
	<div id="message">
		<div class="compose-element" id="from-container">From: <input type="text" onkeyup="" name="from" id="from" placeholder="From"></div>
		<div class="compose-element" id="to-container">To: <input type="text" onkeyup="" name="to" id="to" placeholder="To"></div>
		<div class="" id="results"></div>
		<div class="compose-element">Subject: <input type="text" name="subject" id="subject" placeholder="Subject"></div>
		<div class="compose-element">Message Body:<br><textarea rows="10" cols="70" name="content" id="msgcontent" placeholder="Message Content"></textarea></div>
		<div class="compose-element"><button name="send" id="send" onclick="sendMessage()" disabled >Send Message</div>
	</div>
	<?php
}
?>