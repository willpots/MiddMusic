<?php



class DBObject {
	//! Database Identifier
	public $id = null;
	//! Database Username
	public $User = "middmusic";
	//! Database Password
	public $Pass = "MMG2mmu!";
	//! Database Host
	public $Host = "middmusic.db.7831758.hostedresource.com";
	//! Database Schema
	public $Schema = "middmusic";
	//! Database Connection
	public $Con = null;
	//! Create the connection to the database
	public function getConnection(){
		$con = mysql_connect($this->Host, $this->User, $this->Pass);
		if(!$con) die('Could not connect: ' . mysql_error());
		mysql_select_db($this->Schema, $con) or die('Could not select database');
		return $con;
	}
	//! Close the connection to the database
	public function closeConnection(){
		mysql_close($this->Con);
	}
}

class User extends DBObject {
	/* Variables Section */
	//! User's slug name
	public $username;
	//! Email Address
	public $email;
	//! User Picture Path
	public $picture;
	//! User Class Year
	public $class;
	//! User Firstname
	public $firstname;
	//! User Lastname
	public $lastname;
	//! User Admin?
	public $admin;
	//! User Valid?
	public $valid;
	//! User info
	public $info;
	
	/* Arrays Section */
	public $bands = array();
	public $events = array();
	public $venues = array();
	public $instruments = array();
	//! Initialize User
	public __construct($i) {
		$this->id=$i;
		$this->Con=$this->getConnection();
		$result = mysql_query("SELECT * FROM user WHERE id='".$this->id."'",$this->Con) or die();
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
		}
		$result = mysql_query("SELECT * FROM userbands WHERE userid='".$this->id."'",$this->Con) or die();
		while($row=mysql_fetch_array($result)){
			$this->bands[] = new Band($row['id']);
		}
		$result = mysql_query("SELECT * FROM userevents WHERE userid='".$this->id."'",$this->Con) or die();
		while($row=mysql_fetch_array($result)){
			$this->bands[] = new Band($row['id']);
		}
		$result = mysql_query("SELECT * FROM userbands WHERE userid='".$this->id."'",$this->Con) or die();
		while($row=mysql_fetch_array($result)){
			$this->bands[] = new Band($row['id']);
		}
		
	}

	//!
}
class Venue extends DBObject {
	
	//! Initialize Venue
	public __construct($i) {
		$this->id=$i;
		$this->Con=$this->getConnection();
	}
}
class Event extends DBObject {

	//! Initialize Event
	public __construct($i) {
		$this->id=$i;
		$this->Con=$this->getConnection();
	}
}
class Calendar extends DBObject {
	
	//! Initialize Calendar
	public __construct($i) {
		$this->id=$i;
		$this->Con=$this->getConnection();
	}
}
class Category extends DBObject {

	//! Initialize Category
	public __construct($i) {
		$this->id=$i;
		$this->Con=$this->getConnection();
	}
}

class MailingList {

}
?>