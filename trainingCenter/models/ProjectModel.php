<?php

require_once("TrainingDB.php");


class ProjectModel {


  //Get all the information from the current project
  public static function get($project_id) {
    $db = TrainingDB::getConnection();
    $stmt = $db->prepare("SELECT * FROM `project` WHERE `project_id` = :project_id");
    $stmt->bindValue(":project_id", $project_id);
    $ok = $stmt->execute();
    if ($ok) {
      return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    else{
      return false;
    }
  }
  
  
  //Get all the projects associated with the current trainer
  public static function getMyProjects($person_id) {
    $db = TrainingDB::getConnection();
    $stmt = $db->prepare("SELECT * FROM `project` WHERE `owner_id` = :person_id");
    $stmt->bindValue(":person_id", $person_id);
    $stmt->execute();
    $project = $stmt->fetchAll();
      return $project;
  }
  

  //Get all the information from the project for a specific class
  public static function getProjectSelect($class_id) {
    $db = TrainingDB::getConnection();
    $stmt = $db->prepare("SELECT * FROM `project` WHERE `class_id` = :class_id");
    $stmt->bindValue(":class_id", $class_id);
    $stmt->execute();
    $project = $stmt->fetchAll();
    $select = '';
    for($i=0; $i<count($project); $i++){
      $select .= '<option value="' .$project[$i]['project_id']. '">' .$project[$i]['title']. '</option>';
    }
    return $select;
  }
  
  //add a new project
  public static function add($person_id, $class_id, $title, $deadline, $subject) {
    $db = TrainingDB::getConnection();
    $sql = "INSERT INTO `project`(`owner_id`, `class_id`, `title`, `deadline`, `subject`) VALUES (:person_id, :class_id, :title, :deadline, :subject)";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(":person_id", $person_id);
    $stmt->bindValue(":class_id", $class_id);
    $stmt->bindValue(":title", $title);
    $stmt->bindValue(":deadline", $deadline);
    $stmt->bindValue(":subject", $subject);
    $ok = $stmt->execute();
    if ($ok) {
      return true;
    }
    else{
      return false;
    }
  }
  

  //Update the Project 
  public static function Update($project_id, $title, $deadline, $subject) {
    $db = TrainingDB::getConnection();
    $stmt = $db->prepare("UPDATE `project` SET `title` = :title , `deadline` = :deadline , `subject` = :subject WHERE `project_id` = :project_id");
    $stmt->bindValue(":title", $title);
    $stmt->bindValue(":deadline", $deadline);
    $stmt->bindValue(":subject", $subject);
    $stmt->bindValue(":project_id", $project_id);
    $ok = $stmt->execute();
    if ($ok) {
      return true;
    }
    else{
      return false;
    }
  }
  

  // Update the team
  public static function UpdateTeam($team_id, $summary) {
    $db = TrainingDB::getConnection();
    $stmt = $db->prepare("UPDATE `team` SET `summary` = :summary WHERE `team_id` = :team_id");
    $stmt->bindValue(":team_id", $team_id);
    $stmt->bindValue(":summary", $summary);
    $ok = $stmt->execute();
    if ($ok) {
      return true;
      
    }
    else{
      return false;
    }
  }
  
  
  // Add a new team
  public static function addTeam($project_id, $owner_id, $summary) {
    $db = TrainingDB::getConnection();
    $sql = "INSERT INTO `team`(`project_id`, `owner_id`, `summary`) VALUES (:project_id, :owner_id, :summary)";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(":project_id", $project_id);
    $stmt->bindValue(":owner_id", $owner_id);
    $stmt->bindValue(":summary", $summary);
    $ok = $stmt->execute();
    $team_id = $db->lastInsertId();
    $_SESSION['team_id'] = $team_id;
    if ($ok) {
      $stmt = $db->prepare("INSERT INTO `team_member`(`team_id`, `student_id`) VALUES (:team_id, :student_id)");
      $stmt->bindValue(":team_id", $team_id);
      $stmt->bindValue(":student_id", $owner_id);
      $stmt->execute();
        
        return true;
    }
    else{
    	
      return false;
    }
  }
  

  //Get all team members from a specific team
  public static function getTeam($team_id) {
    $db = TrainingDB::getConnection();
    $stmt = $db->prepare("SELECT * FROM `team_member` WHERE `team_id` = :team_id");
    $stmt->bindValue(":team_id", $team_id);
    $stmt->execute();
    $team = $stmt->fetchAll();
      return json_encode($team);
  }
  

  //Get all the elements associaed with the team
  public static function getTeamDetails($team_id) {
    $db = TrainingDB::getConnection();
    $stmt = $db->prepare("SELECT * FROM `team` WHERE `team_id` = :team_id");
    $stmt->bindValue(":team_id", $team_id);
    $ok = $stmt->execute();
    if($ok){
      return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    else{
      return false;
    }
  }
  
  // Get all the teams from a specific person
  public static function getMyTeams($person_id) {
    $db = TrainingDB::getConnection();
    $stmt = $db->prepare("SELECT * FROM `team` WHERE `owner_id` = :person_id");
    $stmt->bindValue(":person_id", $person_id);
    $stmt->execute();
    $team = $stmt->fetchAll();
      return $team;
  }
  
  
  //Get all the team from a project
  public static function getTeamByProject($project_id) {
    $db = TrainingDB::getConnection();
    $stmt = $db->prepare("SELECT * FROM `team` WHERE `project_id` = :project_id");
    $stmt->bindValue(":project_id", $project_id);
    $stmt->execute();
    $team = $stmt->fetchAll();
      return $team;
  }
  
  /** Print person's name */
  //Get all the 
  public static function showName($person_id) {
    $db = TrainingDB::getConnection();
    $stmt = $db->prepare("SELECT * FROM `person` WHERE `person_id` = :person_id");
    $stmt->bindValue(":person_id", $person_id);
    $stmt->execute();
    $name = $stmt->fetch(PDO::FETCH_ASSOC);
    print $name['first_name'].' '.$name['last_name'];
  }
  

  //Get the first and last name of the person
  public static function getName($person_id) {
    $db = TrainingDB::getConnection();
    $stmt = $db->prepare("SELECT * FROM `person` WHERE `person_id` = :person_id");
    $stmt->bindValue(":person_id", $person_id);
    $stmt->execute();
    $name = $stmt->fetch(PDO::FETCH_ASSOC);
    $val = $name['first_name'].' '.$name['last_name'];
    return $val;
  }
  

//end class
}

?>