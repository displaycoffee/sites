function checkForClasses(e){return e.className?" ":""}function isMobile(e,a){var o=window.innerWidth/e,n=document.documentElement.clientWidth/e,t=document.body.clientWidth/e;return a>=(o||n||t)}function addBodyClass(){if(body.getAttribute("data-class"))var e=body.getAttribute("data-class").replace(/[^a-zA-Z ]/g,"").trim().replace(/ /g,"-").replace(/-+/g,"-");e&&(body.className+=checkForClasses(body)+e)}function addForumImageClass(){var e=document.querySelectorAll(".list-inner .forum-image");if(e.length)for(var a=0;a<e.length;a++){var o=e[a].parentNode.parentNode.parentNode;o.className+=checkForClasses(o)+"has-forum-image"}}function addFieldsetClasses(){var e=document.querySelectorAll("fieldset:not(.polls) dl:not(.pmlist) dd");if(e.length)for(var a=0;a<e.length;a++)e[a].children.length>1&&(e[a].className+=checkForClasses(e[a])+"has-multiple-fields"),-1!==e[a].innerHTML.indexOf("&nbsp;")&&(e[a].className+=checkForClasses(e[a])+"has-space")}function addNoPaginationClass(){var e=document.querySelector(".action-bar .pagination");if(e){var a=e.innerText.toLowerCase(),o="page 1 of 1";if(-1!==a.indexOf(o)){var n=new RegExp(o,"gi"),t=a.replace(n,"").match(/\d+/g);t&&0>=t&&(body.className+=checkForClasses(body)+"no-pagination")}}}function addImageWrapper(e){var a=document.querySelectorAll(e);if(a.length)for(var o=0;o<a.length;o++){var n=document.createElement("div");n.setAttribute("class","image-wrap"),a[o].parentNode.insertBefore(n,a[o]),n.appendChild(a[o])}}function checkForEmpty(e){var a=document.querySelectorAll(e);if(a.length)for(var o=0;o<a.length;o++)a[o].parentNode.style.display="none"}function checkForSpace(e){jQuery(e).each(function(){var e=jQuery(this);"&nbsp;"==e.html()||"<label>&nbsp;</label>"==e.html()?e.addClass("empty-space"):e.removeClass("empty-space")})}function addScrollableArea(e,a,o){e.length&&e[0].scrollHeight>a?(e.addClass("scrollable"),e.wrapInner('<div class="scrollable-wrapper"></div>')):o.hide()}function updateaAttachmentDisplay(e){jQuery(e).on("click",function(e){var a=jQuery(this).closest(".file").parent();a.hasClass("image-expanded")?a.removeClass("image-expanded"):a.addClass("image-expanded")})}function formatDisplayActions(){jQuery(".display-actions").each(function(){var e=jQuery(this);e.html(e.html().replace(/&nbsp;/g,"").replace(/::/g,"&bull;"));var a=e.find(" div a");-1!==a.text().toLowerCase().indexOf("mark")&&a.parent("div").addClass("mark-actions");var o=e.children("select");o.each(function(){jQuery(this).next(".button1, .button2").addBack().wrapAll('<div class="select-actions"></div>')}),e.wrapInner('<div class="display-actions-wrapper"></div>')})}function addOnScroll(e,a,o){var a=jQuery(a).offset().top,n=jQuery(window),t=!1;n.scroll(function(){0==t?n.scrollTop()>a&&(jQuery(e).addClass(o),t=!0):n.scrollTop()<=a&&(jQuery(e).removeClass(o),t=!1)})}function scrollOnPage(e,a,o){addOnScroll(e,".site-description","scroll-to-visible"),jQuery(e).on("click",function(){return jQuery("html, body").animate({scrollTop:o},1e3),!1})}function toggleMobileContent(e,a){jQuery(e).off().on("click",function(){jQuery(a).hasClass("toggle-show")?jQuery(a).removeClass("toggle-show"):jQuery(a).addClass("toggle-show")})}function debounce(e,a,o){var n;return function(){var t=this,l=arguments,s=function(){n=null,o||e.apply(t,l)},i=o&&!n;clearTimeout(n),n=setTimeout(s,a),i&&e.apply(t,l)}}function initializeMobileMenu(e){function a(){s.hasClass("show")?(s.removeClass("show"),jQuery("body, html").removeClass("mobile-open")):(s.addClass("show"),jQuery("body, html").addClass("mobile-open"))}function o(){var o=isMobile(baseFontSize,i/baseFontSize);if(o){if(!r){jQuery(".mobile-menu-header .fa-times").off().on("click",function(){a()}),n.detach().appendTo(s),n.children(".dropdown-container").each(function(){jQuery('<i class="icon fa-chevron-right slide-submenu"></i>').appendTo(this)});var l=jQuery(e.mobileMenu+" > ul > li");l.find(" .slide-submenu").off().on("click",function(){var e=jQuery(this).parent();e.hasClass("dropdown-open")?(l.removeClass("dropdown-close"),e.removeClass("dropdown-open")):(l.addClass("dropdown-close"),e.removeClass("dropdown-close").addClass("dropdown-open"))}),r=!0}}else r&&(n.detach().appendTo(t),jQuery(".slide-submenu").remove(),jQuery("li").removeClass("dropdown-close").removeClass("dropdown-open"),jQuery("body, html").removeClass("mobile-open"),s.removeClass("show"),r=!1)}var n=jQuery(e.menu),t=jQuery(e.menuContainer),l=jQuery(e.mobileButton),s=jQuery(e.mobileMenu),i=e.width,r=!1;l.off().on("click",function(){a()}),o();var c=debounce(function(){o()},100);window.addEventListener("resize",c)}var body=document.querySelector("body"),baseFontSize=16;addBodyClass(),addForumImageClass(),addFieldsetClasses(),addNoPaginationClass(),addImageWrapper(".notification_list .list-inner > img"),addImageWrapper(".notification_list .notification-block > img"),checkForEmpty(".section-mcp-post-details .pagination ul"),checkForEmpty(".section-mcp-post-details .postbody .content pre");var bottomDistance=jQuery(document).height()+jQuery(window).height();jQuery(document).ready(function(e){checkForSpace("fieldset dl dt"),checkForSpace("dl.details dt"),addScrollableArea(e(".topicreview"),400,e(".review .right-box")),addScrollableArea(e(".mcp-main #post_details"),400,e(".mcp-main .post-buttons #expand"));var a=".attach-image";e(a).each(function(){e(this).prepend('<span class="image-open" onclick="viewableArea(this);"><i class="icon icon-xl fa-search-plus fa-fw" aria-hidden="true"></i></span>')}),updateaAttachmentDisplay(".image-open"),updateaAttachmentDisplay(a+" img"),formatDisplayActions();var o=e("#pmheader-postingbox");0==e(o).find("fieldset.fields1").children().length&&e(o).hide();var n=e(".cp-menu"),t=e(".cp-main");(n||t)&&(n.parent().addClass("cp-wrapper"),t.parent().addClass("cp-wrapper")),e("body").hasClass("simple-phpbb")||(addOnScroll("#page-header .navbar",".header-overlay","sticky"),scrollOnPage(".scroll-to-top",100,0),scrollOnPage(".scroll-to-bottom",100,bottomDistance)),toggleMobileContent(".toggle-links a","#page-welcome .site-callouts .site-links"),toggleMobileContent(".toggle-featured a","#featured-content"),initializeMobileMenu({menu:"#page-header .navbar > ul",menuContainer:"#page-header .navbar",mobileButton:".mobile-menu-button",mobileMenu:"#mobile-menu",width:768})});