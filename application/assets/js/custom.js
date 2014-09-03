/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function() {
    $.validator.messages.required = 'required';
    $.validator.messages.email = 'invalid email';
    $("#job_application_form").validate();


    $(".showimagecontainer").click(function() {
        $(".imagecontainer").show(1000);
    });

});
