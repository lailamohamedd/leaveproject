$(function(){
    'use strict';
 // show delete button on child cats
 $('.child-link').hover(function (){
    $(this).find('.show-delete').fadeIn(400);
}, function () {
    $(this).find('.show-delete').fadeOut(400);
});
    //Hide Placeholder On Form Focus
    $('[placeholder]').focus(function(){
        $(this).attr('data-text', $(this).attr('placeholder'));
        $(this).attr('placeholder', '');
    }).blur(function(){
        $(this).attr('placeholder', $(this).attr('data-text'));
    });


    // dashboard 
	$('.toggle-info').click(function(){
		$(this).toggleClass('selected').parent().next('.panel-body').fadeToggle(100);
		if($(this).hasClass('selected')){
			$(this).html('<i class="fa fa-minus fa-lg"></i>');
		}else{
			$(this).html('<i class="fa fa-plus fa-lg"></i>');
		}
	});
	
	//Convert Password Field To Text Field On Hover
    var passField = $('.password');
    $('.show-pass').hover(function(){
        passField.attr('type', 'text');
    }, function(){
        passField.attr('type', 'password');
    });
	
///////////////////////////////////////////////////////////
    // Confirmation Message On Botton
    $('.confirm').click(function () {
        return confirm('Are You Sure?');
    });
    
    // Category View Option
    $('.cat h3').click(function () {
        $(this).next('.full-view').fadeToggle(200);
    });
    $(".option span").click(function(){
        $(this).addClass("active").siblings("span").removeClass("active");
        if($(this).data('view') === 'full'){
            $('.cat .full-view').fadeIn(200);
        }else{
            $('.cat .full-view').fadeOut(200);
        }
    });
    /*fittext*/

    $(".our-head").fitText();	 

   
});

$(document).ready(function(){
	$('[data-toggle="tooltip"]').tooltip();
	// Animate select box length
	var searchInput = $(".search-box input");
	var inputGroup = $(".search-box .input-group");
	var boxWidth = inputGroup.width();
	searchInput.focus(function(){
		inputGroup.animate({
			width: "300"
		});
	}).blur(function(){
		inputGroup.animate({
			width: boxWidth
		});
	});
});
$(function () {
    'use strict';
    $('.toggle-sidebar').on('click', function () {
        $('.content-area, .sidebar').toggleClass("no-sidebar");
    });
    //toggle submenu
    $(".toggle-submenu").on("click", function () {
        $(this)
            .find(".fa-angle-right")
            .toggleClass("down");
        $(this)
            .next(".child-links")
            .slideToggle();
    });
    // open / close fullscreen
    $(".toggle-fullscreen").on("click", function(){
        $(this).toggleClass("full-screen");
        if ($(this).hasClass('full-screen')){ //page is now full screen
            openFullscreen();
        } else {
            closeFullscreen();
        }
    });
    // toggle settings
    $(".toggle-settings").on("click", function () {
        $(this)
            .find("i")
            .toggleClass("fa-spin");
        $(this)
            .parent()
            .toggleClass("hide-settings");
    });
    
});
var elem = document.documentElement;

function openFullscreen(){
    if (elem.requestFullscreen){
        elem.requestFullscreen();
    } else if (elem.mozRequestFullScreen){
        /* firefox */
        elem.mozRequestFullScreen();
    } else if (elem.webkitRequestFullscreen){
        /* chrome, safari and opera */
        elem.webkitRequestFullscreen();
    } else if (elem.msRequestFullscreen){
        /* IE/Edge */
        elem.msRequestFullscreen();
    }
}   
function closeFullscreen(){
    if (document.exitFullscreen) {
        document.exitFullscreen();
    } else if (document.mozCancelFullScreen){
        /* firefox */
        document.mozCancelFullScreen();
    } else if (document.webkitExistFullscreen){
         /* chrome, safari and opera */
        document.webkitExistFullscreen();
    } else if (document.msExistFullscreen) {
        /* IE/Edge */
        document.msExistFullscreen();
    }
}   

const myMap = new Map();
const mySet = new Set();



        $(document).ready(function () {
            $('#records-limit').change(function () {
                $('form').submit();
            })
        });




$(document).ready(function(){
  $("#myInput").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#myDIV *").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});

