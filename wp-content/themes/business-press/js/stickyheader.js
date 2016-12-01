( function( $ ) {
	$(document).ready(function() {
		
		if( $(window).width() > 943 )
		{
			var placeholder = document.createElement('div');
			placeholder.setAttribute("id", "headerplaceholder");
			placeholder.style.width = $('#header').width() + 'px';
			placeholder.style.height = $('#header').height() + 'px';
			
			
			var h = $('#header').offset().top;
			//for default menu sticky
			$(window).scroll(function () {
				
				if( $(this).scrollTop() > h )
				{
					$('#header').addClass('header_sticky');
					$('#navbar').addClass('navbar_sticky');
					$('#logoastext').addClass('logoastext_sticky');
					$('#logoasimg .custom-logo').addClass('logoasimg_sticky');
					$('#header').after(placeholder);
					$('#headerplaceholder').css('display','block');
				}
				else
				{
					$('#header').removeClass('header_sticky');
					$('#navbar').removeClass('navbar_sticky');
					$('#logoastext').removeClass('logoastext_sticky');
					$('#logoasimg .custom-logo').removeClass('logoasimg_sticky');
					$('#headerplaceholder').css('display','none');
				}
				
			});
			//for default menu sticky END

		}
	});
})( jQuery );
