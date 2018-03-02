function checkForClasses(e){return e.className?" ":""}function isMobile(e,o){var n=window.innerWidth/e,a=document.documentElement.clientWidth/e,t=document.body.clientWidth/e;return o>=(n||a||t)}function addBodyClass(){if(body.getAttribute("data-class"))var e=body.getAttribute("data-class").replace(/[^a-zA-Z ]/g,"").trim().replace(/ /g,"-").replace(/-+/g,"-");e&&(body.className+=checkForClasses(body)+e)}function addForumImageClass(){var e=document.querySelectorAll(".list-inner .forum-image");if(e.length)for(var o=0;o<e.length;o++){var n=e[o].parentNode.parentNode.parentNode;n.className+=checkForClasses(n)+"has-forum-image"}}function addFieldsetClasses(){var e=document.querySelectorAll("fieldset:not(.polls) dl:not(.pmlist) dd");if(e.length)for(var o=0;o<e.length;o++)e[o].children.length>1&&(e[o].className+=checkForClasses(e[o])+"has-multiple-fields"),-1!==e[o].innerHTML.indexOf("&nbsp;")&&(e[o].className+=checkForClasses(e[o])+"has-space")}function addNoPaginationClass(){var e=document.querySelector(".action-bar .pagination");if(e){var o=e.innerText.toLowerCase(),n="page 1 of 1";if(-1!==o.indexOf(n)){var a=new RegExp(n,"gi"),t=o.replace(a,"").match(/\d+/g);t&&0>=t&&(body.className+=checkForClasses(body)+"no-pagination")}}}function noContentListing(){var e=["This board has no forums.","You do not have the required permissions to view or read topics within this forum.","There are no topics or posts in this forum.","This category has no forums.","No suitable matches were found."],o=document.querySelectorAll(".action-bar + .panel .inner");if(o.length)for(var n=0;n<o.length;n++)-1!==e.indexOf(o[n].innerText)&&(o[n].className+=checkForClasses(o[n])+"no-content")}function addSearchIgnoredClass(){var e=document.querySelectorAll(".search.post .postbody");if(e.length)for(var o=0;o<e.length;o++)-1!==e[o].innerHTML.indexOf("ignore list")&&(e[o].className+=checkForClasses(e[o])+"ignore")}function checkForNewPM(){var e=document.querySelectorAll('.cp-menu ul li a[href*="folder"]');if(e.length)for(var o=0;o<e.length;o++)-1!==e[o].innerHTML.indexOf("strong")&&(e[o].className+=checkForClasses(e[o])+"new-pm")}function addImageWrapper(e){var o=document.querySelectorAll(e);if(o.length)for(var n=0;n<o.length;n++){var a=document.createElement("div");a.setAttribute("class","image-wrap"),o[n].parentNode.insertBefore(a,o[n]),a.appendChild(o[n])}}function checkForEmpty(e){var o=document.querySelectorAll(e);if(o.length)for(var n=0;n<o.length;n++)o[n].parentNode.style.display="none"}function checkForSpace(e){jQuery(e).each(function(){var e=jQuery(this);"&nbsp;"==e.html()||"<label>&nbsp;</label>"==e.html()?e.addClass("empty-space"):e.removeClass("empty-space")})}function addScrollableArea(e,o,n){e.length&&e[0].scrollHeight>o?(e.addClass("scrollable"),e.wrapInner('<div class="scrollable-wrapper"></div>')):n.hide()}function updateaAttachmentDisplay(e){jQuery(e).on("click",function(e){var o=jQuery(this).closest(".file").parent();o.hasClass("image-expanded")?o.removeClass("image-expanded"):o.addClass("image-expanded")})}function formatDisplayActions(){jQuery(".display-actions").each(function(){var e=jQuery(this);e.html(e.html().replace(/&nbsp;/g,"").replace(/::/g,"&bull;"));var o=e.find(" div a");-1!==o.text().toLowerCase().indexOf("mark")&&o.parent("div").addClass("mark-actions");var n=e.children("select");n.each(function(){jQuery(this).next(".button1, .button2").addBack().wrapAll('<div class="select-actions"></div>')}),e.wrapInner('<div class="display-actions-wrapper"></div>')})}function addOnScroll(e,o,n){var o=jQuery(o).offset().top,a=jQuery(window),t=!1;a.scroll(function(){0==t?a.scrollTop()>o&&(jQuery(e).addClass(n),t=!0):a.scrollTop()<=o&&(jQuery(e).removeClass(n),t=!1)})}function scrollOnPage(e,o,n){addOnScroll(e,".site-description","scroll-to-visible"),jQuery(e).on("click",function(){return jQuery("html, body").animate({scrollTop:n},1e3),!1})}function toggleMobileContent(e,o){jQuery(e).off().on("click",function(){jQuery(o).hasClass("toggle-show")?jQuery(o).removeClass("toggle-show"):jQuery(o).addClass("toggle-show")})}function debounce(e,o,n){var a;return function(){var t=this,i=arguments,s=function(){a=null,n||e.apply(t,i)},l=n&&!a;clearTimeout(a),a=setTimeout(s,o),l&&e.apply(t,i)}}function initializeMobileMenu(e){function o(){s.hasClass("show")?(s.removeClass("show"),jQuery("body, html").removeClass("mobile-open")):(s.addClass("show"),jQuery("body, html").addClass("mobile-open"))}function n(){var n=isMobile(baseFontSize,l/baseFontSize);if(n){if(!r){jQuery(".mobile-menu-header .fa-times").off().on("click",function(){o()}),a.detach().appendTo(s),a.children(".dropdown-container").each(function(){jQuery('<i class="icon fa-chevron-right slide-submenu"></i>').appendTo(this)});var i=jQuery(e.mobileMenu+" > ul > li");i.find(" .slide-submenu").off().on("click",function(){var e=jQuery(this).parent();e.hasClass("dropdown-open")?(i.removeClass("dropdown-close"),e.removeClass("dropdown-open")):(i.addClass("dropdown-close"),e.removeClass("dropdown-close").addClass("dropdown-open"))}),r=!0}}else r&&(a.detach().appendTo(t),jQuery(".slide-submenu").remove(),jQuery("li").removeClass("dropdown-close").removeClass("dropdown-open"),jQuery("body, html").removeClass("mobile-open"),s.removeClass("show"),r=!1)}var a=jQuery(e.menu),t=jQuery(e.menuContainer),i=jQuery(e.mobileButton),s=jQuery(e.mobileMenu),l=e.width,r=!1;i.off().on("click",function(){o()}),n();var c=debounce(function(){n()},100);window.addEventListener("resize",c)}function profileThings(){function e(){jQuery.each(a,function(e,a){var i=jQuery('label[for="'+e+'"]').closest("dl"),s="10"==t?a.hidden:a["default"];"select"==a.fieldType&&o(i,s),"checkbox"==a.fieldType&&n(i,s)}),jQuery("[id^=pf_c_]").each(function(){"9"==t?jQuery(this).closest("dl").removeClass("hide-fields"):jQuery(this).closest("dl").addClass("hide-fields")})}function o(e,o){e.find("option:selected").removeAttr("selected"),e.find("option").each(function(){if(jQuery(this).text().trim()==o){var n=jQuery(this).val();e.find("select").val(n)}})}function n(e,o){e.find('input[type="checkbox"]').prop("checked",!1),"None"!=o&&e.find('input[type="checkbox"]').each(function(){jQuery(this).closest("label").text().trim()==o&&jQuery(this).prop("checked",!0)})}if(jQuery("body").hasClass("section-ucp-register")){var a={pf_c_race_type:{fieldType:"select","default":"Unknown",hidden:"Full Blooded"},pf_c_race_opts:{fieldType:"checkbox","default":"None",hidden:"Human"},pf_c_class_type:{fieldType:"select","default":"Unknown",hidden:"Single"},pf_c_class_opts:{fieldType:"checkbox","default":"None",hidden:"Fighter"}},t="10";e(),jQuery("#pf_account_type").on("change",function(){t=jQuery(this).find("option:selected").text().trim(),e()})}}var body=document.querySelector("body"),baseFontSize=16;addBodyClass(),addForumImageClass(),addFieldsetClasses(),addNoPaginationClass(),noContentListing(),addSearchIgnoredClass(),checkForNewPM(),addImageWrapper(".notification_list .list-inner > img"),addImageWrapper(".notification_list .notification-block > img"),checkForEmpty(".section-mcp-post-details .pagination ul"),checkForEmpty(".section-mcp-post-details .postbody .content pre");var bottomDistance=jQuery(document).height()+jQuery(window).height();jQuery(document).ready(function(e){checkForSpace("fieldset dl dt"),checkForSpace("dl.details dt"),addScrollableArea(e(".topicreview"),400,e(".review .right-box")),addScrollableArea(e(".mcp-main #post_details"),400,e(".mcp-main .post-buttons #expand"));var o=".attach-image";e(o).each(function(){e(this).prepend('<span class="image-open" onclick="viewableArea(this);"><i class="icon icon-xl fa-search-plus fa-fw" aria-hidden="true"></i></span>')}),updateaAttachmentDisplay(".image-open"),updateaAttachmentDisplay(o+" img"),formatDisplayActions();var n=e("#pmheader-postingbox");0==e(n).find("fieldset.fields1").children().length&&e(n).hide();var a=e(".cp-menu"),t=e(".cp-main");(a||t)&&(a.parent().addClass("cp-wrapper"),t.parent().addClass("cp-wrapper")),e("body").hasClass("simple-phpbb")||(addOnScroll("#page-header .navbar",".header-overlay","sticky"),scrollOnPage(".scroll-to-top",100,0),scrollOnPage(".scroll-to-bottom",100,bottomDistance)),toggleMobileContent(".toggle-links a","#page-welcome .site-callouts .site-links"),toggleMobileContent(".toggle-featured a","#featured-content"),initializeMobileMenu({menu:"#page-header .navbar > ul",menuContainer:"#page-header .navbar",mobileButton:".mobile-menu-button",mobileMenu:"#mobile-menu",width:768}),profileThings()});