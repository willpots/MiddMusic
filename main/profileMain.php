<?php 
/****************************************************************************
 * Middlebury Music United 																									*
 * This code is proprietary and property of William S. Potter.							*
 * It has been licensed for use to Middlebury College in this installation.	*
 * Use of this code requires consent from William S. Potter									*
 * will@middpoint.com																												*
 ***************************************************************************/
$messages=getUserMessages($_COOKIE['mu_id']);




?>
<div id="messages">
	<div class="section-title">MY MESSAGES</div>
	<?php 
	if($messages!=false) {
		foreach($messages as $m) {
			echo '<div class="message">';
			if($m['usermsgfrom']!=NULL) {
				$from = $m['usermsgfrom'];
				$fromname = getUser($from, 'firstname').' '.getUser($from, 'lastname');
				echo '<div class="msgfrom">From <a href="?page=profile&id='.$from.'">'.$fromname.'</a></div>';
			} else if($m['actmsgfrom']!=NULL) {
				$from = $m['actmsgfrom'];
			} else if($m['venuemsgfrom']!=NULL) {
				$from = $m['venuemsgfrom'];
			}		
			if($m['usermsgto']!=NULL) {
				$to = $m['usermsgto'];
				$toname = getUser($to, 'firstname').' '.getUser($to, 'lastname');
				echo '<div class="msgto">To <a href="?page=profile&id='.$to.'">'.$toname.'</a></div>';
			} else if($m['actmsgto']!=NULL) {
				$to = $m['actmsgto'];
			} else if($m['venuemsgto']!=NULL) {
				$to = $m['venuemsgto'];
			}
			echo '<div class="msgsent">'.date('n/j/y \a\t  g:i a',$m['msgsent']).'</div>';	
			echo '<div class="msg-subject">'.$m['subject'].'</div>';
			echo '<div class="msg-content">'.$m['content'].'</div>';
			echo '</div>';
		}
	} else {
	
	
	}
	?>
</div>