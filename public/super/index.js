$(document).ready(function () {
    var trigger = $('.hamburger'),
        overlay = $('.overlay'),
        menu = $('#sidebar-wrapper'),
        closing = $('.admin-1'),
       isClosed = false;

  
  

       overlay.show();
          // trigger.removeClass('is-closed');
          // trigger.addClass('is-open');
          menu.css("left", "250px");

            
      
      function hamburger_crossty(){
        if (isClosed == true){
          // overlay.show();
          // // trigger.removeClass('is-closed');
          // // trigger.addClass('is-open');
          // menu.css("left", "250px");
          // isClosed = false;
        }else{
          overlay.hide();
        // trigger.removeClass('is-open');
        // trigger.addClass('is-closed');
        menu.css("left", "0px");
        isClosed = true;
        $('#wrapper').toggleClass('toggled');
        }
        $(".panel-collapse").not($(this).next()).slideUp(400);
        
      }

      trigger.click(function () {
        hamburger_cross();      
      });
  
      function hamburger_cross() {
  
        if (isClosed == true) {          
          overlay.show();
          // trigger.removeClass('is-closed');
          // trigger.addClass('is-open');
          menu.css("left", "250px");
          isClosed = false;
        } else {   
          overlay.hide();
          // trigger.removeClass('is-open');
          // trigger.addClass('is-closed');
          menu.css("left", "0px");
          isClosed = true;
        }
    }
    


    $('[data-toggle="offcanvas"]').click(function () {
          $('#wrapper').toggleClass('toggled');
    });  
  });

  $(document).ready(function() {
    $(".panel-collapse").fadeOut(0);
    $(".panel-heading").click(function() {
      $(".panel-collapse").not($(this).next()).slideUp(400);
      $(this).next().slideToggle(400);
    });
});




$(function() {
  $(".dropdown").click(function() {
     // remove classes from all
     $(".dropdown").removeClass("active");
     // add class to the one we clicked
     $(this).addClass("active");
  });
});
