function checkForClasses(e){return e.className?" ":""}function isMobile(e,a){var n=window.innerWidth/e,o=document.documentElement.clientWidth/e,r=document.body.clientWidth/e;return a>=(n||o||r)}function mergeArray(e,a){for(var n=e.concat(a),o=0;o<n.length;++o)for(var r=o+1;r<n.length;++r)n[o]===n[r]&&n.splice(r--,1);return n}function addBodyClass(){if(body.getAttribute("data-class"))var e=body.getAttribute("data-class").replace(/[^a-zA-Z ]/g,"").trim().replace(/ /g,"-").replace(/-+/g,"-");e&&(body.className+=checkForClasses(body)+e)}function addForumImageClass(){var e=document.querySelectorAll(".list-inner .forum-image");if(e.length)for(var a=0;a<e.length;a++){var n=e[a].parentNode.parentNode.parentNode;n.className+=checkForClasses(n)+"has-forum-image"}}function addFieldsetClasses(){var e=document.querySelectorAll("fieldset:not(.polls) dl:not(.pmlist) dd");if(e.length)for(var a=0;a<e.length;a++)e[a].children.length>1&&(e[a].className+=checkForClasses(e[a])+"has-multiple-fields"),-1!==e[a].innerHTML.indexOf("&nbsp;")&&(e[a].className+=checkForClasses(e[a])+"has-space")}function addNoPaginationClass(){var e=document.querySelector(".action-bar .pagination");if(e){var a=e.innerText.toLowerCase(),n="page 1 of 1";if(-1!==a.indexOf(n)){var o=new RegExp(n,"gi"),r=a.replace(o,"").match(/\d+/g);r&&0>=r&&(body.className+=checkForClasses(body)+"no-pagination")}}}function noContentListing(){var e=["This board has no forums.","You do not have the required permissions to view or read topics within this forum.","There are no topics or posts in this forum.","This category has no forums.","No suitable matches were found."],a=document.querySelectorAll(".action-bar + .panel .inner");if(a.length)for(var n=0;n<a.length;n++)-1!==e.indexOf(a[n].innerText)&&(a[n].className+=checkForClasses(a[n])+"no-content")}function addSearchIgnoredClass(){var e=document.querySelectorAll(".search.post .postbody");if(e.length)for(var a=0;a<e.length;a++)-1!==e[a].innerHTML.indexOf("ignore list")&&(e[a].className+=checkForClasses(e[a])+"ignore")}function checkForNewPM(){var e=document.querySelectorAll('.cp-menu ul li a[href*="folder"]');if(e.length)for(var a=0;a<e.length;a++)-1!==e[a].innerHTML.indexOf("strong")&&(e[a].className+=checkForClasses(e[a])+"new-pm")}function addImageWrapper(e){var a=document.querySelectorAll(e);if(a.length)for(var n=0;n<a.length;n++){var o=document.createElement("div");o.setAttribute("class","image-wrap"),a[n].parentNode.insertBefore(o,a[n]),o.appendChild(a[n])}}function checkForEmpty(e){var a=document.querySelectorAll(e);if(a.length)for(var n=0;n<a.length;n++)a[n].parentNode.style.display="none"}function checkForSpace(e){jQuery(e).each(function(){var e=jQuery(this);"&nbsp;"==e.html()||"<label>&nbsp;</label>"==e.html()?e.addClass("empty-space"):e.removeClass("empty-space")})}function addScrollableArea(e,a,n){e.length&&e[0].scrollHeight>a?(e.addClass("scrollable"),e.wrapInner('<div class="scrollable-wrapper"></div>')):n.hide()}function updateaAttachmentDisplay(e){jQuery(e).on("click",function(e){var a=jQuery(this).closest(".file").parent();a.hasClass("image-expanded")?a.removeClass("image-expanded"):a.addClass("image-expanded")})}function formatDisplayActions(){jQuery(".display-actions").each(function(){var e=jQuery(this);e.html(e.html().replace(/&nbsp;/g,"").replace(/::/g,"&bull;"));var a=e.find(" div a");-1!==a.text().toLowerCase().indexOf("mark")&&a.parent("div").addClass("mark-actions");var n=e.children("select");n.each(function(){jQuery(this).next(".button1, .button2").addBack().wrapAll('<div class="select-actions"></div>')}),e.wrapInner('<div class="display-actions-wrapper"></div>')})}function addOnScroll(e,a,n){var a=jQuery(a).offset().top,o=jQuery(window),r=!1;o.scroll(function(){0==r?o.scrollTop()>a&&(jQuery(e).addClass(n),r=!0):o.scrollTop()<=a&&(jQuery(e).removeClass(n),r=!1)})}function scrollOnPage(e,a,n){addOnScroll(e,".site-description","scroll-to-visible"),jQuery(e).on("click",function(){return jQuery("html, body").animate({scrollTop:n},1e3),!1})}function toggleMobileContent(e,a){jQuery(e).off().on("click",function(){jQuery(a).hasClass("toggle-show")?jQuery(a).removeClass("toggle-show"):jQuery(a).addClass("toggle-show")})}function debounce(e,a,n){var o;return function(){var r=this,s=arguments,i=function(){o=null,n||e.apply(r,s)},t=n&&!o;clearTimeout(o),o=setTimeout(i,a),t&&e.apply(r,s)}}function initializeMobileMenu(e){function a(){i.hasClass("show")?(i.removeClass("show"),jQuery("body, html").removeClass("mobile-open")):(i.addClass("show"),jQuery("body, html").addClass("mobile-open"))}function n(){var n=isMobile(baseFontSize,t/baseFontSize);if(n){if(!l){jQuery(".mobile-menu-header .fa-times").off().on("click",function(){a()}),o.detach().appendTo(i),o.children(".dropdown-container").each(function(){jQuery('<i class="icon fa-chevron-right slide-submenu"></i>').appendTo(this)});var s=jQuery(e.mobileMenu+" > ul > li");s.find(" .slide-submenu").off().on("click",function(){var e=jQuery(this).parent();e.hasClass("dropdown-open")?(s.removeClass("dropdown-close"),e.removeClass("dropdown-open")):(s.addClass("dropdown-close"),e.removeClass("dropdown-close").addClass("dropdown-open"))}),l=!0}}else l&&(o.detach().appendTo(r),jQuery(".slide-submenu").remove(),jQuery("li").removeClass("dropdown-close").removeClass("dropdown-open"),jQuery("body, html").removeClass("mobile-open"),i.removeClass("show"),l=!1)}var o=jQuery(e.menu),r=jQuery(e.menuContainer),s=jQuery(e.mobileButton),i=jQuery(e.mobileMenu),t=e.width,l=!1;s.off().on("click",function(){a()}),n();var c=debounce(function(){n()},100);window.addEventListener("resize",c)}function updateProfileFields(){function e(e,a,n,o){T.find("option").each(function(){g=jQuery(this),b=g.text().trim(),b==e?g.text(function(){return g.text().replace(b,a)}):b==n&&g.text(function(){return g.text().replace(b,o)})})}function a(){L.each(function(){g=jQuery(this),g.is("select")?d(g,!1):g.is('input[type="checkbox"]')?p(g,!1):g.val("").prop("disabled",!0)})}function n(e){e?(jQuery(".error-msg-chracter").addClass("hide-fields"),L.closest("dl").addClass("hide-fields")):(jQuery(".error-msg-chracter").removeClass("hide-fields"),L.closest("dl").removeClass("hide-fields"))}function o(){j=u(H),y=P.find('input[type="checkbox"]:checked'),v=m("#pf_c_race_opts_1"),j==F||j==A?O.each(function(){if(g=jQuery(this),j==A&&1==v){Q=f(y);var e=mergeArray(characterRules[Q].exRace,nonHalf);e&&h(e,f(g),g),i()}else j==F&&1==v||j==A&&2==v?(g.is(":checked")||p(g,!1),d(B,!0)):(j==F?p(g,!0):j==A&&h(nonHalf,f(g),g),i())}):(p(O,!1),d(B,!1))}function r(e){var a=[];return O.each(function(){if(g=jQuery(this),b=f(g),g.is(":checked")){var n=characterRules[b].exClass;n&&(a=e==A&&"Dwarf"==b?dragonClasses:mergeArray(a,n))}}),a}function s(){j=u(H),w=u(B);var e=r(j);y=W.find('input[type="checkbox"]:checked'),x=m("#pf_c_class_opts_1"),w==R||w==N?I.each(function(){g=jQuery(this),w==R&&1==x||w==N&&2==x?g.is(":checked")||p(g,!1):w!=S&&h(e,f(g),g)}):p(I,!1)}function i(){d(B,!1),p(I,!1)}function t(){k=u(q),y=E.find('input[type="checkbox"]:checked'),_=m("#pf_c_religion_opts_1"),k==D||k==M?z.each(function(){g=jQuery(this),_>3?g.is(":checked")||p(g,!1):k!=S&&religionRules[k]?h(religionRules[k],f(g),g,"include"):p(g,!1)}):p(z,!1)}function l(e,a){var n;e.find("option").each(function(){g=jQuery(this),g.prop("disabled",!1),g.text().trim()==a&&(n=g.val())}),e.prop("disabled",!1).val(n)}function c(e,a){e.each(function(){g=jQuery(this),b=f(g),p(g,!1),b==a&&g.prop({disabled:!1,checked:!0})})}function d(e,a){a?(e.prop("disabled",!1),e.find("option").each(function(){jQuery(this).prop("disabled",!1)})):(e.prop("disabled",!0),e.find("option").each(function(a){var n=jQuery(this);n.prop("disabled",!0),n.text().trim()==S&&e.val(n.val())}))}function u(e){return e.find("option:selected").text().trim()}function p(e,a){a?e.prop("disabled",!1):e.prop({disabled:!0,checked:!1})}function h(e,a,n,o){var r=!1,s=!0;"include"==o&&(r=!0,s=!1),e.indexOf(a)>-1?p(n,r):p(n,s)}function f(e){return e[0].nextSibling.nodeValue.trim()}function m(e){return jQuery(e).closest("dd").find('input[type="checkbox"]:checked').length}if(jQuery("body").hasClass("section-ucp-register")){var g,y,b,C,v,j,Q,x,w,_,k,S="-- Please Select --",F="Full Blooded",A="Half-Breed",R="Single",N="Dual",D="Archaicism",M="Idolism",T=jQuery("#pf_account_type"),L=jQuery("[id^=pf_c_]"),H=jQuery("#pf_c_race_type"),O=jQuery('input[name="pf_c_race_opts[]"]'),P=jQuery("#pf_c_race_opts_1").closest("dd"),B=jQuery("#pf_c_class_type"),I=jQuery('input[name="pf_c_class_opts[]"]'),W=jQuery("#pf_c_class_opts_1").closest("dd"),q=jQuery("#pf_c_religion_type"),z=jQuery('input[name="pf_c_religion_opts[]"]'),E=jQuery("#pf_c_religion_opts_1").closest("dd");e("10","Writer","9","Character"),C=u(T),"Writer"==C||"10"==C||C==S?(a(),n(!0)):n(!1),T.on("change",function(){a(),n(!0),C=u(T),"Character"!=C&&"9"!=C||(n(!1),d(H,!0),d(q,!0),jQuery('input[id^=pf_c_][type="text"]').prop("disabled",!1),jQuery("textarea[id^=pf_c_]").prop("disabled",!1))}),H.on("change",function(){j=u(H),p(O,!1),i(),j==F?p(O,!0):j==A&&jQuery.each(O,function(){g=jQuery(this),h(nonHalf,f(g),g)})}),o(),O.on("change",function(){o()}),B.on("change",function(){if(j=u(H),w=u(B),p(I,!1),w!=S){var e=r(j);jQuery.each(I,function(){g=jQuery(this),h(e,f(g),g)})}}),s(),I.on("change",function(){s()}),q.on("change",function(){k=u(q),p(z,!1),k!=S&&religionRules[k]?jQuery.each(z,function(){g=jQuery(this),h(religionRules[k],f(g),g,"include")}):p(g,!1)}),t(),z.on("change",function(){t()}),jQuery("#register").on("submit",function(e){C=u(T),"Writer"!=C&&"10"!=C||(a(),l(H,F),c(O,"Human"),l(B,R),c(I,"Bard"))})}}var body=document.querySelector("body"),baseFontSize=16,dragonClasses=["Physical","Magical","Healing"],magicClasses=["Cleric","Druid","Sorcerer","Summoner","Wizard"],all=["All"],nonHalf=["Dragon","Ghost","Korcai"],characterRules={Dragon:{exRace:all,exClass:["Alchemist","Barbarian","Bard","Cleric","Druid","Fighter","Monk","Paladin","Ranger","Rogue","Sorcerer","Summoner","Wizard"]},Dwarf:{exRace:["Elemental","Fae","Lumeacia","Ue'drahc"],exClass:mergeArray(magicClasses,dragonClasses)},Elemental:{exRace:["Dwarf","Ue'drahc"],exClass:dragonClasses},Fae:{exRace:["Dwarf","Lumeacia","Ue'drahc"],exClass:dragonClasses},Ghost:{exRace:all,exClass:dragonClasses},Human:{exRace:["Lumeacia"],exClass:dragonClasses},Kerasoka:{exRace:["Ue'drahc"],exClass:mergeArray(magicClasses,dragonClasses)},Korcai:{exRace:all,exClass:dragonClasses},Lumeacia:{exRace:["Dwarf","Fae","Human","Shapeshifter","Ue'drahc"],exClass:dragonClasses},Shapeshifter:{exRace:["Lumeacia","Ue'drahc"],exClass:dragonClasses},"Ue'drahc":{exRace:["Dwarf","Elemental","Fae","Kerasoka","Lumeacia","Shapeshifter"],exClass:dragonClasses}},religionRules={Archaicism:["Dainyil","Ixaziel","Ny'tha","Pheriss","Ristgir"],Idolism:["Cecilia","Bhelest"]};addBodyClass(),addForumImageClass(),addFieldsetClasses(),addNoPaginationClass(),noContentListing(),addSearchIgnoredClass(),checkForNewPM(),addImageWrapper(".notification_list .list-inner > img"),addImageWrapper(".notification_list .notification-block > img"),checkForEmpty(".section-mcp-post-details .pagination ul"),checkForEmpty(".section-mcp-post-details .postbody .content pre");var bottomDistance=jQuery(document).height()+jQuery(window).height();jQuery(document).ready(function(e){checkForSpace("fieldset dl dt"),checkForSpace("dl.details dt"),addScrollableArea(e(".topicreview"),400,e(".review .right-box")),addScrollableArea(e(".mcp-main #post_details"),400,e(".mcp-main .post-buttons #expand"));var a=".attach-image";e(a).each(function(){e(this).prepend('<span class="image-open" onclick="viewableArea(this);"><i class="icon icon-xl fa-search-plus fa-fw" aria-hidden="true"></i></span>')}),updateaAttachmentDisplay(".image-open"),updateaAttachmentDisplay(a+" img"),formatDisplayActions();var n=e("#pmheader-postingbox");0==e(n).find("fieldset.fields1").children().length&&e(n).hide();var o=e(".cp-menu"),r=e(".cp-main");(o||r)&&(o.parent().addClass("cp-wrapper"),r.parent().addClass("cp-wrapper")),e("body").hasClass("simple-phpbb")||(addOnScroll("#page-header .navbar",".header-overlay","sticky"),scrollOnPage(".scroll-to-top",100,0),scrollOnPage(".scroll-to-bottom",100,bottomDistance)),toggleMobileContent(".toggle-links a","#page-welcome .site-callouts .site-links"),toggleMobileContent(".toggle-featured a","#featured-content"),initializeMobileMenu({menu:"#page-header .navbar > ul",menuContainer:"#page-header .navbar",mobileButton:".mobile-menu-button",mobileMenu:"#mobile-menu",width:768}),updateProfileFields()});