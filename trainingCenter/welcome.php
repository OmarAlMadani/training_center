<?php
include("header.php");
?>

<div class="content">
    
    <?php
    if(isset($_SESSION['isLoggedIn'])){
        print "<h2>Welcome back,</h3>
                <h1>".$person['first_name']."!</h1>";
    
    }
    ?>
    
    
</div>
