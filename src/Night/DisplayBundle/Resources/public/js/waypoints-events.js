var wpContext = '.st-content';

var offset = Night.isMobile() ? "0" : "25%";

$('section#about-me').waypoint(function(direction) {
    if (direction == 'down') {
        $('#about-me .card').addClass('display');
    } else {
        $('#about-me .card').removeClass('display');
    }
}, { context: wpContext, off3set: '25%' });