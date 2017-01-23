<?php

require_once "TrainingDB.php";

class PersonModel {


	//Get person id
	public static function getByPersonId($personId) {
		$db = TrainingDB::getConnection();
		$sql = "SELECT person_id, name FROM person WHERE person_id = :person_id";
		$stmt = $db->prepare($sql);
		$stmt->bindValue(":person_id", $personId);
		$ok = $stmt->execute();
		if ($ok) {
			return $stmt->fetch(PDO::FETCH_ASSOC);
		}
	}

	//Verify the login information
	public static function getByLoginPassword($email, $password) {

		$db = TrainingDB::getConnection();
		$sql = "SELECT * FROM person WHERE (email = :email AND password=:password)";
		$stmt = $db->prepare($sql);
		$stmt->bindValue(":email", $email);
		$stmt->bindValue(":password", $password);
		$ok = $stmt->execute();
		if ($ok) {
			//this is an associative array
			return $stmt->fetch(PDO::FETCH_ASSOC);
		}
		
		else{
			//return false;
			return null;
		}

	}
	
	//Used to redirect to other pages
	public static function redirect($url){
		if (headers_sent()){
			die('<script type="text/javascript">window.location.href="' . $url . '";</script>');
		}else{
			header('Location: ' . $url);
			die();
		}
	}
	
	
	//Get all elements from the person
	public static function get($personId) {
		$db = TrainingDB::getConnection();
		$stmt = $db->prepare("SELECT * FROM `person` WHERE `person_id` = :person_id");
		$stmt->bindValue(":person_id", $personId);
		$ok = $stmt->execute();
		if ($ok) {
			return json_encode($stmt->fetch(PDO::FETCH_ASSOC));
		}
		else{
			return false;
		}
	}
	
	

	//Get the class the person belongs to 
	public static function getClass($personId) {
		$db = TrainingDB::getConnection();
		$stmt = $db->prepare("SELECT * FROM `class_member` WHERE `person_id` = :person_id");
		$stmt->bindValue(":person_id", $personId);
		$ok = $stmt->execute();
		if ($ok) {
			return $stmt->fetch(PDO::FETCH_ASSOC);
		}
		else{
			return false;
		}
	}
	

	//Check if the person is already in the team
	public static function IsInTeam($person_id, $team_id) {
		$db = TrainingDB::getConnection();
		$sql = "SELECT *
              FROM `team_member`
              WHERE `team_id` = :team_id AND `student_id` = :person_id";
		$stmt = $db->prepare($sql);
		$stmt->bindValue(":team_id", $team_id);
		$stmt->bindValue(":person_id", $person_id);
		$stmt->execute();
		if ($stmt->fetchColumn()>=1) {
			return true;
		}
		else{
			return false;
		}
	}
	
	
	// Class end
}
	
?>