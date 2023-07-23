/* Demo */
jQuery( document ).ready(function($) {
	var markerMap = {}
	$(document).on("mouseenter", ".professional_details_above", function(e) {
		var cdkID = $(this).parents('.professional_details_inner').attr('data-id');
		new  google.maps.event.trigger(markerMap["marker-"+cdkID], "mouseover");
	});

	$(document).on("mouseleave", ".professional_details_above", function(e) {
		var cdkID = $(this).parents('.professional_details_inner').attr('data-id');
		new  google.maps.event.trigger(markerMap["marker-"+cdkID], "mouseout");
	});


	// display user with ajax for agent-listing page



	function checkNameEmpty(inputID)

	{

		$(inputID).blur(function(){

	 

		if($(this).val() == '')

		{

			$(this).css('border-bottom','1px solid red');

			

		}

		else

		{

			//$(this).css('border-bottom','1px solid green');

			

		}

		});

	}

	 

	 

	//regex to validate email

	function validateEmail(email) {

	  var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

	  return re.test(email);

	}

	 

	 

	// validation for email input using validateEmail Function

	function checkValidEmail(emailInputID)

	{

		$(emailInputID).blur(function(){

			var email = $(emailInputID).val();

			console.log(validateEmail(email))

			if (validateEmail(email)) 

			{

				//$(this).css('border-bottom','1px solid green');

				

			} 

			else 

			{

				$(this).css('border-bottom','1px solid red');

			}

		});

			

		

	}

	 

	 

	// regex to validate phone

	function validatePhone(inputtxt) {
		//+XX-XXXX-XXXX

		//+XX.XXXX.XXXX

		//+XX XXXX XXXX
		var phoneno = /^\+?([0-9]{2})\)?[-. ]?([0-9]{4})[-. ]?([0-9]{4})$/;
		if(inputtxt.match(phoneno)) 
		{
			return true;
		}  
		else 
		{  
			return false;
		}
	}

	 

	 

	// validation for phone input using validatePhone Function

	function checkvalidPhoneNumber(phoneInputID){
		$(phoneInputID).blur(function(){
			var phone = $(phoneInputID).val();
			var getPhone = validatePhone(phone);
			if(getPhone){
				//$(this).css('border-bottom','1px solid green');
			}else{
				$(this).css('border-bottom','1px solid red');
			}
		});
	}

	 

	 

	$("body").on('focusout','.username',function () {

 		var emailInputID = $(this).attr('id');

		if($(this).val() == ''){

			//$(this).css('border-bottom','1px solid red');
			showError = true;

		}else{

			//$(this).css('border-bottom','1px solid green');

		}

	});

 	

 	$("body").on('focusout','.useremail',function () {

 		var emailInputID = $(this).attr('id');

		var email = $("#"+emailInputID).val();

		if (validateEmail(email)) {

			//$(this).css('border-bottom','1px solid green');

			

		}else{
		
			showError = true;

			//$(this).css('border-bottom','1px solid red');

		}

	});



 	$("body").on('focusout','.phone',function () {

 		var phoneInputID = $(this).attr('id');

		var phone = $("#"+phoneInputID).val();

		var getPhone = validatePhone(phone);

		if(getPhone){

			//$(this).css('border-bottom','1px solid green');

		}else{

			//$(this).css('border-bottom','1px solid red');
			showError = true;

		}

	});

 	

 	jQuery(document).on('submit', '.request_call_form', function(e){

		// adding rules for inputs with class 'comment'

		e.preventDefault();

		var ele = $(this);

		var showError = false;

		if($(this).find(".username").val() == '')
		{
			showError = true;	
		}
		if($(this).find(".useremail").val() == '')
		{
			showError = true;
		}
		if($(this).find(".useremail").val() != '')
		{
			var email = $(this).find(".useremail").val();
			if (!validateEmail(email)) 
			{
				showError = true;
			} 
		}
		var phoneLength = $(this).find(".phone").val().length;
		console.log(phoneLength);
		if(phoneLength < 14 )
			{
			 showError = true; 
			}

		var isChecked = $(this).find('input[name="tos"]:checked');
		if(isChecked.length == 0){
			//$(this).find(".tos").css('border-bottom','1px solid red');
			showError = true;
		}

		ele.find('.response_box').html('').show();

		if(showError == true){
			ele.find('.response_box').html('<p class="error">Please fill all required fields</p>');
			setTimeout( function(){
				//ele.find('.response_box').hide();
			} , 6000);
		}else{
			$.ajax({

	           type: "POST",
	           url:  script_adurl.ajax_url,
	           data: jQuery(this).serialize(), // serializes the form's elements.
	           type: 'POST',
	           cache: false,
	           dataType : 'json',
	            beforeSend : function() { 
	              ele.find('.response_box').html("<div class='loder-image'><img src='"+script_adurl.plugin_url+"/images/584b607f5c2ff075429dc0e7b8d142ef.gif' alt='loder' style='margin-right: 30px !important;margin-bottom: -9px !important;'></div><br>");
	            },
	           success: function(data)
	           {
	           	  if(data.sucess){
						ele.find('.response_box').html(data.message)
	           	  	ele.trigger("reset"); 
	           	  	grecaptcha.reset();
                    $(".rating").addClass('removerating');
	              }else {
	                ele.find('.response_box').html(data.message) 
	            }
	            setTimeout( function(){
	            	//ele.find('.response_box').hide();
	           
	            } , 1000);

	           },

	           error: function(jqXHR, exception) {

	            var msg = '';

	            if (jqXHR.status === 0) {

	                msg = 'Not connect.\n Verify Network.';

	            } else if (jqXHR.status == 404) {

	                msg = 'Requested page not found. [404]';

	            } else if (jqXHR.status == 500) {

	                msg = 'Internal Server Error [500].';

	            } else if (exception === 'parsererror') {

	                msg = 'Requested JSON parse failed.';

	            } else if (exception === 'timeout') {

	                msg = 'Time out error.';

	            } else if (exception === 'abort') {

	                msg = 'Ajax request aborted.';

	            } else {

	                msg = 'Uncaught Error.\n' + jqXHR.responseText;

	            }

	           //console.log(msg)

	          },

	         });

		}



		

		//var closestmsg = jQuery(this).parent(); 

		//alert(ele);

		//jQuery(ele).find('.submit').addClass("loading");



		//var agent_id = jQuery('.agent-listing').data("id");

		//jQuery("body").find("#popupagentid").val(agent_id);

		

		//jQuery("html, body").animate({ scrollTop: "300px" });

		// jQuery(".ad-list-main").html('');

		//jQuery('.ad-list-main').append("<div class='loder-image'><img src='"+script_adurl.plugin_url+"/images/584b607f5c2ff075429dc0e7b8d142ef.gif' alt='loder'></div>");

		//var data = jQuery(this).serialize();

		//alert(data);

		//jQuery(this).find("input[type=submit]").prop('disabled', true);

		

		//return false;

		

		/*jQuery.ajax({

			url : script_adurl.ajax_url,

			type : 'post',

			data : jQuery(this).serialize(),

			success : function( response ) {

				jQuery(ele).find(".submit").removeClass("loading");

				jQuery(ele).find(".submit").addClass("hide-loading");

				//alert(response);

				

				closestmsg.find(".agent-lead-response-msg").html(response).delay(1000).fadeOut("slow","linear");

				/**/						

				

			/*}

		});	*/

	});



	jQuery(document).on('submit', '.request_information_form', function(e){
		// adding rules for inputs with class 'comment'
		e.preventDefault();
		var ele = $(this);
		var showError = false;
		if($(this).find(".username").val() == '')
		{
			//$(this).find(".username").css('border-bottom','1px solid red');
			showError = true;	
		}
		if($(this).find(".useremail").val() == ''){
		//	$(this).find(".useremail").css('border-bottom','1px solid red');
			showError = true;
		}
		if($(this).find(".useremail").val() != ''){
			var email = $(this).find(".useremail").val();
			if (!validateEmail(email)) {
				showError = true;
			} 
		}
		var isChecked = $(this).find('input[name="tos"]:checked');
		if(isChecked.length == 0){
		//	$(this).find(".tos").css('border-bottom','1px solid red');
			showError = true;
		}else{
			$(this).find(".tos").css('border-bottom','');
		}
		ele.find('.response_box').html('').show();
		if(showError == true){
			ele.find('.response_box').html('<p class="error">Please fill all required fields.</p>');
			setTimeout( function(){ele.find('.response_box').hide();} , 4000);
		}else{
			$.ajax({

	           type: "POST",

	           url:  script_adurl.ajax_url,

	           data: jQuery(this).serialize(), // serializes the form's elements.

	           type: 'POST',

	           cache: false,

	           dataType : 'json',

	            beforeSend : function() { 
			ele.find('.response_box').html("<div class='loder-image'><br><img src='"+script_adurl.plugin_url+"/images/584b607f5c2ff075429dc0e7b8d142ef.gif' alt='loder' style='margin-right: 30px !important;margin-bottom: -9px !important;'></div><br>");    
	            },
	           success: function(data)
	           {
	              if(data.sucess){
	              ele.find('.response_box').html(data.message)
	           	 	 ele.trigger('reset');
	           	    grecaptcha.reset();
	              }else {
	                ele.find('.response_box').html(data.message) 
	            }
	            setTimeout( function(){
	            	ele.find('.response_box').hide();
	            } , 6000);
	                     
	           },

	           error: function(jqXHR, exception) {

	            var msg = '';

	            if (jqXHR.status === 0) {

	                msg = 'Not connect.\n Verify Network.';

	            } else if (jqXHR.status == 404) {

	                msg = 'Requested page not found. [404]';

	            } else if (jqXHR.status == 500) {

	                msg = 'Internal Server Error [500].';

	            } else if (exception === 'parsererror') {

	                msg = 'Requested JSON parse failed.';

	            } else if (exception === 'timeout') {

	                msg = 'Time out error.';

	            } else if (exception === 'abort') {

	                msg = 'Ajax request aborted.';

	            } else {

	                msg = 'Uncaught Error.\n' + jqXHR.responseText;

	            }

	           //console.log(msg)

	          },

	         });

		}
		//var closestmsg = jQuery(this).parent(); 

		//alert(ele);

		//jQuery(ele).find('.submit').addClass("loading");



		//var agent_id = jQuery('.agent-listing').data("id");

		//jQuery("body").find("#popupagentid").val(agent_id);

		

		//jQuery("html, body").animate({ scrollTop: "300px" });

		// jQuery(".ad-list-main").html('');

		//jQuery('.ad-list-main').append("<div class='loder-image'><img src='"+script_adurl.plugin_url+"/images/584b607f5c2ff075429dc0e7b8d142ef.gif' alt='loder'></div>");

		//var data = jQuery(this).serialize();

		//alert(data);

		//jQuery(this).find("input[type=submit]").prop('disabled', true);

		

		//return false;

		

		/*jQuery.ajax({

			url : script_adurl.ajax_url,

			type : 'post',

			data : jQuery(this).serialize(),

			success : function( response ) {

				jQuery(ele).find(".submit").removeClass("loading");

				jQuery(ele).find(".submit").addClass("hide-loading");

				//alert(response);

				

				closestmsg.find(".agent-lead-response-msg").html(response).delay(1000).fadeOut("slow","linear");

				/**/						

				

			/*}

		});	*/

	});


/*function captcha_check_empty(){
	showError = false;
	if (grecaptcha.getResponse() == ""){
	$(".form__captcha").css('border-bottom','1px solid red');
	setTimeout( function(){ele.find('.recaptcha_error').hide();} , 4000);
	//find('.recaptcha_error').html('<p class="error error-agnet-not-fond">Please fill all required fields</p>');
	showError = true;
	return showError;
    
} else {
   $(".recaptcha_error").css("display","none");
   return showError;
}
}
*/

	jQuery(document).on('submit', '.book_appointment_form', function(e){

		// adding rules for inputs with class 'comment'

		e.preventDefault();

		var ele = $(this);

		var showError = false;
/*
		var captcha = captcha_check_empty();
		showError = captcha;
*/

		if($(this).find(".username").val() == '')

		{

			//$(this).find(".username").css('border-bottom','1px solid red');

			showError = true;	

		}

	

		if($(this).find(".useremail").val() == ''){
			//$(this).find(".useremail").css('border-bottom','1px solid red');
			showError = true;
		}

		if($(this).find(".useremail").val() != ''){

			var email = $(this).find(".useremail").val();

			if (!validateEmail(email)) 

			{

				showError = true;

			} 

		}



		var phoneLength = $(this).find(".phone").val().length;
		console.log(phoneLength);
		if(phoneLength < 14 )
			{
			 showError = true; 
			}



		var isChecked = $(this).find('input[name="tos"]:checked');

		if(isChecked.length == 0)

		{

			//$(this).find(".tos").css('border-bottom','1px solid red');

			showError = true;

		}else{

			//$(this).find(".tos").css('border-bottom','');

		}



		ele.find('.response_box').html('').show();

		if(showError == true){

			ele.find('.response_box').html('<p class="error">Please fill all required fields</p>');
			setTimeout( function(){
				//ele.find('.response_box').hide();
			} , 6000);

		}else{

			$.ajax({
	           type: "POST",
			   url:  script_adurl.ajax_url,
	           data: jQuery(this).serialize(), // serializes the form's elements.
	           type: 'POST',
	           cache: false,
	           dataType : 'json',
	            beforeSend : function() { 
	              ele.find('.response_box').html("<div class='loder-image'><img src='"+script_adurl.plugin_url+"/images/584b607f5c2ff075429dc0e7b8d142ef.gif' alt='loder'></div>");
	            },

	           success: function(data){
	              if(data.sucess){
	                ele.find('.response_box').html(data.message)
	              	$('.book_appointment_form')[0].reset(); 
	              }else {
	                ele.find('.response_box').html(data.message) 
	            }

	            setTimeout( function(){
	            	ele.find('.response_box').hide();
	            } , 6000);
	            
	           },

	           error: function(jqXHR, exception) {

	            var msg = '';

	            if (jqXHR.status === 0) {

	                msg = 'Not connect.\n Verify Network.';

	            } else if (jqXHR.status == 404) {

	                msg = 'Requested page not found. [404]';

	            } else if (jqXHR.status == 500) {

	                msg = 'Internal Server Error [500].';

	            } else if (exception === 'parsererror') {

	                msg = 'Requested JSON parse failed.';

	            } else if (exception === 'timeout') {

	                msg = 'Time out error.';

	            } else if (exception === 'abort') {

	                msg = 'Ajax request aborted.';

	            } else {

	                msg = 'Uncaught Error.\n' + jqXHR.responseText;

	            }

	           //console.log(msg)

	          },

	         });
		}

	});





	jQuery(document).on('submit', '.leave_review_form', function(e){

		// adding rules for inputs with class 'comment'

		e.preventDefault();

		var ele = $(this);

		var showError = false;

		/*var captcha = captcha_check_empty();
		showError = captcha;*/

		if($(this).find(".reviewer_name").val() == '')

		{

			//$(this).find(".reviewer_name").css('border-bottom','1px solid red');

			showError = true;	

		}

		

	

		if($(this).find(".reviewer_email").val() == '')

		{

			//$(this).find(".reviewer_email").css('border-bottom','1px solid red');

			showError = true;

		}

		

		if($(this).find(".reviewer_email").val() != '')

		{

			var email = $(this).find(".reviewer_email").val();

			if (!validateEmail(email)) 

			{

				showError = true;

			} 

		}



		if($(this).find(".review_description").val() == '')

		{

			//$(this).find(".review_description").css('border-bottom','1px solid red');

			showError = true;	

		}



		ele.find('.response_box').html('').show();

		if(showError == true){

			ele.find('.response_box').html('<p class="error">Please fill all required fields</p>');

			setTimeout( function(){
				//ele.find('.response_box').hide();
			} , 1000);


		}else{

			$.ajax({

	           type: "POST",

	           url:  script_adurl.ajax_url,

	           data: jQuery(this).serialize(), // serializes the form's elements.

	           type: 'POST',

	           cache: false,

	           dataType : 'json',

	            beforeSend : function() { 

	              ele.find('.response_box').html("<div class='loder-image'><img src='"+script_adurl.plugin_url+"/images/584b607f5c2ff075429dc0e7b8d142ef.gif' alt='loder'></div>");

	            },

	           success: function(data)
	           {
	              if(data.sucess){
	                ele.find('.response_box').html(data.message)
	            	 ele.trigger('reset');
	            	 grecaptcha.reset();
	            	 $(".rating").addClass('removerating');
	            	}else {
	                ele.find('.response_box').html(data.message) 
	            }

	            setTimeout( function(){
	            	//ele.find('.response_box').hide();

	        		var gtagID = ele.find(".request_information_form_gta");
            		recpachaID = gtagID.attr('id')
            		grecaptcha.reset(widgetId);
	        	} , 1000);
	           },
	           error: function(jqXHR, exception) {

	            var msg = '';

	            if (jqXHR.status === 0) {

	                msg = 'Not connect.\n Verify Network.';

	            } else if (jqXHR.status == 404) {

	                msg = 'Requested page not found. [404]';

	            } else if (jqXHR.status == 500) {

	                msg = 'Internal Server Error [500].';

	            } else if (exception === 'parsererror') {

	                msg = 'Requested JSON parse failed.';

	            } else if (exception === 'timeout') {

	                msg = 'Time out error.';

	            } else if (exception === 'abort') {

	                msg = 'Ajax request aborted.';

	            } else {

	                msg = 'Uncaught Error.\n' + jqXHR.responseText;

	            }

	           //console.log(msg)

	          },

	         });

		}



	});





	jQuery('body').on('click','.pagination li a',function(e){
		e.preventDefault();


		let page = $(this).attr('href');
		let zipcode = $(".zip-code").val();
		let paginationData = {'action':'find_agent_by_zipcode','page':page,'zipcode':zipcode} 
		//$('body').animate({scrollTop: $("#professional_box").position().top }, 800, 'swing');
		
		//ListAgentAjaxCall(paginationData,true);
		$.ajax({

           type: "POST",

           url:  script_adurl.ajax_url,

           data: paginationData, // serializes the form's elements.

           type: 'POST',

           cache: false,

           dataType : 'json',

            beforeSend : function() { 
	           /* 
	            */
	            
	            //$('.professional_details').html("<div class='loder-image'><img src='"+script_adurl.plugin_url+"/images/584b607f5c2ff075429dc0e7b8d142ef.gif' alt='loder'></div>");
            },

           success: function(data){
           	$('.professional_details').html('');
              if(data.sucess){
                $('.professional_details').html(data.data)
                MapInit(locations)
              }else {
                $('.professional_details').html(data.message) 
                 locations = {};
                 MapInit(locations)
            }

       		 setTimeout(function() {
        		$('.professional_details').find('.request_information_form_gta').each(function() {
	            var gtagID = $(this).attr('id')
	            var widgetId =  grecaptcha.render(gtagID, {
	            'sitekey': script_adurl.site_key
		        	});
		        });
		    	}, 1000);

	    	

           },

           error: function(jqXHR, exception) {

            var msg = '';

            if (jqXHR.status === 0) {

                msg = 'Not connect.\n Verify Network.';

            } else if (jqXHR.status == 404) {

                msg = 'Requested page not found. [404]';

            } else if (jqXHR.status == 500) {

                msg = 'Internal Server Error [500].';

            } else if (exception === 'parsererror') {

                msg = 'Requested JSON parse failed.';

            } else if (exception === 'timeout') {

                msg = 'Time out error.';

            } else if (exception === 'abort') {

                msg = 'Ajax request aborted.';

            } else {

                msg = 'Uncaught Error.\n' + jqXHR.responseText;

            }

           //console.log(msg)

          },

         });
		$('html, body').animate({
        scrollTop: $("#professional_box").offset().top - 500
    	}, 1500 , 'swing');	
	});



	jQuery(document).on('click','input.searchbyzipcode.btn.sitebtn.search-agent-btn',function(){

		jQuery('.searchform.moduleContent').addClass("searchbutton");

		jQuery('.ad-list-main.widget-main').addClass("searchresult");

	});

	//$("#findagent").submit();

	
	function MapInit(locations){

		if(locations.length > 0){

			var markers =  JSON.parse(locations);

		}

		const United_States_BOUNDS = {
			  north: 49.078736316518786,
			  south: 26.27648087345881,
			  west: -123.96363385038184,
			  east: -67.07027349820551,
			  /*north: -171.791110603,
			  south: 18.91619,
			  west: -66.96466,
			  east: 71.3577635769,*/
			};
		var mapOptions = {

                center: new window.google.maps.LatLng(markers[0].lat, markers[0].lng),
                mapTypeId: google.maps.MapTypeId.ROADMAP,
                //zoom: 15,
                restriction: {
			      latLngBounds: United_States_BOUNDS,
			      strictBounds: true,
			    },

            };

        var infoWindow = new google.maps.InfoWindow();

        var map = new google.maps.Map(document.getElementById("map"), mapOptions);



        //Create LatLngBounds object.

        var latlngbounds = new google.maps.LatLngBounds();

        var is_mouse_on_map = false;

        if(locations.length > 0){

			google.maps.event.addListener(map, "mouseover", function (e) {
				is_mouse_on_map = true;
			})

			google.maps.event.addListener(map, "mouseout", function (e) {
				is_mouse_on_map = false;
			})

        	for (var i = 0; i < markers.length; i++) {
        		addMarkerWithTimeout(markers[i],latlngbounds, i * 200);

	           
        	}

        	function addMarkerWithTimeout(position,latlngbounds, timeout) {
				  window.setTimeout(() => {

				  	 var data = position

		            var myLatlng = new google.maps.LatLng(data.lat, data.lng);
		           
		            var marker = new google.maps.Marker({
		                position: myLatlng,
		                map: map,
		                title: data.title,
		                animation: google.maps.Animation.DROP,

		            });



		            (function (marker, data) {
		            	markerMap[ "marker-" + data.cdkid ] = marker;

		                google.maps.event.addListener(marker, "mouseover", function (e) {
		                	var agnetbox = 'agnetbox-' + data.cdkid
		                	$('.professional_details_inner').removeClass('markerhighlights');
		                	$('#'+agnetbox).addClass('markerhighlights');
							 	if(is_mouse_on_map){
							 		$('html, body').animate({ scrollTop: $('#'+agnetbox).offset().top - 150}, 'slow');
							 	}
                                if($(window).outerWidth() <= 767){
                                    $('html, body').animate({ scrollTop: $('#map').offset().top - 50}, 'slow');
                                }

							content = "<div class='map_info_wrapper'><a href="+data.wpAuthorslug+">" + 
							    "<div class='card p-3' style='width: 350px;''> " +
							        "<div class='d-flex align-items-center'>" +
							            "<div class='image tooltip-img'> <img src=" + data.profile_pic + " width='100'> </div>" +
							            "<div class='w-100 tooltip-info'> " + "<h5 class='mb-0 mt-0'>"+ data.title + "</h5>";
							              if(data.certifications) content +=  " <span class='desp'> " + data.certifications + "</span> " ;
							          		content +=	"<div class='tooltip-location stats'> " ;
							           if(data.description) content += "<div class='d-flex flex-column'><i class='fas fa-location'></i>" + data.description +  "</div> " ;
							            	content +=  "</div>" + 
							            "</div>"+
							        "</div>" +
							    "</div>" +
							"</a></div>";
		                	//infoWindow.setContent("<div style = 'width:200px;min-height:40px'>" + data.description + "</div>");
		                	infoWindow.setContent(content);
		                    infoWindow.open(map, marker);
		                });

		                
		                

		            })(marker, data);

		            google.maps.event.addListener(marker, 'mouseout', function() {
							//infoWindow.close();	
						});

		            //Extend each marker's position in LatLngBounds object.

	            	latlngbounds.extend(marker.position);

				    /*markers.push(
				      new google.maps.Marker({
				        position: position,
				        map,
				        animation: google.maps.Animation.DROP,
				      })
				    );*/
				  }, timeout);
				}

    	}


        //Get the boundaries of the Map.

        var bounds = new google.maps.LatLngBounds();



        //Center map and adjust Zoom based on the position of all markers.
         window.setTimeout(() => {
         	 console.log(bounds);
	        	map.setCenter(latlngbounds.getCenter());
	        	map.fitBounds(latlngbounds);

	        },900)
         
        /*map.setCenter(latlngbounds.getCenter());

        map.fitBounds(latlngbounds);*/
	}




	/**

	 * Accepts either a URL or querystring and returns an object associating 

	 * each querystring parameter to its value. 

	 *

	 * Returns an empty object if no querystring parameters found.

	 */

	function getUrlParams(urlOrQueryString) {

	  if ((i = urlOrQueryString.indexOf('?')) >= 0) {

	    const queryString = urlOrQueryString.substring(i+1);

	    if (queryString) {

	      return _mapUrlParams(queryString);

	    } 

	  }



	  return {};

	}



	/**

	 * Helper function for `getUrlParams()`

	 * Builds the querystring parameter to value object map.

	 *

	 * @param queryString {string} - The full querystring, without the leading '?'.

	 */

	function _mapUrlParams(queryString) {

	  return queryString    

	    .split('&') 

	    .map(function(keyValueString) { return keyValueString.split('=') })

	    .reduce(function(urlParams, [key, value]) {

	      if (Number.isInteger(parseInt(value)) && parseInt(value) == value) {

	        urlParams[key] = parseInt(value);

	      } else {

	        urlParams[key] = decodeURI(value);

	      }

	      return urlParams;

	    }, {});

	}



	function ListAgentAjaxCall(formdata = null,isdefault = false){

		

		//var agent_id = jQuery('.agent-listing').data("id");

		//jQuery("body").find("#popupagentid").val(agent_id);

		

		//var zip_code = jQuery(this).val();

		//$("#agentidmain").val(agent_id);

		//jQuery("body").find("#popupagentid").val(agent_id);

		var url = location.search;

		urlParams = getUrlParams(url);
		// To check if a parameter exists, simply do:

		var ajaxDAta = {'action':'find_agent_by_zipcode'} 
		if (urlParams.hasOwnProperty('zipcode')) { 
		  	ajaxDAta.zipcode =  urlParams.zipcode;
		}

		if(formdata){
			ajaxDAta = formdata;
		}

		$.ajax({

           type: "POST",

           url:  script_adurl.ajax_url,

           data: ajaxDAta, // serializes the form's elements.

           type: 'POST',

           cache: false,

           dataType : 'json',

            beforeSend : function() { 
	            $('.professional_details').html('');
	            if(!isdefault){
	            	$('html, body').animate({
				        scrollTop: $("#professional_box").offset().top - 500
				    	}, 1500 , 'swing');	
	            }
	            
	            $('.professional_details').html("<div class='loder-image'><img src='"+script_adurl.plugin_url+"/images/584b607f5c2ff075429dc0e7b8d142ef.gif' alt='loder'></div>");
            },

           success: function(data){
              if(data.sucess){
                $('.professional_details').html(data.data)
                	MapInit(locations)
              }else {
                 $('.professional_details').html(data.message) 
                 locations = {};
                 MapInit(locations)
            }

            setTimeout(function() {
        		$('.professional_details').find('.request_information_form_gta').each(function() {
	            var gtagID = $(this).attr('id')
	            var widgetId =  grecaptcha.render(gtagID, {
	            'sitekey': script_adurl.site_key
	        	});
	        });
		        
		    	}, 1000);

	    	

           },

           error: function(jqXHR, exception) {

            var msg = '';

            if (jqXHR.status === 0) {

                msg = 'Not connect.\n Verify Network.';

            } else if (jqXHR.status == 404) {

                msg = 'Requested page not found. [404]';

            } else if (jqXHR.status == 500) {

                msg = 'Internal Server Error [500].';

            } else if (exception === 'parsererror') {

                msg = 'Requested JSON parse failed.';

            } else if (exception === 'timeout') {

                msg = 'Time out error.';

            } else if (exception === 'abort') {

                msg = 'Ajax request aborted.';

            } else {

                msg = 'Uncaught Error.\n' + jqXHR.responseText;

            }

           //console.log(msg)

          },

         });
	}

	

	var foundprofessional_box =  $("#professional_box");

	if(foundprofessional_box.length > 0 ) ListAgentAjaxCall(null,true);


	jQuery(document).on('submit', '#primary_topic', function(e){
		e.preventDefault();
		var ele = jQuery(this);
		let zipcode = $(".zip-code").val();

		if(zipcode){
			eleserialize = ele.serialize() + '&=zipcode' + zipcode; 
		}else{
			eleserialize = ele.serialize()
		}
		$('html, body').animate({
	      scrollTop: $('#findagent').offset().top - 1800
	    }, 1500);
		//$('header').animate({scrollTop: $("header").position().top }, 800, 'swing');
		ListAgentAjaxCall(eleserialize);
	})



	//checkNameEmpty(".zip-code");

	jQuery(document).on('submit', '#findagent', function(e){

		e.preventDefault();

		var url = location.search;

		urlParams = getUrlParams(url);
		// To check if a parameter exists, simply do:

		var ajaxDAta = {'action':'find_agent_by_zipcode'} 
		if (urlParams.hasOwnProperty('zipcode')) { 
		  	ajaxDAta.zipcode =  urlParams.zipcode;
		}

		var zipcode = $('#findagent .zip-code').val();
		if($.trim(zipcode) != ''){
			ajaxDAta.zipcode =  $.trim(zipcode);
		}

		var ele = jQuery(this);

		if($(".zip-code").val() == ''){

			$(".zip-code").css('border-bottom','1px solid red');

			return false;	

		}

		//var closestmsg = jQuery(this).parent(); 

		$('#zipcodebox').html($(".zip-code").val())

		//alert(ele);

		//jQuery(ele).find('.submit').addClass("loading");

		$('.professional_details').html('');

		ListAgentAjaxCall(ele.serialize());
	

	});





	jQuery('body').on('click','.agent-listing',function(){

		

		var agent_id = jQuery(this).data("id");

		$("#agentidmain").val(agent_id);

		jQuery("body").find("#popupagentid").val(agent_id);



		jQuery.ajax({

			url : script_adurl.ajax_url,

			type : 'post',

			data : {

				action : 'get_agentbyid',

				agent_id : agent_id

			},

			success : function( response ) {	

				//console.log(response);

				jQuery("#pip").html(response);

				jQuery("#Response").html(response);

				//jQuery(".ad-list-main").html('');

				//jQuery(".ad-list-main").html(response);

			}

		});	



		var theGoodStuff = jQuery('body').find('.white-popup-block');

		

			jQuery.magnificPopup.open({

			  	items: {

				  src: theGoodStuff

			  	}

		  	});



		return false;

	});



	//jQuery('#other').popup();

	

	jQuery(document).on('click', '#popup-with-form', function(e){

				 

	  var theGoodStuff = jQuery('body').find('.white-popup-block');

	  //console.log(theGoodStuff);

	  jQuery.magnificPopup.open({

		  items: {

			  src: theGoodStuff

		  }

	  });

	});



	

   jQuery(document).on('click', '.page-click', function(e){

	  e.preventDefault();

	  var page_id =  jQuery(this).data("page_id");

		

		jQuery(".ad-list-main").html('');

		jQuery("html, body").animate({ scrollTop: "300px" });

		jQuery('.ad-list-main').append("<div class='loder-image'><img src='"+script_adurl.plugin_url+"/images/584b607f5c2ff075429dc0e7b8d142ef.gif' alt='loder'></div>");

			

		jQuery.ajax({

			url : script_adurl.ajax_url,

			type : 'post',

			data : {

				action : 'get_adbyajax',

				page_id : page_id

			},

			success : function( response ) {

				jQuery(".ad-list-main").html('');

				jQuery(".ad-list-main").html(response);

			}

		});

   });



	jQuery(document).on('click', '.view_agent', function(e){

		e.preventDefault();

		var agent_id =  jQuery(this).data("agent_id");

					

		jQuery.ajax({

			url : script_adurl.ajax_url,

			type : 'post',

			data : {

				action : 'get_agent_by_id',

				agent_id : agent_id

			},

			success : function( response ) {	

				//alert(response);

				//jQuery(".ad-list-main").html('');

				//jQuery(".ad-list-main").html(response);

			}

		});	

	});

	   

    jQuery(document).on('submit', '#agentleadadd', function(e){

		e.preventDefault();

		

		var ele = jQuery(this);

		var closestmsg = jQuery(this).parent(); 

		//alert(ele);

		jQuery(ele).find('.submit').addClass("loading");



		var agent_id = jQuery('.agent-listing').data("id");

		jQuery("body").find("#popupagentid").val(agent_id);

		

		//jQuery("html, body").animate({ scrollTop: "300px" });

		// jQuery(".ad-list-main").html('');

		//jQuery('.ad-list-main').append("<div class='loder-image'><img src='"+script_adurl.plugin_url+"/images/584b607f5c2ff075429dc0e7b8d142ef.gif' alt='loder'></div>");

		//var data = jQuery(this).serialize();

		//alert(data);

		//jQuery(this).find("input[type=submit]").prop('disabled', true);

		

		//return false;

		

		jQuery.ajax({

			url : script_adurl.ajax_url,

			type : 'post',

			data : jQuery(this).serialize(),

			success : function( response ) {

				jQuery(ele).find(".submit").removeClass("loading");

				jQuery(ele).find(".submit").addClass("hide-loading");

				//alert(response);

				

				closestmsg.find(".agent-lead-response-msg").html(response).delay(1000).fadeOut("slow","linear");

				/**/						

				

			}

		});	

	});

	   

	jQuery(document).on('submit', '#user-search', function(e){

		e.preventDefault();

		jQuery("html, body").animate({ scrollTop: "300px" });

		jQuery(".ad-list-main").html('');

		if(jQuery('.postalCode').val()=='')

		{

		   jQuery(".text").html("Please Enter Zipcode.");

		   jQuery('.searchform.moduleContent').removeClass("searchbutton");

		   jQuery('.ad-list-main.widget-main').removeClass("searchresult");

			

		}else

		{

			 jQuery(".text").html("");

		jQuery('.ad-list-main').append("<div class='loder-image'><img src='"+script_adurl.plugin_url+"/images/584b607f5c2ff075429dc0e7b8d142ef.gif' alt='loder'></div>");   

			

				jQuery.ajax({

				url : script_adurl.ajax_url,

				type : 'post',

				data : jQuery(this).serialize(),

				success : function( response ) {		

					//alert(response);

					jQuery(".ad-list-main").html('');

					jQuery(".ad-list-main").html(response);

				}

			});	

		}

		

	});

	$('.agt-agent-toggle').on('click',function(){
        $(this).removeClass('active');        
       $(this).parents('.agt-user-detail').find('.agt-agent-popup').hide();
      setTimeout(function() {
          $('.agt-user-detail').find('.request_information_form_gta').each(function() {
              var gtagID = $(this).attr('id')
              grecaptcha.render(gtagID, {
              'sitekey': script_adurl.site_key
            });
          });
          
        },0);
       $(this).addClass('active');       
       var PopUp = $(this).attr('data-popup-open');
       var OpenPopup = $('[data-popup="' + PopUp + '"]');
       $(this).parents('.agt-user-detail').find(OpenPopup).show();
       $('body').addClass('agt-popup-open');

    });
        $('.agt-agent-popup-close').on('click',function(){
       $('.agt-agent-toggle').removeClass('active');
       var PopUpClose = $(this).attr('data-popup-close');
       var ClosePopup = $('[data-popup="' + PopUpClose + '"]');
       $('.leave_review_form').trigger("reset");
       $('.book_appointment_form').trigger("reset");
       $('.request_information_form').trigger("reset"); 
       $(this).parents('.agt-user-detail').find(ClosePopup).hide();
       $('body').removeClass('agt-popup-open');
       $(this).parents('.leave_review').find(".rating").addClass('removerating'); 
    });

    function AddReadMore() {
      var carLmt = 280;
      var readMoreTxt = " Read More";
      var readLessTxt = " Read Less";

      //Traverse all selectors with this class and manupulate HTML part to show Read More
      $(".addReadMore").each(function() {
          if ($(this).find(".firstSec").length)
              return;
          var allstr = $(this).text();
          if (allstr.length > carLmt) {
              var firstSet = allstr.substring(0, carLmt);
              var secdHalf = allstr.substring(carLmt, allstr.length);
              var strtoadd = firstSet + "<span class='SecSec'>" + secdHalf + "</span><span class='readMore white-button'  title='Click to Show More'>" + readMoreTxt + "</span><span class='readLess white-button' title='Click to Show Less'>" + readLessTxt + "</span>";
              $(this).html(strtoadd);
          }
      });

      $(document).on("click", ".readMore,.readLess", function() {
          $(this).closest(".addReadMore").toggleClass("showlesscontent showmorecontent");
      });
  }
  $(function() {
      AddReadMore();
  });
    
jQuery('#agt-ebook-slider').owlCarousel({
    items:2,
    loop:true,
    dots:false,
    nav:true,
    responsive:{
        320:{            
            margin:20
        },
        768:{            
            margin:30
        }  
        
    }
});    



});

