<?php 
/***************************************************************************
 * Middlebury Music United 													*
 * This code is proprietary and property of William S. Potter.					*
 * It has been licensed for use to Middlebury College in this installation.*
 * Use of this code requires consent from William S. Potter						*
 * will@middpoint.com																		*
 ***************************************************************************/
if(isset($_COOKIE['mu_id'] )) {
	if(isset($_GET['to'])) $to = $_GET['to'];
	else $to = "";
	if($to==false) $to="";
	?>
	<div class="section-title">COMPOSE</div>
	<div id="message">
		<form name="composeMessage" method="post">
		<div class="compose-element" id="from-container">From: 
			<select name="from" id="from" style="width:300px;" class="chzn-select" title="Choose a sender" data-placeholder="Chose a sender"  >
				<option value="u-<?php echo $me->id; ?>"><?php echo $me->firstname." ".$me->lastname; ?></option>
			<?php
				foreach($me->bands as $b) {
					echo '<option value="b-'.$b->id.'">'.$b->name.'</option>';
				}
				foreach($me->venues as $v) {
					echo '<option value="v-'.$v->id.'">'.$v->name.'</option>';
				}
			?>
			</select>
		</div>
		<div class="compose-element" id="to-container">To: <!--<input type="text" onkeyup="" name="to" id="to" placeholder="To">-->
		<select id="to" name="to[]" multiple style="width:300px;" class="chzn-select" title="Choose a recipient" data-placeholder="Choose a recipient"  >
			<option></option>
			<?php
				$a=pullAllEntities();
				foreach($a as $b) {
					if($to==$b['id']) {
						echo '<option selected value="'.$b['id'].'">'.$b['name'].'</option>';
					} else {
						echo '<option value="'.$b['id'].'">'.$b['name'].'</option>';
					}
				}
				if(isset($_COOKIE['mu_admin'])) {
					echo '<option value="everyone">Everyone</option>';
				}
			?>
		</select>
		</div>
		<div class="compose-element">Subject: <input type="text" name="subject" class="compose-field" id="subject" placeholder="Subject"></div>
		<div class="compose-element">Message Body:<br><textarea rows="10" cols="70" name="content" class="compose-field" id="msgcontent" placeholder="Message Content"></textarea></div>
		</form>
		<div class="compose-element"><button name="send" id="send" onclick="sendMessage()" class="button" >Send Message</div>
	</div>
	<?php
}
?>