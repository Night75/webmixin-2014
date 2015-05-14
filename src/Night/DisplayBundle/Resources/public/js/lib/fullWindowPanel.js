
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


    function FullWindowPanel(options, debug)
    {
        this.options = extend( {}, this.options );
        this.debug = debug;
        extend( this.options, options )
        this._init();
    }

    FullWindowPanel.prototype.options =
    {
        itemsSelector: [],
        keepCssMinHeight: true,
        keepCssMaxHeight: true
    }

    FullWindowPanel.prototype._init = function()
    {
        this._logDebug('_init', 'Start. Options defined', this.options);
        this._config();
        this.resize();
        this._initEvents();
    }

    FullWindowPanel.prototype._config = function()
    {
        this.items = [];

        var selectors = this.options.itemsSelector;
        for (var k in selectors) {
            var elements = [].slice.call(document.querySelectorAll(selectors[k]));
            this.items = this.items.concat(elements);
        }

        this._logDebug('_config', 'Items: ', this.items);
    }

    FullWindowPanel.prototype._initEvents = function()
    {
        this._logDebug('_initEvents', 'Start');
        var self = this;
        window.addEventListener('resize', function() {self.resize.apply(self); });
    }

    FullWindowPanel.prototype.resize = function()
    {
        this._logDebug('resize', 'start');
        for (var k in this.items) {
            this._logDebug('resize', 'Resize item: ', this.items[k]);
            var height = this.getAppropriateHeight(this.items[k]);
            this.items[k].style.height = height;
        }
        $(this).trigger('FullWindowPanel.resized');
    }

    FullWindowPanel.prototype.getAppropriateHeight = function(element)
    {
        // TODO: Verify that the styles are in px
        var styles = window.getComputedStyle(element);
        var maxHeight = this.options.keepCssMaxHeight ? styles.getPropertyValue('max-height') : null;
        var minHeight = this.options.keepCssMinHeight ? styles.getPropertyValue('min-height') : null;

        maxHeight = parseInt(maxHeight);
        minHeight = parseInt(minHeight);

        this._logDebug('getAppropriateHeight', 'Css Max height: "' + maxHeight + '" , Css Min height : "' + minHeight + '", Window height: "' + window.innerHeight + '"');

        if (maxHeight && window.innerHeight > maxHeight) {
            this._logDebug('getAppropriateHeight', 'Selected : Css Max height')
            return maxHeight;
        } else if (minHeight && window.innerHeight < minHeight) {
            this._logDebug('getAppropriateHeight', 'Selected : Css Min height')
            return minHeight;
        } else {
            this._logDebug('getAppropriateHeight', 'Selected : Window height')
            return window.innerHeight + 'px';
        }
    }

    FullWindowPanel.prototype._logDebug = function(method, message, objectToLog)
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

    window.FullWindowPanel = FullWindowPanel;
})();