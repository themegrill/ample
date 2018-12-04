jQuery(document).ready(function(){

   // For Search Icon Toggle effect added at the top
   jQuery('.search-top').click(function(){
      jQuery('#masthead .search-form-top').toggleClass( 'show' );

	   // focus after some time to fix conflict with toggleClass.
	   setTimeout(  function(){
		   jQuery( '#masthead .search-form-top.show input' ).focus();
	   }, 200 );
   });

   // For Scroll to top button
   jQuery('#scroll-up').hide();
   jQuery(function () {
      jQuery(window).scroll(function () {
         if (jQuery(this).scrollTop() > 1000) {
            jQuery('#scroll-up').fadeIn();
         } else {
            jQuery('#scroll-up').fadeOut();
         }
      });
      jQuery('a#scroll-up').click(function () {
         jQuery('body,html').animate({
            scrollTop: 0
         }, 800);
         return false;
      });
   });

});
