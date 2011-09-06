<?php
function compareMessages($a,$b) {
	if($a->msgsent==$b->msgsent) {
		return 0;
	} else if($a->msgsent<$b->msgsent) {
		return 1;
	} else if($a->msgsent>$b->msgsent) {
		return -1;
	}
}
function compareEvents($a,$b) {
	if($a->starttime==$b->starttime) {
		return 0;
	} else if($a->starttime<$b->starttime) {
		return -1;
	} else if($a->starttime>$b->starttime) {
		return 1;
	}
}
class DBObject {
	public $id = null;
	public $User = "middmusic";
	public $Pass = "MMG2mmu!";
	public $Host = "middmusic.db.7831758.hostedresource.com";
	public $Schema = "middmusic";
	public $Con = null;
	public function getConnection(){
		$con = mysql_connect($this->Host, $this->User, $this->Pass);
		if(!$con) die('Could not connect: ' . mysql_error());
		mysql_select_db($this->Schema, $con) or die('Could not select database');
		return $con;
	}
	public function closeConnection(){
		mysql_close($this->Con);
	}
}

class User extends DBObject { //USER
	
	public $username;
	public $email;
	public $picture;
	public $class;
	public $firstname;
	public $lastname;
	public $admin;
	public $valid;
	public $info;
	public $exists;
	
	
	public $bands = array();
	public $events = array();
	public $venues = array();
	public $instruments = array();
	public $messages = array();
	
