function addFeatherLightGallery(e){jQuery(e).each(function(){var e,n=jQuery(this),i=n.attr("id"),s=n.find(".gallery-item .gallery-icon a");jQuery(s).each(function(){var n=jQuery(this),s=/\.(gif|jpg|jpeg|tiff|png|bmp|svg)$/i.test(n.attr("href"));return 0==s?(e=!1,!1):void(e=i)}),e==i&&jQuery(s).featherlightGallery({previousIcon:'<span class="icon icon-chevron-left"></span>',nextIcon:'<span class="icon icon-chevron-right"></span>',closeIcon:'<span class="icon icon-close"></span>',galleryFadeIn:300,openSpeed:300,afterOpen:function(e){jQuery("body, html").addClass("featherlight-open")},afterClose:function(e){jQuery("body, html").removeClass("featherlight-open")}})})}function scrollOnPage(e,n,i){jQuery(window).scroll(function(){jQuery(this).scrollTop()>n?jQuery(e).fadeIn():jQuery(e).fadeOut()}),jQuery(e).click(function(){return jQuery("html, body").animate({scrollTop:i},1e3),!1})}function toggleSpoilerContent(){jQuery(".spoiler").each(function(){var e=jQuery(this),n=e.find(".spoiler-close"),i=e.find(".spoiler-open"),s=e.find(".spoiler-content");n.add(s).addClass("spoiler-hide"),jQuery(i).click(function(){n.add(s).addClass("spoiler-show").removeClass("spoiler-hide"),i.addClass("spoiler-hide").removeClass("spoiler-show")}),jQuery(n).click(function(){n.add(s).addClass("spoiler-hide").removeClass("spoiler-show"),i.addClass("spoiler-show").removeClass("spoiler-hide")})})}function debounce(e,n,i){var s;return function(){var o=this,a=arguments,l=function(){s=null,i||e.apply(o,a)},r=i&&!s;clearTimeout(s),s=setTimeout(l,n),r&&e.apply(o,a)}}function initializeMobileMenu(e){function n(){l.hasClass("show")?(l.removeClass("show"),jQuery("body, html").removeClass("mobile-open")):(l.addClass("show"),jQuery("body, html").addClass("mobile-open"))}function i(){var e=window.innerWidth/baseFontSize,i=document.documentElement.clientWidth/baseFontSize,a=document.body.clientWidth/baseFontSize,d=r/baseFontSize;if(d>=(e||i||a)){if(!t){var c='<header class="mobile-menu-header"><span class="mobile-header">Menu</span><span class="icon icon-remove"></span></header>';jQuery(c).appendTo(l),jQuery(".mobile-menu-header .icon-remove").click(function(){n()}),s.detach().appendTo(l),s.children("ul").children("li").each(function(){var e=jQuery(this),n=e.children("ul");n.length>0&&jQuery('<span class="icon icon-chevron-right slide-submenu"></span>').insertBefore(n)}),jQuery(".slide-submenu").click(function(){jQuery(this).next().hasClass("slide-open")?(s.children("ul").children("li").removeClass("slide-close"),jQuery(this).next().add(jQuery(this).parent()).removeClass("slide-open")):(s.children("ul").children("li").addClass("slide-close"),jQuery(this).next().add(jQuery(this).parent()).addClass("slide-open").removeClass("slide-close"))}),t=!0}}else t&&(jQuery(".mobile-menu-header").remove(),s.detach().appendTo(o),jQuery(".slide-submenu").remove(),jQuery("ul, li").removeClass("slide-open"),jQuery("li").removeClass("slide-close"),jQuery("body, html").removeClass("mobile-open"),l.removeClass("show"),t=!1)}var s=jQuery(e.menu),o=jQuery(e.menuContainer),a=jQuery(e.mobileButton),l=jQuery(e.mobileMenu),r=e.width,t=!1;a.click(function(){n()}),i();var d=debounce(function(){i()},100);window.addEventListener("resize",d)}var bottomDistance=jQuery(document).height()+jQuery(window).height(),baseFontSize=16,body=document.getElementsByTagName("body");if(body[0].getAttribute("data-class"))var bodyClass=body[0].getAttribute("data-class").replace(/[^a-zA-Z ]/g,"").trim().replace(/ /g,"-").replace(/-+/g,"-");bodyClass&&(body[0].className=body[0].className+(" "+bodyClass)),jQuery(document).ready(function(e){var n=e(".section-posting .topicreview");n.length&&n[0].scrollHeight>400&&n.wrapInner('<div class="topicreview-wrapper"></div>');var i=e(".cp-main .topicreview");i.length&&i[0].scrollHeight>375?i.addClass("scrollable"):e(".cp-main .review .right-box").hide();var s=e(".mcp-main #post_details");s.length&&s[0].scrollHeight>375?s.addClass("scrollable"):e(".mcp-main .post-buttons #expand").hide();var o=e("#pmheader-postingbox");0==e(o).find("fieldset.fields1").children().length&&e(o).hide();var a=e(".mcp-main .pagination");0==e(a).find("ul").children().length&&e(a).hide();var l=e(".section-search .pagination");jQuery(l).each(function(){var n=e(this).text();n.indexOf("Search found 0 matches")>=0&&e(this).parent(".action-bar").hide()});var r=e(".cp-menu"),t=e(".cp-main");(r||t)&&(r.parent().addClass("cp-wrapper"),t.parent().addClass("cp-wrapper")),scrollOnPage(".scroll-to-top",100,0),scrollOnPage(".scroll-to-bottom",100,bottomDistance)});