<?php
include("header.php");
require_once("models/ProjectModel.php");
?>

<script type="text/javascript">
$(document).ready(function(){
        $("a").removeClass("active");
        $("#li-viewteam").addClass("active");
});
</script>
<h1 class="heading-top">Existing Teams</h1>

<?php
$teams = ProjectModel::getMyTeams($person['person_id']);

print   '
        <div class="content">
            <center>
            <table border="1" class="StyledForm">
                <tr>
                    <th>#</th>
                    <th>Team</th>
                    <th>Details</th>
                    <th>Members</th>
                    <th style="min-width:60px;">Edit</th>
                </tr>
        ';
                
            for($i=0; $i<count($teams); $i++){
                
                $project = ProjectModel::get($teams[$i]['project_id']);
                $members = json_decode(ProjectModel::getTeam($teams[$i]['team_id']), true);
                
                print   '
                        <tr>
                            <td>'.($i+1).'</td>
                            <td><strong><a href="team.php?tid='.$teams[$i]["team_id"].'">Team # '.$teams[$i]["team_id"].' </a></strong><br/><br/><small><i>(Created: '.$teams[$i]["created_at"].')</i></small></td>
                            <td>
                                <strong>Project: </strong><a href="project.php?pid='.$teams[$i]['project_id'].'">'.$project["title"].'</a>
                                <br/><br/>
                                <strong><small>Summary: </strong>'.$teams[$i]['summary'].'
                                <br/><br/>
                            <td>
                        ';
                        
                        for($j=0; $j<count($members); $j++){
                            print '* ';
                            ProjectModel::showName($members[$j]['student_id']);
                            print '</br>';
                        }
                
                print   '
                            </td>
                            <td><a style="float:left;margin-right:15px;" href="ModifyTeam.php?tid='.$teams[$i]['team_id'].'">edit team</a>
                        <a style="float:left;" href="ModifyMembers.php?tid='.$teams[$i]['team_id'].'">edit member</a></td>
                        </tr>
                        ';
            }
            
print '
            </table>
            </center>
        </div>';
?>
