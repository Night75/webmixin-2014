/**
 * Inspired by hovers.js v1.0.0 0 -> http://www.codrops.com
 */
(function() {

    var debug = false;

    function extend( a, b ) {
        for( var key in b ) {
            if( b.hasOwnProperty( key ) ) {
                a[key] = b[key];
            }
        }
        return a;
    }

    function logDebug(message)
    {
        if (debug) {
            console.debug(message);
        }
    }

    function SVGHoverEffect( options, enableDebug ) {
        this.options = extend( {}, this.options );
        extend( this.options, options );
        debug = enableDebug;

        var self = this;
        this.elements = [].slice.call ( document.querySelectorAll(self.options.svgWrapperSelector) );
        logDebug(this.elements);
        this._init();
    }

    SVGHoverEffect.prototype.options = {
        svgWrapperSelector: '.svg-hover-wrapper > a',
        speed : 250,
        easing : mina.easeinout
    }

    SVGHoverEffect.prototype._init = function() {
        var speed = this.options.speed,
            easing = this.options.easing;
        logDebug('_init');

        this.elements.forEach( function( el ) {
            logDebug(el);

            [].slice.call ( el.querySelectorAll('svg[data-path-to]') ).forEach( function( svg ) {
                logDebug(svg);

                var s = Snap( svg ), path = s.select( 'path' ),
                    pathConfig = {
                        from : path.attr( 'd' ),
                        to : svg.getAttribute( 'data-path-to' )
                    };

                el.addEventListener( 'mouseenter', function() {
                    path.animate( { 'path' : pathConfig.to }, speed, easing );
                } );

                el.addEventListener( 'mouseleave', function() {
                    path.animate( { 'path' : pathConfig.from }, speed, easing );
                } );
            });

        } );
    }

    // add to global namespace
    window.SVGHoverEffect = SVGHoverEffect;

})();