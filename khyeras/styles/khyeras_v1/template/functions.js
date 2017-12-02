function checkForSpace(e){jQuery(e).each(function(){var e=jQuery(this);"&nbsp;"==e.html()||"<label>&nbsp;</label>"==e.html()?e.addClass("empty-space"):e.removeClass("empty-space")})}function removeSpaces(e){jQuery(e).each(function(){var e=jQuery(this);e.html(e.html().replace(/&nbsp;/g,""))})}function addScrollableArea(e,a,o){e.length&&e[0].scrollHeight>a?(e.addClass("scrollable"),e.wrapInner('<div class="scrollable-wrapper"></div>')):o.hide()}function updateaAttachmentDisplay(e){jQuery(e).on("click",function(e){var a=jQuery(this).closest(".file").parent();a.hasClass("image-expanded")?a.removeClass("image-expanded"):a.addClass("image-expanded")})}function formatDisplayActions(){jQuery(".display-actions").each(function(){var e=jQuery(this);e.html(e.html().replace(/&nbsp;/g,"").replace(/::/g,"&bull;"));var a=e.find(" div a");-1!==a.text().toLowerCase().indexOf("mark")&&a.parent("div").addClass("mark-actions");var o=e.children("select");o.each(function(){jQuery(this).next(".button1, .button2").addBack().wrapAll('<div class="select-actions"></div>')}),e.wrapInner('<div class="display-actions-wrapper"></div>')})}function addOnScroll(e,a,o){var a=jQuery(a).offset().top,n=jQuery(window),t=!1;n.scroll(function(){0==t?n.scrollTop()>a&&(jQuery(e).addClass(o),t=!0):n.scrollTop()<=a&&(jQuery(e).removeClass(o),t=!1)})}function addStickyNav(e,a){var a=jQuery(a).offset().top,o=jQuery(window),n=!1;o.scroll(function(){0==n?o.scrollTop()>a&&(jQuery(e).addClass("sticky"),n=!0):o.scrollTop()<=a&&(jQuery(e).removeClass("sticky"),n=!1)})}function scrollOnPage(e,a,o){addOnScroll(e,".site-description","scroll-to-visible"),jQuery(e).on("click",function(){return jQuery("html, body").animate({scrollTop:o},1e3),!1})}function toggleMobileContent(e,a){jQuery(e).off().on("click",function(){jQuery(a).hasClass("toggle-show")?jQuery(a).removeClass("toggle-show"):jQuery(a).addClass("toggle-show")})}function debounce(e,a,o){var n;return function(){var t=this,l=arguments,s=function(){n=null,o||e.apply(t,l)},i=o&&!n;clearTimeout(n),n=setTimeout(s,a),i&&e.apply(t,l)}}function initializeMobileMenu(e){function a(){s.hasClass("show")?(s.removeClass("show"),jQuery("body, html").removeClass("mobile-open")):(s.addClass("show"),jQuery("body, html").addClass("mobile-open"))}function o(){var o=window.innerWidth/baseFontSize,l=document.documentElement.clientWidth/baseFontSize,d=document.body.clientWidth/baseFontSize,c=i/baseFontSize;if(c>=(o||l||d)){if(!r){jQuery(".mobile-menu-header .fa-times").off().on("click",function(){a()}),n.detach().appendTo(s),n.children(".dropdown-container").each(function(){jQuery('<i class="icon fa-chevron-right slide-submenu"></i>').appendTo(this)});var u=jQuery(e.mobileMenu+" > ul > li");u.find(" .slide-submenu").off().on("click",function(){var e=jQuery(this).parent();e.hasClass("dropdown-open")?(u.removeClass("dropdown-close"),e.removeClass("dropdown-open")):(u.addClass("dropdown-close"),e.removeClass("dropdown-close").addClass("dropdown-open"))}),r=!0}}else r&&(n.detach().appendTo(t),jQuery(".slide-submenu").remove(),jQuery("li").removeClass("dropdown-close").removeClass("dropdown-open"),jQuery("body, html").removeClass("mobile-open"),s.removeClass("show"),r=!1)}var n=jQuery(e.menu),t=jQuery(e.menuContainer),l=jQuery(e.mobileButton),s=jQuery(e.mobileMenu),i=e.width,r=!1;l.off().on("click",function(){a()}),o();var d=debounce(function(){o()},100);window.addEventListener("resize",d)}var bottomDistance=jQuery(document).height()+jQuery(window).height(),baseFontSize=16,body=document.getElementsByTagName("body");if(body[0].getAttribute("data-class"))var bodyClass=body[0].getAttribute("data-class").replace(/[^a-zA-Z ]/g,"").trim().replace(/ /g,"-").replace(/-+/g,"-");bodyClass&&(body[0].className=body[0].className+(" "+bodyClass));var forumImage=document.querySelectorAll(".list-inner .forum-image");if(forumImage.length)for(var i=0;i<forumImage.length;i++){var parentRow=forumImage[i].parentNode.parentNode.parentNode;parentRow.className=parentRow.className+" has-forum-image"}jQuery(document).ready(function(e){checkForSpace("fieldset dl dt"),checkForSpace("dl.details dt"),removeSpaces("fieldset dl dd"),addScrollableArea(e(".topicreview"),400,e(".review .right-box")),addScrollableArea(e(".mcp-main #post_details"),400,e(".mcp-main .post-buttons #expand"));var a=".attach-image";e(a).each(function(){e(this).prepend('<span class="image-open" onclick="viewableArea(this);"><i class="icon icon-xl fa-search-plus fa-fw" aria-hidden="true"></i></span>')}),updateaAttachmentDisplay(".image-open"),updateaAttachmentDisplay(a+" img"),formatDisplayActions();var o=e("#pmheader-postingbox");0==e(o).find("fieldset.fields1").children().length&&e(o).hide();var n=e(".mcp-main .pagination");0==e(n).find("ul").children().length&&e(n).hide();var t=e(".cp-menu"),l=e(".cp-main");(t||l)&&(t.parent().addClass("cp-wrapper"),l.parent().addClass("cp-wrapper")),e("body").hasClass("simple-phpbb")||(addOnScroll("#page-header .navbar",".header-overlay","sticky"),scrollOnPage(".scroll-to-top",100,0),scrollOnPage(".scroll-to-bottom",100,bottomDistance)),toggleMobileContent(".toggle-links a","#page-welcome .site-callouts .site-links"),toggleMobileContent(".toggle-featured a","#featured-content"),initializeMobileMenu({menu:"#page-header .navbar > ul",menuContainer:"#page-header .navbar",mobileButton:".mobile-menu-button",mobileMenu:"#mobile-menu",width:768})});