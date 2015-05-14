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

    function SkillBarManager(options)
    {
        this.options = extend( {}, this.options );
        extend( this.options, options )
        this._init();
    }

    SkillBarManager.prototype.options =
    {
        skillSelector: '.skillbar',
        barSelector: '.skill-bar-percent, .skillbar-bar'
    }

    SkillBarManager.prototype._init = function()
    {
        this._config();
        //this._initEvents();
    }

    SkillBarManager.prototype._config = function()
    {
        this.$items = $(this.options.skillSelector);
    }

    SkillBarManager.prototype.showAll = function()
    {
        var self = this;

        this.$items.each(function() {
            var $bar = $(this).find(self.options.barSelector);
            $bar.width($(this).data('percent'));
        });
    }

    SkillBarManager.prototype.hideAll = function()
    {
        var self = this;

        this.$items.each(function() {
            var $bar = $(this).find(self.options.barSelector);
            $bar.width(0);
        });
    }

    window.SkillBarManager = SkillBarManager;
})();