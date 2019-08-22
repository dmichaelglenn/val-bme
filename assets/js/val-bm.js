import browser from 'browser-detect';

document.addEventListener('DOMContentLoaded', function(){

    var annies = document.getElementsByClassName('val-bme');

    var userBrowser = browser();
    console.log(userBrowser.name);

    if (userBrowser.name === 'edge' || userBrowser.name === 'ie') {
        console.log('yuck');
        tooOld();
    } else {
        supportsBodymovin();
    }

    function tooOld() {
        for (var i = 0, len = annies.length; i < len; i++ ) {
            var name = annies[i].id;
            var fallback = annies[i].dataset.bmFallback;
        
            var oldEl = document.getElementById(name);
            var newEl = document.createElement("IMG");

            newEl.src = fallback;
            newEl.classList.add('fallback-img');

            oldEl.parentNode.replaceChild(newEl, oldEl);
        }
    }

    function supportsBodymovin() {
        for (var i = 0, len = annies.length; i < len; i++ ) {

            var name = annies[i].id;
            var animData = annies[i].dataset.bmLink;
            var loopy = annies[i].dataset.shouldLoop;
            var autoplay = annies[i].dataset.shouldAutoplay;
            var loadOffset = annies[i].dataset.loadOffset / 100;
    
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
    
            var params = {
                container: document.getElementById(name),
                renderer: 'svg',
                loop: loopy,
                autoplay: autoplay,
                path: animData,
                offset: loadOffset
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
    }

   

});






