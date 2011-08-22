<?php 
/***************************************************************************
 * Middlebury Music United 																*
 * This code is proprietary and property of William S. Potter.					*
 * It has been licensed for use to Middlebury College in this installation.*
 * Use of this code requires consent from William S. Potter						*
 * will@middpoint.com																		*
 ***************************************************************************/

if(!isset($_GET['id'])&&isset($_COOKIE['mu_id'])) {
	$id = $me->id;
	
	?>
	<div id="messages">
		<a id="compose-message" href="?page=compose" class="button right">Compose</a>
		<div class="section-title">MESSAGES</div>
		<?php 
		if($me->messages!=false) {
			foreach($me->messages as $m) {
				echo '<div class="message">';
				if($m->usermsgfrom!=NULL) {
					$from = $m->usermsgfrom;
					$fromname = getUser($from, 'firstname').' '.getUser($from, 'lastname');
					echo '<div class="msgfrom">From <a href="?page=profile&id='.$from.'">'.$fromname.'</a></div>';
				} else if($m->bandmsgfrom!=NULL) {
					$from = $m->bandmsgfrom;
					$b = new Band($from);
					echo '<div class="msgfrom">From <a href="?page=profile&id='.$from.'">'.$b->name.'</a></div>';
				} else if($m->venuemsgfrom!=NULL) {
					$from = $m->venuemsgfrom;
					$v = new Venue($from);
					echo '<div class="msgfrom">From <a href="?page=profile&id='.$from.'">'.$v->name.'</a></div>';
				}		
				if($m->usermsgto!=NULL) {
					$to = $m->usermsgto;
					$toname = getUser($to, 'firstname').' '.getUser($to, 'lastname');
					echo '<div class="msgto">To <a href="?page=profile&id='.$to.'">'.$toname.'</a></div>';
				} else if($m->bandmsgto!=NULL) {
					$to = $m->bandmsgto;
					$b = new Band($to);
					echo '<div class="msgto">To <a href="?page=profile&id='.$to.'">'.$b->name.'</a></div>';
				} else if($m->venuemsgto!=NULL) {
					$to = $m->venuemsgto;
					$v = new Venue($to);
					echo '<div class="msgto">To <a href="?page=profile&id='.$to.'">'.$v->name.'</a></div>';
				}
				echo '<div class="msgsent">'.date('n/j/y \a\t  g:i a',$m->msgsent).'</div>';	
				echo '<div class="msg-subject">'.stripslashes($m->subject).'</div>';
				echo '<div class="msg-content">'.stripslashes($m->content).'</div>';
				echo '</div>';
			}
		} else {
		
		
		}
		?>
	</div>

<?php } else if(isset($_GET['id'])) { 
	$id = $_GET['id'];
	$i = getUserInfo($id);
	$in = getUserInstruments($id);
	if($i!=false) {
?>
	<div id="user-profile">
		<div id="profile-picture" class="right">
			<img src="<?php if(isset($i['picture'])) echo $i['picture']; else echo "photos/nameless.png"; ?>" width="200" alt="">
		</div>
		<div class="section-title"><?php echo strtoupper($i['firstname'].' '.$i['lastname']);?></div>
		<div id="class"><?php echo $i['class']; ?></div>
		<div id="info"><?php echo stripslashes($i['info']); ?></div>
		<div id="user-instruments">
		<div class="section-title">I Know...</div>
		<?php
		if($in!=false) {
			foreach($in as $n) {
				echo '<div class="user-inst">'.$n['name'].'</div>';
			}
		}
		?>
		</div>
	</div>
<?php
	}
}?>