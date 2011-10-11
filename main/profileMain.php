<?php 
/***************************************************************************
 * Middlebury Music United 																*
 * This code is proprietary and property of William S. Potter.					*
 * It has been licensed for use to Middlebury College in this installation.*
 * Use of this code requires consent from William S. Potter						*
 * will@middpoint.com																		*
 ***************************************************************************/

if(!isset($_GET['id'])&&!isset($_GET['band'])&&!isset($_GET['venue'])&&!isset($_GET['event'])&&is_logged_in()) {
	$me = new User($_COOKIE['mu_id']);
	$id = $me->id;
	
	?>
	<div id="messages">
		<a id="compose-message" href="?page=compose" class="button right">Compose</a>
		<div class="section-title">MESSAGES</div>
		<?php 
		if($me->messages!=false) {
			foreach($me->messages as $m) {
				echo '<div class="message">';
				echo '<a class="right msg-delete" onclick="deleteMessage('.$m->id.')">Delete</a>';
				$e = explode(':',$m->msgfrom);
				$f = explode('-',$e[1]);
				if($f[0]=='u') {
					$fromname = getUser($f[1], 'firstname').' '.getUser($f[1], 'lastname');
					echo '<div class="msgfrom">From <a href="?page=profile&id='.$f[1].'">'.$fromname.'</a></div>';
				} else if($f[0]=='b') {
					$b = new Band($f[1]);
					echo '<div class="msgfrom">From <a href="?page=profile&band='.$f[1].'">'.$b->name.'</a></div>';
				} else if($f[0]=='v') {
					$v = new Venue($f[1]);
					echo '<div class="msgfrom">From <a href="?page=profile&venue='.$f[1].'">'.$v->name.'</a></div>';
				}
				$e = explode(':',$m->msgto);
				$i=0;
				echo '<div class="msgto">To ';
				foreach($e as $a) {
					$f = explode('-',$a);
					if(count($f)>1) {
						if($f[0]=='u') {
							$fromname = getUser($f[1], 'firstname').' '.getUser($f[1], 'lastname');
							echo '<a href="?page=profile&id='.$f[1].'">'.$fromname.'</a>';
						} else if($f[0]=='b') {
							$b = new Band($f[1]);
							echo '<a href="?page=profile&band='.$f[1].'">'.$b->name.'</a>';
						} else if($f[0]=='v') {
							$v = new Venue($f[1]);
							echo '<a href="?page=profile&venue='.$f[1].'">'.$v->name.'</a>';
						} else if($f[0]=='i') {
							$in = new Instrument($f[1]);
							echo $in->name;
						}
					} 
					if($a=="everyone") {
							echo "Everyone";
					}
					if($i==(count($e)-3)&&count($e)>3) {
						echo ' and ';
					} else if($i>0&&count($e)>3&&$i<(count($e)-3)) {
						echo ', ';
					}
					$i++;
				}
				echo '</div>';
				echo '<div class="msgsent">'.date('n/j/y \a\t  g:i a',$m->msgsent).'</div>';	
				echo '<div class="msg-subject">'.viewString($m->subject).'</div>';
				echo '<div class="msg-content">'.viewString($m->content).'</div>';
				echo '</div>';
			}
		} else {
			echo "You have no messages in your inbox!";
		
		}
		?>
	</div>

<?php } else if(isset($_GET['id'])) { 
	$id = $_GET['id'];
	$i = getUserInfo($id);
	$in = getUserInstruments($id);
	$u = new User($id);
	if($i!=false) {
?>
	<div id="user-profile">
		<div id="profile-picture" class="right">
			<img src="<?php if(isset($i['picture'])) echo '/'.$i['picture']; else echo "/photos/nameless.png"; ?>" width="200" alt="">
		</div>
		<div class="section-title"><?php echo strtoupper($i['firstname'].' '.$i['lastname']);?>
		<?php if(is_logged_in()) { ?>
		<a id="compose-message" href="?page=compose&to=u-<?php echo $i['id']; ?>" class="small-button right">Message Me</a></div>
		<?php } ?>
		<div id="class"><?php echo $i['class']; ?></div>
		<div id="info" class="section-content"><?php echo viewString($i['info']); ?></div>
		<div id="user-instruments">
		<div class="section-title">I Know...</div>
		<div class="section-content">
		<?php
		if($in!=false) {
			foreach($in as $n) {
				echo '<div class="user-inst">'.$n['name'].'</div>';
			}
		}
		?>
		</div>
		<?php
		if(!empty($u->popacts)) { ?>
			<div class="section-title">I Like...</div>
			<div class="section-content">
			<?php
			foreach($u->popacts as $a) {
				$act = new PopAct($a);
				echo '<div>'.viewString($act->name).'</div>';
			}
			?> </div> <?php
		} 
		?>
		<div class="section-title">My Events</div>
		<div class="section-content">
		<?php
		if(!empty($u->event)) {
			foreach($u->events as $e) {
				echo '<div><a href="?page=profile&event='.$e->id.'">'.date('n/j/y g:i a',$e->starttime).' - '.$e->name.'</a></div>';
			}
		} else {
			echo $u->firstname." has not created any events yet.";
		}
		?>
		</div>
		</div>		
	</div>
<?php
	} else {
		echo '<p>Could not find profile!</p>';
	}
} else if(isset($_GET['band'])) {
	$id = $_GET['band'];
	$b = new Band($id);
?>
	<div id="user-profile">
		<div id="profile-picture" class="right">
			<img src="<?php if(isset($b->picture)&&$b->picture!="") echo '/'.$b->picture; else echo "/photos/nameless.png"; ?>" width="200" alt="">
		</div>
		<div class="section-title"><?php echo strtoupper($b->name);?></div>
		<div id="info"><?php echo viewString($b->info); ?></div>
		<div id="user-instruments">
		<div class="section-title">Style</div>
		<div class="section-content">
		<?php 
		//print_r($b->type);
		if(!empty($b->typenames)) {
			$a = $b->typenames;
			echo $a[0];
			for($i=1;$i<count($b->typenames);$i++) {
				echo ', '.$a[$i];
			}
		}
		?>
		</div>	
		<div class="section-title">Members</div>
		<div class="section-content">
		<?php 
		foreach($b->users as $u) {
			$u = new User($u);
			echo '<div><a href="?page=profile&id='.$u->id.'">'.$u->firstname.' '.$u->lastname.'</a></div>';
		}
		?>
		</div>
		<div class="section-title">Upcoming Events</div>
		<div class="section-content">
		<?php 
		foreach($b->events as $e) {
			echo '<div><a href="?page=profile&event='.$e->id.'">'.$e->name.'</a> - '.date('n/j/y g:i a',$ev->starttime).'</div>';
		}
		?>
		</div>
		</div>
	</div>
<?php	
} else if(isset($_GET['venue'])) {
	$id = $_GET['venue'];
	$b = new Venue($id);
?>
	<div id="user-profile">
		<div id="profile-picture" class="right">
			<img src="<?php if(isset($b->picture)) echo '/photos/'.$b->picture; else echo "/photos/nameless.png"; ?>" width="200" alt="">
		</div>
		<div class="section-title"><?php echo strtoupper($b->name);?></div>
		<div id="info"><?php echo viewString($b->info); ?></div>
		<div class="section-title">Style</div>
			<div class="section-content">
			<?php echo $b->typename; ?>
			</div>
		<div class="section-title">Upcoming Events</div>
			<div class="section-content">
			<?php 
				foreach($b->events as $a) {
					$ev = new Event($a);
					echo '<div><a href="?page=profile&event='.$ev->id.'">'.date('n/j/y g:i a',$ev->starttime).' - '.$ev->name.'</a></div>';
				}
			?>
			</div>
	</div>
<?php	
} else if(isset($_GET['event'])) {
	$id = $_GET['event'];
	$b = new Event($id);
	if($b->exists==true ) {

?>
	<div id="user-profile">
		<div class="section-title"><?php echo strtoupper($b->name);?></div>
		<div id="info"><?php echo viewString($b->description); ?></div>
		<div class="profile-section">
		<div class="section-title">Location</div>
			<div class="section-content">
			<?php 
				$v = new Venue($b->venueid);
				echo '<div><a href="?page=profile&venue='.$v->id.'">'.$v->name.'</a></div>'; 
				echo '<div>'.date('n/j/y g:i a',$b->starttime).'</div>';
			?>
			</div>
		</div>
		<div class="profile-section">
		<div class="section-title">Bands/Acts</div>
			<div class="section-content">
		<?php 
			foreach($b->bands as $a) {
				$as = new Band($a);
				echo '<a href="?page=profile&band='.$as->id.'">'.$as->name.'</a>'; 
			}
		?>
			</div>
		</div>
	</div>

<?php	
	} else {
		echo '<p>The event you are looking for does not exist!</p>';
	}
} else {
	$_GET['page'] = "calendar";
	include('calendarMain.php');
} ?>