	public function __construct($i=null) {
		if($i!=null) {
			$this->id=$i;
			$this->Con=$this->getConnection();
			$result = mysql_query("SELECT * FROM user WHERE id='".$this->id."'",$this->Con) or die("It was me!".mysql_error());
			while($row=mysql_fetch_array($result)){
				$this->username = $row['username'];
				$this->email = $row['email'];
				$this->picture = $row['picture'];
				$this->class = $row['class'];
				$this->firstname = $row['firstname'];
				$this->lastname = $row['lastname'];
				$this->admin = $row['admin'];
				$this->valid = $row['valid'];
				$this->info = $row['info'];
				$this->exists=true;
			}
			if($this->exists==true){
				$result = mysql_query("SELECT * FROM userbands WHERE userid='".$this->id."'",$this->Con) or die("It was me!".mysql_error());
				while($row=mysql_fetch_array($result)){
					$this->bands[] = new Band($row['bandid']);
				}
				$result = mysql_query("SELECT * FROM usercalendar WHERE userid='".$this->id."'",$this->Con) or die("It was me!".mysql_error());
				while($row=mysql_fetch_array($result)){
					$e = new Event($row['calendarid']);
					if(!in_array($e,$this->events)&&$e->starttime>=time()) {
						$this->events[]=$e;
					}
				}
				foreach($this->bands as $b) {
					$result = mysql_query("SELECT * FROM bandcalendar WHERE bandid='".$b->id."'",$this->Con) or die("It was me!".mysql_error());
					while($row=mysql_fetch_array($result)){
						$e = new Event($row['calendarid']);
						if(!in_array($e,$this->events)&&$e->starttime>=time()) {
							$this->events[]=$e;
						}
					}				
				}
				usort($this->events, "compareEvents" );
				$result = mysql_query("SELECT * FROM uservenue WHERE userid='".$this->id."'",$this->Con) or die("It was me!".mysql_error());
				while($row=mysql_fetch_array($result)){
					$this->venues[] = new Venue($row['venueid']);
				}
				$result = mysql_query("SELECT * FROM userinstruments WHERE userid='".$this->id."'",$this->Con) or die("It was me!".mysql_error());
				while($row=mysql_fetch_array($result)){
					$this->instruments[] = $row['instrumentid'];
				}
				$query = "SELECT * FROM messages WHERE usermsgto='".$this->id."' OR usermsgfrom='".$this->id."' ORDER BY msgsent DESC";
				$result = mysql_query($query,$this->Con) or die("Couldn't do query because of: ".mysql_error());
			 	while($row=mysql_fetch_array($result)) {
			 		if($row['usermsgto']==$this->id&&$row['deletedto']!=1) {
				 		$m=new Message($row['id']);
				 		$m->state="to";
				 		$this->messages[] = $m;
			 		} else if($row['usermsgfrom']==$this->id&&$row['deletedfrom']!=1) {
				 		$m=new Message($row['id']);
				 		$m->state="from";
				 		$this->messages[] = $m;
			 		}
			 	}
				if(!empty($this->bands)) {
					foreach($this->bands as $a) {
						$query = "SELECT * FROM messages WHERE bandmsgto='".$a->id."' OR bandmsgfrom='".$a->id."' ORDER BY msgsent DESC";
						$result = mysql_query($query,$this->Con) or die("Couldn't do query because of: ".mysql_error());
					 	while($row=mysql_fetch_array($result)) {
					 		if($row['bandmsgto']==$a->id&&$row['deletedto']!=1) {
						 		$m=new Message($row['id']);
						 		$m->state="to";
						 		$this->messages[] = $m;
					 		} else if($row['bandmsgfrom']==$a->id&&$row['deletedfrom']!=1) {
						 		$m=new Message($row['id']);
						 		$m->state="from";
						 		$this->messages[] = $m;
					 		}
					 	}
				 	}
				}
				if(!empty($this->venues)) {
					foreach($this->venues as $v) {
						$query = "SELECT * FROM messages WHERE venuemsgto='".$v->id."' OR venuemsgfrom='".$v->id."' ORDER BY msgsent DESC";
						$result = mysql_query($query,$this->Con) or die("Couldn't do query because of: ".mysql_error());
					 	while($row=mysql_fetch_array($result)) {
					 		if($row['bandmsgto']==$v->id&&$row['deletedto']!=1) {
						 		$m=new Message($row['id']);
						 		$m->state="to";
						 		$this->messages[] = $m;
					 		} else if($row['bandmsgfrom']==$v->id&&$row['deletedfrom']!=1) {
						 		$m=new Message($row['id']);
						 		$m->state="to";
						 		$this->messages[] = $m;
					 		}
					 	}
				 	}
				}
				usort($this->messages, "compareMessages" );
			 	if(!empty($this->messages)) return $this->messages;
			 	else return false;
 			}
		}
	}
	public function login() {
		$expires = time() + 60*60*24*31;
		if($this->valid==1)
		{
			setrawcookie("mu_user", $this->username, $expires);
			setrawcookie("mu_id", $this->id, $expires);
		}
		if($this->admin == 1 && $this->valid==1)
		{
			setrawcookie("mu_admin", "yes", $expires);
		}
	}
	public function addInstrument($instid) {
		$query = "INSERT INTO userinstruments (userid, instrumentid) VALUES ('".$this->id."','$instid')";
		$result = mysql_query($query) or die("Couldn't do query because of: ".mysql_error());
		$result = mysql_query("SELECT * FROM messages WHERE usermsgto='".$this->id."' OR usermsgfrom='".$this->id."'",$this->Con) or die("It was me!".mysql_error());
		while($row=mysql_fetch_array($result)){
			$this->messages[] = new Message($row['id']);
		}
	}
	public function deleteInstrument($instid) {
		$query = "DELETE FROM userinstruments WHERE userid='".$this->id."' AND instrumentid='$instid'";
		$result = mysql_query($query,$this->Con) or die("Couldn't do query because of: ".mysql_error());
		$result = mysql_query("SELECT * FROM messages WHERE usermsgto='".$this->id."' OR usermsgfrom='".$this->id."'",$this->Con) or die("It was me!".mysql_error());
		while($row=mysql_fetch_array($result)){
			$this->messages[] = new Message($row['id']);
		}
	}
	public function canEdit($id,$type) {
		if($type=="band") {
			
		} else if($type=="venue") {
			
		} else if($type=="event") {
			
		}
	}
}

class Message extends DBObject {
	public $id;
	public $usermsgto=NULL;
	public $usermsgfrom=NULL;
	public $bandmsgto=NULL;
	public $bandmsgfrom=NULL;
	public $venuemsgto=NULL;
	public $venuemsgfrom=NULL;
	public $msgsent=NULL;
	public $subject=NULL;
	public $content=NULL;
	public $state=NULL;
	public $unread;
	
