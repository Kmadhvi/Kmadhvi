 var swiper = new Swiper(".mySwiper", {
      cssMode: true,
      navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
      },
      pagination: {
        el: ".swiper-pagination",
      },
      mousewheel: true,
      keyboard: true,
    });

 var swiper = new Swiper(".auth-swiper", {
          pagination: {
        el: ".swiper-pagination",
        clickable: true,
      }
    });

 var swiper = new Swiper(".review-swiper", {
          spaceBetween: 20,
      slidesPerView: "auto",
    });

 
 


 /*var swiper = new Swiper(".plan-swiper", {
      freeMode: true,
      slidesPerView: 3,
      spaceBetween: 30,
      navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
      },
      pagination: {
        el: ".swiper-pagination",
        clickable: true,
      },
      
      keyboard: true,
      breakpoints: {
        1181: {
            slidesPerView: 3
        },
        1180: {
            slidesPerView: 3
        },
        767: {
            slidesPerView: 2
        },
        300: {
            slidesPerView: 1
        }
    }
    });*/

jQuery(document).ready(function($) {

 $('#owl-carousel').owlCarousel({
    loop: true,
    margin: 30,
    dots: true,
    nav: true,
    items: 3,
    responsive: {
    0: {
      items: 1
    },
    600: {
      items: 2
    },
    1000: {
      items: 3
    }
  },
})


 $('#category-carousel').owlCarousel({
    loop: true,
    margin: 30,
    dots: true,
    nav: true,
    items: 6,
    responsive: {
    0: {
      items: 2
    },
    600: {
      items: 4
    },
    1000: {
      items: 6
    }
  },
})


 $('#slider-date').owlCarousel({
    loop: false,
    margin: 10,
    dots: false,
    nav: true,
    items: 7,
    responsive: {
    0: {
      items: 4
    },
    600: {
      items: 5
    },
    1000: {
      items: 7
    }
  },
})


$('#insta-slider').owlCarousel({
    loop: true,
    margin: 30,
    dots: true,
    nav: true,
    items: 4,
    responsive: {
    0: {
      items: 1
    },
    600: {
      items: 3
    },
    1000: {
      items: 4
    }
  },
})

var swiper = new Swiper(".testimonial-swiper", {
      spaceBetween: 30,
      slidesPerView: "auto",
      
 });




// $(".btn-login").click( function(){
//     $(".login-details.active").removeClass("active");
//     $('.varification').addClass("active");
// });

// $(".btn-login1").click( function(){
//     $(".varification.active").removeClass("active");
//     $('.name-pro').addClass("active");
// });

// $(".btn-login2").click( function(){
//     $(".name-pro.active").removeClass("active");
//     $('.gender-selection').addClass("active");
// });

// $(".btn-login3").click( function(){
//     $(".gender-selection.active").removeClass("active");
//     $('.birth-date').addClass("active");
// });
// $(".btn-login4").click( function(){
//   $(".gender-selection.active").removeClass("active");
//   $('.pin-code').addClass("active");
// });


$(function() {
  $('input[name="birthday"]').daterangepicker({
    singleDatePicker: true,
    showDropdowns: true
  });
  $('input[name="birthday"]').on('apply.daterangepicker', function(ev, picker) {
    var selectedDate = picker.startDate.format('DD-MM-YYYY');
    console.log(selectedDate); // Output: selected date in the desired format
    // You can perform any further actions with the selected date here
  });  
});


let minusBtn = document.getElementById("minus-btn");
let count = document.getElementById("count");
let plusBtn = document.getElementById("plus-btn");

let countNum = 0;
count.innerHTML = countNum;

minusBtn.addEventListener("click", () => {
  countNum -= 1;
  count.innerHTML = countNum;
});

plusBtn.addEventListener("click", () => {
  countNum += 1;
  count.innerHTML = countNum;
});


$(".cart-btn").click( function(){
    $('.cart-menu').toggleClass("active");
});

$(document).on('click','#readmore_review',function(){ 
  var desc = $(this).attr('text');
  var cname = $(this).attr('name');
  var c_deg = $(this).attr('desi');
  var c_img = $(this).attr('img');
  var sec_head = $(this).attr('section_title');

 
  $("#more_view_review").html(desc);
  $("#sect_head").html(sec_head);
  $("#long_t_deg").html(c_deg);
  $("#long_t_name").html(cname);
  $("#long_te_img").attr('src',c_img);
});



$('.video-link').each(function() {
  var videoId = $(this).data('src');
  console.log(videoId);
  
  var regex = /(?:[?&]v=|\/embed\/|\/\d\/|\/vi\/|https?:\/\/(?:www\.)?youtube\.com\/user\/\S+|https?:\/\/(?:www\.)?youtube\.com\/(?:(?:v|e(?:mbed)?)\/|.*[?&]v=)|(?:[?&]vi?=|https?:\/\/(?:www\.)?youtube\.com\/v\/))([\w-]{11})(?:.+)?$/
  var match = videoId.match(regex);
  
  if (match) {
    var video_imageid = match[1];
    $('.testimonial-box.video-testimonial').css("background-image", "url('http://img.youtube.com/vi/" + video_imageid + "/0.jpg')");
    //alert(video_imageid);
  }
});


/*
$('.video-link').each(function() {
  var videoId = $(this).data('src');
  console.log(videoId);
  video_imageid = str.replace('https://www.youtube.com/watch?v=', '');
  $('.testimonial-box.video-testimonial').css("background-url","http://img.youtube.com/vi/"+video_imageid+"/0.jpg");
  alert(video_imageid);
}); */

$('#video_play').on('show.bs.modal', function (event) {
  var videoId = $(this).data('src');
  var iframeHtml = '<iframe width="560" height="315" src="https://www.youtube.com/embed/' + videoId + '" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
  $(".modal-body").html(iframeHtml);
});

 $('li.woocommerce-MyAccount-navigation-link.woocommerce-MyAccount-navigation-link--contact-us').on('click', function () {
  $('#contactModal').modal('show');
}) 


});