$(document).on('click', '#SlideLeft', (event) => {
    $({
        x: parseInt($('#NavLeft').css('transform').split(',')[4]) < 0 ? -100 : 0
    }).animate({
        x: parseInt($('#NavLeft').css('transform').split(',')[4]) < 0 ? 0 : -100
    }, {
        duration: 500,
        step: function(now) {
            $('#NavLeft').css({
                transform: 'translateX(' + now + '%)'
            });
        }
    });

    $({
        deg: parseInt($('#NavLeft').css('transform').split(',')[4]) < 0 ? 0 : -180
    }).animate({
        deg: parseInt($('#NavLeft').css('transform').split(',')[4]) < 0 ? -180 : 0
    }, {
        duration: 500,
        step: function(now) {
            $('#SlideLeft').css({
                transform: 'rotate(' + now + 'deg)'
            });
        },
    });

    $({
        x: parseInt($('#NavLeft').css('transform').split(',')[4]) < 0 ? -42 : -15
    }).animate({
        x: parseInt($('#NavLeft').css('transform').split(',')[4]) < 0 ? -15 : -42
    }, {
        duration: 500,
        step: function(now) {
            $('#SlideLeft').css({
                right: now + 'px'
            });
        },
    });
});

window.onresize = function(event) {
    let innerWidth = window.innerWidth;
    if (innerWidth >= 1010) {
        if (parseInt($('#NavLeft').css('transform').split(',')[4]) < 0) {
            $('#NavLeft').css({
                transform: 'translateX(0%)'
            });
            $('#SlideLeft').css({
                transform: 'rotate(-180deg)'
            });
        }
    }
}
