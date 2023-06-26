$(function() {
    $(window).on("scroll", function() {
        if ($(window).scrollTop() > 0) {
            $(".header").addClass("header_top");
        } else {
            $(".header").removeClass("header_top");
        }
    });
});

// $(function() {
//     $(window).on("scroll", function() {
//         if ($(window).scrollTop() > 580) {
//             $(".fixedSearchform").addClass("fixedContainer");
//         } else {
//             $(".fixedSearchform").removeClass("fixedContainer");
//         }
//     });
// });
// $("#onboardingMenu").click(function() {
//     if ($(".dropdown-menu").hasClass("show")) {
//         return $("body").removeClass("no-scroll");
//     } else {
//         return $("body").addClass("no-scroll");
//     }
// });

$(document).ready(function() {
    $(".openSidebar-btn").click(function() {
        $(".left-sidebar-main").addClass("active");
        $("body").addClass("bodyActive");
    });
    $(".closeSidebar-btn").click(function() {
        $(".left-sidebar-main").removeClass("active");
        $("body").removeClass("bodyActive");
    });
});

// Datetimeepicker

// $('.timepicker').datetimepicker({
//   format: 'HH:mm',
//   icons: {
//       time: "fa fa-clock-o",
//       date: "fa fa-calendar",
//       up: "fa fa-arrow-up",
//       down: "fa fa-arrow-down"
//   }
// });

$(function() {
    $('.datepicker').datepicker({
        format: "yyyy-mm-dd ",
        autoclose: true,
       // minDate: '0d' // minDate: '0' would work too
    });
});

// Home banner slider
$('.homebannerslider').slick({
    dots: true,
    infinite: true,
    speed: 500,
    fade: true,
    arrows: false,
    autoplay: true,
    cssEase: 'linear'
});


$('.editorPickslider').slick({
    dots: false,
    infinite: false,
    speed: 300,
    slidesToShow: 3,
    slidesToScroll: 1,
    responsive: [{
            breakpoint: 1024,
            settings: {
                slidesToShow: 2,
                slidesToScroll: 1,
                infinite: true,
            }
        },
        {
            breakpoint: 600,
            settings: {
                slidesToShow: 2,
                slidesToScroll: 2
            }
        },
        {
            breakpoint: 480,
            settings: {
                slidesToShow: 1,
                slidesToScroll: 1
            }
        }
    ]
});
// Explore Magazine
$('.exploreMagazineSlider').slick({
    dots: true,
    infinite: false,
    speed: 300,
    slidesToShow: 3,
    slidesToScroll: 1,
    arrows: false,
    responsive: [{
            breakpoint: 1024,
            settings: {
                slidesToShow: 2,
                slidesToScroll: 1,
                infinite: true,
            }
        },
        {
            breakpoint: 600,
            settings: {
                slidesToShow: 1,
                slidesToScroll: 2
            }
        },
        {
            breakpoint: 480,
            settings: {
                slidesToShow: 1,
                slidesToScroll: 1
            }
        }
    ]
});
// Hotel Event
$('.hotelEventSlider').slick({
    dots: false,
    infinite: false,
    speed: 300,
    slidesToShow: 4,
    slidesToScroll: 1,
    arrows: true,
    responsive: [{
            breakpoint: 1024,
            settings: {
                slidesToShow: 2,
                slidesToScroll: 1,
                infinite: true,
            }
        },
        {
            breakpoint: 600,
            settings: {
                slidesToShow: 2,
                slidesToScroll: 2
            }
        },
        {
            breakpoint: 480,
            settings: {
                slidesToShow: 1,
                slidesToScroll: 1
            }
        }
    ]
});

// Hotel detail slider
$('.hotelDetilSlider').slick({
    dots: false,
    infinite: false,
    speed: 300,
    slidesToShow: 1,
    slidesToScroll: 1,
    arrows: true,
    autoplay: true,
});
$('.roomtypesliderbox').slick({
    dots: false,
    infinite: true,
    speed: 300,
    slidesToShow: 1,
    slidesToScroll: 1,
    arrows: true,
    autoplay: false,
});
$('.hotelsliderbox').slick({
    dots: false,
    infinite: true,
    speed: 300,
    slidesToShow: 1,
    slidesToScroll: 1,
    arrows: true,
    autoplay: false,
});
// plus-minus counts
$(document).ready(function() {
	$(document).on('click','.minus',function(){
    //~ $('.minus').click(function() {
        var $input = $(this).parent().find('input');
        var count = parseInt($input.val()) - 1;
        count = count < 1 ? 1 : count;
        $input.val(count);
        $input.change();
        return false;
    });
    $(document).on('click','.plus',function(){
    //~ $('.plus').click(function() {
        var $input = $(this).parent().find('input');
        $input.val(parseInt($input.val()) + 1);
        $input.change();
        return false;
    });

    $(document).on('click','.minusMinZero',function(){
        //~ $('.minus').click(function() {
            var $input = $(this).parent().find('input');
            var count = parseInt($input.val()) - 1;
            count = count <= 0 ? 0 : count;
            $input.val(count);
            $input.change();
            return false;
        });
});

// Banner guest dropdown

$('.guestdropdownBtn').click(function() {
    $(".guestdropdown").toggleClass("active");
    $("body").toggleClass("bodyscroll");
});

/*
function expandTextarea(id) {
    document.getElementById(id).addEventListener('keyup', function() {
        this.style.overflow = 'hidden';
        this.style.height = 0;
        this.style.height = this.scrollHeight + 'px';
    }, false);
}

expandTextarea('txtarea');
*/ 

// $(document).click(function(e) {
//     if (!$(e.target).hasClass("guestdropdownBtn") &&
//         $(e.target).parents(".guestdropdown").length === 0) {
//         $(".guestdropdown").removeClass();
//     }
// });
