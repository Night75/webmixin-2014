(function($){

    function loadPage(url, isAnnex)
    {
        $
    }

    $('.ajax').on('click', function(event) {
        event.preventDefault();
        var url = $(this).attr('href');
        history.pushState({some: 'thing'}, url, url);

    });


})(jQuery);