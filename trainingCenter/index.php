<?php
require_once "/models/PersonModel.php";
?>


 
<h1 class="heading-top">Login</h1>
<div class="content">

<?php
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
  $email = ($_SERVER["REQUEST_METHOD"] == "GET") ? "" : $_POST["email"];
  if (!array_key_exists("email", $messages)) {
    $messages["email"] = "";
  }
  else {
    $messages["email"] = "<span style='color: red;'>$messages[email]</span>";
  }
  $pass = ($_SERVER["REQUEST_METHOD"] == "GET") ? "" : $_POST["pass"];
  if (!array_key_exists("pass", $messages)) {
    $messages["pass"] = "";
  }
  else {
    $messages["pass"] = "<span style='color: red;'>$messages[pass]</span>";
  }
  if (!array_key_exists("main", $messages)) {
    $messages["main"] = "";
  }
  else {
    $messages["main"] = "<span style='color: red;'>$messages[main]</span>";
  }

  print <<<END_FORM
  <center>$messages[main]<br><br>
  <form method="POST" class="StyledForm">
    <table>
      <tr>
        <th>Enter Email Id:</th>
        <td><input type="email" name="email" value="$email"/></td>
        <td>$messages[email]</td>
      </tr>
      <tr>
        <th>Enter Password:</th>
        <td><input type="password" name="pass" value="$pass"/></td>
        <td>$messages[pass]</td>
      </tr>
    </table>
    <br/><br/>
    <button type="submit">Login</button>
    <button type="reset">Reset</button>
  </form>
  </center>
END_FORM;
}

function do_post() {
  global $messages;
  $email = (empty($_POST["email"])) ? "" : (trim($_POST["email"]));
  $pass = (empty($_POST["pass"])) ? "" : (trim($_POST["pass"]));
  if ($email== "") {
    $messages["email"] = "Enter Email Id";
    display_form();
  }
  else if ($pass == "") {
    $messages["pass"] = "Enter Password";
    display_form();
  }
  else {
        try {
          $login = PersonModel::getByLoginPassword($email,$pass);
          if($login != null){
          	session_start();
            $_SESSION['isLoggedIn'] = ($login['person_id']);
            
            PersonModel::redirect("welcome.php");
          }
          else{
            $messages["main"] = "Invalid email address or password!";
            display_form();
          }
          
        } catch (PDOException $exc) {
          $msg = $exc->getMessage();
          $code = $exc->getCode();
          print "$msg (error code $code)";
        }
    
  }
}

?>
</div>

