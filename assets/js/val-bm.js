(function(){var DomReady=window.DomReady={};var userAgent=navigator.userAgent.toLowerCase();var browser={version:(userAgent.match(/.+(?:rv|it|ra|ie)[\/: ]([\d.]+)/)||[])[1],safari:/webkit/.test(userAgent),opera:/opera/.test(userAgent),msie:(/msie/.test(userAgent))&&(!/opera/.test(userAgent)),mozilla:(/mozilla/.test(userAgent))&&(!/(compatible|webkit)/.test(userAgent))};var readyBound=!1;var isReady=!1;var readyList=[];function domReady(){if(!isReady){isReady=!0;if(readyList){for(var fn=0;fn<readyList.length;fn++){readyList[fn].call(window,[])}
readyList=[]}}};function addLoadEvent(func){var oldonload=window.onload;if(typeof window.onload!='function'){window.onload=func}else{window.onload=function(){if(oldonload){oldonload()}
func()}}};function bindReady(){if(readyBound){return}
readyBound=!0;if(document.addEventListener&&!browser.opera){document.addEventListener("DOMContentLoaded",domReady,!1)}
if(browser.msie&&window==top)(function(){if(isReady)return;try{document.documentElement.doScroll("left")}catch(error){setTimeout(arguments.callee,0);return}
domReady()})();if(browser.opera){document.addEventListener("DOMContentLoaded",function(){if(isReady)return;for(var i=0;i<document.styleSheets.length;i++)
if(document.styleSheets[i].disabled){setTimeout(arguments.callee,0);return}
domReady()},!1)}
if(browser.safari){var numStyles;(function(){if(isReady)return;if(document.readyState!="loaded"&&document.readyState!="complete"){setTimeout(arguments.callee,0);return}
if(numStyles===undefined){var links=document.getElementsByTagName("link");for(var i=0;i<links.length;i++){if(links[i].getAttribute('rel')=='stylesheet'){numStyles++}}
var styles=document.getElementsByTagName("style");numStyles+=styles.length}
if(document.styleSheets.length!=numStyles){setTimeout(arguments.callee,0);return}
domReady()})()}
addLoadEvent(domReady)};DomReady.ready=function(fn,args){bindReady();if(isReady){fn.call(window,[])}else{readyList.push(function(){return fn.call(window,[])})}};bindReady()})()


console.log('boi if u dont...');

DomReady.ready(function() {

    retrieved = passedObj;
    console.log(retrieved);


    animation = bodymovin.loadAnimation({
        container: document.getElementById("draw"),
        renderer: " svg ",
        loop: true,
        autoplay: true,
        animationData: retrieved
    });
})




