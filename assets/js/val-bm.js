document.addEventListener('DOMContentLoaded', function(){
    var annies = document.getElementsByClassName('val-bme');
    // console.log(annies);
    for (var i = 0, len = annies.length; i < len; i++ ) {
        name = annies[i].id;
        animData = annies[i].dataset.bmLink;
        loopy = annies[i].dataset.shouldLoop;
        loadOffset = annies[i].dataset.loadOffset / 100;

        if (loopy === 'yes') {
            loopy = true;
        } else {
            loopy = false;
        }

        var params = {
            container: document.getElementById(name),
            renderer: 'svg',
            loop: loopy,
            autoplay: false,
            path: animData
         };

    var anim;

    anim = bodymovin.loadAnimation(params);

    enterView({
        selector: '#' + name,
        enter: function() {
            anim.play();
        },
        exit: function() {
            anim.pause();
        },
        offset: loadOffset
    })
    }

});






