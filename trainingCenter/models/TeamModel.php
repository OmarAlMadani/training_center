<?php

require_once "TrainingDB.php";

class TeamModel {


	//Add a new member to the team
	public static function addMember($person_id,$team_id) {
		$db = TrainingDB::getConnection();
		$sql = "INSERT INTO `team_member`(`team_id`, `student_id`) VALUES (:team_id, :student_id)";
		$stmt = $db->prepare($sql);
		$stmt->bindValue(":team_id", $team_id);
		$stmt->bindValue(":student_id",$person_id );
		$ok = $stmt->execute();
		
	}
	
	//Remove a member from the team
	public static function removeMember($person_id,$team_id) {
		$db = TrainingDB::getConnection();
		$sql = "DELETE FROM `team_member` WHERE `student_id`=:student_id AND `team_id`=:team_id";
		$stmt = $db->prepare($sql);
		$stmt->bindValue(":team_id", $team_id);
		$stmt->bindValue(":student_id",$person_id );
		$ok = $stmt->execute();
	
	}
	
	
}