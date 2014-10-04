var wpContext = '.st-content';

$('section#about-me').waypoint(function(direction) {
    if (direction == 'down') {
        $('#about-me .card').addClass('display');
    } else {
        $('#about-me .card').removeClass('display');
    }
}, { context: wpContext, offset: '25%' });