<?php
session_start();    
require_once('models/PersonModel.php');
if(isset($_SESSION['isLoggedIn'])){                                                        
	$person = json_decode(PersonModel::get($_SESSION['isLoggedIn']), true); 
	?>
    <!DOCTYPE html>
    <html>
    <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" href="css/style.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    </head>
    <body>
    <div class="container">
    <div class="header">
        
        <div class="main_title_header">
            <ul>
                <li><a id="li-home" class="active" href="home.php">Home</a></li>
                    
                    <!-----------------------------------------------------
                    //SHOW MENUS FOR TRAINER OR STUDENT ACCORDINGLY
                    //----------------------------------------------------->
                    <?php if($person['is_trainer']=='1'){ ?>
                        <li><a id="li-addproject" href="newProject.php">Create a new Project</a></li>
                        <li><a id="li-viewproject" href="viewProject.php">My Projects</a></li>
                    <?php } else { ?>
                        <li><a id="li-Newteam" href="newTeam.php">New Team</a></li>
                        <li><a id="li-viewteam" href="viewTeam.php">Existing Teams</a></li>
                    <?php } ?>
                    
                <li class="dropdown" style="float:right;">
                    <a href="#" class="dropbtn">Hi, <?=$person['first_name']?>!</a>
                    <div class="dropdown-content">
                    <a href="profile.php?pid=<?=$_SESSION['isLoggedIn']?>">My Profile</a>
                    <a href="logout.php">Logout</a>
                    </div>
                </li>
            </ul>
        </div>
    </div>
<?php    
}
else{
	
    if((basename($_SERVER['PHP_SELF']) == 'index.php') || (basename($_SERVER['PHP_SELF']) == 'userInfo.php') || (basename($_SERVER['PHP_SELF']) == 'project.php') || (basename($_SERVER['PHP_SELF']) == 'team.php')){
        
    }
    else{
        //PersonModel::redirect("index.php");     
    }
?>
    <!DOCTYPE html>
    <html>
    <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <link rel="stylesheet" href="css/style.css" />
    </head>
    <body>
    <div class="container">
    <div class="header">
       
        <div class="main_title_header">
            <ul>
                <li><a class="active" href="index.php">Home</a></li>
                <li style="float:right;background:brown;"><a href="login.php">Login</a></li>
            </ul>
        </div>
    </div>
<?php    
}

?>
