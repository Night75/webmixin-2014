/**
 * Dependencies :
 */
;( function() {

    function extend( a, b )
    {
        for( var key in b ) {
            if( b.hasOwnProperty( key ) ) {
                a[key] = b[key];
            }
        }
        return a;
    }

    function svgDrawLoader(options, debug)
    {
        this.options = extend( {}, this.options );
        this.debug = debug;
        extend( this.options, options )
        this._init();
    }

    svgDrawLoader.prototype.options =
    {
        itemSelector: '',
        svgLoader: '<svg version="1.1" class="text-loader" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"viewBox="-1.4 340.9 598.2 160.3" enable-background="new -1.4 340.9 598.2 160.3" xml:space="preserve" preserveAspectRatio="none"><path stroke-miterlimit="10" d="M33.5,498.5L33.5,498.5c-18,0-32.4-14.4-32.4-32.4v-90.3c0-17.8,14.4-32.4,32.4-32.4H562c17.8,0,32.4,14.4,32.4,32.4v90.5c0,17.8-14.4,32.4-32.4,32.4H33.1"/></svg>',
        // Css properties that will be automatically set to the svg
        cssProperties: {'height': false, 'width': true},
        svgPathDrawOptions: {
            items: [{cssSelector: 'path', duration: '1s'}]
        },
        hideClass: 'hide'
    }

    svgDrawLoader.prototype._init = function()
    {
        this._logDebug('_init', 'Start. Options defined', this.options);
        this._config();

        this._initEvents();
    }

    svgDrawLoader.prototype._config = function()
    {
        var self = this;
        this.item = document.querySelector(this.options.itemSelector);
        this._logDebug('_config', 'Items: ', this.item);

        this._insertSvgLoader();

        for (var prop in this.options.cssProperties) {
            if (this.options.cssProperties[prop] == false) {
                continue;
            }
            var propValue = window.getComputedStyle(this.item).getPropertyValue(prop);
            this.loader.style.setProperty(prop, propValue);
            this._logDebug('_config', 'Property "' + prop + '" set to :"' + propValue + '"');
        }

        this.svgPathDraw = $(this.loader).svgPathDraw(self.options.svgPathDrawOptions, self.debug);
        this._hideItem();
    }

    svgDrawLoader.prototype._insertSvgLoader = function()
    {
        this._logDebug('_insertSvgLoader', 'Start');
        var temp = document.createElement('div');
        temp.innerHTML = this.options.svgLoader;
        this.loader = temp.childNodes[0];

        var container = this.item.parentElement;
        container.insertBefore(this.loader, this.item);

        this._logDebug('_insertSvgLoader', 'Inserted svg loader: ', this.loader);
    }

    svgDrawLoader.prototype._hideItem = function()
    {
        classie.addClass(this.item, this.options.hideClass);
        this.item.style.position = 'absolute';
        this._logDebug('_hideItem', 'Hide item :', this.item);
    }

    svgDrawLoader.prototype.show = function()
    {
        var self = this;
        this._logDebug('_hideItem', 'Show start');

        var onEndDraw = function() {
            self.loader.style.opacity = 0;
            self.loader.style.position = 'absolute';
            self.item.style.position = 'relative';
            classie.removeClass(self.item, self.options.hideClass);
        }

        this.loader.addEventListener('animationend', onEndDraw );
        this.loader.addEventListener('webkitAnimationEnd', onEndDraw);

        this.svgPathDraw.svgPathDraw('draw');
    }

    svgDrawLoader.prototype.reset = function()
    {
        var self = this;
        this._logDebug('reset', 'Reset start');
        this.svgPathDraw.svgPathDraw('clear');
        self.loader.style.opacity = 1;
        self.loader.style.position = 'relative';
        this._hideItem();

        this._logDebug('reset', 'Reset done');
    }

    svgDrawLoader.prototype._initEvents = function()
    {
        this._logDebug('_initEvents', 'Start');
        var self = this;
    }

    svgDrawLoader.prototype._logDebug = function(method, message, objectToLog)
    {
        if (window.console && this.debug) {
            message = "DEBUG - " + this.constructor.name + " - " + method + ": " + message;
            if (objectToLog != undefined) {
                window.console.debug(message, objectToLog);
            } else {
                window.console.debug(message);
            }
        }
    }


    window.svgDrawLoader = svgDrawLoader;
})();