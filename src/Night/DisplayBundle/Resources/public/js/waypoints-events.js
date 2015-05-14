var wpContext = '.st-content';
var offset = Night.isMobile() ? "0" : "25%";

//
// ============ SKILLS
// ________________________________________________________________

//  Skillbars
// ____________
var skillBarManager = new SkillBarManager();
$('section#skills').waypoint(function(direction) {
    if (direction == 'down') {
        skillBarManager.showAll();
    }
}, { context: wpContext, off3set: '25%' });


//
// ============ ABOUT ME
// ________________________________________________________________

//  Cards
// ____________
$('section#about-me').waypoint(function(direction) {
    if (direction == 'down') {
        $('#about-me .card').addClass('display');
    } else {
        $('#about-me .card').removeClass('display');
    }
}, { context: wpContext, off3set: '25%' });