	public function __construct($i=null) {
		$this->Con = $this->getConnection();
		if($i!=null) {
			$this->id=$i;
			$query = "SELECT * FROM messages WHERE id='".$this->id."'";		
			$result = mysql_query($query) or die("Query failed: ".mysql_error());
			while($row=mysql_fetch_array($result)) {
				$this->id = $row['id'];
				$this->msgsent = $row['msgsent'];
				$this->usermsgfrom = $row['usermsgfrom'];
				$this->usermsgto = $row['usermsgto'];
				$this->bandmsgfrom = $row['bandmsgfrom'];
				$this->bandmsgto = $row['bandmsgto'];
				$this->venuemsgfrom = $row['venuemsgfrom'];
				$this->venuemsgto = $row['venuemsgto'];
				$this->subject = $row['subject'];
				$this->content = $row['content'];
				$this->unread = $row['unread'];
			}
		}
	} 
	function deliver() {
		$this->Con = $this->getConnection();
		$this->subject=cleanString($this->subject);
		$this->content=cleanString($this->content);
		$date = time();
		$query = "INSERT INTO messages 
		(msgsent, usermsgto, usermsgfrom, bandmsgto, bandmsgfrom, venuemsgto, venuemsgfrom, subject, content, unread) 
		VALUES ('$date', '".$this->usermsgto."','".$this->usermsgfrom."', '".$this->bandmsgto."', '".$this->bandmsgfrom."', '".$this->venuemsgto."', '".$this->venuemsgfrom."', '".$this->subject."', '".$this->content."', '1')";
		$result = mysql_query($query) or die("Query failed: ".mysql_error());
	}
	function delete($tofrom) {
		$this->Con = $this->getConnection();
		echo $tofrom;
		if($tofrom=="to") {
			$query = "UPDATE messages SET deletedto='1' WHERE id='".$this->id."'";
		} else if($tofrom=="from") {
			$query = "UPDATE messages SET deletedfrom='1' WHERE id='".$this->id."'";
		}
		mysql_query($query) or die("Query failed: ".mysql_error());
	}
	function markAsRead() {
		$this->Con = $this->getConnection();
		$query = "UPDATE messages SET unread='0' WHERE id='".$this->id."'";
		mysql_query($query) or die("Query failed: ".mysql_error());
	}
}
class Band extends DBObject {
	
	public $name;
	public $picture;
	public $typename;
	public $type;
	public $info;
	public $exists=false;
	
	
	public $users = array();
	public $events = array();
		
	public function __construct($i) {
		$this->id=$i;
		$this->Con=$this->getConnection();
		$result = mysql_query("SELECT * FROM bands WHERE id='".$this->id."'",$this->Con) or die("It was me!".mysql_error());
		while($row=mysql_fetch_array($result)){
			$this->name = $row['name'];
			$this->picture = $row['picture'];
			$this->type = $row['type'];
			$this->info = $row['info'];
			$this->exists=true;
		}
		if($this->exists==true){

			$result = mysql_query("SELECT * FROM bandcalendar WHERE bandid='".$this->id."'",$this->Con) or die("It was me!".mysql_error());
			while($row=mysql_fetch_array($result)){
				$e = new Event($row['calendarid']);
				if(!in_array($e,$this->events)&&$e->starttime>=time()) {
					$this->events[]=$e;
				}
			}
			$result = mysql_query("SELECT * FROM userbands WHERE bandid='".$this->id."'",$this->Con) or die("It was me!".mysql_error());
			while($row=mysql_fetch_array($result)){
				$this->users[] = $row['userid'];
			}
			$result = mysql_query("SELECT * FROM bandstyles WHERE id='".$this->type."'",$this->Con) or die("It was me!".mysql_error());
			while($row=mysql_fetch_array($result)){
				$this->typename = $row['name'];
			}
		}
	}
	public function update() {
		$result = mysql_query("UPDATE bands SET 
								name = '".$this->name."', 
								type = '".$this->type."',
								info = '".$this->info."' 
							 	WHERE id='".$this->id."'",$this->Con) or die("It was me!".mysql_error());
	
	}
}
class Venue extends DBObject {
	
