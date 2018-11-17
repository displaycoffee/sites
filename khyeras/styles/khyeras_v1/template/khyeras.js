function checkForClasses(e){return e.className?" ":""}function isMobile(e,a){var n=window.innerWidth/e,r=document.documentElement.clientWidth/e,t=document.body.clientWidth/e;return a>=(n||r||t)}function mergeArray(e,a){for(var n=e.concat(a),r=0;r<n.length;++r)for(var t=r+1;t<n.length;++t)n[r]===n[t]&&n.splice(t--,1);return n}function cleanHTML(e){return e.replace(/(<([^>]+)>)/gi,"")}function debounce(e,a,n){var r;return function(){var t=this,o=arguments,i=function(){r=null,n||e.apply(t,o)},s=n&&!r;clearTimeout(r),r=setTimeout(i,a),s&&e.apply(t,o)}}function addBodyClass(){if(body.getAttribute("data-class"))var e=body.getAttribute("data-class").replace(/[^a-zA-Z ]/g,"").trim().replace(/ /g,"-").replace(/-+/g,"-");e&&(body.className+=checkForClasses(body)+e)}function addForumImageClass(){var e=document.querySelectorAll(".list-inner .forum-image");if(e&&e.length)for(var a=0;a<e.length;a++){var n=e[a],r=n.parentNode.parentNode.parentNode;r.className+=checkForClasses(r)+"has-forum-image"}}function addFieldsetClasses(){var e="fieldset:not(.polls) dl:not(.pmlist) dd",a=document.querySelectorAll(e),n=document.querySelectorAll(e+' input[type="radio"]');if(a&&a.length)for(var r=0;r<a.length;r++){var t=a[r];t.children.length>1&&(t.className+=checkForClasses(t)+"has-multiple-fields"),-1!==t.innerHTML.indexOf("&nbsp;")&&(t.className+=checkForClasses(t)+"has-space")}if(n&&n.length)for(var r=0;r<n.length;r++){var o=n[r];o.parentNode.className+=checkForClasses(o.parentNode)+"has-radio-button"}}function addNoPaginationClass(){var e=document.querySelector(".action-bar .pagination");if(e){var a=e.innerText.toLowerCase(),n="page 1 of 1";if(-1!==a.indexOf(n)){var r=new RegExp(n,"gi"),t=a.replace(r,"").match(/\d+/g);t&&0>=t&&(body.className+=checkForClasses(body)+"no-pagination")}}}function addThanksClass(){var e=document.querySelectorAll("#viewprofile .extra-details h3");if(e&&e.length)for(var a=0;a<e.length;a++){var n=e[a];if(-1!==n.innerHTML.indexOf("Thanks list")){var r=n.parentNode.parentNode;r.className+=checkForClasses(r)+"member-thanks-list"}}}function moveRankText(){var e=document.querySelectorAll("table.table1 .rank-img");if(e&&e.length)for(var a=0;a<e.length;a++){var n=e[a];n.parentNode.appendChild(n),"TD"!=n.parentNode.nodeName&&"td"!=n.parentNode.nodeName||(n.parentNode.className+=checkForClasses(n.parentNode)+"name")}}function noContentListing(){var e=["This board has no forums.","You do not have the required permissions to view or read topics within this forum.","There are no topics or posts in this forum.","This category has no forums.","No suitable matches were found."],a=document.querySelectorAll(".action-bar + .panel .inner");if(a&&a.length)for(var n=0;n<a.length;n++){var r=a[n];-1!==e.indexOf(r.innerText.trim())&&(r.className+=checkForClasses(r)+"no-content")}}function addSearchIgnoredClass(){var e=document.querySelectorAll(".search.post .postbody");if(e&&e.length)for(var a=0;a<e.length;a++){var n=e[a];-1!==n.innerHTML.indexOf("ignore list")&&(n.className+=checkForClasses(n)+"ignore")}}function checkForNewPM(){var e=document.querySelectorAll('.cp-menu ul li a[href*="folder"]');if(e&&e.length)for(var a=0;a<e.length;a++){var n=e[a];-1!==n.innerHTML.indexOf("strong")&&(n.className+=checkForClasses(n)+"new-pm")}}function checkForEmpty(e){var a=document.querySelectorAll(e);if(a&&a.length)for(var n=0;n<a.length;n++)a[n].parentNode.style.display="none"}function removeHTMLFromDraft(){var e=" #postform #message",a=document.querySelectorAll(".section-ucp-manage-drafts"+e);if(a&&a.length){var n=cleanHTML(a[0].value);a[0].value=n}var r=document.querySelectorAll(".section-posting");if(r&&r.length&&-1!==window.location.href.indexOf("&d=")){var t=document.querySelectorAll(".section-posting"+e),o=cleanHTML(t[0].value);t[0].value=o}}function bannerCodeGenerator(e,a){function n(e,a,n){var o=e.target||e.srcElement;r.innerHTML=t.replace(a,o.getAttribute("src")).replace(n,o.getAttribute("alt"))}var r=document.querySelector(a);if(r)for(var t=r.innerHTML,o=t.match(/src=\"(.*?)\"/)[1],i=t.match(/alt=\"(.*?)\"/)[1],s=document.querySelectorAll(e),l=0;l<s.length;l++)s[l].onclick=function(e){n(e,o,i)}}function addImageWrapper(e){var a=document.querySelectorAll(e);if(a&&a.length)for(var n=0;n<a.length;n++){var r=a[n],t=document.createElement("div");t.setAttribute("class","image-wrap"),r.parentNode.insertBefore(t,r),t.appendChild(r)}}function checkImageDimensions(e){var a=document.querySelectorAll(e);if(a&&a.length)for(var n=0;n<a.length;n++){var r=a[n];r.naturalWidth>r.naturalHeight?r.className+=checkForClasses(r)+"image-wide":r.naturalHeight>r.naturalWidth&&(r.className+=checkForClasses(r)+"image-tall")}}function addImageBackground(e,a){var n=document.querySelectorAll(e);if(n&&n.length)for(var r=0;r<n.length;r++){var t=n[r],o=t.getAttribute("src"),i=o.match(/(\d+x\d+)/g),s=o.match(/.(jpg|jpeg|gif|png)/g),l=o;i?l=o.replace(i,a):s&&(l=o.replace(s,"-"+a+s)),t.parentNode.setAttribute("style","background-image: url("+l+");")}}function detectiPhone(){navigator.userAgent.match(/iPhone|iPad|iPod/i)&&(body.className+=checkForClasses(body)+"ios")}function checkForSpace(e){var a=jQuery(e);a&&a.length&&a.each(function(){var e=jQuery(this);"&nbsp;"==e.html()||"<label>&nbsp;</label>"==e.html()?e.addClass("empty-space"):e.removeClass("empty-space")})}function addScrollableArea(e,a,n){(e&&e.length||n&&n.length)&&(e[0].scrollHeight>a?(e.addClass("scrollable"),e.wrapInner('<div class="scrollable-wrapper"></div>')):n.hide())}function addAttachmentIcon(){var e=jQuery(".attach-image");e&&e.length&&e.each(function(){jQuery(this).prepend('<span class="image-open" onclick="viewableArea(this);"><i class="icon icon-xl fa-search-plus fa-fw" aria-hidden="true"></i></span>')})}function updateaAttachmentDisplay(e){var a=jQuery(e);a&&a.length&&a.on("click",function(e){var a=jQuery(this).closest(".file").parent();a.hasClass("image-expanded")?a.removeClass("image-expanded"):a.addClass("image-expanded")})}function formatDisplayActions(){var e=jQuery(".display-actions");e&&e.length&&e.each(function(){var e=jQuery(this);e.html(e.html().replace(/&nbsp;/g,"").replace(/::/g,"&bull;"));var a=e.find(" div a");-1!==a.text().toLowerCase().indexOf("mark")&&a.parent("div").addClass("mark-actions");var n=e.children("select");n.each(function(){jQuery(this).next(".button1, .button2").addBack().wrapAll('<div class="select-actions"></div>')}),e.wrapInner('<div class="display-actions-wrapper"></div>')})}function hidePMPostBox(){var e=jQuery("#pmheader-postingbox");e&&e.length&&0==e.find("fieldset.fields1").children().length&&e.hide()}function addCPWrapper(){var e=jQuery(".cp-menu"),a=jQuery(".cp-main");(e&&e.length||a&&a.length)&&(e.parent().addClass("cp-wrapper"),a.parent().addClass("cp-wrapper"))}function toggleMobileContent(e,a){var n=jQuery(e),r=jQuery(a);(n&&n.length||r&&r.length)&&n.off().on("click",function(){r.hasClass("toggle-show")?r.removeClass("toggle-show"):r.addClass("toggle-show")})}function toggleMemberDisplay(){var e=jQuery(".profile-tabs");if(e&&e.length){var a=e.find("ul li a[data-tabname]");a.on("click",function(){var e=jQuery(this);a.parent().removeClass("activetab"),e.parent().addClass("activetab");var n=e.attr("data-tabname");jQuery(".tab-panel").each(function(){var e=jQuery(this);e.hasClass(n)?e.addClass("show-panel").removeClass("hide-panel"):e.addClass("hide-panel").removeClass("show-panel")})})}}function toggleMapDisplay(){var e=jQuery(".map-tabs");if(e&&e.length){var a=e.find("ul li a[data-tabname]");a.on("click",function(){var e=jQuery(this);e.parent().hasClass("activetab")?e.parent().removeClass("activetab"):e.parent().addClass("activetab");var a=e.attr("data-tabname"),n=jQuery(".map ."+a);n.hasClass("hide-panel")?n.addClass("show-panel").removeClass("hide-panel"):n.addClass("hide-panel").removeClass("show-panel")})}}function addOnScroll(e,a,n){var r=jQuery(window);if(r&&r.length){var a=jQuery(a).offset().top,t=!1;r.scroll(function(){0==t?r.scrollTop()>a&&(jQuery(e).addClass(n),t=!0):r.scrollTop()<=a&&(jQuery(e).removeClass(n),t=!1)})}}function scrollOnPage(e,a,n){var r=jQuery(e);r&&r.length&&(addOnScroll(e,".site-description","scroll-to-visible"),r.on("click",function(){return jQuery("html, body").animate({scrollTop:n},1e3),!1}))}function initializeDropdownMenu(e,a){var n="dropdown-visible",r="dropdown-not-visible",e=jQuery(e),t=jQuery(a);e.off().on("click",function(){var e=jQuery(this).closest(a);e.hasClass(n)?(t.removeClass(r),e.removeClass(n)):(t.removeClass(n).addClass(r),e.removeClass(r).addClass(n))}),e&&e.length&&jQuery(document).off().on("click",function(e){jQuery(e.target).closest(a).length||t.removeClass(n).removeClass(r)})}function initializeMobileMenu(e){function a(){i.hasClass("show")?(i.removeClass("show"),jQuery("body, html").removeClass("mobile-open")):(i.addClass("show"),jQuery("body, html").addClass("mobile-open"))}function n(){var e=isMobile(baseFontSize,c/baseFontSize);e?d||(jQuery(".mobile-menu-header .fa-times").off().on("click",function(){a()}),r.detach().appendTo(s),d=!0):d&&(r.detach().appendTo(t),jQuery("body, html").removeClass("mobile-open"),i.removeClass("show"),d=!1)}var r=jQuery(e.menu),t=jQuery(e.menuContainer),o=jQuery(e.mobileButton),i=jQuery(e.mobileMenu),s=jQuery(e.mobileContent),l=jQuery(e.mobileOverlay),c=e.width,d=!1;o.off().on("click",function(){a()}),l.off().on("click",function(){a()}),n();var u=debounce(function(){n()},100);window.addEventListener("resize",u)}function updateProfileFields(){function e(){R.each(function(){g=jQuery(this),"ucp"==f?(I.prop("disabled",!0),g.prop("disabled",!0)):g.is("select")?c(g,!1):g.is('input[type="checkbox"]')?u(g,!1):g.val("").prop("disabled",!0)})}function a(e){e?jQuery(".error-msg-chracter, .character-fields").addClass("hide-fields"):jQuery(".error-msg-chracter, .character-fields").removeClass("hide-fields")}function n(){k=d(H),y=L.find('input[type="checkbox"]:checked'),C=m("#pf_c_race_opts_1"),k==S||k==F?P.each(function(){if(g=jQuery(this),k==F&&1==C){j=h(y);var e=mergeArray(characterRules[j].exRace,nonHalf);e&&p(e,h(g),g),o()}else k==S&&1==C||k==F&&2==C?(g.is(":checked")||u(g,!1),c(q,!0)):(k==S?u(g,!0):k==F&&p(nonHalf,h(g),g),o())}):(u(P,!1),c(q,!1)),"Writer"==accType&&"ucp"==f&&q.prop("disabled",!0)}function r(e){var a=[];return P.each(function(){if(g=jQuery(this),v=h(g),g.is(":checked")){var n=characterRules[v].exClass;n&&(a=e==F&&"Dwarf"==v?dragonClasses:mergeArray(a,n))}}),a}function t(){k=d(H),x=d(q);var e=r(k);y=O.find('input[type="checkbox"]:checked'),Q=m("#pf_c_class_opts_1"),x==N||x==M?B.each(function(){g=jQuery(this),x==N&&1==Q||x==M&&2==Q?g.is(":checked")||u(g,!1):x!=A&&p(e,h(g),g)}):u(B,!1)}function o(){c(q,!1),u(B,!1)}function i(){_=d(W),y=E.find('input[type="checkbox"]:checked'),w=m("#pf_c_religion_opts_1"),_==D||_==T?z.each(function(){g=jQuery(this),w>3?g.is(":checked")||u(g,!1):_!=A&&religionRules[_]?p(religionRules[_],h(g),g,"include"):u(g,!1)}):u(z,!1)}function s(e,a){var n;e.find("option").each(function(){g=jQuery(this),g.prop("disabled",!1),g.text().trim()==a&&(n=g.val())}),e.prop("disabled",!1).val(n)}function l(e,a){e.each(function(){g=jQuery(this),v=h(g),u(g,!1),v==a&&g.prop({disabled:!1,checked:!0})})}function c(e,a){a?(e.prop("disabled",!1),e.find("option").each(function(){jQuery(this).prop("disabled",!1)})):(e.prop("disabled",!0),e.find("option").each(function(a){var n=jQuery(this);n.prop("disabled",!0),n.text().trim()==A&&e.val(n.val())}))}function d(e){return e.find("option:selected").text().trim()}function u(e,a){a?e.prop("disabled",!1):e.prop({disabled:!0,checked:!1})}function p(e,a,n,r){var t=!1,o=!0;"include"==r&&(t=!0,o=!1),e.indexOf(a)>-1?u(n,t):u(n,o)}function h(e){return e[0].nextSibling.nodeValue.trim()}function m(e){return jQuery(e).closest("dd").find('input[type="checkbox"]:checked').length}if(jQuery("body").hasClass("section-ucp-register")||jQuery("body").hasClass("section-ucp-edit-profile")){if(jQuery("body").hasClass("section-ucp-register"))var f="register";else var f="ucp";var g,y,v,b,C,k,j,Q,x,w,_,A="-- Please Select --",S="Full Blooded",F="Half-Breed",N="Single",M="Dual",D="Archaicism",T="Idolism",I=jQuery("#pf_account_type"),R=jQuery("[id^=pf_c_]"),H=jQuery("#pf_c_race_type"),P=jQuery('input[name="pf_c_race_opts[]"]'),L=jQuery("#pf_c_race_opts_1").closest("dd"),q=jQuery("#pf_c_class_type"),B=jQuery('input[name="pf_c_class_opts[]"]'),O=jQuery("#pf_c_class_opts_1").closest("dd"),W=jQuery("#pf_c_religion_type"),z=jQuery('input[name="pf_c_religion_opts[]"]'),E=jQuery("#pf_c_religion_opts_1").closest("dd");"undefined"==typeof accType&&(accType=!1),b=d(I),"Writer"==accType||"Writer"==b||b==A?(e(),a(!0)):a(!1),I.on("change",function(){e(),a(!0),b=d(I),"Character"==b&&(a(!1),c(H,!0),c(W,!0),jQuery('input[id^=pf_c_][type="text"], input[id^=pf_c_][type="number"], textarea[id^=pf_c_]').prop("disabled",!1))}),H.on("change",function(){k=d(H),u(P,!1),o(),k==S?u(P,!0):k==F&&jQuery.each(P,function(){g=jQuery(this),p(nonHalf,h(g),g)})}),n(),P.on("change",function(){n()}),q.on("change",function(){if(k=d(H),x=d(q),u(B,!1),x!=A){var e=r(k);jQuery.each(B,function(){g=jQuery(this),p(e,h(g),g)})}}),t(),B.on("change",function(){t()}),W.on("change",function(){_=d(W),u(z,!1),_!=A&&religionRules[_]?jQuery.each(z,function(){g=jQuery(this),p(religionRules[_],h(g),g,"include")}):u(z,!1)}),i(),z.on("change",function(){i()}),jQuery(".page-body").on("submit","#register, #ucp.edit-profile-form",function(a){b=d(I),"Writer"==b&&(e(),s(H,S),l(P,"Human"),s(q,N),l(B,"Bard"),"ucp"==f&&s(I,"Writer"))})}}var body=document.querySelector("body"),baseFontSize=16,bottomDistance=document.body.scrollHeight+window.innerHeight,dragonClasses=["Physical","Magical","Restoration"],magicClasses=["Cleric","Druid","Sorcerer","Summoner","Wizard"],all=["All"],nonHalf=["Dragon","Ghost","Korcai"],characterRules={Dragon:{exRace:all,exClass:["Alchemist","Barbarian","Bard","Cleric","Druid","Fighter","Monk","Paladin","Ranger","Rogue","Sorcerer","Summoner","Wizard"]},Dwarf:{exRace:["Elemental","Fae","Lumeacia","Ue'drahc"],exClass:mergeArray(magicClasses,dragonClasses)},Elemental:{exRace:["Dwarf","Ue'drahc"],exClass:dragonClasses},Fae:{exRace:["Dwarf","Lumeacia","Ue'drahc"],exClass:dragonClasses},Ghost:{exRace:all,exClass:dragonClasses},Human:{exRace:["Lumeacia"],exClass:dragonClasses},Kerasoka:{exRace:["Ue'drahc"],exClass:mergeArray(magicClasses,dragonClasses)},Korcai:{exRace:all,exClass:dragonClasses},Lumeacia:{exRace:["Dwarf","Fae","Human","Shapeshifter","Ue'drahc"],exClass:dragonClasses},Shapeshifter:{exRace:["Lumeacia","Ue'drahc"],exClass:dragonClasses},"Ue'drahc":{exRace:["Dwarf","Elemental","Fae","Kerasoka","Lumeacia","Shapeshifter"],exClass:dragonClasses}},religionRules={Archaicism:["Dainyil","Ixaziel","Ny'tha","Pheriss","Ristgir"],Idolism:["Ahm'kela","Cecilia","Bhelest","Esyrax","Faryv","Faunir","Iodrah","Kaxitaki","Kelorha","Lahiel","Misanyt","Nilbein","Veditova"]};addBodyClass(),addForumImageClass(),addFieldsetClasses(),addNoPaginationClass(),addThanksClass(),moveRankText(),noContentListing(),addSearchIgnoredClass(),checkForNewPM(),checkForEmpty(".section-mcp-post-details .pagination ul"),checkForEmpty(".section-mcp-post-details .postbody .content pre"),removeHTMLFromDraft(),bannerCodeGenerator(".link-banners img","#link-banner-code code"),addImageWrapper(".notification_list .list-inner > img"),addImageWrapper(".notification_list .notification-block > img"),checkImageDimensions(".page-welcome .image-wrap img"),checkImageDimensions(".postprofile .avatar img"),detectiPhone();var forumImage=".forum-image img";checkImageDimensions(forumImage),addImageBackground(forumImage,"1000x500");var excerptImage=".excerpt .excerpt-image img";checkImageDimensions(excerptImage),addImageBackground(excerptImage,"1000x500"),jQuery(document).ready(function(e){checkForSpace("fieldset dl dt"),checkForSpace("dl.details dt"),addScrollableArea(e(".topicreview"),400,e(".review .right-box")),addScrollableArea(e(".mcp-main #post_details"),400,e(".mcp-main .post-buttons #expand")),addAttachmentIcon(),updateaAttachmentDisplay(".image-open"),updateaAttachmentDisplay(".attach-image img"),formatDisplayActions(),hidePMPostBox(),addCPWrapper(),toggleMobileContent(".toggle-links a","#page-welcome .site-links"),toggleMobileContent(".toggle-featured a","#featured-content"),toggleMemberDisplay(),toggleMapDisplay(),e("body").hasClass("simple-phpbb")||(addOnScroll("#page-header .navbar",".header-overlay","sticky"),scrollOnPage(".scroll-to-top",100,0),scrollOnPage(".scroll-to-bottom",100,bottomDistance)),initializeDropdownMenu(".menu-trigger",".menu > li"),initializeMobileMenu({menu:"#page-header .navbar .wrapper > ul",menuContainer:"#page-header .navbar .wrapper",mobileButton:".mobile-menu-button",mobileMenu:"#mobile-menu",mobileContent:".mobile-menu-content",mobileOverlay:"#mobile-overlay",width:768}),updateProfileFields()});