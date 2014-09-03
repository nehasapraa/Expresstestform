<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include_once 'header.php';
?>
<div class="savedinfo">
    <span class="successmsg"><?php echo $success_msg; ?></span>

    <p><label>First Name :</label><span class="userentry"><?php echo $first_name; ?></span></p>
    <p><label>Last Name :</label><span class="userentry"><?php echo $last_name; ?></span></p>
    <p> <label>Email :</label><span class="userentry"><?php echo $email; ?></span></p>
    <p><label>Address :</label><span class="userentry"><?php echo $address; ?></span></p>
    <p><label>Country :</label><span class="userentry"><?php echo $country; ?></span></p>
</div>   




<?php include_once 'footer.php'; ?>