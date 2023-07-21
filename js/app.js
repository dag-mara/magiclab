(function($) {
	'use strict';


   //show hidden form in jobs advertisement section 
  /*  $('.showform').click(
    function(){
        $('#gform_1').show();
    }
   ) */
   
   //show hidden form in jobs advertisement section in case or validation error
  /*  $('#gform_1_validation_container').click(
    function(){
        $('#gform_1').show();
    }
   )*/

   $('.menu-icon-search').click(
    function(event){
        event.preventDefault();
        $('.search-form-wrapper').addClass('visible');
        $('.top-bar ul.title-area').css('z-index', '3');

        if ($('.hw-acc:not(.sticky-top)').length !== 0){
            var y = $(window).scrollTop();
            $(window).scrollTop(y+90);
        }
        
    }
   )

   $('.close-searchform').click(
    function(){
        $('.search-form-wrapper').removeClass('visible');
        $('.top-bar ul.title-area').css('z-index', '5');
    }
   )

  /*  $(".tax-location #s").attr("placeholder", 'Find work by client, type, year'); */
  

})(jQuery, this);