function addFeatherLightGallery(e){jQuery(e).each(function(){var e,n=jQuery(this),o=n.attr("id"),s=n.find(".gallery-item .gallery-icon a");jQuery(s).each(function(){var n=jQuery(this),s=/\.(gif|jpg|jpeg|tiff|png|bmp|svg)$/i.test(n.attr("href"));return 0==s?(e=!1,!1):void(e=o)}),e==o&&jQuery(s).featherlightGallery({previousIcon:'<span class="icon icon-chevron-left"></span>',nextIcon:'<span class="icon icon-chevron-right"></span>',closeIcon:'<span class="icon icon-close"></span>',galleryFadeIn:300,openSpeed:300,afterOpen:function(e){jQuery("body, html").addClass("featherlight-open")},afterClose:function(e){jQuery("body, html").removeClass("featherlight-open")}})})}function scrollOnPage(e,n,o){jQuery(window).scroll(function(){jQuery(this).scrollTop()>n?jQuery(e).fadeIn():jQuery(e).fadeOut()}),jQuery(e).click(function(){return jQuery("html, body").animate({scrollTop:o},1e3),!1})}function toggleSpoilerContent(){jQuery(".spoiler").each(function(){var e=jQuery(this),n=e.find(".spoiler-close"),o=e.find(".spoiler-open"),s=e.find(".spoiler-content");n.add(s).addClass("spoiler-hide"),jQuery(o).click(function(){n.add(s).addClass("spoiler-show").removeClass("spoiler-hide"),o.addClass("spoiler-hide").removeClass("spoiler-show")}),jQuery(n).click(function(){n.add(s).addClass("spoiler-hide").removeClass("spoiler-show"),o.addClass("spoiler-show").removeClass("spoiler-hide")})})}function debounce(e,n,o){var s;return function(){var i=this,a=arguments,r=function(){s=null,o||e.apply(i,a)},l=o&&!s;clearTimeout(s),s=setTimeout(r,n),l&&e.apply(i,a)}}function initializeMobileMenu(e){function n(){r.hasClass("show")?(r.removeClass("show"),jQuery("body, html").removeClass("mobile-open")):(r.addClass("show"),jQuery("body, html").addClass("mobile-open"))}function o(){var e=window.innerWidth/baseFontSize,o=document.documentElement.clientWidth/baseFontSize,a=document.body.clientWidth/baseFontSize,c=l/baseFontSize;if(c>=(e||o||a)){if(!t){var d='<header class="mobile-menu-header"><span class="mobile-header">Menu</span><span class="icon icon-remove"></span></header>';jQuery(d).appendTo(r),jQuery(".mobile-menu-header .icon-remove").click(function(){n()}),s.detach().appendTo(r),s.children("ul").children("li").each(function(){var e=jQuery(this),n=e.children("ul");n.length>0&&jQuery('<span class="icon icon-chevron-right slide-submenu"></span>').insertBefore(n)}),jQuery(".slide-submenu").click(function(){jQuery(this).next().hasClass("slide-open")?(s.children("ul").children("li").removeClass("slide-close"),jQuery(this).next().add(jQuery(this).parent()).removeClass("slide-open")):(s.children("ul").children("li").addClass("slide-close"),jQuery(this).next().add(jQuery(this).parent()).addClass("slide-open").removeClass("slide-close"))}),t=!0}}else t&&(jQuery(".mobile-menu-header").remove(),s.detach().appendTo(i),jQuery(".slide-submenu").remove(),jQuery("ul, li").removeClass("slide-open"),jQuery("li").removeClass("slide-close"),jQuery("body, html").removeClass("mobile-open"),r.removeClass("show"),t=!1)}var s=jQuery(e.menu),i=jQuery(e.menuContainer),a=jQuery(e.mobileButton),r=jQuery(e.mobileMenu),l=e.width,t=!1;a.click(function(){n()}),o();var c=debounce(function(){o()},100);window.addEventListener("resize",c)}var bottomDistance=jQuery(document).height()+jQuery(window).height(),baseFontSize=16,body=document.getElementsByTagName("body");if(body[0].getAttribute("data-class"))var bodyClass=body[0].getAttribute("data-class").replace(/[^a-zA-Z ]/g,"").trim().replace(/ /g,"-").replace(/-+/g,"-");bodyClass&&(body[0].className=body[0].className+(" "+bodyClass)),jQuery(document).ready(function(e){var n=e(".topicreview");n.length&&n[0].scrollHeight>400&&n.wrapInner('<div class="topicreview-wrapper"></div>');var o=e(".section-search .pagination");jQuery(o).each(function(){var n=e(this).text();n.indexOf("Search found 0 matches")>=0&&e(this).parent(".action-bar").hide()});var s=e(".cp-menu"),i=e(".cp-main");(s||i)&&(s.parent().addClass("cp-wrapper"),i.parent().addClass("cp-wrapper")),scrollOnPage(".scroll-to-top",100,0),scrollOnPage(".scroll-to-bottom",100,bottomDistance)});