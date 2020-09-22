<?php
	// This class is for manipulating data relating to Contacts
	class Contact {
		// Variable to hold a DB instance
		private $db;
		
		// All variables for when all contacts are searched
		public $all = null; // Variable used to hold all contacts
		
		// All variables which are relating to when a user searches for a particular ID
		public $found = false, // Used to check if a contact could be found or not
			   $single = null, // Variable used to hold details of single contact ID
			   $email = null, // Contact email address
			   $date_of_birth = null, // Users date of birth
			   $number = array(), // Used as an array to store various formatted and unformatted phone numbers
			   $full_name = null, // Variable used to hold full name of contact
			   
			   $name = null,
			   $head = null,
			   
			   $gender = null,
			   $photo = null,
			   $city = null,
			   $contact_id = null,
			   $job = null,
			   $web = null,
			   $added = null,
			   $updated = null,
			   $reason = null,
			   $full_address = null; // Variable used to hold the full address of the contact
			   
		// Constructor
		public function __construct($id = null) {
			// Set the $db with an instance of the database
			$this->db = DB::get_instance();
			
			// If an $id is sent through then return the contact associated with the ID
			// Check if an $id has been sent
			if($id) {
				// $id has been sent, find only that contact
				$this->find_id($id);
			} else {
				// No $id has been sent, find all contacts
				$this->find_all();
			}
		}
		
		// Method to find all contacts in the database
		public function find_all() {
			// Return all 
			return $this->all = $this->db->query('SELECT * FROM org ORDER BY name', PDO::FETCH_ASSOC);
		}
		
		// Method to find specific contact in the database
		public function find_id($id = null) {
			// Check if $id has been sent
			if($id) {
				// Begin prepared statement to find single ID in database
				$sql = '
					SELECT * FROM org 
					WHERE contact_id = :contact_id
				';
				$stmt = $this->db->prepare($sql);
				
				// Pass in the $id into the prepared statement and execute
				$stmt->bindParam(':contact_id', $id);
				$stmt->execute();
				
				// Fetch the results from the prepared statement
				$result = $stmt->fetch();
				
				// Check if a contact could be found
				if($result) {
					// Contact found
					$this->found = true; // Specify that a contact could be found
					// Set the properties of the class as per the users details
					$this->full_name = htmlentities($this->full_name($result['last_name'], $result['first_name'], $result['middle_name']));
					$this->contact_id = htmlentities($this->contact_id($result['contact_id']));
					
					$this->name = htmlentities($this->name($result['name']));
					$this->head = htmlentities($this->head($result['head']));
					
					$this->gender = htmlentities($this->gender($result['gender']));
					$this->photo = htmlentities($this->photo($result['photo']));
					$this->city = htmlentities($this->city($result['city']));
					$this->job = htmlentities($this->job($result['job']));
					$this->web = htmlentities($this->web($result['web']));
					$this->added = htmlentities($this->cosmetic_mysqldate($result['added']));
					$this->updated = htmlentities($this->cosmetic_mysqldate2($result['updated']));
					$this->reason = $this->reason($result['reason']);
					$this->full_address = htmlentities($this->full_address($result['address_line_1'], $result['address_line_2'], $result['address_town'], $result['address_county'], $result['address_post_code']));
					$this->email = htmlentities($result['contact_email']);
					$this->date_of_birth = htmlentities($this->cosmetic_mysqldate($result["date_of_birth"]));
					$this->number['home']['raw'] = htmlentities($result['contact_number_home']);
					$this->number['home']['formatted'] = htmlentities($this->format_phone_number($result['contact_number_home']));
					$this->number['mobile']['raw'] = htmlentities($result['contact_number_mobile']);
					$this->number['mobile']['formatted'] = htmlentities($this->format_phone_number($result['contact_number_mobile']));
					
					// Return all of the details of the contact
					return $this->single = $result;
				} else {
					// Contact not found, return false
					return false;
				}
			} else {
				// $id not sent, return false
				return false;
			}
		}
		

		// Generate an ID to be used as the unique key associated with a new contact which is being created
		private function generate_id($token_length) {
			// Used to generate a token
			// Initialise a variable used to store the token
			$token = null;
			// Create a salt of accepted characters
			$salt = "abcdefghjkmnpqrstuvxyzABCDEFGHIJKLMNOPQRSTUVXYZ0123456789";
			
			srand((double)microtime()*1000000);
			$i = 0;
			while ($i < $token_length) {
				$num = rand() % strlen($salt);
				$tmp = substr($salt, $num, 1);
				$token = $token . $tmp;
				$i++;
			}
			// Return the token
			return $token;
		}
		
		public function format_phone_number($phone_number) {
			// Remove all white space from the phone number
			$phone_number = $this->remove_white_space($phone_number);
			// Insert a space at position 5 in a phone number, formatting as 01234 567890
			return substr_replace($phone_number, " ", 5, 0);
		}
		
		public function remove_white_space($string) {
			// Remove all white space within the string
			return preg_replace('/\s+/', '', $string);
		}
		
		public function full_name($last_name, $first_name, $middle_name){
			// If the person has a middle name
			if($middle_name != null ) {
				// Create their name with a middle name
				return $last_name . " " . $first_name . " " . $middle_name;
			} else {
				// Don't include the middle name
				return $last_name . " " . $first_name;
			}
		}
		
		public function gender($gender){
			if($gender != null ) {
				return $gender;
			} else {
				return $gender;
			}
		}
		
				public function name($name){
			if($name != null ) {
				return $name;
			} else {
				return $name;
			}
		}
				public function head($head){
			if($head != null ) {
				return $head;
			} else {
				return $head;
			}
		}
				public function photo($photo){
			if($photo != null ) {
				return $photo;
			} else {
				return $photo;
			}
		}
		
				public function contact_id($contact_id){
			if($contact_id != null ) {
				return $contact_id;
			} else {
				return $contact_id;
			}
		}
				public function city($city){
			if($city != null ) {
				return $city;
			} else {
				return $city;
			}
		}
						public function job($job){
			if($job != null ) {
				return $job;
			} else {
				return $job;
			}
		}
								public function web($web){
			if($web != null ) {
				return $web;
			} else {
				return $web;
			}
		}
								public function added($added){
			if($added != null ) {
				return $added;
			} else {
				return $added;
			}
		}
		
										public function updated($updated){
			if($updated != null ) {
				return $updated;
			} else {
				return $updated;
			}
		}
								public function reason($reason){
			if($reason != null ) {
				return $reason;
			} else {
				return $reason;
			}
		}
		
		
		private function full_address($address_line_1, $address_line_2=null, $town, $county, $post_code) {
			// If the address has a value in address line 2
			if($address_line_2 != null) {
				// Create the address with the line 2 value
				return $address = $address_line_1 . ", " . $address_line_2 . ", " . $town . ", " . $county . ", " . $post_code;
			} else {
				// Don't include the line 2 value
				return $address = $address_line_1 . ", " . $town . ", " . $county . ", " . $post_code;
			}
		}
		
		private function cosmetic_mysqldate($mysql_date = null) {
			if($mysql_date) {
				// Convert MySQL date to a UNIX time stamp
				$unix_date = strtotime($mysql_date);
				
				// Format date into correct string, example: Saturday 1st May 1993
				$cosmetic_date = date('d.m.Y', $unix_date);
				return $cosmetic_date;
			} else {
				return false;
			}
		}
		
				private function cosmetic_mysqldate2($mysql_date = null) {
			if($mysql_date) {
				// Convert MySQL date to a UNIX time stamp
				$unix_date = strtotime($mysql_date);
				
				// Format date into correct string, example: Saturday 1st May 1993
				$cosmetic_date2 = date('d.m.Y H:i', $unix_date);
				return $cosmetic_date2;
			} else {
				return false;
			}
		}
		
	}; // Close class Contact
	
// EOF