jQuery( document ).ready( function () {

	// For Search Icon Toggle effect added at the top
	var hideSearchForm = function () {
		jQuery( '#masthead .search-form-top' ).removeClass( 'show' );
	};

	// For Search Icon Toggle effect added at the top
	jQuery( '.search-top' ).click( function () {
		jQuery( '#masthead .search-form-top' ).toggleClass( 'show' );

		// focus after some time to fix conflict with toggleClass.
		setTimeout( function () {
			jQuery( '#masthead .search-form-top.show input' ).focus();
		}, 200 );

		// For esc key press.
		jQuery( document ).on( 'keyup', function ( e ) {

			//on esc key press.
			if ( 27 === e.keyCode ) {
				//if search box is opened.
				if ( jQuery( '.search-form-top' ).hasClass( 'show' ) ) {
					hideSearchForm();
				}
			}
		} );

		// For click out of search box.
		jQuery( document ).on( 'click.outEvent', function( e ){
			if ( e.target.closest('.search-form-top') || e.target.closest('.search-top') ) {
				return;
			}

			hideSearchForm();

			// Unbind current click event.
			jQuery( document ).off( 'click.outEvent' );
		} );

	} );

	// For Scroll to top button
	jQuery( '#scroll-up' ).hide();
	jQuery( function () {
		jQuery( window ).scroll( function () {
			if ( jQuery( this ).scrollTop() > 1000 ) {
				jQuery( '#scroll-up' ).fadeIn();
			} else {
				jQuery( '#scroll-up' ).fadeOut();
			}
		} );
		jQuery( 'a#scroll-up' ).click( function () {
			jQuery( 'body,html' ).animate( {
				scrollTop : 0
			}, 800 );
			return false;
		} );
	} );

	// For bx slider setting.
	if ( typeof jQuery.fn.bxSlider !== 'undefined' ) {
		jQuery( '.big-slider' ).bxSlider( {
			mode           : 'fade',
			speed          : 1500,
			auto           : true,
			pause          : 5000,
			adaptiveHeight : true,
			nextText       : '',
			prevText       : '',
			nextSelector   : '.slide-next',
			prevSelector   : '.slide-prev',
			pager          : false,
			autoHover      : true
		} );
	}

} );
