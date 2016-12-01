// skip link focus -fix
( function() {
	var is_webkit = navigator.userAgent.toLowerCase().indexOf( 'webkit' ) > -1,
	    is_opera  = navigator.userAgent.toLowerCase().indexOf( 'opera' )  > -1,
	    is_ie     = navigator.userAgent.toLowerCase().indexOf( 'msie' )   > -1;

	if ( ( is_webkit || is_opera || is_ie ) && document.getElementById && window.addEventListener ) {
		window.addEventListener( 'hashchange', function() {
			var id = location.hash.substring( 1 ),
				element;

			if ( ! ( /^[A-z0-9_-]+$/.test( id ) ) ) {
				return;
			}

			element = document.getElementById( id );

			if ( element ) {
				if ( ! ( /^(?:a|select|input|button|textarea)$/i.test( element.tagName ) ) ) {
					element.tabIndex = -1;
				}

				element.focus();
			}
		}, false );
	}
})();

jQuery(document).ready(function($){
		
 //Menu
  $('#menu > ul').superfish({ 
	  delay:       1000,                           
	  animation:   {opacity:'show', height:'show'}, 
	  speed:       'fast',                          
	  autoArrows:  true
  
  });
  
      // responsive menu
  if( $('header nav > ul').length )
  $('header nav,#navigation nav').meanmenu();
  
  
  $('.widget-box ul li').each(function(){
		  if($(this).find('ul').length){
			  $(this).addClass('item-has-children');
			  }					 
   });
  
  if(!$('.mean-bar').length){
  $('.hero_content').css({'height':$('.hero_content').parents('section').height()});
  $('.bottom-image').css({'height':$('.bottom-image').parents('section').height()});
  }
  
  // 
  
	
 });


