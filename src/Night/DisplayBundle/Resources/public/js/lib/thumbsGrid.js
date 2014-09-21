/**
 * Svg Line draw
 * Some css code will be generated for the element managed by the plugin.
 * To achieve this, a selector for the element will be define, many options
 * are available for this.
 */
;( function( $, window, undefined ) {

    ///////////////////////////////////////////////
    // ======== Object/Class definition ======== //
    ///////////////////////////////////////////////

    $.thumbsGrid = function(options, debug, element) {
        this.pluginName = 'thumbsGrid';
        this.$el = $(element);
        this.debug = debug;
        this._init(options);
    };

    // Default options
    $.thumbsGrid.defaults = {
        // Array of array of items.
        // - The first level separe the different 'pages' (or 'set of items')
        // - The second level should contain all the items of a page
        // Example: items = [
        //      ['<img src="image1_1.jpg />', '<img src="image2.jpg" />'],
        //      ['<img src="image2_1.jpg" />', '<img src="image2_2.jpg" />']
        // ]
        items: [],
        // This is the index of the page (not the number)
        initialPage: 0,
        // Auto scroll, false if disabled or interval duration
        autoScroll: false,
        // Whether to enable the navDots
        navDots: true,
        // Supported classes :
        // tt-effect-fall, tt-effect-slide, tt-effect-fallrotate, tt-effect-scalerotate
        effectClass: 'tt-effect-fallrotate',
        // Better not change these options
        classGrid: 'tt-grid',
        classNavDots: 'tt-nav-dots',
        classGridEffectActive: 'tt-effect-active',
        classEmptyLiTag: 'tt-empty',
        classOldATag: 'tt-old',
        currentDotClass: 'tt-current'
    }

    $.thumbsGrid.prototype._init  = function( options )
    {
        this._logDebug('_init', 'Start');
        // options
        this.options = $.extend( true, {}, $.thumbsGrid.defaults, options);
        // cache some elements and initialize some variables
        this._config();
        // Init events
        this._initEvents();
    }

    $.thumbsGrid.prototype._config  = function()
    {
        this._logDebug('_config', 'Configure items:', this.options.items);

        this.clickEventType = mobilecheck() ? 'touchstart' : 'click';
        this.items = this.options.items;
        this.isAnimating = false;
        this.activePage = this.options.initialPage;

        var animEndEventNames = {
            'WebkitAnimation' : 'webkitAnimationEnd',
            'OAnimation' : 'oAnimationEnd',
            'msAnimation' : 'MSAnimationEnd',
            'animation' : 'animationend'
        };
        this.animEventName = animEndEventNames[ Modernizr.prefixed( 'animation' ) ];
        this._logDebug('_config', 'Animation event name configured: "' + this.animEventName + '"');

        this._buildItems();
        this._buildNavDots();
    }

    $.thumbsGrid.prototype._buildItems = function()
    {
        this._logDebug('_buildItems', 'start');
        var self = this;
        var pageItems = this.items[this.activePage]

        pageItems.forEach(function(itemTag) {
            var $item = $('<li><a>' + itemTag +'</a></li>');
            self.$el.append($item);
            self._logDebug('_buildItems', 'Added item: ', $item);
        });

        this.itemSlots = this.$el.find('li');
        this._logDebug('_buildItems', '"' + this.itemSlots.length + '" Page slots saved');
    }

    $.thumbsGrid.prototype._buildNavDots = function()
    {
        this._logDebug('_buildNavdots', 'start');

        var $navDotsTag = $('<nav class="' + this.options.classNavDots + '" ></nav>');
        var navDots = '';
        for (var i in this.items) {
            var dot = (this.activePage != i) ?
                '<a></a>' :
                '<a class="' + this.options.currentDotClass + '" />';

            navDots += dot;
        }

        this.navDots = $(navDots);
        this.$el.after($navDotsTag.append(this.navDots));

        this._logDebug('_buildNavdots', 'Nav dots builded:', this.navDots);
    }

    $.thumbsGrid.prototype._initEvents = function()
    {
        var self = this;
        this._logDebug('_initEvents', 'start');

        this.navDots.each(function(index) {
            $(this).on(self.clickEventType, $.proxy(self._handleNavDotClicked, self) );
        });
    }

    $.thumbsGrid.prototype._handleNavDotClicked = function(event)
    {
        var $navDotClicked = $(event.target);
        var index = this.navDots.index($navDotClicked);

        this._logDebug('_handleNavDotClicked', 'Nav dot "' + index + '" clicked :', $navDotClicked);

        this._logDebug('_handleNavDotClicked', 'Animating: ', this.isAnimating );
        this._logDebug('_handleNavDotClicked', 'Active page: ', this.activePage );

        // Nav dot already animating or active
        if (this.isAnimating || this.activePage == index) {
            this._logDebug('_handleNavDotClicked', 'Nav dot already active or an animation is already running.', index);
            return false;
        }

        this.isAnimating = true;
        this._setActiveDot(index);
        this._loadItems(index);
    }

    $.thumbsGrid.prototype._loadItems = function(index)
    {
        var self = this;
        this._logDebug('_loadNewPage', 'Page to load "' + index + '"');
        this._setActivePage(index);

        var pageItems = this.items[index];
        this.itemSlots.each(function() {
            var $slotItem = $(this).find('a');
            self._logDebug('_loadItems', 'Load slot item :', $slotItem);
            if ($slotItem.length != 0) {
                $slotItem.addClass(self.options.classOldATag);
            }
        });

        // apply effect
        setTimeout( function() {
            var indexPage = self.activePage;

            // append new elements
            self.itemSlots.each(function(indexSlot) {
                if (self.items[indexPage][indexSlot] == undefined) {
                    return;
                }
                $(this).append('<a>' + self.items[indexPage][indexSlot]  +'</a>');
            })

            // add "effect" class to the grid
            self.$el.addClass(self.options.classGridEffectActive);

            // wait that animations end
            // remove old elements
            self.itemsAnimDone = 0;
            self.itemSlots.each(function() {
                $(this).find('a').on(self.animEventName, $.proxy(self._onSingleAnimationEnd, self));
            });
        }, 25)
    }

    $.thumbsGrid.prototype._onSingleAnimationEnd = function(event)
    {
        var $item = $(event.target);
        this._logDebug('_onSingleAnimationEnd', 'Animation ended for the item: ', $item);
        var self = this;

        $item.off(this.animEventName, $.proxy(self._onAnimationEnd, self));
        ++this.itemsAnimDone;
        this._logDebug('_onSingleAnimationEnd', 'Total Animations done: ', this.itemsAnimDone);
        if (this.itemsAnimDone == this.itemSlots.length) {
            this._onAllAnimationEnd();
        }
    }

    $.thumbsGrid.prototype._onAllAnimationEnd = function()
    {
        this._logDebug('_onAllAnimationEnd', 'start');
        var self = this;

        this.itemSlots.each(function (index) {
            var $old = $(this).find('a.' + self.options.classOldATag);
            if( $old.length != 0 ) { $old.remove(); }
            // remove class "tt-empty" from the empty items
            $(this).removeClass(self.options.classEmptyLiTag);
            // now apply that same class to the items that got no children (special case)
            if ($(this).find('a').length == 0) {
                $(this).addClass(self.options.classEmptyLiTag);
            };
        });

        this.$el.removeClass(self.options.classGridEffectActive);
        this.isAnimating = false;
        this._logDebug('_onAllAnimationEnd', 'End');
    }

    $.thumbsGrid.prototype._setActiveDot = function(index)
    {
        this._logDebug('_setActiveDot', 'Active dot is now at index:', index);
        this._logDebug('_setActiveDot', 'Nav dots:', this.navDots);
        this._logDebug('_setActiveDot', 'Filter' , '.' + this.options.currentDotClass);
        this.navDots
            .filter('.' + this.options.currentDotClass)
            .removeClass(this.options.currentDotClass);

        this.navDots.eq(index).addClass(this.options.currentDotClass);
    }

    $.thumbsGrid.prototype._setActivePage = function(index)
    {
        var old = this.activePage;
        this.activePage = index;
        this._logDebug('_setActivePage', 'Current page has been change from "' + old + '" to "' + this.activePage + '"');
    }

    /**
     * Trigger an event on a element
     *
     * @param Object Element
     * @param string eventName
     * @param boolean removeSuffix
     * @param mixed data
     */
    $.thumbsGrid.prototype._trigger = function($element, eventName, data, removeSuffix)
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
    $.thumbsGrid.prototype._logDebug = function(method, message, objectToLog)
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
    $.thumbsGrid.prototype._logError = function(method, message, objectToLog)
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

    ///////////////////////////////////////
    // ======== Util functions  ======== //
    ///////////////////////////////////////

    // http://coveroverflow.com/a/11381730/989439
    function mobilecheck() {
        var check = false;
        (function(a){if(/(android|ipad|playbook|silk|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i.test(a)||/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0,4)))check = true})(navigator.userAgent||navigator.vendor||window.opera);
        return check;
    }

    ///////////////////////////////////////////////////////
    // ======== jQuery plugin related functions ======== //
    ///////////////////////////////////////////////////////

    $.fn.thumbsGrid = function(options, debug) {
        if (typeof options === 'string' ) {
            var args = Array.prototype.slice.call(arguments, 1);
            this.each(function() {
                var instance = $.data(this, 'thumbsGrid');
                if (!instance) {
                    window.console.error( "cannot call methods on " + 'thumbsGrid' + " prior to initialization; " +
                    "attempted to call method '" + options + "'" );
                    return;
                }
                // Public method call handler
                if ( !$.isFunction(instance[options]) || options.charAt(0) === "_" ) {
                    window.console.error( "no such method '" + options + "' for thumbsGrid instance" );
                    return;
                }
                instance[options].apply(instance, args);
            });
        }
        else {
            this.each(function() {

                var instance = $.data(this, 'thumbsGrid');
                if (instance) {
                    instance._init();
                }
                else {
                    instance = $.data(this, 'thumbsGrid', new $.thumbsGrid(options, debug, this));
                }
            });
        }
        return this;
    };

} )(jQuery, window);