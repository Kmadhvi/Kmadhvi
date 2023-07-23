jQuery(document).ready(function ($) {


  $('body').on('click', '.radiocheck', function () {
    var checked_value = $('input[name="poll"]:checked').val();
    alert(checked_value);
    $.ajax({
      method: 'POST',
      type: 'json',
      url: custom.ajaxurl,
      data: {
        'action': 'radio_cookie_set',
        'checked_value': checked_value,
      },
      success: function (data) {
        alert(data);
        if (data) {
          jQuery("span#radiovalue").attr('data-option',data);
        }
      }
    });
  });
});



/* $("input[type=radio]").click(function(){

  var checked_value =  $('input[name="poll"]:checked').val();
  if (!$("input[name='poll']:checked").val()) {
    alert('Nothing is checked!');
    return false;
  }
  else {
    // alert('One of the radio buttons is checked!');
    alert(checked_value);
    $('span#radiovalue').attr('data-option',checked_value);
 } 
 $( 'input:radio' ).attr( 'disabled', 'true' );
 var checked_value_len =  $('input[name="poll"]:checked').length; 

    var radiolength = $("input[type=radio]").length;
    var totalper =  100/radiolength;
    var percent = totalper * checked_value_len ;
    console.log(percent);
    //this.css("width", percent+"%");
    $(".bar-main-1.bar").css('width', percent+'%');

 /* $(".bar-main-1.bar").progress();
 $(".bar-main-2.bar").progress();
 $(".bar-main-3.bar").progress(); 
});  */



/* (function ( $ ) {
  $.fn.progress = function() {
    var checked_value_len =  $('input[name="poll"]:checked').length; 

    var radiolength = $("input[type=radio]").length;
    var totalper =  100/radiolength;
    console.log(totalper);
     var percent = totalper * checked_value_len ;
    //this.css("width", percent+"%");
    $(".bar-main-1.bar").css('width', percent+'%');
  };
}( jQuery )); */