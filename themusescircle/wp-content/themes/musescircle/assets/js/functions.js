function toggleNavSubMenus(t){jQuery(t).each(function(){var t=jQuery(this);if(t.hasClass("menu-item-has-children")){jQuery('<span class="icon icon-chevron-down toggle-submenu"></span>').insertAfter(t.find("> a"));var e=t.find(".toggle-submenu"),i=t.find(".sub-menu");jQuery(e).click(function(){jQuery(i).toggleClass("show"),jQuery(e).toggleClass("show")}),jQuery(document).on("click",function(s){jQuery(s.target).closest(t).length||(jQuery(i).removeClass("show"),jQuery(e).removeClass("show"))})}})}function hideNavigation(t){var e=jQuery(t).find(".prev"),i=jQuery(t).find(".next");0==e.children().length&&e.remove(),0==i.children().length&&i.remove(),0==e.children().length&&0==i.children().length&&jQuery(t).remove()}function addSwipeBoxGallery(t){jQuery(t).each(function(){var t,e=jQuery(this),i=e.attr("id"),s=e.find(".gallery-item .gallery-icon a");jQuery(s).each(function(){var e=jQuery(this),s=/\.(gif|jpg|jpeg|tiff|png|bmp|svg)$/i.test(e.attr("href"));return 0==s?(t=!1,!1):void(t=i)}),t==i&&jQuery(s).each(function(){currentImageLink=jQuery(this),currentImageLink.attr("rel",i),currentImageLink.attr("class","swipebox");var t=currentImageLink.find("img").attr("alt");currentImageLink.attr("title",t),jQuery(".swipebox").swipebox({loopAtEnd:!0})})})}function newTimeFunction(){jQuery(".countdown").each(function(){function t(t,e,i){return'<div class="'+t+'"><span class="countdown-value">'+e+'</span><span class="countdown-label">'+i+"</span></div>"}var e=Date.parse(new Date),i=Date.parse(this.dataset.endDate),s=i-e;if(s>0){var o=Math.floor(s/1e3),n=Math.floor(o/60)%60,a=Math.floor(o/60/60)%24,r=Math.floor(o/60/60/24),l=t("seconds",r,"seconds"),p=t("minutes",n,"minutes"),h=t("hours",a,"hours"),u=t("days",r,"days");jQuery(this).append(u,h,p,l)}})}"function"!=typeof Object.create&&(Object.create=function(t){function e(){}return e.prototype=t,new e}),function(t,e,i){var s={init:function(e,i){this.$elem=t(i),this.options=t.extend({},t.fn.owlCarousel.options,this.$elem.data(),e),this.userOptions=e,this.loadContent()},loadContent:function(){function e(t){var e,i="";if("function"==typeof s.options.jsonSuccess)s.options.jsonSuccess.apply(this,[t]);else{for(e in t.owl)t.owl.hasOwnProperty(e)&&(i+=t.owl[e].item);s.$elem.html(i)}s.logIn()}var i,s=this;"function"==typeof s.options.beforeInit&&s.options.beforeInit.apply(this,[s.$elem]),"string"==typeof s.options.jsonPath?(i=s.options.jsonPath,t.getJSON(i,e)):s.logIn()},logIn:function(){this.$elem.data("owl-originalStyles",this.$elem.attr("style")),this.$elem.data("owl-originalClasses",this.$elem.attr("class")),this.$elem.css({opacity:0}),this.orignalItems=this.options.items,this.checkBrowser(),this.wrapperWidth=0,this.checkVisible=null,this.setVars()},setVars:function(){return 0===this.$elem.children().length?!1:(this.baseClass(),this.eventTypes(),this.$userItems=this.$elem.children(),this.itemsAmount=this.$userItems.length,this.wrapItems(),this.$owlItems=this.$elem.find(".owl-item"),this.$owlWrapper=this.$elem.find(".owl-wrapper"),this.playDirection="next",this.prevItem=0,this.prevArr=[0],this.currentItem=0,this.customEvents(),void this.onStartup())},onStartup:function(){this.updateItems(),this.calculateAll(),this.buildControls(),this.updateControls(),this.response(),this.moveEvents(),this.stopOnHover(),this.owlStatus(),!1!==this.options.transitionStyle&&this.transitionTypes(this.options.transitionStyle),!0===this.options.autoPlay&&(this.options.autoPlay=5e3),this.play(),this.$elem.find(".owl-wrapper").css("display","block"),this.$elem.is(":visible")?this.$elem.css("opacity",1):this.watchVisibility(),this.onstartup=!1,this.eachMoveUpdate(),"function"==typeof this.options.afterInit&&this.options.afterInit.apply(this,[this.$elem])},eachMoveUpdate:function(){!0===this.options.lazyLoad&&this.lazyLoad(),!0===this.options.autoHeight&&this.autoHeight(),this.onVisibleItems(),"function"==typeof this.options.afterAction&&this.options.afterAction.apply(this,[this.$elem])},updateVars:function(){"function"==typeof this.options.beforeUpdate&&this.options.beforeUpdate.apply(this,[this.$elem]),this.watchVisibility(),this.updateItems(),this.calculateAll(),this.updatePosition(),this.updateControls(),this.eachMoveUpdate(),"function"==typeof this.options.afterUpdate&&this.options.afterUpdate.apply(this,[this.$elem])},reload:function(){var t=this;e.setTimeout(function(){t.updateVars()},0)},watchVisibility:function(){var t=this;return!1!==t.$elem.is(":visible")?!1:(t.$elem.css({opacity:0}),e.clearInterval(t.autoPlayInterval),e.clearInterval(t.checkVisible),void(t.checkVisible=e.setInterval(function(){t.$elem.is(":visible")&&(t.reload(),t.$elem.animate({opacity:1},200),e.clearInterval(t.checkVisible))},500)))},wrapItems:function(){this.$userItems.wrapAll('<div class="owl-wrapper">').wrap('<div class="owl-item"></div>'),this.$elem.find(".owl-wrapper").wrap('<div class="owl-wrapper-outer">'),this.wrapperOuter=this.$elem.find(".owl-wrapper-outer"),this.$elem.css("display","block")},baseClass:function(){var t=this.$elem.hasClass(this.options.baseClass),e=this.$elem.hasClass(this.options.theme);t||this.$elem.addClass(this.options.baseClass),e||this.$elem.addClass(this.options.theme)},updateItems:function(){var e,i;if(!1===this.options.responsive)return!1;if(!0===this.options.singleItem)return this.options.items=this.orignalItems=1,this.options.itemsCustom=!1,this.options.itemsDesktop=!1,this.options.itemsDesktopSmall=!1,this.options.itemsTablet=!1,this.options.itemsTabletSmall=!1,this.options.itemsMobile=!1;if(e=t(this.options.responsiveBaseWidth).width(),e>(this.options.itemsDesktop[0]||this.orignalItems)&&(this.options.items=this.orignalItems),!1!==this.options.itemsCustom)for(this.options.itemsCustom.sort(function(t,e){return t[0]-e[0]}),i=0;i<this.options.itemsCustom.length;i+=1)this.options.itemsCustom[i][0]<=e&&(this.options.items=this.options.itemsCustom[i][1]);else e<=this.options.itemsDesktop[0]&&!1!==this.options.itemsDesktop&&(this.options.items=this.options.itemsDesktop[1]),e<=this.options.itemsDesktopSmall[0]&&!1!==this.options.itemsDesktopSmall&&(this.options.items=this.options.itemsDesktopSmall[1]),e<=this.options.itemsTablet[0]&&!1!==this.options.itemsTablet&&(this.options.items=this.options.itemsTablet[1]),e<=this.options.itemsTabletSmall[0]&&!1!==this.options.itemsTabletSmall&&(this.options.items=this.options.itemsTabletSmall[1]),e<=this.options.itemsMobile[0]&&!1!==this.options.itemsMobile&&(this.options.items=this.options.itemsMobile[1]);this.options.items>this.itemsAmount&&!0===this.options.itemsScaleUp&&(this.options.items=this.itemsAmount)},response:function(){var i,s,o=this;return!0!==o.options.responsive?!1:(s=t(e).width(),o.resizer=function(){t(e).width()!==s&&(!1!==o.options.autoPlay&&e.clearInterval(o.autoPlayInterval),e.clearTimeout(i),i=e.setTimeout(function(){s=t(e).width(),o.updateVars()},o.options.responsiveRefreshRate))},void t(e).resize(o.resizer))},updatePosition:function(){this.jumpTo(this.currentItem),!1!==this.options.autoPlay&&this.checkAp()},appendItemsSizes:function(){var e=this,i=0,s=e.itemsAmount-e.options.items;e.$owlItems.each(function(o){var n=t(this);n.css({width:e.itemWidth}).data("owl-item",Number(o)),0!==o%e.options.items&&o!==s||o>s||(i+=1),n.data("owl-roundPages",i)})},appendWrapperSizes:function(){this.$owlWrapper.css({width:this.$owlItems.length*this.itemWidth*2,left:0}),this.appendItemsSizes()},calculateAll:function(){this.calculateWidth(),this.appendWrapperSizes(),this.loops(),this.max()},calculateWidth:function(){this.itemWidth=Math.round(this.$elem.width()/this.options.items)},max:function(){var t=-1*(this.itemsAmount*this.itemWidth-this.options.items*this.itemWidth);return this.options.items>this.itemsAmount?this.maximumPixels=t=this.maximumItem=0:(this.maximumItem=this.itemsAmount-this.options.items,this.maximumPixels=t),t},min:function(){return 0},loops:function(){var e,i,s=0,o=0;for(this.positionsInArray=[0],this.pagesInArray=[],e=0;e<this.itemsAmount;e+=1)o+=this.itemWidth,this.positionsInArray.push(-o),!0===this.options.scrollPerPage&&(i=t(this.$owlItems[e]),i=i.data("owl-roundPages"),i!==s&&(this.pagesInArray[s]=this.positionsInArray[e],s=i))},buildControls:function(){!0!==this.options.navigation&&!0!==this.options.pagination||(this.owlControls=t('<div class="owl-controls"/>').toggleClass("clickable",!this.browser.isTouch).appendTo(this.$elem)),!0===this.options.pagination&&this.buildPagination(),!0===this.options.navigation&&this.buildButtons()},buildButtons:function(){var e=this,i=t('<div class="owl-buttons"/>');e.owlControls.append(i),e.buttonPrev=t("<div/>",{"class":"owl-prev",html:e.options.navigationText[0]||""}),e.buttonNext=t("<div/>",{"class":"owl-next",html:e.options.navigationText[1]||""}),i.append(e.buttonPrev).append(e.buttonNext),i.on("touchstart.owlControls mousedown.owlControls",'div[class^="owl"]',function(t){t.preventDefault()}),i.on("touchend.owlControls mouseup.owlControls",'div[class^="owl"]',function(i){i.preventDefault(),t(this).hasClass("owl-next")?e.next():e.prev()})},buildPagination:function(){var e=this;e.paginationWrapper=t('<div class="owl-pagination"/>'),e.owlControls.append(e.paginationWrapper),e.paginationWrapper.on("touchend.owlControls mouseup.owlControls",".owl-page",function(i){i.preventDefault(),Number(t(this).data("owl-page"))!==e.currentItem&&e.goTo(Number(t(this).data("owl-page")),!0)})},updatePagination:function(){var e,i,s,o,n,a;if(!1===this.options.pagination)return!1;for(this.paginationWrapper.html(""),e=0,i=this.itemsAmount-this.itemsAmount%this.options.items,o=0;o<this.itemsAmount;o+=1)0===o%this.options.items&&(e+=1,i===o&&(s=this.itemsAmount-this.options.items),n=t("<div/>",{"class":"owl-page"}),a=t("<span></span>",{text:!0===this.options.paginationNumbers?e:"","class":!0===this.options.paginationNumbers?"owl-numbers":""}),n.append(a),n.data("owl-page",i===o?s:o),n.data("owl-roundPages",e),this.paginationWrapper.append(n));this.checkPagination()},checkPagination:function(){var e=this;return!1===e.options.pagination?!1:void e.paginationWrapper.find(".owl-page").each(function(){t(this).data("owl-roundPages")===t(e.$owlItems[e.currentItem]).data("owl-roundPages")&&(e.paginationWrapper.find(".owl-page").removeClass("active"),t(this).addClass("active"))})},checkNavigation:function(){return!1===this.options.navigation?!1:void(!1===this.options.rewindNav&&(0===this.currentItem&&0===this.maximumItem?(this.buttonPrev.addClass("disabled"),this.buttonNext.addClass("disabled")):0===this.currentItem&&0!==this.maximumItem?(this.buttonPrev.addClass("disabled"),this.buttonNext.removeClass("disabled")):this.currentItem===this.maximumItem?(this.buttonPrev.removeClass("disabled"),this.buttonNext.addClass("disabled")):0!==this.currentItem&&this.currentItem!==this.maximumItem&&(this.buttonPrev.removeClass("disabled"),this.buttonNext.removeClass("disabled"))))},updateControls:function(){this.updatePagination(),this.checkNavigation(),this.owlControls&&(this.options.items>=this.itemsAmount?this.owlControls.hide():this.owlControls.show())},destroyControls:function(){this.owlControls&&this.owlControls.remove()},next:function(t){if(this.isTransition)return!1;if(this.currentItem+=!0===this.options.scrollPerPage?this.options.items:1,this.currentItem>this.maximumItem+(!0===this.options.scrollPerPage?this.options.items-1:0)){if(!0!==this.options.rewindNav)return this.currentItem=this.maximumItem,!1;this.currentItem=0,t="rewind"}this.goTo(this.currentItem,t)},prev:function(t){if(this.isTransition)return!1;if(this.currentItem=!0===this.options.scrollPerPage&&0<this.currentItem&&this.currentItem<this.options.items?0:this.currentItem-(!0===this.options.scrollPerPage?this.options.items:1),0>this.currentItem){if(!0!==this.options.rewindNav)return this.currentItem=0,!1;this.currentItem=this.maximumItem,t="rewind"}this.goTo(this.currentItem,t)},goTo:function(t,i,s){var o=this;return o.isTransition?!1:("function"==typeof o.options.beforeMove&&o.options.beforeMove.apply(this,[o.$elem]),t>=o.maximumItem?t=o.maximumItem:0>=t&&(t=0),o.currentItem=o.owl.currentItem=t,!1!==o.options.transitionStyle&&"drag"!==s&&1===o.options.items&&!0===o.browser.support3d?(o.swapSpeed(0),!0===o.browser.support3d?o.transition3d(o.positionsInArray[t]):o.css2slide(o.positionsInArray[t],1),o.afterGo(),o.singleItemTransition(),!1):(t=o.positionsInArray[t],!0===o.browser.support3d?(o.isCss3Finish=!1,!0===i?(o.swapSpeed("paginationSpeed"),e.setTimeout(function(){o.isCss3Finish=!0},o.options.paginationSpeed)):"rewind"===i?(o.swapSpeed(o.options.rewindSpeed),e.setTimeout(function(){o.isCss3Finish=!0},o.options.rewindSpeed)):(o.swapSpeed("slideSpeed"),e.setTimeout(function(){o.isCss3Finish=!0},o.options.slideSpeed)),o.transition3d(t)):!0===i?o.css2slide(t,o.options.paginationSpeed):"rewind"===i?o.css2slide(t,o.options.rewindSpeed):o.css2slide(t,o.options.slideSpeed),void o.afterGo()))},jumpTo:function(t){"function"==typeof this.options.beforeMove&&this.options.beforeMove.apply(this,[this.$elem]),t>=this.maximumItem||-1===t?t=this.maximumItem:0>=t&&(t=0),this.swapSpeed(0),!0===this.browser.support3d?this.transition3d(this.positionsInArray[t]):this.css2slide(this.positionsInArray[t],1),this.currentItem=this.owl.currentItem=t,this.afterGo()},afterGo:function(){this.prevArr.push(this.currentItem),this.prevItem=this.owl.prevItem=this.prevArr[this.prevArr.length-2],this.prevArr.shift(0),this.prevItem!==this.currentItem&&(this.checkPagination(),this.checkNavigation(),this.eachMoveUpdate(),!1!==this.options.autoPlay&&this.checkAp()),"function"==typeof this.options.afterMove&&this.prevItem!==this.currentItem&&this.options.afterMove.apply(this,[this.$elem])},stop:function(){this.apStatus="stop",e.clearInterval(this.autoPlayInterval)},checkAp:function(){"stop"!==this.apStatus&&this.play()},play:function(){var t=this;return t.apStatus="play",!1===t.options.autoPlay?!1:(e.clearInterval(t.autoPlayInterval),void(t.autoPlayInterval=e.setInterval(function(){t.next(!0)},t.options.autoPlay)))},swapSpeed:function(t){"slideSpeed"===t?this.$owlWrapper.css(this.addCssSpeed(this.options.slideSpeed)):"paginationSpeed"===t?this.$owlWrapper.css(this.addCssSpeed(this.options.paginationSpeed)):"string"!=typeof t&&this.$owlWrapper.css(this.addCssSpeed(t))},addCssSpeed:function(t){return{"-webkit-transition":"all "+t+"ms ease","-moz-transition":"all "+t+"ms ease","-o-transition":"all "+t+"ms ease",transition:"all "+t+"ms ease"}},removeTransition:function(){return{"-webkit-transition":"","-moz-transition":"","-o-transition":"",transition:""}},doTranslate:function(t){return{"-webkit-transform":"translate3d("+t+"px, 0px, 0px)","-moz-transform":"translate3d("+t+"px, 0px, 0px)","-o-transform":"translate3d("+t+"px, 0px, 0px)","-ms-transform":"translate3d("+t+"px, 0px, 0px)",transform:"translate3d("+t+"px, 0px,0px)"}},transition3d:function(t){this.$owlWrapper.css(this.doTranslate(t))},css2move:function(t){this.$owlWrapper.css({left:t})},css2slide:function(t,e){var i=this;i.isCssFinish=!1,i.$owlWrapper.stop(!0,!0).animate({left:t},{duration:e||i.options.slideSpeed,complete:function(){i.isCssFinish=!0}})},checkBrowser:function(){var t=i.createElement("div");t.style.cssText="  -moz-transform:translate3d(0px, 0px, 0px); -ms-transform:translate3d(0px, 0px, 0px); -o-transform:translate3d(0px, 0px, 0px); -webkit-transform:translate3d(0px, 0px, 0px); transform:translate3d(0px, 0px, 0px)",t=t.style.cssText.match(/translate3d\(0px, 0px, 0px\)/g),this.browser={support3d:null!==t&&1===t.length,isTouch:"ontouchstart"in e||e.navigator.msMaxTouchPoints}},moveEvents:function(){!1===this.options.mouseDrag&&!1===this.options.touchDrag||(this.gestures(),this.disabledEvents())},eventTypes:function(){var t=["s","e","x"];this.ev_types={},!0===this.options.mouseDrag&&!0===this.options.touchDrag?t=["touchstart.owl mousedown.owl","touchmove.owl mousemove.owl","touchend.owl touchcancel.owl mouseup.owl"]:!1===this.options.mouseDrag&&!0===this.options.touchDrag?t=["touchstart.owl","touchmove.owl","touchend.owl touchcancel.owl"]:!0===this.options.mouseDrag&&!1===this.options.touchDrag&&(t=["mousedown.owl","mousemove.owl","mouseup.owl"]),this.ev_types.start=t[0],this.ev_types.move=t[1],this.ev_types.end=t[2]},disabledEvents:function(){this.$elem.on("dragstart.owl",function(t){t.preventDefault()}),this.$elem.on("mousedown.disableTextSelect",function(e){return t(e.target).is("input, textarea, select, option")})},gestures:function(){function s(t){if(void 0!==t.touches)return{x:t.touches[0].pageX,y:t.touches[0].pageY};if(void 0===t.touches){if(void 0!==t.pageX)return{x:t.pageX,y:t.pageY};if(void 0===t.pageX)return{x:t.clientX,y:t.clientY}}}function o(e){"on"===e?(t(i).on(r.ev_types.move,n),t(i).on(r.ev_types.end,a)):"off"===e&&(t(i).off(r.ev_types.move),t(i).off(r.ev_types.end))}function n(o){o=o.originalEvent||o||e.event,r.newPosX=s(o).x-l.offsetX,r.newPosY=s(o).y-l.offsetY,r.newRelativeX=r.newPosX-l.relativePos,"function"==typeof r.options.startDragging&&!0!==l.dragging&&0!==r.newRelativeX&&(l.dragging=!0,r.options.startDragging.apply(r,[r.$elem])),(8<r.newRelativeX||-8>r.newRelativeX)&&!0===r.browser.isTouch&&(void 0!==o.preventDefault?o.preventDefault():o.returnValue=!1,l.sliding=!0),(10<r.newPosY||-10>r.newPosY)&&!1===l.sliding&&t(i).off("touchmove.owl"),r.newPosX=Math.max(Math.min(r.newPosX,r.newRelativeX/5),r.maximumPixels+r.newRelativeX/5),!0===r.browser.support3d?r.transition3d(r.newPosX):r.css2move(r.newPosX)}function a(i){i=i.originalEvent||i||e.event;var s;i.target=i.target||i.srcElement,l.dragging=!1,!0!==r.browser.isTouch&&r.$owlWrapper.removeClass("grabbing"),r.dragDirection=0>r.newRelativeX?r.owl.dragDirection="left":r.owl.dragDirection="right",0!==r.newRelativeX&&(s=r.getNewPosition(),r.goTo(s,!1,"drag"),l.targetElement===i.target&&!0!==r.browser.isTouch&&(t(i.target).on("click.disable",function(e){e.stopImmediatePropagation(),e.stopPropagation(),e.preventDefault(),t(e.target).off("click.disable")}),i=t._data(i.target,"events").click,s=i.pop(),i.splice(0,0,s))),o("off")}var r=this,l={offsetX:0,offsetY:0,baseElWidth:0,relativePos:0,position:null,minSwipe:null,maxSwipe:null,sliding:null,dargging:null,targetElement:null};r.isCssFinish=!0,r.$elem.on(r.ev_types.start,".owl-wrapper",function(i){i=i.originalEvent||i||e.event;var n;if(3===i.which)return!1;if(!(r.itemsAmount<=r.options.items)){if(!1===r.isCssFinish&&!r.options.dragBeforeAnimFinish||!1===r.isCss3Finish&&!r.options.dragBeforeAnimFinish)return!1;!1!==r.options.autoPlay&&e.clearInterval(r.autoPlayInterval),!0===r.browser.isTouch||r.$owlWrapper.hasClass("grabbing")||r.$owlWrapper.addClass("grabbing"),r.newPosX=0,r.newRelativeX=0,t(this).css(r.removeTransition()),n=t(this).position(),l.relativePos=n.left,l.offsetX=s(i).x-n.left,l.offsetY=s(i).y-n.top,o("on"),l.sliding=!1,l.targetElement=i.target||i.srcElement}})},getNewPosition:function(){var t=this.closestItem();return t>this.maximumItem?t=this.currentItem=this.maximumItem:0<=this.newPosX&&(this.currentItem=t=0),t},closestItem:function(){var e=this,i=!0===e.options.scrollPerPage?e.pagesInArray:e.positionsInArray,s=e.newPosX,o=null;return t.each(i,function(n,a){s-e.itemWidth/20>i[n+1]&&s-e.itemWidth/20<a&&"left"===e.moveDirection()?(o=a,e.currentItem=!0===e.options.scrollPerPage?t.inArray(o,e.positionsInArray):n):s+e.itemWidth/20<a&&s+e.itemWidth/20>(i[n+1]||i[n]-e.itemWidth)&&"right"===e.moveDirection()&&(!0===e.options.scrollPerPage?(o=i[n+1]||i[i.length-1],e.currentItem=t.inArray(o,e.positionsInArray)):(o=i[n+1],e.currentItem=n+1))}),e.currentItem},moveDirection:function(){var t;return 0>this.newRelativeX?(t="right",this.playDirection="next"):(t="left",this.playDirection="prev"),t},customEvents:function(){var t=this;t.$elem.on("owl.next",function(){t.next()}),t.$elem.on("owl.prev",function(){t.prev()}),t.$elem.on("owl.play",function(e,i){t.options.autoPlay=i,t.play(),t.hoverStatus="play"}),t.$elem.on("owl.stop",function(){t.stop(),t.hoverStatus="stop"}),t.$elem.on("owl.goTo",function(e,i){t.goTo(i)}),t.$elem.on("owl.jumpTo",function(e,i){t.jumpTo(i)})},stopOnHover:function(){var t=this;!0===t.options.stopOnHover&&!0!==t.browser.isTouch&&!1!==t.options.autoPlay&&(t.$elem.on("mouseover",function(){t.stop()}),t.$elem.on("mouseout",function(){"stop"!==t.hoverStatus&&t.play()}))},lazyLoad:function(){var e,i,s,o,n;if(!1===this.options.lazyLoad)return!1;for(e=0;e<this.itemsAmount;e+=1)i=t(this.$owlItems[e]),"loaded"!==i.data("owl-loaded")&&(s=i.data("owl-item"),o=i.find(".lazyOwl"),"string"!=typeof o.data("src")?i.data("owl-loaded","loaded"):(void 0===i.data("owl-loaded")&&(o.hide(),i.addClass("loading").data("owl-loaded","checked")),(n=!0===this.options.lazyFollow?s>=this.currentItem:!0)&&s<this.currentItem+this.options.items&&o.length&&this.lazyPreload(i,o)))},lazyPreload:function(t,i){function s(){t.data("owl-loaded","loaded").removeClass("loading"),i.removeAttr("data-src"),"fade"===a.options.lazyEffect?i.fadeIn(400):i.show(),"function"==typeof a.options.afterLazyLoad&&a.options.afterLazyLoad.apply(this,[a.$elem])}function o(){r+=1,a.completeImg(i.get(0))||!0===n?s():100>=r?e.setTimeout(o,100):s()}var n,a=this,r=0;"DIV"===i.prop("tagName")?(i.css("background-image","url("+i.data("src")+")"),n=!0):i[0].src=i.data("src"),o()},autoHeight:function(){function i(){var i=t(n.$owlItems[n.currentItem]).height();n.wrapperOuter.css("height",i+"px"),n.wrapperOuter.hasClass("autoHeight")||e.setTimeout(function(){n.wrapperOuter.addClass("autoHeight")},0)}function s(){o+=1,n.completeImg(a.get(0))?i():100>=o?e.setTimeout(s,100):n.wrapperOuter.css("height","")}var o,n=this,a=t(n.$owlItems[n.currentItem]).find("img");void 0!==a.get(0)?(o=0,s()):i()},completeImg:function(t){return t.complete&&("undefined"==typeof t.naturalWidth||0!==t.naturalWidth)},onVisibleItems:function(){var e;for(!0===this.options.addClassActive&&this.$owlItems.removeClass("active"),this.visibleItems=[],e=this.currentItem;e<this.currentItem+this.options.items;e+=1)this.visibleItems.push(e),!0===this.options.addClassActive&&t(this.$owlItems[e]).addClass("active");this.owl.visibleItems=this.visibleItems},transitionTypes:function(t){this.outClass="owl-"+t+"-out",this.inClass="owl-"+t+"-in"},singleItemTransition:function(){var t=this,e=t.outClass,i=t.inClass,s=t.$owlItems.eq(t.currentItem),o=t.$owlItems.eq(t.prevItem),n=Math.abs(t.positionsInArray[t.currentItem])+t.positionsInArray[t.prevItem],a=Math.abs(t.positionsInArray[t.currentItem])+t.itemWidth/2;t.isTransition=!0,t.$owlWrapper.addClass("owl-origin").css({"-webkit-transform-origin":a+"px","-moz-perspective-origin":a+"px","perspective-origin":a+"px"}),o.css({position:"relative",left:n+"px"}).addClass(e).on("webkitAnimationEnd oAnimationEnd MSAnimationEnd animationend",function(){t.endPrev=!0,o.off("webkitAnimationEnd oAnimationEnd MSAnimationEnd animationend"),t.clearTransStyle(o,e)}),s.addClass(i).on("webkitAnimationEnd oAnimationEnd MSAnimationEnd animationend",function(){t.endCurrent=!0,s.off("webkitAnimationEnd oAnimationEnd MSAnimationEnd animationend"),t.clearTransStyle(s,i)})},clearTransStyle:function(t,e){t.css({position:"",left:""}).removeClass(e),this.endPrev&&this.endCurrent&&(this.$owlWrapper.removeClass("owl-origin"),this.isTransition=this.endCurrent=this.endPrev=!1)},owlStatus:function(){this.owl={userOptions:this.userOptions,baseElement:this.$elem,userItems:this.$userItems,owlItems:this.$owlItems,currentItem:this.currentItem,prevItem:this.prevItem,visibleItems:this.visibleItems,isTouch:this.browser.isTouch,browser:this.browser,dragDirection:this.dragDirection}},clearEvents:function(){this.$elem.off(".owl owl mousedown.disableTextSelect"),t(i).off(".owl owl"),t(e).off("resize",this.resizer)},unWrap:function(){0!==this.$elem.children().length&&(this.$owlWrapper.unwrap(),this.$userItems.unwrap().unwrap(),this.owlControls&&this.owlControls.remove()),this.clearEvents(),this.$elem.attr("style",this.$elem.data("owl-originalStyles")||"").attr("class",this.$elem.data("owl-originalClasses"))},destroy:function(){this.stop(),e.clearInterval(this.checkVisible),this.unWrap(),this.$elem.removeData()},reinit:function(e){e=t.extend({},this.userOptions,e),this.unWrap(),this.init(e,this.$elem)},addItem:function(t,e){var i;return t?0===this.$elem.children().length?(this.$elem.append(t),this.setVars(),!1):(this.unWrap(),i=void 0===e||-1===e?-1:e,i>=this.$userItems.length||-1===i?this.$userItems.eq(-1).after(t):this.$userItems.eq(i).before(t),void this.setVars()):!1},removeItem:function(t){return 0===this.$elem.children().length?!1:(t=void 0===t||-1===t?-1:t,this.unWrap(),this.$userItems.eq(t).remove(),void this.setVars())}};t.fn.owlCarousel=function(e){return this.each(function(){if(!0===t(this).data("owl-init"))return!1;t(this).data("owl-init",!0);var i=Object.create(s);i.init(e,this),t.data(this,"owlCarousel",i)})},t.fn.owlCarousel.options={items:5,itemsCustom:!1,itemsDesktop:[1199,4],itemsDesktopSmall:[979,3],itemsTablet:[768,2],itemsTabletSmall:!1,itemsMobile:[479,1],singleItem:!1,itemsScaleUp:!1,slideSpeed:200,paginationSpeed:800,rewindSpeed:1e3,autoPlay:!1,stopOnHover:!1,navigation:!1,navigationText:["prev","next"],rewindNav:!0,scrollPerPage:!1,pagination:!0,paginationNumbers:!1,responsive:!0,responsiveRefreshRate:200,responsiveBaseWidth:e,baseClass:"owl-carousel",theme:"owl-theme",lazyLoad:!1,lazyFollow:!0,lazyEffect:"fade",autoHeight:!1,jsonPath:!1,jsonSuccess:!1,dragBeforeAnimFinish:!0,mouseDrag:!0,touchDrag:!0,addClassActive:!1,transitionStyle:!1,beforeUpdate:!1,afterUpdate:!1,beforeInit:!1,afterInit:!1,beforeMove:!1,afterMove:!1,afterAction:!1,startDragging:!1,afterLazyLoad:!1}}(jQuery,window,document),!function(t,e,i,s){i.swipebox=function(o,n){var a,r,l={useCSS:!0,useSVG:!0,initialIndexOnArray:0,removeBarsOnMobile:!0,hideCloseButtonOnMobile:!1,hideBarsDelay:3e3,videoMaxWidth:1140,vimeoColor:"cccccc",beforeOpen:null,afterOpen:null,afterClose:null,afterMedia:null,nextSlide:null,prevSlide:null,loopAtEnd:!1,autoplayVideos:!1,queryStringData:{},toggleClassOnLoad:""},p=this,h=[],u=o.selector,d=navigator.userAgent.match(/(iPad)|(iPhone)|(iPod)|(Android)|(PlayBook)|(BB10)|(BlackBerry)|(Opera Mini)|(IEMobile)|(webOS)|(MeeGo)/i),c=null!==d||e.createTouch!==s||"ontouchstart"in t||"onmsgesturechange"in t||navigator.msMaxTouchPoints,m=!!e.createElementNS&&!!e.createElementNS("http://www.w3.org/2000/svg","svg").createSVGRect,f=t.innerWidth?t.innerWidth:i(t).width(),v=t.innerHeight?t.innerHeight:i(t).height(),w=0,g='<div id="swipebox-overlay">					<div id="swipebox-container">						<div id="swipebox-slider"></div>						<div id="swipebox-top-bar">							<div id="swipebox-title"></div>						</div>						<div id="swipebox-bottom-bar">							<div id="swipebox-arrows">								<a id="swipebox-prev"></a>								<a id="swipebox-next"></a>							</div>						</div>						<a id="swipebox-close"></a>					</div>			</div>';p.settings={},i.swipebox.close=function(){a.closeSlide()},i.swipebox.extend=function(){return a},p.init=function(){p.settings=i.extend({},l,n),i.isArray(o)?(h=o,a.target=i(t),a.init(p.settings.initialIndexOnArray)):i(e).on("click",u,function(t){if("slide current"===t.target.parentNode.className)return!1;i.isArray(o)||(a.destroy(),r=i(u),a.actions()),h=[];var e,s,n;n||(s="data-rel",n=i(this).attr(s)),n||(s="rel",n=i(this).attr(s)),r=n&&""!==n&&"nofollow"!==n?i(u).filter("["+s+'="'+n+'"]'):i(u),r.each(function(){var t=null,e=null;i(this).attr("title")&&(t=i(this).attr("title")),i(this).attr("href")&&(e=i(this).attr("href")),h.push({href:e,title:t})}),e=r.index(i(this)),t.preventDefault(),t.stopPropagation(),a.target=i(t.target),a.init(e)})},a={init:function(t){p.settings.beforeOpen&&p.settings.beforeOpen(),this.target.trigger("swipebox-start"),i.swipebox.isOpen=!0,this.build(),this.openSlide(t),this.openMedia(t),this.preloadMedia(t+1),this.preloadMedia(t-1),p.settings.afterOpen&&p.settings.afterOpen(t)},build:function(){var t,e=this;i("body").append(g),m&&p.settings.useSVG===!0&&(t=i("#swipebox-close").css("background-image"),t=t.replace("png","svg"),i("#swipebox-prev, #swipebox-next, #swipebox-close").css({"background-image":t})),d&&p.settings.removeBarsOnMobile&&i("#swipebox-bottom-bar, #swipebox-top-bar").remove(),i.each(h,function(){i("#swipebox-slider").append('<div class="slide"></div>')}),e.setDim(),e.actions(),c&&e.gesture(),e.keyboard(),e.animBars(),e.resize()},setDim:function(){var e,s,o={};"onorientationchange"in t?t.addEventListener("orientationchange",function(){0===t.orientation?(e=f,s=v):(90===t.orientation||-90===t.orientation)&&(e=v,s=f)},!1):(e=t.innerWidth?t.innerWidth:i(t).width(),s=t.innerHeight?t.innerHeight:i(t).height()),o={width:e,height:s},i("#swipebox-overlay").css(o)},resize:function(){var e=this;i(t).resize(function(){e.setDim()}).resize()},supportTransition:function(){var t,i="transition WebkitTransition MozTransition OTransition msTransition KhtmlTransition".split(" ");for(t=0;t<i.length;t++)if(e.createElement("div").style[i[t]]!==s)return i[t];return!1},doCssTrans:function(){return p.settings.useCSS&&this.supportTransition()?!0:void 0},gesture:function(){var t,e,s,o,n,a,r=this,l=!1,p=!1,u=10,d=50,c={},m={},v=i("#swipebox-top-bar, #swipebox-bottom-bar"),g=i("#swipebox-slider");v.addClass("visible-bars"),r.setTimeout(),i("body").bind("touchstart",function(r){return i(this).addClass("touching"),t=i("#swipebox-slider .slide").index(i("#swipebox-slider .slide.current")),m=r.originalEvent.targetTouches[0],c.pageX=r.originalEvent.targetTouches[0].pageX,c.pageY=r.originalEvent.targetTouches[0].pageY,i("#swipebox-slider").css({"-webkit-transform":"translate3d("+w+"%, 0, 0)",transform:"translate3d("+w+"%, 0, 0)"}),i(".touching").bind("touchmove",function(r){if(r.preventDefault(),r.stopPropagation(),m=r.originalEvent.targetTouches[0],!p&&(n=s,s=m.pageY-c.pageY,Math.abs(s)>=d||l)){var v=.75-Math.abs(s)/g.height();g.css({top:s+"px"}),g.css({opacity:v}),l=!0}o=e,e=m.pageX-c.pageX,a=100*e/f,!p&&!l&&Math.abs(e)>=u&&(i("#swipebox-slider").css({"-webkit-transition":"",transition:""}),p=!0),p&&(e>0?0===t?i("#swipebox-overlay").addClass("leftSpringTouch"):(i("#swipebox-overlay").removeClass("leftSpringTouch").removeClass("rightSpringTouch"),i("#swipebox-slider").css({"-webkit-transform":"translate3d("+(w+a)+"%, 0, 0)",transform:"translate3d("+(w+a)+"%, 0, 0)"})):0>e&&(h.length===t+1?i("#swipebox-overlay").addClass("rightSpringTouch"):(i("#swipebox-overlay").removeClass("leftSpringTouch").removeClass("rightSpringTouch"),i("#swipebox-slider").css({"-webkit-transform":"translate3d("+(w+a)+"%, 0, 0)",transform:"translate3d("+(w+a)+"%, 0, 0)"}))))}),!1}).bind("touchend",function(t){if(t.preventDefault(),t.stopPropagation(),i("#swipebox-slider").css({"-webkit-transition":"-webkit-transform 0.4s ease",transition:"transform 0.4s ease"}),s=m.pageY-c.pageY,e=m.pageX-c.pageX,a=100*e/f,l)if(l=!1,Math.abs(s)>=2*d&&Math.abs(s)>Math.abs(n)){var h=s>0?g.height():-g.height();g.animate({top:h+"px",opacity:0},300,function(){r.closeSlide()})}else g.animate({top:0,opacity:1},300);else p?(p=!1,e>=u&&e>=o?r.getPrev():-u>=e&&o>=e&&r.getNext()):v.hasClass("visible-bars")?(r.clearTimeout(),r.hideBars()):(r.showBars(),r.setTimeout());i("#swipebox-slider").css({"-webkit-transform":"translate3d("+w+"%, 0, 0)",transform:"translate3d("+w+"%, 0, 0)"}),i("#swipebox-overlay").removeClass("leftSpringTouch").removeClass("rightSpringTouch"),i(".touching").off("touchmove").removeClass("touching")})},setTimeout:function(){if(p.settings.hideBarsDelay>0){var e=this;e.clearTimeout(),e.timeout=t.setTimeout(function(){e.hideBars()},p.settings.hideBarsDelay)}},clearTimeout:function(){t.clearTimeout(this.timeout),this.timeout=null},showBars:function(){var t=i("#swipebox-top-bar, #swipebox-bottom-bar");this.doCssTrans()?t.addClass("visible-bars"):(i("#swipebox-top-bar").animate({top:0},500),i("#swipebox-bottom-bar").animate({bottom:0},500),setTimeout(function(){t.addClass("visible-bars")},1e3))},hideBars:function(){var t=i("#swipebox-top-bar, #swipebox-bottom-bar");this.doCssTrans()?t.removeClass("visible-bars"):(i("#swipebox-top-bar").animate({
top:"-50px"},500),i("#swipebox-bottom-bar").animate({bottom:"-50px"},500),setTimeout(function(){t.removeClass("visible-bars")},1e3))},animBars:function(){var t=this,e=i("#swipebox-top-bar, #swipebox-bottom-bar");e.addClass("visible-bars"),t.setTimeout(),i("#swipebox-slider").click(function(){e.hasClass("visible-bars")||(t.showBars(),t.setTimeout())}),i("#swipebox-bottom-bar").hover(function(){t.showBars(),e.addClass("visible-bars"),t.clearTimeout()},function(){p.settings.hideBarsDelay>0&&(e.removeClass("visible-bars"),t.setTimeout())})},keyboard:function(){var e=this;i(t).bind("keyup",function(t){t.preventDefault(),t.stopPropagation(),37===t.keyCode?e.getPrev():39===t.keyCode?e.getNext():27===t.keyCode&&e.closeSlide()})},actions:function(){var t=this,e="touchend click";h.length<2?(i("#swipebox-bottom-bar").hide(),s===h[1]&&i("#swipebox-top-bar").hide()):(i("#swipebox-prev").bind(e,function(e){e.preventDefault(),e.stopPropagation(),t.getPrev(),t.setTimeout()}),i("#swipebox-next").bind(e,function(e){e.preventDefault(),e.stopPropagation(),t.getNext(),t.setTimeout()})),i("#swipebox-close").bind(e,function(){t.closeSlide()})},setSlide:function(t,e){e=e||!1;var s=i("#swipebox-slider");w=100*-t,this.doCssTrans()?s.css({"-webkit-transform":"translate3d("+100*-t+"%, 0, 0)",transform:"translate3d("+100*-t+"%, 0, 0)"}):s.animate({left:100*-t+"%"}),i("#swipebox-slider .slide").removeClass("current"),i("#swipebox-slider .slide").eq(t).addClass("current"),this.setTitle(t),e&&s.fadeIn(),i("#swipebox-prev, #swipebox-next").removeClass("disabled"),0===t?i("#swipebox-prev").addClass("disabled"):t===h.length-1&&p.settings.loopAtEnd!==!0&&i("#swipebox-next").addClass("disabled")},openSlide:function(e){i("html").addClass("swipebox-html"),c?(i("html").addClass("swipebox-touch"),p.settings.hideCloseButtonOnMobile&&i("html").addClass("swipebox-no-close-button")):i("html").addClass("swipebox-no-touch"),i(t).trigger("resize"),this.setSlide(e,!0)},preloadMedia:function(t){var e=this,i=null;h[t]!==s&&(i=h[t].href),e.isVideo(i)?e.openMedia(t):setTimeout(function(){e.openMedia(t)},1e3)},openMedia:function(t){var e,o,n=this;return h[t]!==s&&(e=h[t].href),0>t||t>=h.length?!1:(o=i("#swipebox-slider .slide").eq(t),void(n.isVideo(e)?(o.html(n.getVideo(e)),p.settings.afterMedia&&p.settings.afterMedia(t)):(o.addClass("slide-loading"),n.loadMedia(e,function(){o.removeClass("slide-loading"),o.html(this),p.settings.afterMedia&&p.settings.afterMedia(t)}))))},setTitle:function(t){var e=null;i("#swipebox-title").empty(),h[t]!==s&&(e=h[t].title),e?(i("#swipebox-top-bar").show(),i("#swipebox-title").append(e)):i("#swipebox-top-bar").hide()},isVideo:function(t){if(t){if(t.match(/(youtube\.com|youtube-nocookie\.com)\/watch\?v=([a-zA-Z0-9\-_]+)/)||t.match(/vimeo\.com\/([0-9]*)/)||t.match(/youtu\.be\/([a-zA-Z0-9\-_]+)/))return!0;if(t.toLowerCase().indexOf("swipeboxvideo=1")>=0)return!0}},parseUri:function(t,s){var o=e.createElement("a"),n={};return o.href=decodeURIComponent(t),o.search&&(n=JSON.parse('{"'+o.search.toLowerCase().replace("?","").replace(/&/g,'","').replace(/=/g,'":"')+'"}')),i.isPlainObject(s)&&(n=i.extend(n,s,p.settings.queryStringData)),i.map(n,function(t,e){return t&&t>""?encodeURIComponent(e)+"="+encodeURIComponent(t):void 0}).join("&")},getVideo:function(t){var e="",i=t.match(/((?:www\.)?youtube\.com|(?:www\.)?youtube-nocookie\.com)\/watch\?v=([a-zA-Z0-9\-_]+)/),s=t.match(/(?:www\.)?youtu\.be\/([a-zA-Z0-9\-_]+)/),o=t.match(/(?:www\.)?vimeo\.com\/([0-9]*)/),n="";return i||s?(s&&(i=s),n=a.parseUri(t,{autoplay:p.settings.autoplayVideos?"1":"0",v:""}),e='<iframe width="560" height="315" src="//'+i[1]+"/embed/"+i[2]+"?"+n+'" frameborder="0" allowfullscreen></iframe>'):o?(n=a.parseUri(t,{autoplay:p.settings.autoplayVideos?"1":"0",byline:"0",portrait:"0",color:p.settings.vimeoColor}),e='<iframe width="560" height="315"  src="//player.vimeo.com/video/'+o[1]+"?"+n+'" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>'):e='<iframe width="560" height="315" src="'+t+'" frameborder="0" allowfullscreen></iframe>','<div class="swipebox-video-container" style="max-width:'+p.settings.videoMaxWidth+'px"><div class="swipebox-video">'+e+"</div></div>"},loadMedia:function(t,e){if(0===t.trim().indexOf("#"))e.call(i("<div>",{"class":"swipebox-inline-container"}).append(i(t).clone().toggleClass(p.settings.toggleClassOnLoad)));else if(!this.isVideo(t)){var s=i("<img>").on("load",function(){e.call(s)});s.attr("src",t)}},getNext:function(){var t,e=this,s=i("#swipebox-slider .slide").index(i("#swipebox-slider .slide.current"));s+1<h.length?(t=i("#swipebox-slider .slide").eq(s).contents().find("iframe").attr("src"),i("#swipebox-slider .slide").eq(s).contents().find("iframe").attr("src",t),s++,e.setSlide(s),e.preloadMedia(s+1),p.settings.nextSlide&&p.settings.nextSlide(s)):p.settings.loopAtEnd===!0?(t=i("#swipebox-slider .slide").eq(s).contents().find("iframe").attr("src"),i("#swipebox-slider .slide").eq(s).contents().find("iframe").attr("src",t),s=0,e.preloadMedia(s),e.setSlide(s),e.preloadMedia(s+1),p.settings.nextSlide&&p.settings.nextSlide(s)):(i("#swipebox-overlay").addClass("rightSpring"),setTimeout(function(){i("#swipebox-overlay").removeClass("rightSpring")},500))},getPrev:function(){var t,e=i("#swipebox-slider .slide").index(i("#swipebox-slider .slide.current"));e>0?(t=i("#swipebox-slider .slide").eq(e).contents().find("iframe").attr("src"),i("#swipebox-slider .slide").eq(e).contents().find("iframe").attr("src",t),e--,this.setSlide(e),this.preloadMedia(e-1),p.settings.prevSlide&&p.settings.prevSlide(e)):(i("#swipebox-overlay").addClass("leftSpring"),setTimeout(function(){i("#swipebox-overlay").removeClass("leftSpring")},500))},nextSlide:function(t){},prevSlide:function(t){},closeSlide:function(){i("html").removeClass("swipebox-html"),i("html").removeClass("swipebox-touch"),i(t).trigger("resize"),this.destroy()},destroy:function(){i(t).unbind("keyup"),i("body").unbind("touchstart"),i("body").unbind("touchmove"),i("body").unbind("touchend"),i("#swipebox-slider").unbind(),i("#swipebox-overlay").remove(),i.isArray(o)||o.removeData("_swipebox"),this.target&&this.target.trigger("swipebox-destroy"),i.swipebox.isOpen=!1,p.settings.afterClose&&p.settings.afterClose()}},p.init()},i.fn.swipebox=function(t){if(!i.data(this,"_swipebox")){var e=new i.swipebox(this,t);this.data("_swipebox",e)}return this.data("_swipebox")}}(window,document,jQuery),newTimeFunction();var url=wpurl.siteurl;jQuery(document).ready(function(t){toggleNavSubMenus("#header-nav .menu-main-container .menu > li"),hideNavigation("body.attachment .navigation-links"),addSwipeBoxGallery(".gallery"),t("#front-page-sections #recent-reviews .insprvw-recent-reviews").owlCarousel({pagination:!1,navigation:!0,navigationText:['<span class="icon icon-chevron-left"></span>','<span class="icon icon-chevron-right"></span>']})});