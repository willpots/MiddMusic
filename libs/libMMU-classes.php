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
		$this->Con = $con;
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
	public $commons;
	public $firstname;
	public $lastname;
	public $admin;
	public $valid;
	public $info;
	public $exists;
	public $registered;
	public $email_ok;
	
	public $confirmed=false;
	public $bands = array();
	public $events = array();
	public $venues = array();
	public $instruments = array();
	public $messages = array();
	public $popacts = array();
	
	public function __construct($i=null,$code=null) {
		if($i!=null) {
			$this->id=$i;
			$this->Con=$this->getConnection();
			$result = mysql_query("SELECT * FROM user WHERE id='".$this->id."'",$this->Con) or die("It was me!".mysql_error());
			while($row=mysql_fetch_array($result)){
				$this->username = $row['username'];
				$this->email = $row['email'];
				$this->picture = $row['picture'];
				$this->class = $row['class'];
				$this->commons = $row['commons'];
				$this->firstname = $row['firstname'];
				$this->lastname = $row['lastname'];
				$this->admin = $row['admin'];
				$this->valid = $row['valid'];
				$this->info = $row['info'];
				$this->registered = $row['registered'];
				$this->email_ok = $row['email_ok'];
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
					$this->instruments[] = new Instrument($row['instrumentid']);
				}
				$result = mysql_query("SELECT * FROM userpopacts WHERE userid='".$this->id."'",$this->Con) or die("It was me!".mysql_error());
				while($row=mysql_fetch_array($result)){
					$this->popacts[] = $row['popactid'];
				}
				// Messages
				$query = "SELECT * FROM messages WHERE msgsent >= '".$this->registered."' AND (msgto LIKE '%:everyone:%' OR msgto LIKE '%:u-".$this->id.":%' OR msgfrom LIKE '%:u-".$this->id.":%'";
				if(!empty($this->bands)) {
					foreach($this->bands as $a) {
						$query .= " OR msgto LIKE '%:b-".$a->id.":%' OR msgfrom LIKE '%:b-".$a->id.":%'";
					}
				}
				if(!empty($this->venues)) {
					foreach($this->venues as $v) {
						$query .= " OR msgto LIKE '%:v-".$v->id.":%' OR msgfrom LIKE '%:v-".$v->id.":%'";
				 	}
				}
				if(!empty($this->instruments)) {
					foreach($this->instruments as $i) {
						$query .= " OR msgto LIKE '%:i-".$i->id.":%' OR msgfrom LIKE '%:i-".$i->id.":%'";
					}
				}
				$query .= ") ORDER BY msgsent DESC";
				$messages=array();
				$result = mysql_query($query,$this->Con) or die(mysql_error()." ".$query);
				while($row=mysql_fetch_array($result)) {
					$q = "SELECT * FROM messageread WHERE userid='".$_COOKIE['mu_id']."' AND messageid='".$row['id']."'";
					$result2 = mysql_query($q,$this->Con) or die(mysql_error()." ".$q);
					if(mysql_num_rows($result2)==0) {
						$messages[]= new Message($row['id']);
					}
				}
			 	if(empty($messages)) $this->messages=false;
				else $this->messages = $messages;
 			}
		} else if($code!=null) {
			$this->Con = $this->getConnection();
			$query = "SELECT * FROM user WHERE confirm = '$code'";
			$result = mysql_query($query,$this->Con) or die(mysql_error()." ".$query);
			if(mysql_num_rows($result)>0) {
				while($row=mysql_fetch_array($result)) {
					$id = $row['id'];
				}
				$query = "UPDATE user SET valid='1' WHERE id='$id'";
				$a = mysql_query($query,$this->Con) or die(mysql_error()." ".$query);
				if($a==true) $this->confirmed = true;
			}
		}
	}
	public function confirm() {
	
	}
	public function login() {
		$expires = time() + 60*60*24*31;
		if($this->valid==1) {
			setrawcookie("mu_user", $this->username, $expires);
			setrawcookie("mu_id", $this->id, $expires);
		}
		if($this->admin == 1 && $this->valid==1) {
			setrawcookie("mu_admin", "yes", $expires);
		}
	}
	public function update() {
		$query = "UPDATE user SET firstname='".$this->firstname."', lastname='".$this->lastname."', info='".$this->info."', picture='".$this->picture."' WHERE id='".$this->id."'";
		$result = mysql_query($query) or die("Couldn't do query because of: ".mysql_error());
		$query = "DELETE FROM userpopacts WHERE userid='".$this->id."'";
		$result = mysql_query($query) or die("Couldn't do query because of: ".mysql_error());
		foreach($this->popacts as $a) {
			$query = "INSERT INTO userpopacts (userid, popactid) VALUES ('".$this->id."','".$a."')";
			$result = mysql_query($query) or die("Couldn't do query because of: ".mysql_error());
		}
		
	}
	public function addInstrument($instid) {
		$query = "INSERT INTO userinstruments (userid, instrumentid) VALUES ('".$this->id."','$instid')";
		$result = mysql_query($query) or die("Couldn't do query because of: ".mysql_error());
	}
	public function deleteInstrument($instid) {
		$query = "DELETE FROM userinstruments WHERE userid='".$this->id."' AND instrumentid='$instid'";
		$result = mysql_query($query,$this->Con) or die("Couldn't do query because of: ".mysql_error());
	}
	public function addPopAct($popactid) {
		$query = "DELETE FROM userpopacts WHERE userid='".$this->id."' AND popactid='$popactid'";
		$result = mysql_query($query,$this->Con) or die("Couldn't do query because of: ".mysql_error());
	}
	public function deletePopAct($popactid) {
		$query = "DELETE FROM userpopacts WHERE userid='".$this->id."' AND popactid='$popactid'";
		$result = mysql_query($query,$this->Con) or die("Couldn't do query because of: ".mysql_error());
	}
	public function canEdit($id,$type) {
		if($type=="band") {
			$query = "SELECT * FROM userbands WHERE userid='".$this->id."' AND bandid='$id'";
		} else if($type=="venue") {
			$query = "SELECT * FROM uservenue WHERE userid='".$this->id."' AND venueid='$id'";
		} else if($type=="event") {
			$query = "SELECT * FROM usercalendar WHERE userid='".$this->id."' AND calendarid='$id'";
		}
		$result = mysql_query($query,$this->Con);
		if(mysql_num_rows($result)!=0) {
			return true;
		} else {
			return false;
		}
	}
	public function set($field,$value) {
		$query = "UPDATE user SET $field = '$value' WHERE id = '".$this->id."'";
		mysql_query($query,$this->Con) or die("Query $query failed because: ".mysql_error());
	}
}

