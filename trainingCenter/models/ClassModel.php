<?php
require_once("TrainingDB.php");


class ClassModel {

	//Get class id
	public static function getClassId($class_id) {
		$db = TrainingDB::getConnection();
		$stmt = $db->prepare("SELECT * FROM `class` WHERE `class_id` = :class_id");
		$stmt->bindValue(":class_id", $class_id);
		$ok = $stmt->execute();
		if ($ok) {
			return $stmt->fetch(PDO::FETCH_ASSOC);
		}
		else{
			return false;
		}
	}

	//Get all members from a class
	public static function getClassMembers($class_id) {
		$db = TrainingDB::getConnection();
		$stmt = $db->prepare("SELECT * FROM `class_member` WHERE `class_id` = :class_id");
		$stmt->bindValue(":class_id", $class_id);
		$stmt->execute();
		$class = $stmt->fetchAll();
		return $class;
	}
	

	//Select all elements from the class
	public static function getClassSelect() {
		$db = TrainingDB::getConnection();
		$stmt = $db->prepare("SELECT * FROM `class`");
		$stmt->execute();
		$class = $stmt->fetchAll();
		$select = '';
		for($i=0; $i<count($class); $i++){
			$select .= '<option value="' .$class[$i]['class_id']. '">' .$class[$i]['name']. '</option>';
		}
		return $select;
	}

	

	//Get the class name
	public static function showName($class_id) {
		$db = TrainingDB::getConnection();
		$stmt = $db->prepare("SELECT * FROM `class` WHERE `class_id` = :class_id");
		$stmt->bindValue(":class_id", $class_id);
		$stmt->execute();
		$class = $stmt->fetch(PDO::FETCH_ASSOC);
		print $class["name"];;
	}


}

?>