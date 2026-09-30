( function() {
    'use strict';

    function decorate() {
        document.querySelectorAll( '.entry-content pre.wp-block-code[title]' ).forEach( function( pre ) {
            if ( pre.querySelector( ':scope > .fw-code-title' ) ) return;
            const label = document.createElement( 'div' );
            label.className = 'fw-code-title';
            label.textContent = pre.getAttribute( 'title' ) || '';
            pre.insertBefore( label, pre.firstChild );
        } );
    }

    if ( document.readyState === 'loading' ) {
        document.addEventListener( 'DOMContentLoaded', decorate );
    } else {
        decorate();
    }
} )();
