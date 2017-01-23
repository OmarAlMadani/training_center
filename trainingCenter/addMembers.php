<?php
include ("header.php");
require_once("models/ProjectModel.php");
require_once("models/ClassModel.php");
require_once("models/PersonModel.php");
require_once("models/TeamModel.php");


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

if(!isset($_SESSION['isLoggedIn'])){
	PersonModel::redirect("login.php");
}

$team_id = $_SESSION['team_id'];
$person_id = $_SESSION['isLoggedIn'];
$class_id = PersonModel::getClass($person_id);
$person = json_decode(PersonModel::get($_SESSION['isLoggedIn']), true);


            try {
              $team = json_decode(ProjectModel::getTeam($team_id), true);
            } catch (PDOException $exc) {
              $msg = $exc->getMessage();
              $code = $exc->getCode();
              print "$msg (error code $code)";
            }
            
            print '<ul id="sortable">';
            
            for($i=0; $i<count($team); $i++){
                $student = json_decode(PersonModel::get($team[$i]["student_id"]), true);
                $sID = $team[$i]["student_id"];
                print "<li id=\"$sID \">
                            <span></span>
                            <img src=\"$student[picture_location]\">
                            <div><h2>$student[first_name] $student[last_name]</h2>$student[email]</div>
                        </li>";
            }
            
            print '</ul>';
        ?>
        <h1 class="main_title">Students List </h1>
        <?php
        
        $team_id = $_SESSION['team_id'];
        $person_id = $_SESSION['isLoggedIn'];
 
            try {
            $class_members = ClassModel::getClassMembers($class_id["class_id"]);
            } catch (PDOException $exc) {
            $msg = $exc->getMessage();
            $code = $exc->getCode();
            print "$msg (error code $code)";
            }
            
            print '<ul id="sortable2">';
            
            for($i=0; $i<count($class_members); $i++){
            $sID = $class_members[$i]['person_id'];
            $student = json_decode(PersonModel::get($sID), true);
            
            if(!PersonModel::IsInTeam($sID, $team_id)){
        print "<li id=\"$sID \">
                <span></span>
                <div><h2>'$student[first_name] $student[last_name]</h2>$student[person_id]</div>
            </li>";
            }
            }
            
            print '</ul>';
            
            function display_form() {

            	global $messages;

            	$person_id = ($_SERVER["REQUEST_METHOD"] == "GET") ? "" : $_POST["person_id"];
            	if (!array_key_exists("person_id", $messages)) {
            		$messages["person_id"] = "";
            	}
            	else {
            		$messages["person_id"] = "<span style='color: red;'>$messages[person_id]</span>";
            	}

            	print <<<END_FORM
  
  <form method="POST" class="StyledForm">
    <table>
      <tr>
        <th>Enter Person ID:</th>
        <td><input type="person_id" name="person_id" value="$person_id"/></td>
        <td>$messages[person_id]</td>
      </tr>
            
    </table>
            
    <br/><br/>
    <button type="submit">add</button>
    <button type="reset">Reset</button>
  </form>
  </center>
END_FORM;
            
            }
         
            
            function do_post() {
            	global $messages;
            	$person_id = (empty($_POST["person_id"])) ? "" : (trim($_POST["person_id"]));
            	$team_id = $_SESSION['team_id'];

            	if ($person_id== "") {
            		$messages["person_id"] = "Enter person id";
            		display_form();
            	}
            	
            	else {
            		try {
            			$addperson = TeamModel::addMember($person_id, $team_id);
            			if(!$addperson){
            				echo 'sucss';
            				PersonModel::redirect("addMembers.php");
            			}
            			else{
            				
            				$messages["person_id"] = "Invalid id!";
            				display_form();
            			}
            
            		} catch (PDOException $exc) {
            			$msg = $exc->getMessage();
            			$code = $exc->getCode();
            			print "$msg (error code $code)";
            		}
            
            	}
            	//end post
            }
		?>