document.addEventListener('DOMContentLoaded', function(){
    var annies = document.getElementsByClassName('val-bme');
    // console.log(annies);
    for (var i = 0, len = annies.length; i < len; i++ ) {
        name = annies[i].id;
        animData = annies[i].dataset.bmLink;
        loopy = annies[i].dataset.shouldLoop;
        autoplay = annies[i].dataset.shouldAutoplay;
        loadOffset = annies[i].dataset.loadOffset / 100;

        if (loopy === 'yes') {
            loopy = true;
        } else {
            loopy = false;
        }

        if (autoplay === 'yes') {
            autoplay = true;
        } else {
            autoplay = false;
        }

        if (autoplay === true) {
            loadOffset = 0;
        }



        console.log(autoplay);
        var params = {
            container: document.getElementById(name),
            renderer: 'svg',
            loop: loopy,
            autoplay: autoplay,
            path: animData,
            offset: loadOffset
         };

         console.log(params);

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