class Message extends DBObject {
	public $id;
	public $msgto=NULL;
	public $msgfrom=NULL;
	public $msgsent=NULL;
	public $deletedto=NULL;
	public $deletedfrom=NULL;
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
				$this->msgfrom = $row['msgfrom'];
				$this->msgto = $row['msgto'];
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
		(msgsent, msgto, msgfrom, subject, content, unread) 
		VALUES ('$date', '".$this->msgto."','".$this->msgfrom."', '".$this->subject."', '".$this->content."', '1')";
		
		mysql_query($query) or die("Query failed: ".$query.' '.mysql_error());
	}
	function delete() {
		$this->Con = $this->getConnection();
		$query = "INSERT INTO messageread (userid,messageid) VALUES ('".$_COOKIE['mu_id']."','".$this->id."')";
		mysql_query($query) or die("Query failed: ".$query.' '.mysql_error());
	}
	function markAsRead() {
		$this->Con = $this->getConnection();
		$query = "UPDATE messages SET unread='0' WHERE id='".$this->id."'";
		mysql_query($query) or die("Query failed: ".$query.' '.mysql_error());
	}
}
class Band extends DBObject {
	
	public $name;
	public $picture=NULL;
	public $typenames=array();
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
			$this->type = explode(',',$row['type']);
			$this->info = $row['info'];
			$this->exists=true;
			if($this->name == "") {
				$this->name = "Unnamed";
			}
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
			if(!empty($this->type)) {
				foreach($this->type as $a) {
					$result = mysql_query("SELECT * FROM bandstyles WHERE id='".$a."'",$this->Con) or die("It was me!".mysql_error());
					while($row=mysql_fetch_array($result)){
						$this->typenames[] = $row['name'];
					}
				}
			}
		}
	}
	public function update() {
		$result = mysql_query("UPDATE bands SET 
								name = '".$this->name."', 
								type = '".$this->type."',
								info = '".$this->info."', 
								picture = '".$this->picture."' 
							 	WHERE id='".$this->id."'",$this->Con) or die("It was me!".mysql_error());
		$query = "DELETE FROM userbands WHERE bandid='".$this->id."'";
		mysql_query($query,$this->Con) or die("Query $query failed.".mysql_error());
		foreach($this->users as $u) {
			$query = "INSERT INTO userbands (userid,bandid) VALUES ('".$u."','".$this->id."')";
			mysql_query($query,$this->Con) or die("Query $query failed.".mysql_error());
		}
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
	public $latitude;
	public $longitude;
	
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
			$this->latitude=$row['latitude'];
			$this->longitude=$row['longitude'];
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
	public function delete() {
		mysql_query("DELETE FROM calendar WHERE id='".$this->id."'",$this->Con) or die("It was me!".mysql_error());
		mysql_query("DELETE FROM usercalendar WHERE calendarid='".$this->id."'",$this->Con) or die("It was me!".mysql_error());
		mysql_query("DELETE FROM bandcalendar WHERE calendarid='".$this->id."'",$this->Con) or die("It was me!".mysql_error());
		mysql_query("DELETE FROM venuecalendar WHERE calendarid='".$this->id."'",$this->Con) or die("It was me!".mysql_error());
	}
}
class Record extends DBObject {
	public $id;
	public $name;
	public $starttime;
	public $endtime;
	public $description;
	public $users = array();
	public $bands = array();
	public $exists = false;
	
	public function __construct($i) {
		$this->id=$i;
		$this->Con=$this->getConnection();
		$result = mysql_query("SELECT * FROM record WHERE id='".$this->id."'",$this->Con) or die("It was me!".mysql_error());
		while($row=mysql_fetch_array($result)){
			$this->name = $row['name'];
			$this->starttime = $row['starttime'];
			$this->endtime = $row['endtime'];
			$this->description = $row['description'];
			$this->exists=true;
		}
		if($this->exists==true){
			$result = mysql_query("SELECT * FROM userrecord WHERE recordid='".$this->id."'",$this->Con) or die("It was me!".mysql_error());
			while($row=mysql_fetch_array($result)){
				$this->users[] = $row['userid'];
			}
			$result = mysql_query("SELECT * FROM bandrecord WHERE recordid='".$this->id."'",$this->Con) or die("It was me!".mysql_error());
			while($row=mysql_fetch_array($result)){
				$this->bands[] = $row['bandid'];
			}
		}
	}
	public function update() {
		mysql_query("UPDATE record SET name = '".$this->name."', starttime = '".$this->starttime."', endtime = '".$this->endtime."', description = '".$this->description."' WHERE id = '".$this->id."'") or die("It was me!".mysql_error());
		mysql_query("DELETE FROM bandrecord WHERE recordid='".$this->id."'",$this->Con) or die("It was me!".mysql_error());
		foreach($this->bands as $b) {
			mysql_query("INSERT INTO bandrecord (bandid,recordid) VALUES ('".$b."','".$this->id."')") or die("It was me!".mysql_error());
		}
	}
	public function delete() {
		mysql_query("DELETE FROM record WHERE id='".$this->id."'",$this->Con) or die("It was me!".mysql_error());
		mysql_query("DELETE FROM userrecord WHERE recordid='".$this->id."'",$this->Con) or die("It was me!".mysql_error());
		mysql_query("DELETE FROM bandrecord WHERE recordid='".$this->id."'",$this->Con) or die("It was me!".mysql_error());
	}
}
class Practice extends DBObject {
	public $id;
	public $name;
	public $starttime;
	public $endtime;
	public $description;
	public $users = array();
	public $bands = array();
	public $exists = false;
	
	public function __construct($i) {
		$this->id=$i;
		$this->Con=$this->getConnection();
		$result = mysql_query("SELECT * FROM practice WHERE id='".$this->id."'",$this->Con) or die("It was me!".mysql_error());
		while($row=mysql_fetch_array($result)){
			$this->name = $row['name'];
			$this->starttime = $row['starttime'];
			$this->endtime = $row['endtime'];
			$this->description = $row['description'];
			$this->exists=true;
		}
		if($this->exists==true){
			$result = mysql_query("SELECT * FROM userpractice WHERE practiceid='".$this->id."'",$this->Con) or die("It was me!".mysql_error());
			while($row=mysql_fetch_array($result)){
				$this->users[] = $row['userid'];
			}
			$result = mysql_query("SELECT * FROM bandpractice WHERE practiceid='".$this->id."'",$this->Con) or die("It was me!".mysql_error());
			while($row=mysql_fetch_array($result)){
				$this->bands[] = $row['bandid'];
			}
		}
	}
	public function update() {
		mysql_query("UPDATE practice SET name = '".$this->name."', starttime = '".$this->starttime."', endtime = '".$this->endtime."', description = '".$this->description."' WHERE id = '".$this->id."'") or die("It was me!".mysql_error());
		mysql_query("DELETE FROM bandpractice WHERE practiceid='".$this->id."'",$this->Con) or die("It was me!".mysql_error());
		foreach($this->bands as $b) {
			mysql_query("INSERT INTO bandpractice (bandid,practiceid) VALUES ('".$b."','".$this->id."')") or die("It was me!".mysql_error());
		}
	}
	public function delete() {
		mysql_query("DELETE FROM practice WHERE id='".$this->id."'",$this->Con) or die("It was me!".mysql_error());
		mysql_query("DELETE FROM userpractice WHERE practiceid='".$this->id."'",$this->Con) or die("It was me!".mysql_error());
		mysql_query("DELETE FROM bandpractice WHERE practiceid='".$this->id."'",$this->Con) or die("It was me!".mysql_error());
	}
}

class Instrument extends DBObject {

	public $id=null;
	public $name=null;
	public function __construct($i=null) {
		if($i!=null) {
			$this->id=$i;
			$this->Con=$this->getConnection();
			$query = "SELECT * FROM instruments WHERE id='$i'";
			$result = mysql_query($query,$this->Con) or die("Couldn't complete $query ".mysql_error());
			while($row=mysql_fetch_array($result)) {
				$this->name = $row['name'];
			}
		}
	}
}
class PopAct extends DBObject {

	public $id=null;
	public $name=null;
	public function __construct($i=null) {
		if($i!=null) {
			$this->id=$i;
			$this->Con=$this->getConnection();
			$query = "SELECT * FROM popacts WHERE id='$i'";
			$result = mysql_query($query,$this->Con) or die("Couldn't complete $query ".mysql_error());
			while($row=mysql_fetch_array($result)) {
				$this->name = $row['name'];
			}
		}
	}
}

class MailingList {
	
}
?>