	public $name;
	public $email;
	public $picture;
	public $lastname;
	public $typename;
	public $type;
	public $info;
	public $exists;
	
	
	public $users = array();
	public $events = array();
		
	public function __construct($i) {
		$this->id=$i;
		$this->Con=$this->getConnection();
		$result = mysql_query("SELECT * FROM venue WHERE id='".$this->id."'",$this->Con) or die("It was me!".mysql_error());
		while($row=mysql_fetch_array($result)){
			$this->name = $row['name'];
			$this->email = $row['email'];
			$this->picture = $row['picture'];
			$this->type = $row['type'];
			$this->info = $row['info'];
			$this->exists=true;
		}
		if($this->exists==true){

			$result = mysql_query("SELECT * FROM venuecalendar WHERE venueid='".$this->id."'",$this->Con) or die("It was me!".mysql_error());
			while($row=mysql_fetch_array($result)){
				$this->events[] = $row['calendarid'];
			}
			$result = mysql_query("SELECT * FROM uservenue WHERE venueid='".$this->id."'",$this->Con) or die("It was me!".mysql_error());
			while($row=mysql_fetch_array($result)){
				$this->users[] = $row['userid'];
			}
			$result = mysql_query("SELECT * FROM venuestyles WHERE id='".$this->type."'",$this->Con) or die("It was me!".mysql_error());
			while($row=mysql_fetch_array($result)){
				$this->typename = $row['name'];
			}
		}
	}
}
class Event extends DBObject {
	public $id;
	public $name;
	public $starttime;
	public $endtime;
	public $description;
	public $users = array();
	public $venueid;
	public $bands = array();
	public $exists = false;
	
	public function __construct($i) {
		$this->id=$i;
		$this->Con=$this->getConnection();
		$result = mysql_query("SELECT * FROM calendar WHERE id='".$this->id."'",$this->Con) or die("It was me!".mysql_error());
		while($row=mysql_fetch_array($result)){
			$this->name = $row['name'];
			$this->starttime = $row['starttime'];
			$this->endtime = $row['endtime'];
			$this->description = $row['description'];
			$this->exists=true;
		}
		if($this->exists==true){
			$result = mysql_query("SELECT * FROM usercalendar WHERE calendarid='".$this->id."'",$this->Con) or die("It was me!".mysql_error());
			while($row=mysql_fetch_array($result)){
				$this->users[] = $row['userid'];
			}
			$result = mysql_query("SELECT * FROM bandcalendar WHERE calendarid='".$this->id."'",$this->Con) or die("It was me!".mysql_error());
			while($row=mysql_fetch_array($result)){
				$this->bands[] = $row['bandid'];
			}
			$result = mysql_query("SELECT * FROM venuecalendar WHERE calendarid='".$this->id."'",$this->Con) or die("It was me!".mysql_error());
			while($row=mysql_fetch_array($result)){
				$this->venueid = $row['venueid'];
			}
			
		}
	}
	public function update() {
		mysql_query("UPDATE calendar SET name = '".$this->name."', starttime = '".$this->starttime."', endtime = '".$this->endtime."', description = '".$this->description."' WHERE id = '".$this->id."'") or die("It was me!".mysql_error());
		mysql_query("DELETE FROM bandcalendar WHERE calendarid='".$this->id."'",$this->Con) or die("It was me!".mysql_error());
		foreach($this->bands as $b) {
			mysql_query("INSERT INTO bandcalendar (bandid,calendarid) VALUES ('".$b."','".$this->id."')") or die("It was me!".mysql_error());
		}
		mysql_query("DELETE FROM venuecalendar WHERE calendarid='".$this->id."'",$this->Con) or die("It was me!".mysql_error());
		mysql_query("INSERT INTO venuecalendar (calendarid, venueid) VALUES ('".$this->id."' , '".$this->venueid."')") or die(mysql_error());
	}
}
class Calendar extends DBObject {
	
	public function __construct($i) {
		$this->id=$i;
		$this->Con=$this->getConnection();
	}
}
class Category extends DBObject {

	public function __construct($i) {
		$this->id=$i;
		$this->Con=$this->getConnection();
	}
}

class MailingList {
	
}
?>