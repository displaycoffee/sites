function checkForClasses(e){return e.className?" ":""}function isMobile(e,a){var n=window.innerWidth/e,t=document.documentElement.clientWidth/e,r=document.body.clientWidth/e;return a>=(n||t||r)}function mergeArray(e,a){for(var n=e.concat(a),t=0;t<n.length;++t)for(var r=t+1;r<n.length;++r)n[t]===n[r]&&n.splice(r--,1);return n}function cleanHTML(e){return e.replace(/(<([^>]+)>)/gi,"")}function debounce(e,a,n){var t;return function(){var r=this,o=arguments,i=function(){t=null,n||e.apply(r,o)},s=n&&!t;clearTimeout(t),t=setTimeout(i,a),s&&e.apply(r,o)}}function addBodyClass(){if(body.getAttribute("data-class"))var e=body.getAttribute("data-class").replace(/[^a-zA-Z ]/g,"").trim().replace(/ /g,"-").replace(/-+/g,"-");e&&(body.className+=checkForClasses(body)+e)}function addForumImageClass(){var e=document.querySelectorAll(".list-inner .forum-image");if(e&&e.length)for(var a=0;a<e.length;a++){var n=e[a],t=n.parentNode.parentNode.parentNode;t.className+=checkForClasses(t)+"has-forum-image"}}function addFieldsetClasses(){var e="fieldset:not(.polls) dl:not(.pmlist) dd",a=document.querySelectorAll(e),n=document.querySelectorAll(e+' input[type="radio"]');if(a&&a.length)for(var t=0;t<a.length;t++){var r=a[t];r.children.length>1&&(r.className+=checkForClasses(r)+"has-multiple-fields"),-1!==r.innerHTML.indexOf("&nbsp;")&&(r.className+=checkForClasses(r)+"has-space")}if(n&&n.length)for(var t=0;t<n.length;t++){var o=n[t];o.parentNode.className+=checkForClasses(o.parentNode)+"has-radio-button"}}function addNoPaginationClass(){var e=document.querySelector(".action-bar .pagination");if(e){var a=e.innerText.toLowerCase(),n="page 1 of 1";if(-1!==a.indexOf(n)){var t=new RegExp(n,"gi"),r=a.replace(t,"").match(/\d+/g);r&&0>=r&&(body.className+=checkForClasses(body)+"no-pagination")}}}function addThanksClass(){var e=document.querySelectorAll("#viewprofile .extra-details h3");if(e&&e.length)for(var a=0;a<e.length;a++){var n=e[a];if(-1!==n.innerHTML.indexOf("Thanks list")){var t=n.parentNode.parentNode;t.className+=checkForClasses(t)+"member-thanks-list"}}}function moveRankText(){var e=document.querySelectorAll("table.table1 .rank-img");if(e&&e.length)for(var a=0;a<e.length;a++){var n=e[a];n.parentNode.appendChild(n),"TD"!=n.parentNode.nodeName&&"td"!=n.parentNode.nodeName||(n.parentNode.className+=checkForClasses(n.parentNode)+"name")}}function noContentListing(){var e=["This board has no forums.","You do not have the required permissions to view or read topics within this forum.","There are no topics or posts in this forum.","This category has no forums.","No suitable matches were found."],a=document.querySelectorAll(".action-bar + .panel .inner");if(a&&a.length)for(var n=0;n<a.length;n++){var t=a[n];-1!==e.indexOf(t.innerText.trim())&&(t.className+=checkForClasses(t)+"no-content")}}function addSearchIgnoredClass(){var e=document.querySelectorAll(".search.post .postbody");if(e&&e.length)for(var a=0;a<e.length;a++){var n=e[a];-1!==n.innerHTML.indexOf("ignore list")&&(n.className+=checkForClasses(n)+"ignore")}}function checkForNewPM(){var e=document.querySelectorAll('.cp-menu ul li a[href*="folder"]');if(e&&e.length)for(var a=0;a<e.length;a++){var n=e[a];-1!==n.innerHTML.indexOf("strong")&&(n.className+=checkForClasses(n)+"new-pm")}}function checkForEmpty(e){var a=document.querySelectorAll(e);if(a&&a.length)for(var n=0;n<a.length;n++)a[n].parentNode.style.display="none"}function bannerCodeGenerator(e,a){function n(e,a,n){var o=e.target||e.srcElement;t.innerHTML=r.replace(a,o.getAttribute("src")).replace(n,o.getAttribute("alt"))}var t=document.querySelector(a);if(t)for(var r=t.innerHTML,o=r.match(/src=\"(.*?)\"/)[1],i=r.match(/alt=\"(.*?)\"/)[1],s=document.querySelectorAll(e),l=0;l<s.length;l++)s[l].onclick=function(e){n(e,o,i)}}function addImageWrapper(e){var a=document.querySelectorAll(e);if(a&&a.length)for(var n=0;n<a.length;n++){var t=a[n],r=document.createElement("div");r.setAttribute("class","image-wrap"),t.parentNode.insertBefore(r,t),r.appendChild(t)}}function checkImageDimensions(e){var a=document.querySelectorAll(e);if(a&&a.length)for(var n=0;n<a.length;n++){var t=a[n],r=t.clientWidth,o=t.clientHeight,i=t.parentNode.clientWidth,s=t.parentNode.clientHeight,l=Math.round(r/i*100);s>o?t.className+=checkForClasses(t)+"image-fit-height":r!=o&&(t.className+=checkForClasses(t)+"image-fit-width",l>=90&&(t.className+=checkForClasses(t)+"image-centered"))}}function addImageBackground(e,a){var n=document.querySelectorAll(e);if(n&&n.length)for(var t=0;t<n.length;t++){var r=n[t],o=r.getAttribute("src"),i=o.match(/(\d+x\d+)/g),s=o.match(/.(jpg|jpeg|gif|png)/g),l=o;i?l=o.replace(i,a):s&&(l=o.replace(s,"-"+a+s)),r.parentNode.setAttribute("style","background-image: url("+l+");")}}function detectiPhone(){navigator.userAgent.match(/iPhone|iPad|iPod/i)&&(body.className+=checkForClasses(body)+"ios")}function checkForSpace(e){var a=jQuery(e);a&&a.length&&a.each(function(){var e=jQuery(this);"&nbsp;"==e.html()||"<label>&nbsp;</label>"==e.html()?e.addClass("empty-space"):e.removeClass("empty-space")})}function addScrollableArea(e,a,n){(e&&e.length||n&&n.length)&&(e[0].scrollHeight>a?(e.addClass("scrollable"),e.wrapInner('<div class="scrollable-wrapper"></div>')):n.hide())}function addAttachmentIcon(){var e=jQuery(".attach-image");e&&e.length&&e.each(function(){jQuery(this).prepend('<span class="image-open" onclick="viewableArea(this);"><i class="icon icon-xl fa-search-plus fa-fw" aria-hidden="true"></i></span>')})}function updateaAttachmentDisplay(e){var a=jQuery(e);a&&a.length&&a.on("click",function(e){var a=jQuery(this).closest(".file").parent();a.hasClass("image-expanded")?a.removeClass("image-expanded"):a.addClass("image-expanded")})}function formatDisplayActions(){var e=jQuery(".display-actions");e&&e.length&&e.each(function(){var e=jQuery(this);e.html(e.html().replace(/&nbsp;/g,"").replace(/::/g,"&bull;"));var a=e.find(" div a");-1!==a.text().toLowerCase().indexOf("mark")&&a.parent("div").addClass("mark-actions");var n=e.children("select");n.each(function(){jQuery(this).next(".button1, .button2").addBack().wrapAll('<div class="select-actions"></div>')}),e.wrapInner('<div class="display-actions-wrapper"></div>')})}function hidePMPostBox(){var e=jQuery("#pmheader-postingbox");e&&e.length&&0==e.find("fieldset.fields1").children().length&&e.hide()}function addCPWrapper(){var e=jQuery(".cp-menu"),a=jQuery(".cp-main");(e&&e.length||a&&a.length)&&(e.parent().addClass("cp-wrapper"),a.parent().addClass("cp-wrapper"))}function toggleContent(e,a,n){var e=jQuery(e);e&&e.length&&e.off().on("click",function(){var e=jQuery(this),t=jQuery(a);"prev"==n?t=e.prev(a):"next"==n&&(t=e.next(a)),t.hasClass("toggle-show")?t.removeClass("toggle-show"):t.addClass("toggle-show")})}function toggleMemberDisplay(){var e=jQuery(".profile-tabs");if(e&&e.length){var a=e.find("ul li a[data-tabname]");a.on("click",function(){var e=jQuery(this);a.parent().removeClass("activetab"),e.parent().addClass("activetab");var n=e.attr("data-tabname");jQuery(".tab-panel").each(function(){var e=jQuery(this);e.hasClass(n)?e.addClass("show-panel").removeClass("hide-panel"):e.addClass("hide-panel").removeClass("show-panel")})})}}function toggleMapDisplay(){var e=jQuery(".map-tabs");if(e&&e.length){var a=e.find("ul li a[data-tabname]");a.on("click",function(){var e=jQuery(this);e.parent().hasClass("activetab")?e.parent().removeClass("activetab"):e.parent().addClass("activetab");var a=e.attr("data-tabname"),n=jQuery(".map ."+a);n.hasClass("hide-panel")?n.addClass("show-panel").removeClass("hide-panel"):n.addClass("hide-panel").removeClass("show-panel")})}}function addOnScroll(e,a,n){var t=jQuery(window);if(t&&t.length){var a=jQuery(a).offset().top,r=!1;t.scroll(function(){0==r?t.scrollTop()>a&&(jQuery(e).addClass(n),r=!0):t.scrollTop()<=a&&(jQuery(e).removeClass(n),r=!1)})}}function scrollOnPage(e,a,n){var t=jQuery(e);t&&t.length&&(addOnScroll(e,".site-description","scroll-to-visible"),t.on("click",function(){return jQuery("html, body").animate({scrollTop:n},1e3),!1}))}function initializeDropdownMenu(e,a){var n="dropdown-visible",t="dropdown-not-visible",e=jQuery(e),r=jQuery(a);e.off().on("click",function(){var e=jQuery(this).closest(a);e.hasClass(n)?(r.removeClass(t),e.removeClass(n)):(r.removeClass(n).addClass(t),e.removeClass(t).addClass(n))}),e&&e.length&&jQuery(document).off().on("click",function(e){jQuery(e.target).closest(a).length||r.removeClass(n).removeClass(t)})}function initializeMobileMenu(e){function a(){i.hasClass("show")?(i.removeClass("show"),jQuery("body, html").removeClass("mobile-open")):(i.addClass("show"),jQuery("body, html").addClass("mobile-open"))}function n(){var e=isMobile(baseFontSize,c/baseFontSize);e?d||(jQuery(".mobile-menu-header .fa-times").off().on("click",function(){a()}),t.detach().appendTo(s),d=!0):d&&(t.detach().appendTo(r),jQuery("body, html").removeClass("mobile-open"),i.removeClass("show"),d=!1)}var t=jQuery(e.menu),r=jQuery(e.menuContainer),o=jQuery(e.mobileButton),i=jQuery(e.mobileMenu),s=jQuery(e.mobileContent),l=jQuery(e.mobileOverlay),c=e.width,d=!1;o.off().on("click",function(){a()}),l.off().on("click",function(){a()}),n();var u=debounce(function(){n()},100);window.addEventListener("resize",u)}function updateProfileFields(){function e(){R.each(function(){g=jQuery(this),"ucp"==f?(T.prop("disabled",!0),g.prop("disabled",!0)):g.is("select")?c(g,!1):g.is('input[type="checkbox"]')?u(g,!1):g.val("").prop("disabled",!0)})}function a(e){e?jQuery(".error-msg-chracter, .character-fields").addClass("hide-fields"):jQuery(".error-msg-chracter, .character-fields").removeClass("hide-fields")}function n(){k=d(P),y=L.find('input[type="checkbox"]:checked'),C=m("#pf_c_race_opts_1"),k==N||k==F?H.each(function(){if(g=jQuery(this),k==F&&1==C){j=h(y);var e=mergeArray(characterRules[j].exRace,nonHalf);e&&p(e,h(g),g),o()}else k==N&&1==C||k==F&&2==C?(g.is(":checked")||u(g,!1),c(q,!0)):(k==N?u(g,!0):k==F&&p(nonHalf,h(g),g),o())}):(u(H,!1),c(q,!1)),"Writer"==accType&&"ucp"==f&&q.prop("disabled",!0)}function t(e){var a=[];return H.each(function(){if(g=jQuery(this),v=h(g),"Kerasoka"==v&&(K=g),g.is(":checked")){var n=characterRules[v].exClass;n&&(a=e!=F||"Dwarf"!=v||K.is(":checked")?mergeArray(a,n):dragonClasses)}}),a}function r(){k=d(P),x=d(q);var e=t(k);y=W.find('input[type="checkbox"]:checked'),Q=m("#pf_c_class_opts_1"),x==S||x==D?B.each(function(){g=jQuery(this),x==S&&1==Q||x==D&&2==Q?g.is(":checked")||u(g,!1):x!=A&&p(e,h(g),g)}):u(B,!1)}function o(){c(q,!1),u(B,!1)}function i(){_=d(O),y=E.find('input[type="checkbox"]:checked'),w=m("#pf_c_religion_opts_1"),_==I||_==M?z.each(function(){g=jQuery(this),w>3?g.is(":checked")||u(g,!1):_!=A&&religionRules[_]?p(religionRules[_],h(g),g,"include"):u(g,!1)}):u(z,!1)}function s(e,a){var n;e.find("option").each(function(){g=jQuery(this),g.prop("disabled",!1),g.text().trim()==a&&(n=g.val())}),e.prop("disabled",!1).val(n)}function l(e,a){e.each(function(){g=jQuery(this),v=h(g),u(g,!1),v==a&&g.prop({disabled:!1,checked:!0})})}function c(e,a){a?(e.prop("disabled",!1),e.find("option").each(function(){jQuery(this).prop("disabled",!1)})):(e.prop("disabled",!0),e.find("option").each(function(a){var n=jQuery(this);n.prop("disabled",!0),n.text().trim()==A&&e.val(n.val())}))}function d(e){return e.find("option:selected").text().trim()}function u(e,a){a?e.prop("disabled",!1):e.prop({disabled:!0,checked:!1})}function p(e,a,n,t){var r=!1,o=!0;"include"==t&&(r=!0,o=!1),e.indexOf(a)>-1?u(n,r):u(n,o)}function h(e){return e[0].nextSibling.nodeValue.trim()}function m(e){return jQuery(e).closest("dd").find('input[type="checkbox"]:checked').length}if(jQuery("body").hasClass("section-ucp-register")||jQuery("body").hasClass("section-ucp-edit-profile")){if(jQuery("body").hasClass("section-ucp-register"))var f="register";else var f="ucp";var g,y,v,b,C,k,j,Q,x,w,_,A="-- Please Select --",N="Full Blooded",F="Half-Breed",S="Single",D="Dual",I="Archaicism",M="Idolism",T=jQuery("#pf_account_type"),R=jQuery("[id^=pf_c_]"),P=jQuery("#pf_c_race_type"),H=jQuery('input[name="pf_c_race_opts[]"]'),L=jQuery("#pf_c_race_opts_1").closest("dd"),q=jQuery("#pf_c_class_type"),B=jQuery('input[name="pf_c_class_opts[]"]'),W=jQuery("#pf_c_class_opts_1").closest("dd"),O=jQuery("#pf_c_religion_type"),z=jQuery('input[name="pf_c_religion_opts[]"]'),E=jQuery("#pf_c_religion_opts_1").closest("dd");"undefined"==typeof accType&&(accType=!1),b=d(T),"Writer"==accType||"Writer"==b||b==A?(e(),a(!0)):a(!1),T.on("change",function(){e(),a(!0),b=d(T),"Character"==b&&(a(!1),c(P,!0),c(O,!0),jQuery('input[id^=pf_c_][type="text"], input[id^=pf_c_][type="number"], textarea[id^=pf_c_]').prop("disabled",!1))}),P.on("change",function(){k=d(P),u(H,!1),o(),k==N?u(H,!0):k==F&&jQuery.each(H,function(){g=jQuery(this),p(nonHalf,h(g),g)})}),n(),H.on("change",function(){n()}),q.on("change",function(){if(k=d(P),x=d(q),u(B,!1),x!=A){var e=t(k);jQuery.each(B,function(){g=jQuery(this),p(e,h(g),g)})}}),r(),B.on("change",function(){r()});var K=K||!1;O.on("change",function(){_=d(O),u(z,!1),_!=A&&religionRules[_]?jQuery.each(z,function(){g=jQuery(this),p(religionRules[_],h(g),g,"include")}):u(z,!1)}),i(),z.on("change",function(){i()}),jQuery(".page-body").on("submit","#register, #ucp.edit-profile-form",function(a){b=d(T),"Writer"==b&&(e(),s(P,N),l(H,"Human"),s(q,S),l(B,"Bard"),"ucp"==f&&s(T,"Writer"))})}}var body=document.querySelector("body"),baseFontSize=16,bottomDistance=document.body.scrollHeight+window.innerHeight,dragonClasses=["Physical","Magical","Restoration"],magicClasses=["Cleric","Druid","Sorcerer","Summoner","Wizard"],all=["All"],nonHalf=["Dragon","Ghost","Korcai"],characterRules={Dragon:{exRace:all,exClass:["Alchemist","Barbarian","Bard","Cleric","Druid","Fighter","Monk","Paladin","Ranger","Rogue","Sorcerer","Summoner","Wizard"]},Dwarf:{exRace:["Elemental","Fae","Lumeacia","Ue'drahc"],exClass:mergeArray(magicClasses,dragonClasses)},Elemental:{exRace:["Dwarf","Ue'drahc"],exClass:dragonClasses},Fae:{exRace:["Dwarf","Lumeacia","Ue'drahc"],exClass:dragonClasses},Ghost:{exRace:all,exClass:dragonClasses},Human:{exRace:["Lumeacia"],exClass:dragonClasses},Kerasoka:{exRace:["Ue'drahc"],exClass:mergeArray(magicClasses,dragonClasses)},Korcai:{exRace:all,exClass:dragonClasses},Lumeacia:{exRace:["Dwarf","Fae","Human","Shapeshifter","Ue'drahc"],exClass:dragonClasses},Shapeshifter:{exRace:["Lumeacia","Ue'drahc"],exClass:dragonClasses},"Ue'drahc":{exRace:["Dwarf","Elemental","Fae","Kerasoka","Lumeacia","Shapeshifter"],exClass:dragonClasses}},religionRules={Archaicism:["Dainyil","Ixaziel","Ny'tha","Pheriss","Ristgir"],Idolism:["Ahm'kela","Cecilia","Bhelest","Esyrax","Faryv","Faunir","Iodrah","Kaxitaki","Kelorha","Lahiel","Misanyt","Nilbein","Veditova"]};addBodyClass(),addForumImageClass(),addFieldsetClasses(),addNoPaginationClass(),addThanksClass(),moveRankText(),noContentListing(),addSearchIgnoredClass(),checkForNewPM(),checkForEmpty(".section-mcp-post-details .pagination ul"),checkForEmpty(".section-mcp-post-details .postbody .content pre"),bannerCodeGenerator(".link-banners img","#link-banner-code code"),addImageWrapper(".notification_list .list-inner > img"),addImageWrapper(".notification_list .notification-block > img"),checkImageDimensions(".page-welcome .image-wrap img"),checkImageDimensions(".postprofile .avatar img"),detectiPhone();var forumImage=".forum-image img";checkImageDimensions(forumImage),addImageBackground(forumImage,"1000x500");var excerptImage=".excerpt .excerpt-image img";checkImageDimensions(excerptImage),addImageBackground(excerptImage,"1000x500"),jQuery(document).ready(function(e){checkForSpace("fieldset dl dt"),checkForSpace("dl.details dt"),addScrollableArea(e(".topicreview"),400,e(".review .right-box")),addScrollableArea(e(".mcp-main #post_details"),400,e(".mcp-main .post-buttons #expand")),addAttachmentIcon(),updateaAttachmentDisplay(".image-open"),updateaAttachmentDisplay(".attach-image img"),formatDisplayActions(),hidePMPostBox(),addCPWrapper(),toggleContent(".toggle-links a","#page-welcome .site-links",""),toggleContent(".toggle-featured a","#featured-content",""),toggleContent(".bbcode-hidden-toggle",".bbcode-hidden-text","prev"),toggleMemberDisplay(),toggleMapDisplay(),e("body").hasClass("simple-phpbb")||(addOnScroll("#page-header .navbar",".header-overlay","sticky"),scrollOnPage(".scroll-to-top",100,0),scrollOnPage(".scroll-to-bottom",100,bottomDistance)),initializeDropdownMenu(".menu-trigger",".menu > li"),initializeMobileMenu({menu:"#page-header .navbar .wrapper > ul",menuContainer:"#page-header .navbar .wrapper",mobileButton:".mobile-menu-button",mobileMenu:"#mobile-menu",mobileContent:".mobile-menu-content",mobileOverlay:"#mobile-overlay",width:768}),updateProfileFields()});