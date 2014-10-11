/**
 * Svg Path draw
 * Some css code will be generated for the element managed by the plugin.
 * To achieve this, a selector for the element will be define, many options
 * are available for this.
 */
;( function( $, window, undefined ) {

    ///////////////////////////////////////////////
    // ======== Object/Class definition ======== //
    ///////////////////////////////////////////////

    $.svgPathDraw = function(options, debug, element) {
        this.pluginName = 'svgPathDraw';
        this.$el = $(element);
        this.debug = debug;
        this._init(options);
    };

    // Deindiault options
    $.svgPathDraw.defaults = {
        // The class that will be used for launching the animation
        animationClass: 'animate',
        chainAnimations: true,
        // Array of item options here, The options for an item should be define
        // in a object with the following properties:
        // - cssSelector : The selector of the item
        // - duration: The duration of the animation
        // - easing (optional -> default to linear)
        // - delay (optional -> default to 0)
        items: [],
        cssSelector: null,
        duration: null,
        easing: 'linear',
        delay: 0
    }

    $.svgPathDraw.prototype._init  = function( options )
    {
        this._logDebug('_init', 'Start');
        // options
        this.options = $.extend( true, {}, $.svgPathDraw.defaults, options);
        // cache some elements and initialize some variables
        this._config();
        // Init events
        this._initEvents();
    }

    $.svgPathDraw.prototype._config  = function()
    {
        this._logDebug('_config', 'Configure items:', this.options.items);

        if (this.$el.prop('tagName').toUpperCase() != 'SVG') {
            this._logError('_config', 'The element must be an "SVG", not a "' + this.$el.prop('tagName') +'"');
            return;
        }
        this.$items = [];
        this._configItems();    // Populate the $items property

        this._dumpAnimationCode();
    }

    $.svgPathDraw.prototype._configItems = function()
    {
        var self = this;

        var defaultItemOption = {
            easing: self.options.easing,
            delay: self.options.delay
        };

        var previousDelay = 0;
        for (var k in this.options.items) {
            var $item = $.extend( true, {}, defaultItemOption, this.options.items[k]);

            // === Mandatory options parameters validation
            if ($item['cssSelector'] == null) {
                this._logError('_configItems', 'Missing "cssSelector" key for the item', $item);
                return;
            }
            if ($item['duration'] == null) {
                this._logError('_configItems', 'Missing "duration" key for the item', $item);
                return;
            }

            // Unique item identifier
            var $itemEl = this.$el.find($item['cssSelector']);
            if ($itemEl.attr('id') == '' || $itemEl.attr('id') == undefined) {
                $item['id'] = 'svgline-' + k + '-' + this._generateId();
                $itemEl.attr('id', $item['id']);
                this._logDebug('_configItems', 'Added id on item :', $itemEl);
            }

            // jQuery element
            $item['item'] = this.$el.find($item['cssSelector']);
            // Stroke length
            $item['length'] = $item['item'][0].getTotalLength();

            // Delay
            if (this.options.chainAnimations) {
                var itemDelay = $item['delay'];
                $item['delay'] = previousDelay + parseFloat(itemDelay) + 's';
                previousDelay += parseFloat($item['duration']) + parseFloat(itemDelay);
            }

            this.$items.push($item);
            this._logDebug('_configItems', 'Item added :', $item);
        }

        this._logDebug('_configItems', 'Items configured:', this.$items);
    }

    $.svgPathDraw.prototype._dumpAnimationCode = function()
    {
        this._logDebug('_dumpAnimationCode', 'Start');

        var cssCode = '<style type="text/css" scoped>';
        for (var k in this.$items) {
            var $item = this.$items[k];
            cssCode += this._getItemCSSAnimCode($item);
        }
        cssCode += '</style>';

        this.$el.prepend(cssCode);
        this._logDebug('_dumpAnimationCode', 'Code inserted', cssCode);
    }

    $.svgPathDraw.prototype._getItemCSSAnimCode = function($item)
    {
        // KeyFrame property
        var keyFrameProps = '{';
        keyFrameProps += 'from { stroke-dashoffset: ' + $item['length'] + '; }';
        keyFrameProps += 'to { stroke-dashoffset: 0; }';
        keyFrameProps += '}';
        // KeyFrames
        var keyFrame = '@keyframes ' + $item['id'] + keyFrameProps;
        keyFrame += '@-webkit-keyframes ' + $item['id'] + keyFrameProps;

        // Item styles
        var itemStyle = '#' + $item['id'];
        itemStyle += '{';
        itemStyle += 'stroke-dasharray: ' + $item['length'] + ';';
        itemStyle += 'stroke-dashoffset: ' + $item['length'] + ';';
        itemStyle += '}';

        // Animation
        var animStyle = '#' + $item['id'] + '.' + this.options.animationClass;
        animStyle += '{';
        animStyle += 'animation: ' + $item['id'] + ' ' + $item['duration'] + ' ' + $item['easing'] + ' ' + $item['delay'] + ' forwards;';
        animStyle += '-webkit-animation: ' + $item['id'] + ' ' + $item['duration'] + ' ' + $item['easing'] + ' ' + $item['delay'] + ' forwards;';
        animStyle += '}';

        var code = keyFrame + itemStyle + animStyle;

        this._logDebug('_getItemCSSAnimCode', 'Code generated:', code);
        return code;
    }

    $.svgPathDraw.prototype.draw = function()
    {
        this._logDebug('draw', 'Start');

        // === Case of restart
        for (var k in this.$items) {
            var $item = this.$items[k]['item'];
            var itemClass = ($item.attr('class') == undefined) ? '' : $item.attr('class') + ' ';
            $item.attr('class', itemClass + this.options.animationClass);
        }
    }

    $.svgPathDraw.prototype.clear = function()
    {
        this._logDebug('clear', 'Start');
        for (var k in this.$items) {
            var $item = this.$items[k]['item'];
            var itemClass = $item.attr('class');

            if (itemClass) {
                itemClass = itemClass.replace(this.options.animationClass, ''); // Remove the 'animation' class
                $item.attr('class', itemClass);
            }
        }
    }

    $.svgPathDraw.prototype._initEvents = function()
    {
        var self = this;
        this._logDebug('_initEvents', 'start');

        var $lastItem = this.$items[this.$items.length - 1]['item'];
        var endAnimTrigger = function() {
            self._trigger(self.$el, 'drawEnd');
        }

        $lastItem.on('animationend', endAnimTrigger);
        $lastItem.on('webkitAnimationEnd', endAnimTrigger);

        this.$el.on('drawEnd.svgPathDraw',  $.proxy( self._animEndCallback, self));
    }


    $.svgPathDraw.prototype._animEndCallback = function()
    {
        this._logDebug('_animEndCallback', 'start');
        // Does nothing
    }

    $.svgPathDraw.prototype._generateId = function()
    {
        this._logDebug('generateId', 'Start');
        var uid = Math.floor((Math.random() * 10000)) + Math.floor((Math.random() * 10000)) + Math.floor((Math.random() * 10000));
        this._logDebug('generateId', 'Generated :', uid);
        return uid;
    }
    function cuniq() {

    }

    /**
     * Trigger an event on a element
     *
     * @param Object Element
     * @param string eventName
     * @param boolean removeSuffix
     * @param mixed data
     */
    $.svgPathDraw.prototype._trigger = function($element, eventName, data, removeSuffix)
    {
        if (removeSuffix != true) {
            eventName += '.' + this.pluginName;
        }

        this._logDebug('_trigger', 'Trigger "' + eventName + '" event from element:', $element);

        if (data != undefined) {
            this._logDebug('_trigger', 'With data', data);
        }

        $element.trigger(eventName, data);
    }

    /**
     * Log a message the console intended to debug the execution of the script.
     *
     * @param string method Method from where the _logDebug method has been called
     * @param string message Message to log
     * @param mixed  objectToLog Object to log (optionnal)
     */
    $.svgPathDraw.prototype._logDebug = function(method, message, objectToLog)
    {
        // TEMPORARY CODE for debugging on smartphones/tablets
        if (window.location.href.indexOf('hard-debug') != -1 && this.debug) {
            message = "DEBUG - " + this.pluginName + " - " + method + ": " + message;
            if (objectToLog != undefined) {
                if (objectToLog[0] instanceof HTMLElement){
                    var serializer = new XMLSerializer();
                    message += serializer.serializeToString(objectToLog[0]);
                }
            }
            message = '<p class="debug-log">' + message + "</p>";
            $('footer').append(message);
            return;
        }

        if (window.console && this.debug) {
            message = "DEBUG - " + this.pluginName + " - " + method + ": " + message;
            if (objectToLog != undefined) {
                window.console.debug(message, objectToLog);
            } else {
                window.console.debug(message);
            }
        }
    }

    /**
     * Log an error message the console
     *
     * @param string method Method from where the _logError method has been called
     * @param string message Message to log
     * @param mixed  objectToLog Object to log (optionnal)
     *
     * @return boolean true if the value exists. false otherwise
     */
    $.svgPathDraw.prototype._logError = function(method, message, objectToLog)
    {
        if (window.console && this.debug) {
            message = "ERROR - " + this.pluginName + " - " + method + ": " + message;
            if (objectToLog != undefined) {
                window.console.error(message, objectToLog);
            } else {
                window.console.error(message);
            }
        }
    }

    ///////////////////////////////////////////////////////
    // ======== jQuery plugin related functions ======== //
    ///////////////////////////////////////////////////////

    $.fn.svgPathDraw = function(options, debug) {
        if (typeof options === 'string' ) {
            var args = Array.prototype.slice.call(arguments, 1);
            this.each(function() {
                var instance = $.data(this, 'svgPathDraw');
                if (!instance) {
                    window.console.error( "cannot call methods on " + 'svgPathDraw' + " prior to initialization; " +
                    "attempted to call method '" + options + "'" );
                    return;
                }
                // Public method call handler
                if ( !$.isFunction(instance[options]) || options.charAt(0) === "_" ) {
                    window.console.error( "no such method '" + options + "' for svgPathDraw instance" );
                    return;
                }
                instance[options].apply(instance, args);
            });
        }
        else {
            this.each(function() {

                var instance = $.data(this, 'svgPathDraw');
                if (instance) {
                    instance._init();
                }
                else {
                    instance = $.data(this, 'svgPathDraw', new $.svgPathDraw(options, debug, this));
                }
            });
        }
        return this;
    };

} )(jQuery, window);