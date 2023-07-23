jQuery(document).ready(function () {
    jQuery('#all_add').hide();

    //login modal mobile number field
    jQuery(document).on('click', '.btn-login', function () {
        var mobileNumber = jQuery('#mobileNumber').val();
      

        console.log(mobileNumber);
        //alert(mobileNumber);
        if (mobileNumber.trim() == "") {
            jQuery('.mobile_errormsg').html('Please enter mobile number...');
        }
        else if (mobileNumber.length != 10){
            jQuery('.mobile_errormsg').html('Please enter valid contact number');
            return false;

        }
        else{
            jQuery(".login-details.active").removeClass("active");
            jQuery(".varification").addClass("active");
        }
        jQuery.ajax({
            type: 'POST',
            cache: false,
	        dataType : 'json',
            url: templateUrl.ajaxurl,
            data: {
                'action': 'tingl_send_login_otp',
                'mobileNumber': mobileNumber,
            },
            success: function (data) {
                console.log(data);
                if (data.type == "success") {
                    jQuery('.errormsg').html(data);
                  //  console.log(data);
                }else{
                  //  alert(data);
                }
            }
        });
    });


    //login modal otp field
    jQuery(document).on('click', '.btn-login1', function () {
        var mobileNumber = jQuery('#mobileNumber').val();
        var otpDiv = document.querySelector(".otp");
        var inputFields = otpDiv.getElementsByTagName("input");
        
        var otp = [];
        for (let i = 0; i < inputFields.length; i++) {
            otp.push(inputFields[i].value);
        }

        var login_otp = otp.join("");
        console.log(mobileNumber);
        console.log(login_otp);

        var otp_regex = new RegExp("^[0-9]+$");



        if( login_otp.trim() === '' ){
            jQuery('.otp_errormsg').html('Please enter your Otp');
            return false;

        }
        else if(!otp_regex.test(login_otp)){
            jQuery('.otp_errormsg').html('Character Not Allow In OTP');
            return false;
        }
        else if(login_otp.length != 4){
            jQuery('.otp_errormsg').html('Please Enter Valid OTP');
            return false;

        }
      

        jQuery.ajax({
            method: 'POST',
            url: templateUrl.ajaxurl,
            data: {
                'action': 'tingl_verify_login_otp',
                'otp': otp,
                'mobileNumber': mobileNumber

            },
            success: function (data) {
                if(data)
                {
                    if (data.type == "success") {
                        console.log(data);
                    }
                    else
                    {
                        if (data.alert)
                        {
                            jQuery(".otp_errormsg").html(data.alert);
                            jQuery(".varification").addClass("active");
                            jQuery(".name-pro").removeClass("active");
                        }
                        else if(data.login_status == 1 )
                        {
                            window.location.reload(true);
                            jQuery('#loginModal').modal('hide');
                        }
                        else
                        {
                            jQuery(".varification").removeClass("active");
                            jQuery(".name-pro").addClass("active");
                        }
                    }
                }
            }
        });
    });

 
    var formData = {}; // Object to store form data
    //login modal first name && last name field
    jQuery(document).on('click', '.btn-login2', function () {
        formData.step = 1;
        formData. mobileNumber = jQuery('#mobileNumber').val();
        formData.firstName = jQuery('#firstName').val();
        formData.lastName = jQuery('#lastName').val();
        console.log(formData.firstName);
        console.log(formData.lastName);
        console.log(formData.mobileNumber);


        var name_regex = /^[A-Za-z]+$/;

        if (formData.firstName.trim() === '') {
            jQuery('.name_errormsg').html('Please enter your First name');
            return false;
        }
        else if(!name_regex.test(formData.firstName)){
            jQuery('.name_errormsg').html('First Name is not valid');
            return false;
        }
        else if(formData.firstName.length == 1){

            jQuery('.name_errormsg').html(' first name must be 2 characters required');
            return false;
        }
        else if (formData.lastName.trim() === '') {
            jQuery('.name_errormsg').html('Please enter your Last name');
            return false;
        }
        else if(!name_regex.test(formData.lastName)){
            jQuery('.name_errormsg').html('Last Name is not valid');
            return false;
        }
        else if(formData.lastName.length == 1){
            jQuery('.name_errormsg').html('last name must be 2 characters required');
            return false;
        }
        else{
            jQuery(".name-pro").removeClass("active");
            jQuery(".gender-selection").addClass("active");
            processFormData(formData);
        }  
    });


    //login modal gender field
    jQuery(document).on('click', '.btn-login3', function () {
        formData.step = 2;
        formData.gender = jQuery('input[name="gender"]:checked').val();
        var genderSelect = jQuery("#gender");
        selectedOption = genderSelect.find("option:selected");
        formData.gender = selectedOption.val();
        console.log( formData.gender);


        if(formData.gender === 'select'){
            jQuery('.gender_errormsg').html('Please select your gender.');
            return false;
        }
        else
        {
            jQuery(".gender-selection").removeClass("active");
            jQuery(".birth-date").addClass("active");
            processFormData(formData);
        }
    });
    

    // login modal age field
    jQuery(document).on('click', '.btn-login4', function () {
        formData.step = 3;
        formData.age = jQuery('#age').val();
        var age_regex = new RegExp("^[0-9]+$");
        console.log( formData.age);
        processFormData(formData);

        if (formData.age.trim() === '') {
            jQuery('.age_erromsg').html('Please enter your Age');
        }
        else if(!age_regex.test(formData.age)){
            jQuery('.age_erromsg').html('Character Not Allow In age');
            return false;
        }
        else{
            jQuery(".birth-date").removeClass("active");
            jQuery(".pin-code").addClass("active");
            processFormData(formData);
        }
    });
    

    //login modal pincode field
    jQuery(document).on('click', '.btn-login5', function () {
        formData.step = 4;
        formData.pincode = jQuery('#pincode').val();
        console.log( formData.pincode);
        var pin_regex = new RegExp("^[0-9]+$");

        if (formData.pincode  == '')
        {
            // jQuery(".pin-code").addClass("active");
            jQuery('.pin_errormsg').html('Please Enter Zipcode.');
        }
        else if ( !pin_regex.test(formData.pincode) )
        {
            // jQuery(".pin-code").addClass("active");
            jQuery('.pin_errormsg').html('zipcode should be numbers only');
        }
        else if (formData.pincode .length != 6 )
        {
            // jQuery(".pin-code").addClass("active");
            jQuery('.pin_errormsg').html('zipcode should only be 6 digits');
        }
       
        else{
            
            jQuery('#loginModal').modal('hide');
            processFormData(formData);
            //window.location.reload(true);
        }
        
    });
    
    function processFormData(formData) {
        jQuery.ajax({
            url: templateUrl.ajaxurl,
            type: 'POST',
            cache: false,
            dataType: 'json',
            data: {
                action: 'tingl_complete_profile_callback',
                formData: formData
            },
            success: function(response) {
                console.log(response);
                // Handle the response from the PHP script
            }
        });
    }

    //otp  field accept one value 
    jQuery('.otp input').on('input', function(e) {
        var input = jQuery(this).val();
        if (input.length > 1) {
            jQuery(this).val(input.slice(0, 1)); // Truncate the input to one character
        } else if (input.length === 1) {
            jQuery(this).next('.opt_1').focus(); // Move focus to the next input field
        } else if (input.length === 0) {
            if (e.inputType === 'deleteContentBackward') {
                jQuery(this).prev('.opt_1').focus(); // Move focus to the previous input field
            }
        }
    });
    

    jQuery('.otp input').on('keydown', function(e) {
        if (e.keyCode === 8 && this.value.length === 0) {
            jQuery(this).prev('.opt_1').focus(); // Move focus to the previous input field
        }
    });
    

    //show product base on category select on dropdown
    jQuery(document).on('change', '#form_select', function(){

        var cat_slug=jQuery(this).val();
        var cat_name=(jQuery(this).find("option:selected").text());
        jQuery('#my_cat').text(cat_name); 
        jQuery.ajax({
            type: "post",
            url: templateUrl.ajaxurl,
            dataType: 'text',
            data: {
                action:'tingl_show_productby_category_callback',
                cat_slug: cat_slug
            },
            success: function(response){
            console.log(response);
            jQuery('#cayegory_list').html(response); 
            
            }
        });
    
    });


    //subscribe page email field validation
    jQuery(document).on('focusout', '#email', function(){
        var email=jQuery(this).val();
        var email_regex =  new RegExp('[a-z0-9]+@[a-z]+\.[a-z]{2,3}');

        if (email == '') {
            jQuery('#email_error').text('enter your email');
        } 
        else if (!email_regex.test(email)) {
            jQuery('#email_error').text('enter valid emial');
        }
        else {
            jQuery('#email_error').text('');
        }
    });


    //subscribe page pincode field validation
    jQuery(document).on('focusout', '#pincode', function(){
        var pincode=jQuery(this).val();
        
        if (pincode == '') {
            jQuery('#pincode_error').text('enter your pincode');
        } 
        else if (pincode.length != 6) {
            jQuery('#pincode_error').text('enter valid pincode');
        }
        else {
            jQuery('#pincode_error').text('');
        }
    });


    //subscribe page weight field validation
    jQuery(document).on('focusout', '#weight', function(){
        var weight=jQuery(this).val();
        
        if (weight == '') {
            jQuery('#weight_error').text('please enter weight');
        } 
        else {
            jQuery('#weight_error').text('');
        }
    });


    //subscribe page age field validation
    jQuery(document).on('focusout', '#age', function(){
        var age=jQuery(this).val();
        
        if (age == '') {
            jQuery('#age_error').text('please enter age');
        } 
        else {
            jQuery('#age_error').text('');
        }
    });


    //subscribe page height field validation
    jQuery(document).on('focusout', '#height', function(){
        var height = jQuery(this).val();
        
        if (height == '') {
            jQuery('#height_error').text('please select height');
        } 
        else {
            jQuery('#height_error').text('');
        }
    });


    var current_fs, next_fs, previous_fs; //fieldsets
    var opacity;
    var current = 1;
    var steps = jQuery("fieldset").length;
    setProgressBar(current);
    //subdcribe page next page
    jQuery(document).on('click', '.next', function(){
        current_fs = jQuery(this).parent();
        next_fs = jQuery(this).parent().next();

      
        var email          = jQuery('#email').val();
        var pincode        = jQuery('#pincode').val();
        var weight         = jQuery('#weight').val();
        var age            = jQuery('#age').val();
        var height         = jQuery('#height').val();

    
        var email_regex =  new RegExp('[a-z0-9]+@[a-z]+\.[a-z]{2,3}');
        var validate=1;

        if(email == '' && pincode == '' && weight == '' && age == '' && height == ''){
            jQuery('#email_error').html('enter your email');
            jQuery('#pincode_error').html('enter your pincode');
            jQuery('#weight_error').html('please enter weight');
            jQuery('#age_error').html('please enter age');
            jQuery('#height_error').html('please select height');
            validate=0;
        }
        if( email == ''){
            jQuery('#email_error').html('enter your email');
            validate=0;
        }
        if( email != '' && !email_regex.test(email)){
            jQuery('#email_error').html('enter valid emial');
            validate=0;
        }
        if( pincode == ''){
            jQuery('#pincode_error').html('enter your pincode');
            validate=0;
        }
        if( pincode !='' && pincode.length != 6){
            jQuery('#pincode_error').html('enter valid pincode');
            validate=0;
        }
        if( weight == ''){
            jQuery('#weight_error').html('please enter weight');
            validate=0;
        }
        if( age == ''){
            jQuery('#age_error').html('please enter age');
            validate=0;
        }
        if( height == ''){
            jQuery('#height_error').html('please select height');
            validate=0;
        }
        if (validate == 1){
        jQuery("#progressbar li").eq(jQuery("fieldset").index(next_fs)).addClass("active");
        next_fs.show();
        current_fs.animate({
            opacity: 0
        }, {
            step: function(now) {
                // for making fielset appear animation
                opacity = 1 - now;
                current_fs.css({
                    'display': 'none',
                    'position': 'relative'
                });
                next_fs.css({
                    'opacity': opacity
                });
            },
            duration: 500
        });
        setProgressBar(++current);
        }
    });


    //subscribe page previous page
    jQuery(document).on('click', '.previous', function(){
        current_fs  = jQuery(this).parent();
        previous_fs = jQuery(this).parent().prev();
        //Remove class active
        jQuery("#progressbar li").eq(jQuery("fieldset").index(current_fs)).removeClass("active");
        
        //show the previous fieldset
        previous_fs.show();
        current_fs.animate({
            opacity: 0
        }, {
            step: function(now) {
                // for making fielset appear animation
                opacity = 1 - now;
                current_fs.css({
                    'display': 'none',
                    'position': 'relative'
                });
                previous_fs.css({
                    'opacity': opacity
                });
            },
            duration: 500
        });
        setProgressBar(--current);
    });


    //subscribe page progressbar 
    function setProgressBar(curStep) {
        var percent = parseFloat(100 / steps) * curStep;
        percent = percent.toFixed();
        jQuery(".progress-bar")
            .css("width", percent + "%")
    }


    //goal select
    jQuery(document).on('change', '#goal_select', function(){
        var goal=jQuery(this).val();
        jQuery('#goal_final').html('<strong>goal</strong>'+'-'+goal ); 
    });


    //preference select
    jQuery(document).on('change', '#preference_select', function(){
        var preference=jQuery(this).val();
        jQuery('#preference_final').html('<strong>Preference</strong>'+'-'+preference );  
    });


    //day select
    jQuery(document).on('focusout', '#meal_plan_day', function(){
        var meal_day=jQuery(this).val();
        jQuery('#day_final').html('<strong>Days</strong>'+'-'+meal_day ); 
    });


    //subscribe page pincode accept only 6 digits
    jQuery('#pincode').on('input', function() {
        if (jQuery(this).val().length > 6) {
            jQuery(this).val(jQuery(this).val().slice(0, 6)); 
        }
    });


    //subscribe page weight field accept 3 digits
    jQuery('#weight').on('input', function() {
        if (jQuery(this).val().length > 3) {
            jQuery(this).val(jQuery(this).val().slice(0, 3)); 
        }
    });


    //subscribe page age field accept only 2 digits
    jQuery('#age').on('input', function() {
        if (jQuery(this).val().length > 2) {
            jQuery(this).val(jQuery(this).val().slice(0, 2));
        }
    });


    //login modal mobile number accept only 10 digits
    jQuery('#mobileNumber').on('input', function() {
        if (jQuery(this).val().length > 10) {
            jQuery(this).val(jQuery(this).val().slice(0, 10)); 
        }
    });


    //login modal age  accept only 2 digits
    jQuery('.login_age').on('input', function() {
        if (jQuery(this).val().length > 2) {
            jQuery(this).val(jQuery(this).val().slice(0, 2)); 
        }
    });


    //login modal pincode  accept only 6 digits
    jQuery('.login_pincode').on('input', function() {
        if (jQuery(this).val().length > 6) {
            jQuery(this).val(jQuery(this).val().slice(0, 6)); 
        }
    });


    //login modal first name And Last name accept max 30 characters
    jQuery('#firstName , #lastName').on('input', function() {
        if (jQuery(this).val().length > 30) {
            jQuery(this).val(jQuery(this).val().slice(0, 30)); 
        }
    });


    //subscribe page field not start with ZERO 
    jQuery('#age,#weight,#pincode').on('keydown', function(event) {
        // Check if the entered value starts with zero
        if (event.key === '0' && this.value.length === 0) {
          event.preventDefault();
        }
    });


    jQuery('#mobileNumber').on('keydown', function(event) {
        // Check if the entered value starts with zero
        if (event.key === '0' && this.value.length === 0) {
          event.preventDefault();
        }
    });

    
    jQuery('#meal_plan_day').on('keydown', function(event) {
        // Check if the entered value starts with zero
        if (event.key === '0' && this.value.length === 0) {
          event.preventDefault();
        }
    });


    jQuery('#meal_plan_day').on('input', function() {
        var value = jQuery(this).val();
        if (parseFloat(value) < 0) {
          jQuery(this).val('');
        }
    });


    jQuery(document).on('click', '.day-trial a', function () {
        var meal_selcted_day = jQuery(this).text().split(" ");
        jQuery('#meal_day').val(meal_selcted_day[0]); 
        jQuery('#meal_days').html(meal_selcted_day[0] +' '+'days' ); 
        jQuery('#meal_plan_day').val(meal_selcted_day[0]); 
        jQuery('#day_final').html('<strong>Days</strong>'+'-'+ meal_selcted_day[0]); 
    });


    jQuery(document).on('focusout', '#meal_day', function(){
        var meal_day=jQuery(this).val();
        jQuery('#meal_days').html(meal_day +' '+'days' ); 
    
    });

    
    jQuery('#myCheckbox_breakfast').on('change', function() {
        if (jQuery(this).is(':checked')) {
          // Show the label if checkbox is checked
          jQuery('#type_meal_breakfast').show();
          jQuery('#meal_breakfast').show();
        } else {
          // Hide the label if checkbox is unchecked
          jQuery('#type_meal_breakfast').hide();
          jQuery('#meal_breakfast').hide();
        }
    });


    jQuery('#myCheckbox_lunch').on('change', function() {
        if (jQuery(this).is(':checked')) {
          // Show the label if checkbox is checked
          jQuery('#type_meal_lunch').show();
          jQuery('#meal_lunch').show();
        } else {
          // Hide the label if checkbox is unchecked
          jQuery('#type_meal_lunch').hide();
          jQuery('#meal_lunch').hide();
        }
    });


    jQuery('#myCheckbox_snacks').on('change', function() {
        if (jQuery(this).is(':checked')) {
          // Show the label if checkbox is checked
          jQuery('#type_meal_snacks').show();
          jQuery('#meal_snacks').show();
        } else {
          // Hide the label if checkbox is unchecked
          jQuery('#type_meal_snacks').hide();
          jQuery('#meal_snacks').hide();
        }
    });


    jQuery('#myCheckbox_dinner').on('change', function() {
        if (jQuery(this).is(':checked')) {
          // Show the label if checkbox is checked
          jQuery('#type_meal_dinner').show();
          jQuery('#meal_dinner').show();
        } else {
          // Hide the label if checkbox is unchecked
          jQuery('#type_meal_dinner').hide();
          jQuery('#meal_dinner').hide();
        }
    });


    //show other allegies 
    jQuery('#dollarother').on('change', function() {
        if (jQuery(this).is(':checked')) {
            // Show the label if checkbox is checked
            jQuery('#all_add').show();
        } else {
            // Hide the label if checkbox is unchecked
            jQuery('#all_add').hide();
        }
    });


});



    /* start click event for dish details starts */
    jQuery(document).on('click', 'a.dish_detail_btn', function () {
        var dishId= jQuery(this).data('pro-id');
        var dataProId = jQuery('a.dish_detail_btn').data('prod-id');

   
        //alert(d); 
    //  alert("hello");

    jQuery.ajax({
        type: 'POST',
        cache: false,
        dataType : 'json',
        url: templateUrl.ajaxurl,
        data: {
            'action': 'tingle_get_dish_detail_callback',
            'dishId': dishId,
        },
        success: function (data) {
            //console.log(data);
            if (data) {
        // productId= jQuery(this).data('id');
        jQuery('a.single_add_to_cart_button').attr('data-product-id', dataProId);
                 if (data.details)
                    {
                        //(".product-detail-box").html(data.details);
                    } 
               // alert(data);
            }else{
            //  alert(data);
            }
        }
    });

    });
    /* endclick event for dish details ends */
    
    /* map intialization starts */
    
    function initMap() {
        const map = new google.maps.Map(document.getElementById("map"), {
            center: { lat: 19.22, lng: 72.5277 },
            zoom: 9,
        });
        
        map.setTilt(45);
    }
    
   // initMap();

    /* map intialization ends */

    jQuery(document).on('click', 'a.btn.btn-primary.addAddress_btn', function () {
        //  var dishId= jQuery(this).data('pro-id');      
       // alert("hello"); 
        var address = jQuery('#address_full').val();
        var flatno = jQuery('#flatno').val();
        var landmark = jQuery('#landmark').val();


        console.log(address);
        console.log(flatno);
        console.log(landmark);
 
            jQuery.ajax({
            type: 'POST',
            cache: false,
            dataType : 'json',
            url: templateUrl.ajaxurl,
            data: {
                'action': 'tingl_addAddress_callback',
                'address': address,
                'flatno': flatno,
                'landmark': landmark,
            },
            success: function (data) {
                if (data) {
                    alert(data);
                }else{
                    alert(data.error);
                }
            }
        });   
    });
    /*start click event for edit user details starts */

    //start click event for edit user details starts //
    var formdata = {};
    jQuery(document).on('click', 'a.edit_profile_btn', function () {
        //  var dishId= jQuery(this).data('pro-id');      
        //alert(d); 
        formdata.firstname = jQuery('#firstname').val();
        formdata.lastname  = jQuery('#lastname').val();
        formdata.weight    = jQuery('#weight').val();
        formdata.age       = jQuery('#age').val();
        formdata.birthdate = jQuery('#birthdate').val();
        formdata.email     = jQuery('#email').val();
        formdata.gender    = jQuery('#Gender').val();
        formdata.height    = jQuery("#height").val();

        console.log(formdata);

            jQuery.ajax({
            type: 'POST',
            cache: false,
            dataType : 'json',
            url: templateUrl.ajaxurl,
            data: {
                'action': 'tingle_update_edit_profile_callback',
                'formdata': formdata,
            },
            success: function (data) {
                if (data) {
                    alert(data);
                }else{
                    alert(data.error);
                }
            }
        });  

    });
    // end  click event for edit user details ends /`



    //meal menu enter day show on subscribe page
    jQuery(document).ready(function() {
        jQuery(document).on('focusout', '#meal_day', function(){
        var plan_day = jQuery(this).val();
        sessionStorage.setItem('inputValue', plan_day);
        });
    });
    jQuery(document).ready(function() {
        var storedValue = sessionStorage.getItem('inputValue');
        if (storedValue) { 
            jQuery('#meal_plan_day').val(storedValue);
            jQuery('#day_final').html('<strong>Days</strong>'+'-'+ storedValue); 
            sessionStorage.removeItem('inputValue');
        }
    });
  

    //plan select day show on subscribe page
    jQuery(document).ready(function() {
        jQuery(document).on('click', '.day-trial a', function () {
            var meal_selcted_day = jQuery(this).text().split(" ");
        sessionStorage.setItem('inputValue', meal_selcted_day[0]);
        });
    });
    jQuery(document).ready(function() {
        var storedValue = sessionStorage.getItem('inputValue');
        if (storedValue) { 
            jQuery('#meal_plan_day').val(storedValue);
            jQuery('#day_final').html('<strong>Days</strong>'+'-'+ storedValue); 
            sessionStorage.removeItem('inputValue');
        }
    });



    //meal select goal and preference on subscribe page
    jQuery(document).ready(function() {
        jQuery(document).on('change', '#meal_goal_select', function(){
            var meal_goal_select = jQuery(this).val();
        sessionStorage.setItem('meal_goal_select',meal_goal_select);
        });
    });
    jQuery(document).ready(function() {
        var meal_goal_select = sessionStorage.getItem('meal_goal_select');
        if (meal_goal_select) { 
            jQuery('#goal_select').val(meal_goal_select);
            jQuery('#goal_final').html('<strong>goal</strong>'+'-'+meal_goal_select ); 
            sessionStorage.removeItem('meal_goal_select');
        }
    });
  

    //meal select goal and preference on subscribe page
    jQuery(document).ready(function() {
        jQuery(document).on('change', '#meal_preference_select', function(){
            var meal_preference_select = jQuery(this).val();
        sessionStorage.setItem('meal_preference_select',meal_preference_select);
        });
    });
    jQuery(document).ready(function() {
        var meal_preference_select = sessionStorage.getItem('meal_preference_select');
        if (meal_preference_select) { 
            jQuery('#preference_select').val(meal_preference_select);
            jQuery('#preference_final').html('<strong>Preference</strong>'+'-'+meal_preference_select );  
            sessionStorage.removeItem('meal_preference_select');
        }
    });
    

    //meal breakfast select and subscribe breakfast select on change event
    jQuery(document).ready(function() {
        jQuery('#breakfast').change(function() {
        var breakfast_checked = jQuery('#breakfast').is(':checked');
        sessionStorage.setItem('breakfast', breakfast_checked);
        });
    });
    jQuery(document).ready(function() {
        var storedState = sessionStorage.getItem('breakfast');
        if (storedState === 'true') {
            jQuery('#myCheckbox_breakfast').prop('checked', true);
            jQuery('#type_meal_breakfast').show();
            jQuery('#meal_breakfast').show();
        } else {
            jQuery('#myCheckbox_breakfast').prop('checked', false);
            jQuery('#type_meal_breakfast').hide();
            jQuery('#meal_breakfast').hide();
        }
    });
  
  

    //meal lunch select and subscribe lunch select on change event
    jQuery(document).ready(function() {
        jQuery('#lunch').change(function() {
            var lunch_checked = jQuery(this).is(':checked');
            sessionStorage.setItem('lunch', lunch_checked);
        });
    });
    jQuery(document).ready(function() {
        var storedState = sessionStorage.getItem('lunch');
        if (storedState === 'true') {
            jQuery('#myCheckbox_lunch').prop('checked', true);
            jQuery('#type_meal_lunch').show();
            jQuery('#meal_lunch').show();
        } else {
            jQuery('#myCheckbox_lunch').prop('checked', false);
            jQuery('#type_meal_lunch').hide();
            jQuery('#meal_lunch').hide();
        }
    });


    //meal snacks select and subscribe snacks select
    jQuery(document).ready(function() {
        jQuery('#snacks').change(function() {
            var isChecked = jQuery(this).is(':checked');
            sessionStorage.setItem('snacks', isChecked);
        });
    });
    jQuery(document).ready(function() {
        var storedState = sessionStorage.getItem('snacks');
        if (storedState === 'true') {
            jQuery('#myCheckbox_snacks').prop('checked', true);
            jQuery('#type_meal_snacks').show();
            jQuery('#meal_snacks').show();
        } else {
            jQuery('#myCheckbox_snacks').prop('checked', false);
            jQuery('#type_meal_snacks').hide();
            jQuery('#meal_snacks').hide();
        }
    });



    //meal dinner select and subscribe dinner select
    jQuery(document).ready(function() {
        jQuery('#dinner').change(function() {
        var isChecked = jQuery(this).is(':checked');
        sessionStorage.setItem('dinner', isChecked);
        });
    });
    jQuery(document).ready(function() {
        var storedState = sessionStorage.getItem('dinner');
        if (storedState === 'true') {
            jQuery('#myCheckbox_dinner').prop('checked', true);
            jQuery('#type_meal_dinner').show();
            jQuery('#meal_dinner').show();
        } else {
            jQuery('#myCheckbox_dinner').prop('checked', false);
            jQuery('#type_meal_dinner').hide();
            jQuery('#meal_dinner').hide();
        }
    });


    


    // jquery get meal checkbox value at load time
    jQuery(document).ready(function() {
        jQuery('#check_2 input[type="checkbox"]').each(function() {
            var checkboxId = jQuery(this).attr('id');
            var isChecked = jQuery(this).prop('checked');
            if (isChecked) {
                jQuery('#myCheckbox_'+checkboxId).prop('checked', true);
                jQuery('#type_meal_'+checkboxId).show();
                jQuery('#meal_'+checkboxId).show();
                var breakfast_checked = jQuery('#'+checkboxId).is(':checked');
                sessionStorage.setItem(checkboxId, breakfast_checked);
            } else {
                jQuery('#myCheckbox_'+checkboxId).prop('checked', false);
                jQuery('#type_meal_'+checkboxId).hide();
                jQuery('#meal_'+checkboxId).hide();
            }
        });
    });

    jQuery(document).ready(function($) {
        $('a.single_add_to_cart_button').on('click', function(event) {
            event.preventDefault();
            var product_id = $(this).data('product-id');
            
            $.ajax({
                type: 'POST',
                url: templateUrl.ajaxurl, // WordPress AJAX URL
                data: {
                    action: 'add_product_to_cart',
                    product_id: product_id
                },
                success: function(response) {
                    console.log("product added to cart");
                    // Optional: Show a success message or perform other actions if needed
                    //alert('Product added to cart!');
                },
                error: function(xhr, status, error) {
                    // Optional: Handle errors, show error message, etc.
                    console.error(error);
                }
            });
        });
    });    
    
    
