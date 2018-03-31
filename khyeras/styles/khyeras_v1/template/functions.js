function checkForClasses(e){return e.className?" ":""}function isMobile(e,a){var n=window.innerWidth/e,o=document.documentElement.clientWidth/e,s=document.body.clientWidth/e;return a>=(n||o||s)}function mergeArray(e,a){for(var n=e.concat(a),o=0;o<n.length;++o)for(var s=o+1;s<n.length;++s)n[o]===n[s]&&n.splice(s--,1);return n}function addBodyClass(){if(body.getAttribute("data-class"))var e=body.getAttribute("data-class").replace(/[^a-zA-Z ]/g,"").trim().replace(/ /g,"-").replace(/-+/g,"-");e&&(body.className+=checkForClasses(body)+e)}function addForumImageClass(){var e=document.querySelectorAll(".list-inner .forum-image");if(e.length)for(var a=0;a<e.length;a++){var n=e[a].parentNode.parentNode.parentNode;n.className+=checkForClasses(n)+"has-forum-image"}}function addFieldsetClasses(){var e=document.querySelectorAll("fieldset:not(.polls) dl:not(.pmlist) dd");if(e.length)for(var a=0;a<e.length;a++)e[a].children.length>1&&(e[a].className+=checkForClasses(e[a])+"has-multiple-fields"),-1!==e[a].innerHTML.indexOf("&nbsp;")&&(e[a].className+=checkForClasses(e[a])+"has-space")}function addNoPaginationClass(){var e=document.querySelector(".action-bar .pagination");if(e){var a=e.innerText.toLowerCase(),n="page 1 of 1";if(-1!==a.indexOf(n)){var o=new RegExp(n,"gi"),s=a.replace(o,"").match(/\d+/g);s&&0>=s&&(body.className+=checkForClasses(body)+"no-pagination")}}}function noContentListing(){var e=["This board has no forums.","You do not have the required permissions to view or read topics within this forum.","There are no topics or posts in this forum.","This category has no forums.","No suitable matches were found."],a=document.querySelectorAll(".action-bar + .panel .inner");if(a.length)for(var n=0;n<a.length;n++)-1!==e.indexOf(a[n].innerText)&&(a[n].className+=checkForClasses(a[n])+"no-content")}function addSearchIgnoredClass(){var e=document.querySelectorAll(".search.post .postbody");if(e.length)for(var a=0;a<e.length;a++)-1!==e[a].innerHTML.indexOf("ignore list")&&(e[a].className+=checkForClasses(e[a])+"ignore")}function checkForNewPM(){var e=document.querySelectorAll('.cp-menu ul li a[href*="folder"]');if(e.length)for(var a=0;a<e.length;a++)-1!==e[a].innerHTML.indexOf("strong")&&(e[a].className+=checkForClasses(e[a])+"new-pm")}function addImageWrapper(e){var a=document.querySelectorAll(e);if(a.length)for(var n=0;n<a.length;n++){var o=document.createElement("div");o.setAttribute("class","image-wrap"),a[n].parentNode.insertBefore(o,a[n]),o.appendChild(a[n])}}function checkForEmpty(e){var a=document.querySelectorAll(e);if(a.length)for(var n=0;n<a.length;n++)a[n].parentNode.style.display="none"}function checkForSpace(e){jQuery(e).each(function(){var e=jQuery(this);"&nbsp;"==e.html()||"<label>&nbsp;</label>"==e.html()?e.addClass("empty-space"):e.removeClass("empty-space")})}function addScrollableArea(e,a,n){e.length&&e[0].scrollHeight>a?(e.addClass("scrollable"),e.wrapInner('<div class="scrollable-wrapper"></div>')):n.hide()}function updateaAttachmentDisplay(e){jQuery(e).on("click",function(e){var a=jQuery(this).closest(".file").parent();a.hasClass("image-expanded")?a.removeClass("image-expanded"):a.addClass("image-expanded")})}function formatDisplayActions(){jQuery(".display-actions").each(function(){var e=jQuery(this);e.html(e.html().replace(/&nbsp;/g,"").replace(/::/g,"&bull;"));var a=e.find(" div a");-1!==a.text().toLowerCase().indexOf("mark")&&a.parent("div").addClass("mark-actions");var n=e.children("select");n.each(function(){jQuery(this).next(".button1, .button2").addBack().wrapAll('<div class="select-actions"></div>')}),e.wrapInner('<div class="display-actions-wrapper"></div>')})}function addOnScroll(e,a,n){var a=jQuery(a).offset().top,o=jQuery(window),s=!1;o.scroll(function(){0==s?o.scrollTop()>a&&(jQuery(e).addClass(n),s=!0):o.scrollTop()<=a&&(jQuery(e).removeClass(n),s=!1)})}function scrollOnPage(e,a,n){addOnScroll(e,".site-description","scroll-to-visible"),jQuery(e).on("click",function(){return jQuery("html, body").animate({scrollTop:n},1e3),!1})}function toggleMobileContent(e,a){jQuery(e).off().on("click",function(){jQuery(a).hasClass("toggle-show")?jQuery(a).removeClass("toggle-show"):jQuery(a).addClass("toggle-show")})}function debounce(e,a,n){var o;return function(){var s=this,r=arguments,i=function(){o=null,n||e.apply(s,r)},t=n&&!o;clearTimeout(o),o=setTimeout(i,a),t&&e.apply(s,r)}}function initializeMobileMenu(e){function a(){i.hasClass("show")?(i.removeClass("show"),jQuery("body, html").removeClass("mobile-open")):(i.addClass("show"),jQuery("body, html").addClass("mobile-open"))}function n(){var n=isMobile(baseFontSize,t/baseFontSize);if(n){if(!l){jQuery(".mobile-menu-header .fa-times").off().on("click",function(){a()}),o.detach().appendTo(i),o.children(".dropdown-container").each(function(){jQuery('<i class="icon fa-chevron-right slide-submenu"></i>').appendTo(this)});var r=jQuery(e.mobileMenu+" > ul > li");r.find(" .slide-submenu").off().on("click",function(){var e=jQuery(this).parent();e.hasClass("dropdown-open")?(r.removeClass("dropdown-close"),e.removeClass("dropdown-open")):(r.addClass("dropdown-close"),e.removeClass("dropdown-close").addClass("dropdown-open"))}),l=!0}}else l&&(o.detach().appendTo(s),jQuery(".slide-submenu").remove(),jQuery("li").removeClass("dropdown-close").removeClass("dropdown-open"),jQuery("body, html").removeClass("mobile-open"),i.removeClass("show"),l=!1)}var o=jQuery(e.menu),s=jQuery(e.menuContainer),r=jQuery(e.mobileButton),i=jQuery(e.mobileMenu),t=e.width,l=!1;r.off().on("click",function(){a()}),n();var c=debounce(function(){n()},100);window.addEventListener("resize",c)}function updateProfileFields(){function e(){f=t(_),u=F.find('input[type="checkbox"]:checked'),h=u.length,f==v||f==j?S.each(function(){if(d=jQuery(this),f==j&&1==h){m=c(u);var e=mergeArray(characterRules[m].exRace,nonHalf);e&&e.indexOf(c(d))<=-1?l(d,!0):l(d,!1),s()}else f==v&&1==h||f==j&&2==h?(d.is(":checked")||l(d,!1),i(A,!0)):(a(f),s())}):(l(S,!1),i(A,!1))}function a(e){e==v?l(S,!0):e==j&&jQuery.each(S,function(){d=jQuery(this),p=c(d),nonHalf.indexOf(p)<=-1&&l(d,!0)})}function n(){f=t(_),y=t(A),u=N.find('input[type="checkbox"]:checked'),g=u.length,y==Q||y==w?R.each(function(){d=jQuery(this),y==Q&&1==g||y==w&&2==g?d.is(":checked")||l(d,!1):o(f,y)}):l(R,!1)}function o(e,a){var n=[];S.each(function(){if(d=jQuery(this),p=c(d),d.is(":checked")){var a=characterRules[p].exClass;a&&(n=e==j&&"Dwarf"==p?dragonClasses:mergeArray(n,a))}}),a!=C&&jQuery.each(R,function(){d=jQuery(this),p=c(d),n.indexOf(p)<=-1&&l(d,!0)})}function s(){i(A,!1),l(R,!1)}function r(e){e!=C&&religionRules[e]&&jQuery.each(M,function(){var a=jQuery(this),n=c(a);religionRules[e].indexOf(n)<=-1?l(a,!1):l(a,!0)})}function i(e,a){a?(e.prop("disabled",!1),e.find("option").each(function(){jQuery(this).prop("disabled",!1)})):(e.prop("disabled",!0),e.find("option").each(function(a){var n=jQuery(this);n.prop("disabled",!0),n.text().trim()==C&&e.val(n.val())}))}function t(e){return e.find("option:selected").text().trim()}function l(e,a){a?e.prop("disabled",!1):e.prop({disabled:!0,checked:!1})}function c(e){return e[0].nextSibling.nodeValue.trim()}if(jQuery("body").hasClass("section-ucp-register")){var d,u,p,h,f,m,g,y,b,C="-- Please Select --",v="Full Blooded",j="Half-Breed",Q="Single",w="Dual",x="Archaicism",k="Idolism",_=(jQuery("#pf_account_type"),jQuery("[id^=pf_c_]"),jQuery("#pf_c_race_type")),S=jQuery('input[name="pf_c_race_opts[]"]'),F=jQuery("#pf_c_race_opts_1").closest("dd"),A=jQuery("#pf_c_class_type"),R=jQuery('input[name="pf_c_class_opts[]"]'),N=jQuery("#pf_c_class_opts_1").closest("dd"),D=jQuery("#pf_c_religion_type"),M=jQuery('input[name="pf_c_religion_opts[]"]'),O=jQuery("#pf_c_religion_opts_1").closest("dd");_.on("change",function(){f=t(_),l(S,!1),s(),a(f)}),e(),S.on("change",function(){e()}),A.on("change",function(){f=t(_),y=t(A),l(R,!1),o(f,y)}),n(),R.on("change",function(){n()}),D.on("change",function(){var e=t(D);l(M,!1),r(e)}),M.on("change",function(){var e=t(D),a=O.find('input[type="checkbox"]:checked');b=a.length,b?M.each(function(){var a=jQuery(this);e!=x&&e!=k||(b>3?a.is(":checked")||l(a,!1):r(e))}):r(e)})}}var body=document.querySelector("body"),baseFontSize=16,dragonClasses=["Physical","Magical","Healing"],magicClasses=["Cleric","Druid","Sorcerer","Summoner","Wizard"],all=["All"],nonHalf=["Dragon","Ghost","Korcai"],characterRules={Dragon:{exRace:all,exClass:["Alchemist","Barbarian","Bard","Cleric","Druid","Fighter","Monk","Paladin","Ranger","Rogue","Sorcerer","Summoner","Wizard"]},Dwarf:{exRace:["Elemental","Fae","Lumeacia","Ue'drahc"],exClass:mergeArray(magicClasses,dragonClasses)},Elemental:{exRace:["Dwarf","Ue'drahc"],exClass:dragonClasses},Fae:{exRace:["Dwarf","Lumeacia","Ue'drahc"],exClass:dragonClasses},Ghost:{exRace:all,exClass:dragonClasses},Human:{exRace:["Lumeacia"],exClass:dragonClasses},Kerasoka:{exRace:["Ue'drahc"],exClass:mergeArray(magicClasses,dragonClasses)},Korcai:{exRace:all,exClass:dragonClasses},Lumeacia:{exRace:["Dwarf","Fae","Human","Shapeshifter","Ue'drahc"],exClass:dragonClasses},Shapeshifter:{exRace:["Lumeacia","Ue'drahc"],exClass:dragonClasses},"Ue'drahc":{exRace:["Dwarf","Elemental","Fae","Kerasoka","Lumeacia","Shapeshifter"],exClass:dragonClasses}},religionRules={Archaicism:["Dainyil","Ixaziel","Ny'tha","Pheriss","Ristgir"],Idolism:["Cecilia","Bhelest"]};addBodyClass(),addForumImageClass(),addFieldsetClasses(),addNoPaginationClass(),noContentListing(),addSearchIgnoredClass(),checkForNewPM(),addImageWrapper(".notification_list .list-inner > img"),addImageWrapper(".notification_list .notification-block > img"),checkForEmpty(".section-mcp-post-details .pagination ul"),checkForEmpty(".section-mcp-post-details .postbody .content pre");var bottomDistance=jQuery(document).height()+jQuery(window).height();jQuery(document).ready(function(e){checkForSpace("fieldset dl dt"),checkForSpace("dl.details dt"),addScrollableArea(e(".topicreview"),400,e(".review .right-box")),addScrollableArea(e(".mcp-main #post_details"),400,e(".mcp-main .post-buttons #expand"));var a=".attach-image";e(a).each(function(){e(this).prepend('<span class="image-open" onclick="viewableArea(this);"><i class="icon icon-xl fa-search-plus fa-fw" aria-hidden="true"></i></span>')}),updateaAttachmentDisplay(".image-open"),updateaAttachmentDisplay(a+" img"),formatDisplayActions();var n=e("#pmheader-postingbox");0==e(n).find("fieldset.fields1").children().length&&e(n).hide();var o=e(".cp-menu"),s=e(".cp-main");(o||s)&&(o.parent().addClass("cp-wrapper"),s.parent().addClass("cp-wrapper")),e("body").hasClass("simple-phpbb")||(addOnScroll("#page-header .navbar",".header-overlay","sticky"),scrollOnPage(".scroll-to-top",100,0),scrollOnPage(".scroll-to-bottom",100,bottomDistance)),toggleMobileContent(".toggle-links a","#page-welcome .site-callouts .site-links"),toggleMobileContent(".toggle-featured a","#featured-content"),initializeMobileMenu({menu:"#page-header .navbar > ul",menuContainer:"#page-header .navbar",mobileButton:".mobile-menu-button",mobileMenu:"#mobile-menu",width:768}),updateProfileFields()});