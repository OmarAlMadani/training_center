<?php
include("header.php");
require_once("models/ProjectModel.php");
require_once("models/ClassModel.php");
?>
<script type="text/javascript">
$(document).ready(function(){
        $("a").removeClass("active");
        $("#li-viewproject").addClass("active");
});

</script>
<h1 class="heading-top">Existing Projects</h1>
<?php
$projects = ProjectModel::getMyProjects($person['person_id']);

print   '
        <div class="content">
            <center>
            <table border="1" class="StyledForm">
                <tr>
                    <th>#</th>
                    <th>Created</th>
                    <th>Title</th>
                    <th>Details</th>
                    <th>Deadline</th>
                    <th>Modify</th>
                </tr>
        ';
                
            for($i=0; $i<count($projects); $i++){
                
                print   '
                        <tr>
                            <td>'.($i+1).'</td>
                            <td>'.$projects[$i]["created_at"].'</td>
                            <td><a href="project.php?pid='.$projects[$i]["project_id"].'">'.$projects[$i]["title"].'</a></td>
                            <td><strong>Subject: </strong>'.$projects[$i]["subject"].'<br/><br/><small><strong>Class: </strong>
                        ';
                            ClassModel::showName($projects[$i]["class_id"]);
                print   '<br/><br/>
                            <td>'.$projects[$i]["deadline"].'</td>
                            <td><a href="ModifyProject.php?pid='.$projects[$i]["project_id"].'">edit</a></td>
                        </tr>
                        ';
            }
            
'
            </table>
            </center>
        </div>';

