<?php

require_once("models/ClassModel.php");
require_once("models/ProjectModel.php");
require_once("models/PersonModel.php");
include ("header.php");


?>
<script type="text/javascript">
$(document).ready(function(){
        $("a").removeClass("active");
});

</script>
<h1 class="heading-top">Project Details</h1>
<div class="content">
<?php

  $project_id = $_GET['pid'];
  $project_details = ProjectModel::get($project_id);
 
  $class = ClassModel::getClassId($project_details['class_id']);
  $owner_details = json_decode(PersonModel::get($project_details['owner_id']), true);
  $owner_name = $owner_details['first_name'].' '.$owner_details['last_name'];
  $class_id = $project_details['class_id'];
  $title = $project_details['title'];
  $subject = $project_details['subject'];
  $class_name = $class['name'];
  $tomorrow = date("Y-m-d", strtotime("+1 days"));
  $deadline = substr($project_details['deadline'], 0, 10);
  $project_teams = ProjectModel::getTeamByProject($project_id);
  $teams = '';
  $class_members1 = ClassModel::getClassMembers($project_details["class_id"]);
  $members1 = '';
  for($i=0; $i<count($project_teams); $i++){
        $teams .= '* <a href="team.php?tid=' .$project_teams[$i]['team_id']. '"> Team #' .$project_teams[$i]['team_id']. '</a>
              <br/><small>(' .$project_teams[$i]['summary']. ')</small><br/><br/>';
              
        for($j=0; $j<count($class_members1); $j++){
                if(!PersonModel::IsInTeam($class_members1[$j]['person_id'], $project_teams[$i]['team_id'])){
                        $members1 .= '* <a href="profile.php?pid=' .$class_members1[$j]['person_id']. '">' .ProjectModel::getName($class_members1[$j]['person_id']). '</a><br/>';
                }
        }
  }
  
  
  
  print <<<END_FORM
  <center>
   <table class="StyledForm" style="text-align: left;">
      <tr>
        <th><small>Project Title</small></th>
        <td><h1>$title</h1></td>
      </tr>
      <tr>
        <th><small>Subject</small></th>
        <td><h3>$subject</h3></td>
      </tr>
      <tr>
        <th><small>Owner</small></th>
        <td><small>$owner_name</small></td>
      </tr>
      <tr>
        <th><small>Class</small></th>
        <td><small>$class_name</small></td>
      </tr>
      <tr>
        <th><small>Deadline</small></th>
        <td><small>$deadline</small></td>
      </tr>
      <tr>
        <th><small>Team(s)</small></th>
        <td>$teams</td>
      </tr>
      <tr>
        <th><small>Class Members (Not in team)</small></th>
        <td>$members1</td>
      </tr>
    </table>
  </center>
END_FORM;
?>
</div>

