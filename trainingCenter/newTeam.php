<?php
include("header.php");
?>

<script type="text/javascript">
$(document).ready(function(){
        $("a").removeClass("active");
        $("#li-addteam").addClass("active");
});
</script>
<h1 class="heading-top">New Team</h1>
<div class="content">
  
<?php
require_once("models/ProjectModel.php");

$messages = array();
switch ($_SERVER["REQUEST_METHOD"]) {
  case "GET":
    display_form();
    break;
  case "POST":
    do_post();
    break;
  default:
    die("Not implemented");
}

function display_form() {
  global $messages;
  $project_id = ($_SERVER["REQUEST_METHOD"] == "GET") ? "" : $_POST["project_id"];
  if (!array_key_exists("project_id", $messages)) {
    $messages["project_id"] = "";
  }
  else {
    $messages["project_id"] = "<span style='color: red;'>$messages[project_id]</span>";
  }
  
  $summary = ($_SERVER["REQUEST_METHOD"] == "GET") ? "" : $_POST["summary"];
  if (!array_key_exists("summary", $messages)) {
    $messages["summary"] = "";
  }
  else {
    $messages["summary"] = "<span style='color: red;'>$messages[summary]</span>";
  }
  
  $owner_id = $_SESSION['isLoggedIn'];
  $class_id = PersonModel::getClass($owner_id);
  $projects = ProjectModel::getProjectSelect($class_id['class_id']);
  $tomorrow = date("Y-m-d", strtotime("+1 days"));
  
  print <<<END_FORM
  <center>
  <form method="POST" class="StyledForm">
  <table>
      <tr>
        <th>Owner Id:</th>
        <td><input type="text" name="owner_id" value="$owner_id" readonly /></td>
        <td></td>
      </tr>
      <tr>
        <th>Select Project:*</th>
        <td><select name="project_id">$projects</select>$messages[project_id]</td>
        <td></td>
      </tr>
      <tr>
        <th>Summary:*</th>
        <td><textarea rows="3" name="summary" value="$summary" cols="50" placeholder="Enter team summary here..."></textarea></td>
        <td>$messages[summary]</td>
      </tr>
    </table>
    <button type="submit">Save & Add Members</button>
    <button type="reset">Reset</button>
  </form>
  </center>
END_FORM;
}

function do_post() {
  global $messages;
  $project_id = (empty($_POST["project_id"])) ? "" : (trim($_POST["project_id"]));
  $summary = (empty($_POST["summary"])) ? "" : (trim($_POST["summary"]));
  $owner_id = (empty($_POST["owner_id"])) ? "" : (trim($_POST["owner_id"]));
  
  if ($project_id == "") {
    $messages["project_id"] = "Select a project";
    display_form();
  }
  else if ($summary == "") {
    $messages["summary"] = "Enter team summary";
    display_form();
  }
  else if (strlen($summary) < 10) {
    $messages["summary"] = "Summary too short";
    display_form();
  }
  else if ($owner_id == "") {
    header("location:logout.php");
  }
  else {
        
        try {
        $add = ProjectModel::addTeam($project_id, $owner_id, $summary);
        if($add){
          //print "Team added successfully!";
          PersonModel::redirect("addMembers.php");
        }
        else{
          print "Temporary error, try again later!<br><br>";
        }
          
        } catch (PDOException $exc) {
          /* Each time we access a DB, an exception may occur */
          $msg = $exc->getMessage();
          $code = $exc->getCode();
          print "$msg (error code $code)";
        }
    
  }
}

?>

</div>
