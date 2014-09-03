<?php
include_once 'header.php';
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 * Name: jobApplication.php
 * Function: Form for job application
 * createdby: Neha
 */

?>


<div class="or_options">
    <span class="text_or"><h3>OR</h3></span>
    <button class="showimagecontainer"><h3>Apply with X</h3></button>
</div>
<div class="imagecontainer">
<?php if (!empty($url)): ?>
        <a href="<?php echo $url; ?>">
            <img src="<?php echo base_url(); ?>application/assets/images/fb_login.jpg" />
        </a>
    <?php endif; ?>
<?php if (!empty($lid)):$address = $laddress;
else:$address = !empty($location['name']) ? $location['name'] : ''; ?>
        <a href="<?php echo base_url(); ?>index.php/Loginlinkedin/initiate">

            <img src="<?php echo base_url(); ?>application/assets/images/linkedin.jpg" >
        </a>
<?php endif; ?>
</div>  
<div class="userform">

    <?php
    foreach ($countries as $country):

        $options[''] = 'Select Country';
        $options[$country->country_code] = $country->country_name;

    endforeach;

    $attr = array('id' => 'job_application_form');
    echo form_open('jobapplication/save_userinfo', $attr);
    echo "<p><label for='first_name' class='labelform'>First Name</label>";
    echo form_error('first_name');
    $data = array('name' => 'first_name',
        'id' => 'first_name',
        'maxlength' => 20, 'placeholder' => 'First Name',
        'class' => 'required',
        'value' => (!empty($first_name) ? $first_name : ''));
    echo form_input($data) . "</p>";

    echo "<p><label for='last_name'>Last Name</label>";
    $data = array('name' => 'last_name', 'id' => 'last_name', 'maxlength' => 20, 'placeholder' => 'Last Name', 'class' => 'required', 'value' => (!empty($last_name) ? $last_name : ''));
    echo form_input($data) . "</p>";

    echo "<p><label for='email'>Email</label>";
    $data = array('name' => 'email', 'id' => 'email', 'maxlength' => 50, 'placeholder' => 'Email', 'class' => 'required email', 'value' => (!empty($email) ? $email : ''));
    echo form_input($data) . "</p>";

    echo "<p><label for='address'>Address</label>";

    $data = array('name' => 'address', 'id' => 'address', 'rows' => 10, 'cols' => 20, 'placeholder' => 'Address', 'class' => 'required', 'value' => (!empty($address) ? $address : ''));
    echo form_textarea($data) . "</p>";

    echo "<p><label for='countries'>Countries</label>";
    $data = 'id="countries" class="required"';
    echo form_dropdown('countries', $options, (!empty($selected_country->country_code)) ? $selected_country->country_code : '', $data) . "</p>";
    ;

    echo form_hidden('facebook_id', !empty($id) ? $id : '');
    echo form_hidden('linkedin_id', !empty($lid) ? $lid : '');

    echo '<br />';
    $data = 'class="submitbtn"';
    echo form_submit('save_userinfo', 'Save Info', $data);
    echo form_close();
    ?>
</div>

<?php include_once 'footer.php'; ?>