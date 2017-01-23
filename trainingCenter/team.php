<?php
include("header.php");

require_once("models/ProjectModel.php");

?>
<script type="text/javascript">
$(document).ready(function(){
        $("a").removeClass("active");
});
document.title = "Team Details | EpiTrainer";
</script>
<h1 class="heading-top">Team Details</h1>
<div class="content">
  
<?php

  $team_id = $_GET['tid'];
  global $team_details;
  $team_details = ProjectModel::getTeamDetails($team_id);
  if(!$team_details){
    echo '<script type="text/javascript">alert("Invalid team link!"); </script>';
          PersonModel::redirect("index.php");
  }
  
  $owner_id = $team_details['owner_id'];
  $owner_details = json_decode(PersonModel::get($team_details['owner_id']), true);
  $owner_name = $owner_details['first_name'].' '.$owner_details['last_name'];
  $project_id = $team_details["project_id"];
  $project_details = ProjectModel::get($project_id);
  $project_name = $project_details["title"];
  $summary = $team_details["summary"];
  $members = json_decode(ProjectModel::getTeam($team_id), true);
  $member_names = '';
  for($i=0; $i<count($members); $i++){
        $member_names .= '* <a href="profile.php?pid='.$members[$i]['student_id'].'">'. ProjectModel::getName($members[$i]['student_id']) .'</a><br/>';
  }
  
  print <<<END_FORM
  <center>
  <table class="StyledForm" style="text-align: left;">
      <tr>
        <th><small>Team Name</small></th>
        <td><h1>Team #$team_id</h1></td>
      </tr>
      <tr>
        <th><small>Project</small></th>
        <td>$project_name</td>
      </tr>
      <tr>
        <th><small>Owner</small></th>
        <td><small><a href="profile.php?pid=$owner_id">$owner_name</a><small></td>
      </tr>
      <tr>
        <th><small>Summary</small></th>
        <td><small>$summary</small></td>
      </tr>
      <tr>
        <th><small>Members</small></th>
        <td><small>$member_names</small></td>
      </tr>
    </table>
  </center>
END_FORM;

?>

</div>

