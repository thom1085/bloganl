// Sticky Header
$(window).scroll(function() {

    if ($(window).scrollTop() > 100) {
        $('.main_header').addClass('sticky');
    } else {
        $('.main_header').removeClass('sticky');
    }
});

// Mobile Navigation
$('.mobile-toggle').click(function() {
    if ($('.main_header').hasClass('open-nav')) {
        $('.main_header').removeClass('open-nav');
    } else {
        $('.main_header').addClass('open-nav');
    }
});

$('.main_header li a').click(function() {
    if ($('.main_header').hasClass('open-nav')) {
        $('.navigation').removeClass('open-nav');
        $('.main_header').removeClass('open-nav');
    }
});

// navigation scroll
$('nav a').click(function(event) {
    var id = $(this).attr("href");
    var offset = 0;
    var target = $(id).offset().top - offset;
    $('html, body').animate({
        scrollTop: target
    }, 500);
    event.preventDefault();
});
/* Scroll-to-Top Button */
$(window).scroll(function () {
    if ($(this).scrollTop() > 100) {
        $('.scrollup').fadeIn();
    } else {
        $('.scrollup').fadeOut();
    }
});

$('.scrollup').click(function () {
    $("html, body").animate({
        scrollTop: 0
    }, 600);
    return false;
});
/* WORK IN PROGRESS
   NAVIGATION ACTIVE STATE IN SECTION AREA
*/
var sections = $('section'), nav = $('nav'), nav_height = nav.outerHeight();

$(window).on('scroll', function () {
  var cur_pos = $(this).scrollTop();

  sections.each(function() {
    var top = $(this).offset().top - nav_height,
        bottom = top + $(this).outerHeight();

    if (cur_pos >= top && cur_pos <= bottom) {
      nav.find('a').removeClass('active');
      sections.removeClass('active');

      $(this).addClass('active');
      nav.find('a[href="#'+$(this).attr('id')+'"]').addClass('active');
    }
  });
});

function captchaCode() {
  var Numb1, Numb2, Numb3, Numb4, Code;
  Numb1 = (Math.ceil(Math.random() * 10)-1).toString();
  Numb2 = (Math.ceil(Math.random() * 10)-1).toString();
  Numb3 = (Math.ceil(Math.random() * 10)-1).toString();
  Numb4 = (Math.ceil(Math.random() * 10)-1).toString();

  Code = Numb1 + Numb2 + Numb3 + Numb4;
  $("#captcha span").remove();
  $("#captcha input").remove();
  $("#captcha").append("<span id='code'>" + Code + "</span><input type='button' onclick='captchaCode();'>");
}



///blog showing

$(function(){
  $(".show-item").hide();
  $(".item").click(function(){
	$('.back-end').removeClass("active-show");
	$('.back-end', this).addClass("active-show");
	$(".show-item .single").addClass("show-single");
	$(".show-item .single").html($(".active-show").html());
    $(".show-item").fadeIn(600);
    $(".show-item-close").addClass("show-close");
    $("html,body").addClass("overflow");
  })
  $(".show-item-close").click(function(){
    $(".show-item").fadeOut(600);
    $(".show-item-close").removeClass("show-close");
	$(".show-item .single").removeClass("show-single");
    $("html,body").removeClass("overflow");
  })
  $(".show-item-back-top").click(function(){
		$(".show-item").animate({
			scrollTop: 0
		}, 1000)
	})
})
