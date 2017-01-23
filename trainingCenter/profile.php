<?php
include("header.php");
?>
<script type="text/javascript">
$(document).ready(function(){
        $("a").removeClass("active");
});

</script>
<h1 class="heading-top">User Details</h1>
<div class="content">
<?php

  $person_id = $_GET['pid'];
  $person_details = json_decode(PersonModel::get($person_id), true);
  if(!$person_details){
    echo '<script type="text/javascript">alert("Invalid profile link!"); </script>';
          PersonModel::redirect("home.php");
  }
  $first_name = $person_details["first_name"];
  $last_name = ucwords($person_details["last_name"]);
  $address = $person_details["address"];
  $zip = $person_details["zip_code"];
  $town = $person_details["town"];
  $email = $person_details["email"];
  $mobile = $person_details["mobile_phone"];
  $phone = $person_details["phone"];
  $created = $person_details["created_at"];
  
  print <<<END_FORM
  <center>
   <table class="StyledForm" style="text-align: left;">
      <tr>
        <th><small>Name</small></th>
        <td><h1>$first_name $last_name</h1></td>
      </tr>
      <tr>
        <th><small>Email</small></th>
        <td>$email</td>
      </tr>
      <tr>
        <th><small>Address</small></th>
        <td><small>$address</small></td>
      </tr>
      <tr>
        <th><small>Zip Code</small></th>
        <td><small>$zip</small></td>
      </tr>
      <tr>
        <th><small>City</small></th>
        <td><small>$town</small></td>
      </tr>
      <tr>
        <th><small>Mobile No.</small></th>
        <td><small>$mobile</small></td>
      </tr>
      <tr>
        <th><small>Telephone</small></th>
        <td><small>$phone</small></td>
      </tr>
      <tr>
        <th><small>Registered</small></th>
        <td><small>$created</small></td>
      </tr>
    </table>
  </center>
END_FORM;
?>
</div>
