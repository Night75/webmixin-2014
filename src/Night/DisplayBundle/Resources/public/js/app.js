(function($){

    function PageLoaded()
    {
        this.loader = new SVGLoader( document.getElementById( 'loading-overlay' ), { speedIn : 400, easingIn : mina.easeinout } );
        this.loaderItems = [].slice.call(document.querySelectorAll('#loading-overlay .loader'));
    }

    PageLoaded.prototype.hide = function () {
        this.loaderItems.forEach(function(el) { classie.addClass(el, 'hide')});
        this.loader.hide();
    }

    PageLoaded.prototype.show = function () {
        this.loaderItems.forEach(function(el) { classie.removeClass(el, 'hide')});
        this.loader.show();
    }

    window.PageLoaded = PageLoaded;

    //
    // ============ AJAX Page load
    // ________________________________________________________________

    //  App Definition
    // ____________
    //
    // Event triggered:
    // - showPage
    //
    function App(initialPageType, loader)
    {
        this.initialPageType = initialPageType;
        this.minTimeAnimation = 1000;
        // Kind of page cache
        this.pagesLoaded = {'main': '', 'annex': ''};
        // Expected : object with show and hide methods.
        this.loader = loader;
        this._initEvents();
    }

    App.prototype.loadPage = function(pageType, url)
    {
        var self = this;
        this.loader.show();
        if (this.pagesLoaded[pageType] == url) {
            setTimeout(function() {
                self.showPage(pageType);
                self.loader.hide();
            }, self.minTimeAnimation)
            return;
        }

        var startTime = Date.now();
        $.get(url, {})
            .done(function (data) {
                var pageToShow = (pageType == 'annex') ? '#page-annex' : '#page-main';
                self.showPage(pageType);

                $(pageToShow + ' .st-content').html(data);
                self.pagesLoaded[pageType] = document.location.pathname;
            })
            .fail(function () {
                console.log('fail');
            })
            .always(function () {
                var delay = Date.now() - startTime + self.minTimeAnimation;
                delay = delay > 0 ? delay : 0;
                setTimeout(function() { self.loader.hide();}, delay)
            })
    }

    App.prototype.showPage = function(pageType) {
        $(this).trigger('App.showPage');

        var pageToHide = (pageType == 'annex') ? '#page-main:not(".hide")' : '#page-annex:not(".hide")';
        var pageToShow = (pageType == 'annex') ? '#page-annex' : '#page-main';

        $(pageToHide).addClass('hide');
        $(pageToShow).removeClass('hide');
    }

    App.prototype.setPagesLoaded = function(pageType, url) {
        this.pagesLoaded[pageType] = url;
    }

    App.prototype._initEvents = function() {
        this._initClickEvent();
        this._initPopstateEvent();
    }

    App.prototype._initClickEvent = function() {
        var self = this;
        $('body').on('click', '.ajax', function(event) {
            event.preventDefault();
            var url = $(this).attr('href');
            var pageType = $(this).data('page') ? $(this).data('page') : 'annex';
            history.pushState({pageType: pageType}, url, url);
            self.loadPage(pageType, url);
        });
    }

    App.prototype._initPopstateEvent = function() {
        var self = this;
        window.onpopstate = function (event){
            var pageType = event.state ? event.state.pageType : self.initialPageType;
            self.loadPage(pageType, document.location.pathname);
        }
    }

    window.App = App;

    //  Menu
    // ____________
    var pages = ['#home', '#skills', '#projects', '#about-me', '#contact'];
    var offsetTab = {};

    $('#menu-door.st-trigger-open').on('click', function() {
        for (var k in pages) {
            var page = pages[k];
            offsetTab[page] = $('#page-main .st-content ' + page).offset().top;
        }
        console.log(offsetTab);
    });
4
    $('#main-menu a').on('click', function(e) {
        e.preventDefault();
        var referenceHeight = 1061;         // Height between #skills panel and #projects
        var offsetTop = offsetTab[$(this).attr('href')];
        $('#page-main .st-content').scrollTo(offsetTop, 800);
    })

})(jQuery);