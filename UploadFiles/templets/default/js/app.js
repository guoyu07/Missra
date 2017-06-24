/*
 * Template Name: Missra
 * Version: 1.0
 * Author: chzng
 * Website: http://www.missra.com
 */

var App = function () {

    //Toggle
    function handleToggle() {
        jQuery('.list-toggle').on('click', function () {
            jQuery(this).toggleClass('active');
        });
    }
    
    //handleSearch (Header)
    function handleSearch() {
        $( '.search-toggle' ).on( 'click', function( event ) {
            var that    = $( this ),
                icon    = $( '.search-icon' ),
                wrapper = $( '#searchBox' ),
                container = that.find( 'a' );

            that.toggleClass( 'active' );
            wrapper.toggleClass( 'hide' );

            if(icon.hasClass('uk-icon-search')){
            	icon.removeClass('uk-icon-search');
            	icon.addClass('uk-icon-remove');
            } else {
            	icon.addClass('uk-icon-search');
            	icon.removeClass('uk-icon-remove');
            }

            if ( that.hasClass( 'active' ) ) {
                container.attr( 'aria-expanded', 'true' );
            } else {
                container.attr( 'aria-expanded', 'false' );
            }

            if ( that.is( '.active' ) || $( '.search-toggle .search-btn-text' )[0] === event.target ) {
                wrapper.find( '.search-keyword' ).focus();
            }
        } );
    }

    return {
        init: function () {
            handleToggle();
            handleSearch();
        }
    };

}();
