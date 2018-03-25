function checkForClasses(e){return e.className?" ":""}function isMobile(e,a){var n=window.innerWidth/e,o=document.documentElement.clientWidth/e,s=document.body.clientWidth/e;return a>=(n||o||s)}function addBodyClass(){if(body.getAttribute("data-class"))var e=body.getAttribute("data-class").replace(/[^a-zA-Z ]/g,"").trim().replace(/ /g,"-").replace(/-+/g,"-");e&&(body.className+=checkForClasses(body)+e)}function addForumImageClass(){var e=document.querySelectorAll(".list-inner .forum-image");if(e.length)for(var a=0;a<e.length;a++){var n=e[a].parentNode.parentNode.parentNode;n.className+=checkForClasses(n)+"has-forum-image"}}function addFieldsetClasses(){var e=document.querySelectorAll("fieldset:not(.polls) dl:not(.pmlist) dd");if(e.length)for(var a=0;a<e.length;a++)e[a].children.length>1&&(e[a].className+=checkForClasses(e[a])+"has-multiple-fields"),-1!==e[a].innerHTML.indexOf("&nbsp;")&&(e[a].className+=checkForClasses(e[a])+"has-space")}function addNoPaginationClass(){var e=document.querySelector(".action-bar .pagination");if(e){var a=e.innerText.toLowerCase(),n="page 1 of 1";if(-1!==a.indexOf(n)){var o=new RegExp(n,"gi"),s=a.replace(o,"").match(/\d+/g);s&&0>=s&&(body.className+=checkForClasses(body)+"no-pagination")}}}function noContentListing(){var e=["This board has no forums.","You do not have the required permissions to view or read topics within this forum.","There are no topics or posts in this forum.","This category has no forums.","No suitable matches were found."],a=document.querySelectorAll(".action-bar + .panel .inner");if(a.length)for(var n=0;n<a.length;n++)-1!==e.indexOf(a[n].innerText)&&(a[n].className+=checkForClasses(a[n])+"no-content")}function addSearchIgnoredClass(){var e=document.querySelectorAll(".search.post .postbody");if(e.length)for(var a=0;a<e.length;a++)-1!==e[a].innerHTML.indexOf("ignore list")&&(e[a].className+=checkForClasses(e[a])+"ignore")}function checkForNewPM(){var e=document.querySelectorAll('.cp-menu ul li a[href*="folder"]');if(e.length)for(var a=0;a<e.length;a++)-1!==e[a].innerHTML.indexOf("strong")&&(e[a].className+=checkForClasses(e[a])+"new-pm")}function addImageWrapper(e){var a=document.querySelectorAll(e);if(a.length)for(var n=0;n<a.length;n++){var o=document.createElement("div");o.setAttribute("class","image-wrap"),a[n].parentNode.insertBefore(o,a[n]),o.appendChild(a[n])}}function checkForEmpty(e){var a=document.querySelectorAll(e);if(a.length)for(var n=0;n<a.length;n++)a[n].parentNode.style.display="none"}function checkForSpace(e){jQuery(e).each(function(){var e=jQuery(this);"&nbsp;"==e.html()||"<label>&nbsp;</label>"==e.html()?e.addClass("empty-space"):e.removeClass("empty-space")})}function addScrollableArea(e,a,n){e.length&&e[0].scrollHeight>a?(e.addClass("scrollable"),e.wrapInner('<div class="scrollable-wrapper"></div>')):n.hide()}function updateaAttachmentDisplay(e){jQuery(e).on("click",function(e){var a=jQuery(this).closest(".file").parent();a.hasClass("image-expanded")?a.removeClass("image-expanded"):a.addClass("image-expanded")})}function formatDisplayActions(){jQuery(".display-actions").each(function(){var e=jQuery(this);e.html(e.html().replace(/&nbsp;/g,"").replace(/::/g,"&bull;"));var a=e.find(" div a");-1!==a.text().toLowerCase().indexOf("mark")&&a.parent("div").addClass("mark-actions");var n=e.children("select");n.each(function(){jQuery(this).next(".button1, .button2").addBack().wrapAll('<div class="select-actions"></div>')}),e.wrapInner('<div class="display-actions-wrapper"></div>')})}function addOnScroll(e,a,n){var a=jQuery(a).offset().top,o=jQuery(window),s=!1;o.scroll(function(){0==s?o.scrollTop()>a&&(jQuery(e).addClass(n),s=!0):o.scrollTop()<=a&&(jQuery(e).removeClass(n),s=!1)})}function scrollOnPage(e,a,n){addOnScroll(e,".site-description","scroll-to-visible"),jQuery(e).on("click",function(){return jQuery("html, body").animate({scrollTop:n},1e3),!1})}function toggleMobileContent(e,a){jQuery(e).off().on("click",function(){jQuery(a).hasClass("toggle-show")?jQuery(a).removeClass("toggle-show"):jQuery(a).addClass("toggle-show")})}function debounce(e,a,n){var o;return function(){var s=this,r=arguments,t=function(){o=null,n||e.apply(s,r)},l=n&&!o;clearTimeout(o),o=setTimeout(t,a),l&&e.apply(s,r)}}function initializeMobileMenu(e){function a(){t.hasClass("show")?(t.removeClass("show"),jQuery("body, html").removeClass("mobile-open")):(t.addClass("show"),jQuery("body, html").addClass("mobile-open"))}function n(){var n=isMobile(baseFontSize,l/baseFontSize);if(n){if(!i){jQuery(".mobile-menu-header .fa-times").off().on("click",function(){a()}),o.detach().appendTo(t),o.children(".dropdown-container").each(function(){jQuery('<i class="icon fa-chevron-right slide-submenu"></i>').appendTo(this)});var r=jQuery(e.mobileMenu+" > ul > li");r.find(" .slide-submenu").off().on("click",function(){var e=jQuery(this).parent();e.hasClass("dropdown-open")?(r.removeClass("dropdown-close"),e.removeClass("dropdown-open")):(r.addClass("dropdown-close"),e.removeClass("dropdown-close").addClass("dropdown-open"))}),i=!0}}else i&&(o.detach().appendTo(s),jQuery(".slide-submenu").remove(),jQuery("li").removeClass("dropdown-close").removeClass("dropdown-open"),jQuery("body, html").removeClass("mobile-open"),t.removeClass("show"),i=!1)}var o=jQuery(e.menu),s=jQuery(e.menuContainer),r=jQuery(e.mobileButton),t=jQuery(e.mobileMenu),l=e.width,i=!1;r.off().on("click",function(){a()}),n();var c=debounce(function(){n()},100);window.addEventListener("resize",c)}function updateProfileFields(){function e(e){e==r?n(i,!0):e==t&&jQuery.each(i,function(){var e=jQuery(this),a=o(e);nonHalf.indexOf(a)<=-1&&n(e,!0)})}function a(e){e.prop("disabled")||e.prop("disabled",!0),e.find("option").each(function(){jQuery(this).prop("disabled")||jQuery(this).prop("disabled",!0)})}function n(e,a){a?e.prop("disabled",!1):e.prop({disabled:!0,checked:!1})}function o(e){return e[0].nextSibling.nodeValue.trim()}function s(e){return e.find("option:selected").text().trim()}for(var r="Full Blooded",t="Half-Breed",l=(jQuery("#pf_account_type"),jQuery("[id^=pf_c_]"),jQuery("#pf_c_race_type")),i=jQuery('input[name="pf_c_race_opts[]"]'),c=jQuery("#pf_c_race_opts_1").closest("dd"),d=jQuery("#pf_c_class_type"),u=jQuery('input[name="pf_c_class_opts[]"]'),p=(jQuery("#pf_c_class_opts_1").closest("dd"),jQuery("#pf_c_religion_type"),jQuery('input[name="pf_c_religion_opts[]"]')),h=[i,d,u,p],m=0;m<h.length;m++)h[m].is("select")&&a(h[m]),h[m].is('input[type="checkbox"]')&&n(h[m],!1);var f=0;l.on("change",function(){var a=s(l);n(i,!1),e(a)}),i.on("change",function(){var a,d=s(l),u=c.find('input[type="checkbox"]:checked');if(f=u.length){var a=o(u),p=characterRules[a].exRace.concat(nonHalf);i.each(function(){var e=jQuery(this),a=o(e);d==r?e.is(":checked")||n(e,!1):d==t&&(1==f?p&&p.indexOf(a)<=-1?n(e,!0):n(e,!1):2==f&&(e.is(":checked")||n(e,!1)))})}else e(d)})}var body=document.querySelector("body"),baseFontSize=16,dragonClasses=["Physical","Magical","Healing"],magicClasses=["Cleric","Druid","Sorcerer","Summoner","Wizard"].concat(dragonClasses),all=["All"],nonHalf=["Dragon","Ghost","Korcai"],characterRules={Dragon:{exRace:all,exClass:["Alchemist","Barbarian","Bard","Cleric","Druid","Fighter","Monk","Paladin","Ranger","Rogue","Sorcerer","Summoner","Wizard"]},Dwarf:{exRace:["Elemental","Fae","Lumeacia","Ue'drahc"],exClass:magicClasses},Elemental:{exRace:["Dwarf","Ue'drahc"],exClass:dragonClasses},Fae:{exRace:["Dwarf","Lumeacia","Ue'drahc"],exClass:dragonClasses},Ghost:{exRace:all,exClass:dragonClasses},Human:{exRace:["Lumeacia"],exClass:dragonClasses},Kerasoka:{exRace:["Ue'drahc"],exClass:magicClasses},Korcai:{exRace:all,exClass:dragonClasses},Lumeacia:{exRace:["Dwarf","Fae","Human","Shapeshifter","Ue'drahc"],exClass:dragonClasses},Shapeshifter:{exRace:["Lumeacia","Ue'drahc"],exClass:dragonClasses},"Ue'drahc":{exRace:["Dwarf","Elemental","Fae","Kerasoka","Lumeacia","Shapeshifter"],exClass:dragonClasses}};addBodyClass(),addForumImageClass(),addFieldsetClasses(),addNoPaginationClass(),noContentListing(),addSearchIgnoredClass(),checkForNewPM(),addImageWrapper(".notification_list .list-inner > img"),addImageWrapper(".notification_list .notification-block > img"),checkForEmpty(".section-mcp-post-details .pagination ul"),checkForEmpty(".section-mcp-post-details .postbody .content pre");var bottomDistance=jQuery(document).height()+jQuery(window).height();jQuery(document).ready(function(e){checkForSpace("fieldset dl dt"),checkForSpace("dl.details dt"),addScrollableArea(e(".topicreview"),400,e(".review .right-box")),addScrollableArea(e(".mcp-main #post_details"),400,e(".mcp-main .post-buttons #expand"));var a=".attach-image";e(a).each(function(){e(this).prepend('<span class="image-open" onclick="viewableArea(this);"><i class="icon icon-xl fa-search-plus fa-fw" aria-hidden="true"></i></span>')}),updateaAttachmentDisplay(".image-open"),updateaAttachmentDisplay(a+" img"),formatDisplayActions();var n=e("#pmheader-postingbox");0==e(n).find("fieldset.fields1").children().length&&e(n).hide();var o=e(".cp-menu"),s=e(".cp-main");(o||s)&&(o.parent().addClass("cp-wrapper"),s.parent().addClass("cp-wrapper")),e("body").hasClass("simple-phpbb")||(addOnScroll("#page-header .navbar",".header-overlay","sticky"),scrollOnPage(".scroll-to-top",100,0),scrollOnPage(".scroll-to-bottom",100,bottomDistance)),toggleMobileContent(".toggle-links a","#page-welcome .site-callouts .site-links"),toggleMobileContent(".toggle-featured a","#featured-content"),initializeMobileMenu({menu:"#page-header .navbar > ul",menuContainer:"#page-header .navbar",mobileButton:".mobile-menu-button",mobileMenu:"#mobile-menu",width:768}),updateProfileFields()});