function keyfunction(event){
	
    jQuery(".request_call_phone").keydown(function (e) {
        // Allow: backspace, delete, tab, escape, enter
        if (jQuery.inArray(e.keyCode, [46, 8, 9, 27, 13, 110]) !== -1 ||
             // Allow: Ctrl+A, Command+A
            (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) || 
             // Allow: home, end, left, right, down, up
            (e.keyCode >= 35 && e.keyCode <= 40)) {
                 // let it happen, don't do anything
                 return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });
    jQuery(".request_call_phone").keyup(function(e) {  
    	var numericvalue = jQuery(this); 
    	var position = getCursorPosition(numericvalue);
        if (// Allow: Ctrl+A, Command+A
            (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) || 
             // Allow: home, end, left, right, down, up
            (e.keyCode >= 35 && e.keyCode <= 40)) {
                 // let it happen, don't do anything
                 return;
        }
	        
	    var inputval = numericvalue.val();
	    digits = inputval.replace(/\D/g,'');

        if(digits.length > 2){
            res = digits.substring(0, 3);
            result = "(" + res + ") ";
            res = digits.substring(3);
        	result = result + res;
        	
            if(digits.length > 6){
                res = digits.substring(0, 3);
                result = "(" + res + ") ";
            	res = digits.substring(3,6);
            	result = result + res + "-";
            	res = digits.substring(6);
            	result = result + res;
            }
            numericvalue.val(result);
            result ="";
        }else{
        	numericvalue.val(digits);
        }
     	// Allow: backspace, delete, tab, escape, enter
    	if(jQuery.inArray(e.keyCode, [46, 8, 9, 27, 13, 110]) !== -1){
    		setSelectionRange(numericvalue[0], position, position);
        }
    });

    
}
//Set cursor position
function setSelectionRange(input, selectionStart, selectionEnd) {
	  if (input.setSelectionRange) {
	    input.focus();
	    input.setSelectionRange(selectionStart, selectionEnd);
	  } else if (input.createTextRange) {
	    var range = input.createTextRange();
	    range.collapse(true);
	    range.moveEnd('character', selectionEnd);
	    range.moveStart('character', selectionStart);
	    range.select();
	  }
}

// Get cursor position
function getCursorPosition (numericvalue) {
        var pos = 0;
        var el = numericvalue.get(0);
        // IE Support
        if (document.selection) {
            el.focus();
            var Sel = document.selection.createRange();
            var SelLength = document.selection.createRange().text.length;
            Sel.moveStart('character', -el.value.length);
            pos = Sel.text.length - SelLength;
        }
        // Firefox support
        else if (el.selectionStart || el.selectionStart == '0')
            pos = el.selectionStart;
        return pos;
}
