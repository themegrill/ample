/**
 * navigation.js
 *
 * Handles toggling the navigation menu for small screens.
 */
( function() {
	var container, button, menu;

	container = document.getElementById( 'site-navigation' );
	if ( ! container ) {
		return;
	}

	button = container.getElementsByClassName( 'menu-toggle' )[0];
	if ( 'undefined' === typeof button ) {
		return;
	}

	menu = container.getElementsByTagName( 'ul' )[0];

	// Hide menu toggle button if menu is empty and return early.
	if ( 'undefined' === typeof menu ) {
		button.style.display = 'none';
		return;
	}

	if ( -1 === menu.className.indexOf( 'menu-primary-container' ) ) {
		menu.className += 'menu-primary-container';
	}

	button.onclick = function() {
		if ( -1 !== container.className.indexOf( 'main-small-navigation' ) ) {
			container.className = container.className.replace( 'main-small-navigation', 'main-navigation' );
		} else {
			container.className = container.className.replace( 'main-navigation', 'main-small-navigation' );
		}
	};
} )();
jQuery(document).ready(function() {
    jQuery('.better-responsive-menu #site-navigation .menu-item-has-children').append('<span class="sub-toggle"> <i class="fa fa-caret-down"></i> </span>');
    jQuery('.better-responsive-menu #site-navigation .sub-toggle').click(function() {
        jQuery(this).parent('.menu-item-has-children').children('ul.sub-menu').first().slideToggle('1000');
        jQuery(this).children('<i class="fa fa-caret-down"></i>').first().toggleClass('<i class="fa fa-caret-down"></i>');
        jQuery(this).toggleClass('active');
    });
});

jQuery(document).on('click', '#site-navigation .menu li.menu-item-has-children > a', function(event) {
    menuClass = jQuery(this).parent('.menu-item-has-children');
    console.log('clicked');
    if (! menuClass.hasClass('focus')){
        menuClass.addClass('focus');
        event.preventDefault();
        menuClass.children('.sub-menu').css({
           'display': 'block'
        });
    }
  });