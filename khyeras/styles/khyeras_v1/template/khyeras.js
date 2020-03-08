function checkForClasses(e){return e.className?" ":""}function cleanHTML(e){return e.replace(/(<([^>]+)>)/gi,"")}function debounce(e,a,n){var r;return function(){var t=this,i=arguments,o=function(){r=null,n||e.apply(t,i)},s=n&&!r;clearTimeout(r),r=setTimeout(o,a),s&&e.apply(t,i)}}function findParent(e,a){for(;e;){if(e.classList&&e.classList.contains(a))return e;e=e.parentNode}return null}function isMobile(e,a){var n=window.innerWidth/e,r=document.documentElement.clientWidth/e,t=document.body.clientWidth/e;return a>=(n||r||t)}function mergeArray(e,a){for(var n=e.concat(a),r=0;r<n.length;++r)for(var t=r+1;t<n.length;++t)n[r]===n[t]&&n.splice(t--,1);return n}function addFieldsetClasses(){var e="fieldset:not(.polls) dl:not(.pmlist) dd",a=document.querySelectorAll(e),n=document.querySelectorAll(e+' input[type="radio"]');if(a&&a.length)for(var r=0;r<a.length;r++){var t=a[r];t.children.length>1&&(t.className+=checkForClasses(t)+"has-multiple-fields"),-1!==t.innerHTML.indexOf("&nbsp;")&&(t.className+=checkForClasses(t)+"has-space")}if(n&&n.length)for(var r=0;r<n.length;r++){var i=n[r];i.parentNode.className+=checkForClasses(i.parentNode)+"has-radio-button"}}function addForumImageClass(){var e=document.querySelectorAll(".list-inner .forum-image");if(e&&e.length)for(var a=0;a<e.length;a++){var n=e[a],r=findParent(n,"row-item");r.className+=checkForClasses(r)+"has-forum-image"}}function addImageWrapper(e){var a=document.querySelectorAll(e);if(a&&a.length)for(var n=0;n<a.length;n++){var r=a[n],t=document.createElement("div");t.setAttribute("class","image-wrap"),r.parentNode.insertBefore(t,r),t.appendChild(r)}}function addImageBackground(e,a){var n=document.querySelectorAll(e);if(n&&n.length)for(var r=0;r<n.length;r++){var t=n[r],i=t.getAttribute("src"),o="image-fit image-fit-default",s=t.parentNode;if(a){var l=i.match(/(\d+x\d+)/g),c=i.match(/.(jpg|jpeg|gif|png)/g);l?i=i.replace(l,a):c&&(i=i.replace(c,"-"+a+c)),o=o.replace("image-fit-default","image-fit-responsive")}s.style.backgroundImage="url("+i+")",s.className+=checkForClasses(s)+o}}function addNoPaginationClass(){var e=document.querySelector(".action-bar .pagination");if(e){var a=e.innerText.toLowerCase(),n="page 1 of 1";if(-1!==a.indexOf(n)){var r=new RegExp(n,"gi"),t=a.replace(r,"").match(/\d+/g);t&&0>=t&&(body.className+=checkForClasses(body)+"no-pagination")}}}function addSearchIgnoredClass(){var e=document.querySelectorAll(".search.post .postbody");if(e&&e.length)for(var a=0;a<e.length;a++){var n=e[a];-1!==n.innerHTML.indexOf("ignore list")&&(n.className+=checkForClasses(n)+"ignore")}}function addThanksClass(){var e=document.querySelectorAll("#viewprofile .extra-details h3");if(e&&e.length)for(var a=0;a<e.length;a++){var n=e[a];if(-1!==n.innerHTML.indexOf("Thanks list")){var r=findParent(n,"panel");r.className+=checkForClasses(r)+"member-thanks-list"}}}function bannerCodeGenerator(e,a){function n(e,a,n){var i=e.target||e.srcElement,o="//"+window.location.hostname+"/"+i.getAttribute("src").replace("./","");r.innerHTML=t.replace(a,o).replace(n,i.getAttribute("alt"))}var r=document.querySelector(a);if(r)for(var t=r.innerHTML,i=t.match(/src=\"(.*?)\"/)[1],o=t.match(/alt=\"(.*?)\"/)[1],s=document.querySelectorAll(e),l=0;l<s.length;l++)s[l].onclick=function(e){n(e,i,o)}}function checkForNewPM(){var e=document.querySelectorAll('.cp-menu ul li a[href*="folder"]');if(e&&e.length)for(var a=0;a<e.length;a++){var n=e[a];-1!==n.innerHTML.indexOf("strong")&&(n.className+=checkForClasses(n)+"new-pm")}}function checkForEmpty(e){var a=document.querySelectorAll(e);if(a&&a.length)for(var n=0;n<a.length;n++)a[n].parentNode.style.display="none"}function collapseElements(e,a,n){function r(e,r){var t=findParent(r,n),i=t.querySelector(a),o={col:"content-collapsed",exp:"content-expanded",minus:"fa-minus",plus:"fa-plus"};e?(r.classList.remove(o.minus),r.classList.add(o.plus),i.classList.remove(o.col),i.classList.add(o.exp)):(r.classList.remove(o.plus),r.classList.add(o.minus),i.classList.remove(o.exp),i.classList.add(o.col))}var t=document.querySelectorAll(e);if(t&&t.length)for(var i=0;i<t.length;i++){var e=t[i],o=!0,s=document.createElement("button");s.className="content-toggle-button icon icon-lg",e.insertBefore(s,e.firstChild),r(o,s),s.onclick=function(e){o=!o,r(o,e.target||e.srcElement)}}}function detectiPhone(){navigator.userAgent.match(/iPhone|iPad|iPod/i)&&(body.className+=checkForClasses(body)+"ios")}function moveRankText(){var e=document.querySelectorAll("table.table1 .rank-img");if(e&&e.length)for(var a=0;a<e.length;a++){var n=e[a];n.parentNode.appendChild(n),"TD"!=n.parentNode.nodeName&&"td"!=n.parentNode.nodeName||(n.parentNode.className+=checkForClasses(n.parentNode)+"name")}}function noContentListing(){var e=["This board has no forums.","You do not have the required permissions to view or read topics within this forum.","There are no topics or posts in this forum.","This category has no forums.","No suitable matches were found."],a=document.querySelectorAll(".action-bar + .panel");if(a&&a.length)for(var n=0;n<a.length;n++){var r=a[n];-1!==e.indexOf(r.innerText.trim())&&(r.className+=checkForClasses(r)+"no-content")}}function checkForSpace(e){var a=jQuery(e);a&&a.length&&a.each(function(){var e=jQuery(this);"&nbsp;"==e.html()||"<label>&nbsp;</label>"==e.html()?e.addClass("empty-space"):e.removeClass("empty-space")})}function addScrollableArea(e,a,n){(e&&e.length||n&&n.length)&&(e[0].scrollHeight>a?(e.addClass("scrollable"),e.wrapInner('<div class="scrollable-wrapper"></div>')):n.hide())}function addAttachmentIcon(){var e=jQuery(".attach-image");e&&e.length&&e.each(function(){jQuery(this).prepend('<span class="image-open" onclick="viewableArea(this);"><i class="icon icon-xl fa-search-plus fa-fw" aria-hidden="true"></i></span>')})}function updateaAttachmentDisplay(e){var a=jQuery(e);a&&a.length&&a.on("click",function(e){var a=jQuery(this).closest(".file").parent();a.hasClass("image-expanded")?a.removeClass("image-expanded"):a.addClass("image-expanded")})}function formatDisplayActions(){var e=jQuery(".display-actions");e&&e.length&&e.each(function(){var e=jQuery(this);e.html(e.html().replace(/&nbsp;/g,"").replace(/::/g,"&bull;"));var a=e.find(" div a");-1!==a.text().toLowerCase().indexOf("mark")&&a.parent("div").addClass("mark-actions");var n=e.children("select");n.each(function(){jQuery(this).next(".button1, .button2").addBack().wrapAll('<div class="select-actions"></div>')}),e.wrapInner('<div class="display-actions-wrapper"></div>')})}function hidePMPostBox(){var e=jQuery("#pmheader-postingbox");e&&e.length&&0==e.find("fieldset.fields1").children().length&&e.hide()}function addCPWrapper(){var e=jQuery(".cp-menu"),a=jQuery(".cp-main");(e&&e.length||a&&a.length)&&(e.parent().addClass("cp-wrapper"),a.parent().addClass("cp-wrapper"))}function toggleContent(e,a,n,r){var e=jQuery(e);e&&e.length&&e.off().on("click",function(){var e=jQuery(this),t=jQuery(a);"prev"==r?t=e.prev(a):"next"==r&&(t=e.next(a)),t.hasClass(n)?t.removeClass(n):t.addClass(n)})}function toggleMemberDisplay(){var e=jQuery(".profile-tabs");if(e&&e.length){var a=e.find("ul li a[data-tabname]");a.on("click",function(){var e=jQuery(this);a.parent().removeClass("activetab"),e.parent().addClass("activetab");var n=e.attr("data-tabname");jQuery(".tab-panel").each(function(){var e=jQuery(this);e.hasClass(n)?e.addClass("show-panel").removeClass("hide-panel"):e.addClass("hide-panel").removeClass("show-panel")})})}}function toggleMapDisplay(){var e=jQuery(".map-tabs");if(e&&e.length){var a=e.find("ul li a[data-tabname]");a.on("click",function(){var e=jQuery(this);e.parent().hasClass("activetab")?e.parent().removeClass("activetab"):e.parent().addClass("activetab");var a=e.attr("data-tabname"),n=jQuery(".map ."+a);n.hasClass("hide-panel")?n.addClass("show-panel").removeClass("hide-panel"):n.addClass("hide-panel").removeClass("show-panel")})}}function addOnScroll(e,a,n){var r=jQuery(window);if(r&&r.length){var a=jQuery(a).offset().top,t=!1;r.scroll(function(){0==t?r.scrollTop()>a&&(jQuery(e).addClass(n),t=!0):r.scrollTop()<=a&&(jQuery(e).removeClass(n),t=!1)})}}function scrollOnPage(e,a,n){var r=jQuery(e);r&&r.length&&(addOnScroll(".scroll-to-links",".site-description","scroll-to-visible"),r.on("click",function(){return jQuery("html, body").animate({scrollTop:n},1e3),!1}))}function initializeDiscordList(){var e=jQuery(".discord-channel-status .discord-channel-list"),a="<li>There's no one online right now. :( Check back later.</li>",n=jQuery.ajax({type:"GET",url:"//discordapp.com/api/guilds/482924002411806732/widget.json",dataType:"json"});n.done(function(n){var r=n.members||!1,t=["memoria"],i=["algaliarept"];if(r&&r.length>0){r=r.filter(function(e){e.rank=3,e.group="user";var a=e.username.toLowerCase();return i.indexOf(a)>-1?(e.rank=2,e.group="moderator"):t.indexOf(a)>-1&&(e.rank=1,e.group="admin"),e}),r.sort(function(e,a){return e.rank-a.rank});for(var o=r.length,s=12,l=o>s?s:o,c=0;l>c;c++){var d=r[c],u="//khyeras.org/styles/khyeras_v1/theme/images/no_avatar.gif";d.avatar_url&&(u=d.avatar_url.replace(/^http(s?):/i,""));var p="Discord Avatar - "+d.username,h='<span class="discord-avatar image-wrap"><img src="'+u+'" class="user-avatar" alt="'+p+'" title="'+p+'" /></span>',m='<span class="discord-username">'+d.username+"</span>",f='<li class="discord-'+d.group+" discord-status-"+d.status+'">'+h+m+"</li>";e.append(f)}o>s&&e.append('<li class="discord-more-users"><a href="//discord.gg/MXtzbmw" target="_blank">...more users online</a></li>')}else e.append(a)}),n.fail(function(){e.append(a)})}function initializeDropdownMenu(e,a){var n="dropdown-visible",r="dropdown-not-visible",e=jQuery(e),t=jQuery(a);e.off().on("click",function(){var e=jQuery(this).closest(a);e.hasClass(n)?(t.removeClass(r),e.removeClass(n)):(t.removeClass(n).addClass(r),e.removeClass(r).addClass(n))}),e&&e.length&&jQuery(document).off().on("click",function(e){jQuery(e.target).closest(a).length||t.removeClass(n).removeClass(r)})}function initializeMobileMenu(e){function a(){o.hasClass("show")?(o.removeClass("show"),jQuery("body, html").removeClass("mobile-open")):(o.addClass("show"),jQuery("body, html").addClass("mobile-open"))}function n(){var e=isMobile(baseFontSize,c/baseFontSize);e?d||(jQuery(".mobile-menu-header .fa-close").off().on("click",function(){a()}),r.detach().appendTo(s),d=!0):d&&(r.detach().appendTo(t),jQuery("body, html").removeClass("mobile-open"),o.removeClass("show"),d=!1)}var r=jQuery(e.menu),t=jQuery(e.menuContainer),i=jQuery(e.mobileButton),o=jQuery(e.mobileMenu),s=jQuery(e.mobileContent),l=jQuery(e.mobileOverlay),c=e.width,d=!1;i.off().on("click",function(){a()}),l.off().on("click",function(){a()}),n();var u=debounce(function(){n()},100);window.addEventListener("resize",u)}function updateProfileFields(){function e(){P.each(function(){g=jQuery(this),"ucp"==f?(M.prop("disabled",!0),g.prop("disabled",!0)):g.is("select")?c(g,!1):g.is('input[type="checkbox"]')?u(g,!1):g.val("").prop("disabled",!0)})}function a(e){e?jQuery(".error-msg-chracter, .character-fields").addClass("hide-fields"):jQuery(".error-msg-chracter, .character-fields").removeClass("hide-fields")}function n(){k=d(R),v=q.find('input[type="checkbox"]:checked'),C=m("#pf_c_race_opts_1"),k==A||k==F?I.each(function(){if(g=jQuery(this),k==F&&1==C){j=h(v);var e=mergeArray(characterRules[j].exRace,nonHalf);e&&p(e,h(g),g),i()}else k==A&&1==C||k==F&&2==C?(g.is(":checked")||u(g,!1),c(O,!0)):(k==A?u(g,!0):k==F&&p(nonHalf,h(g),g),i())}):(u(I,!1),c(O,!1)),"Writer"==accType&&"ucp"==f&&O.prop("disabled",!0)}function r(e){var a=[];return I.each(function(){if(g=jQuery(this),y=h(g),"Kerasoka"==y&&(K=g),g.is(":checked")){var n=characterRules[y].exClass;n&&(a=e!=F||"Dwarf"!=y||K.is(":checked")?mergeArray(a,n):dragonClasses)}}),a}function t(){k=d(R),x=d(O);var e=r(k);v=B.find('input[type="checkbox"]:checked'),Q=m("#pf_c_class_opts_1"),x==N||x==L?H.each(function(){g=jQuery(this),x==N&&1==Q||x==L&&2==Q?g.is(":checked")||u(g,!1):x!=S&&p(e,h(g),g)}):u(H,!1)}function i(){c(O,!1),u(H,!1)}function o(){_=d(E),v=z.find('input[type="checkbox"]:checked'),w=m("#pf_c_religion_opts_1"),_==T||_==D?W.each(function(){g=jQuery(this),w>3?g.is(":checked")||u(g,!1):_!=S&&religionRules[_]?p(religionRules[_],h(g),g,"include"):u(g,!1)}):u(W,!1)}function s(e,a){var n;e.find("option").each(function(){g=jQuery(this),g.prop("disabled",!1),g.text().trim()==a&&(n=g.val())}),e.prop("disabled",!1).val(n)}function l(e,a){e.each(function(){g=jQuery(this),y=h(g),u(g,!1),y==a&&g.prop({disabled:!1,checked:!0})})}function c(e,a){a?(e.prop("disabled",!1),e.find("option").each(function(){jQuery(this).prop("disabled",!1)})):(e.prop("disabled",!0),e.find("option").each(function(a){var n=jQuery(this);n.prop("disabled",!0),n.text().trim()==S&&e.val(n.val())}))}function d(e){return e.find("option:selected").text().trim()}function u(e,a){a?e.prop("disabled",!1):e.prop({disabled:!0,checked:!1})}function p(e,a,n,r){var t=!1,i=!0;"include"==r&&(t=!0,i=!1),e.indexOf(a)>-1?u(n,t):u(n,i)}function h(e){return e[0].nextSibling.nodeValue.trim()}function m(e){return jQuery(e).closest("dd").find('input[type="checkbox"]:checked').length}if(jQuery("body").hasClass("section-ucp-register")||jQuery("body").hasClass("section-ucp-edit-profile")){if(jQuery("body").hasClass("section-ucp-register"))var f="register";else var f="ucp";var g,v,y,b,C,k,j,Q,x,w,_,S="-- Please Select --",A="Full blooded",F="Half-breed",N="Single",L="Dual",T="Archaicism",D="Idolism",M=jQuery("#pf_account_type"),P=jQuery("[id^=pf_c_]"),R=jQuery("#pf_c_race_type"),I=jQuery('input[name="pf_c_race_opts[]"]'),q=jQuery("#pf_c_race_opts_1").closest("dd"),O=jQuery("#pf_c_class_type"),H=jQuery('input[name="pf_c_class_opts[]"]'),B=jQuery("#pf_c_class_opts_1").closest("dd"),E=jQuery("#pf_c_religion_type"),W=jQuery('input[name="pf_c_religion_opts[]"]'),z=jQuery("#pf_c_religion_opts_1").closest("dd");"undefined"==typeof accType&&(accType=!1),b=d(M),"Writer"==accType||"Writer"==b||b==S?(e(),a(!0)):a(!1),M.on("change",function(){e(),a(!0),b=d(M),"Character"==b&&(a(!1),c(R,!0),c(E,!0),jQuery('input[id^=pf_c_][type="text"], input[id^=pf_c_][type="number"], textarea[id^=pf_c_]').prop("disabled",!1))}),R.on("change",function(){k=d(R),u(I,!1),i(),k==A?u(I,!0):k==F&&jQuery.each(I,function(){g=jQuery(this),p(nonHalf,h(g),g)})}),n(),I.on("change",function(){n()}),O.on("change",function(){if(k=d(R),x=d(O),u(H,!1),x!=S){var e=r(k);jQuery.each(H,function(){g=jQuery(this),p(e,h(g),g)})}}),t(),H.on("change",function(){t()});var K=K||!1;E.on("change",function(){_=d(E),u(W,!1),_!=S&&religionRules[_]?jQuery.each(W,function(){g=jQuery(this),p(religionRules[_],h(g),g,"include")}):u(W,!1)}),o(),W.on("change",function(){o()}),jQuery(".page-body").on("submit","#register, #ucp.edit-profile-form",function(a){b=d(M),"Writer"==b&&(e(),s(R,A),l(I,"Human"),s(O,N),l(H,"Bard"),"ucp"==f&&s(M,"Writer"))})}}var body=document.querySelector("body"),baseFontSize=16,bottomDistance=document.body.scrollHeight+window.innerHeight,dragonClasses=["Physical","Magical","Restoration"],magicClasses=["Cleric","Druid","Sorcerer","Summoner","Wizard"],all=["All"],nonHalf=["Dragon","Ghost","Korcai"],characterRules={Dragon:{exRace:all,exClass:["Alchemist","Barbarian","Bard","Cleric","Druid","Fighter","Monk","Paladin","Ranger","Rogue","Sorcerer","Summoner","Wizard"]},Dwarf:{exRace:["Elemental","Fae","Lumeacia","Ue'drahc"],exClass:mergeArray(magicClasses,dragonClasses)},Elemental:{exRace:["Dwarf","Ue'drahc"],exClass:dragonClasses},Fae:{exRace:["Dwarf","Lumeacia","Ue'drahc"],exClass:dragonClasses},Ghost:{exRace:all,exClass:dragonClasses},Human:{exRace:["Lumeacia"],exClass:dragonClasses},Kerasoka:{exRace:["Ue'drahc"],exClass:mergeArray(magicClasses,dragonClasses)},Korcai:{exRace:all,exClass:dragonClasses},Lumeacia:{exRace:["Dwarf","Fae","Human","Shapeshifter","Ue'drahc"],exClass:dragonClasses},Shapeshifter:{exRace:["Lumeacia","Ue'drahc"],exClass:dragonClasses},"Ue'drahc":{exRace:["Dwarf","Elemental","Fae","Kerasoka","Lumeacia","Shapeshifter"],exClass:dragonClasses}},religionRules={Archaicism:["Dainyil","Ixaziel","Ny'tha","Pheriss","Ristgir"],Idolism:["Ahm'kela","Cecilia","Bhelest","Esyrax","Faryv","Faunir","Iodrah","Kaxitaki","Kelorha","Lahiel","Misanyt","Nilbein","Veditova"]};addForumImageClass(),addFieldsetClasses(),addNoPaginationClass(),addThanksClass(),moveRankText(),noContentListing(),addSearchIgnoredClass(),checkForNewPM(),checkForEmpty(".section-mcp-post-details .pagination ul"),bannerCodeGenerator(".link-banners img","#link-banner-code code"),addImageWrapper(".notification_list .list-inner > img"),addImageWrapper(".notification_list .notification-block > img"),addImageBackground(".page-welcome .image-wrap img",!1),addImageBackground(".postprofile .avatar img",!1),addImageBackground(".dropdown-container .user-avatar img",!1),addImageBackground(".forum-image img","1000x500"),addImageBackground(".excerpt .excerpt-image img","1000x500"),detectiPhone(),collapseElements(".header .row-item .list-inner",".topiclist.forums","inner"),jQuery(document).ready(function(e){checkForSpace("fieldset dl dt"),checkForSpace("dl.details dt"),addScrollableArea(e(".topicreview"),400,e(".review .right-box")),addScrollableArea(e(".mcp-main #post_details"),400,e(".mcp-main .post-buttons #expand")),addAttachmentIcon(),updateaAttachmentDisplay(".image-open"),updateaAttachmentDisplay(".attach-image img"),formatDisplayActions(),hidePMPostBox(),addCPWrapper(),toggleContent(".toggle-links a","#page-welcome .site-links","toggle-show",""),toggleContent(".toggle-featured a","#featured-content","toggle-show",""),toggleContent(".bbcode-hidden-toggle",".bbcode-hidden-text","toggle-show","prev"),toggleContent(".card-filter-button",".card-changed","toggle-hide",""),toggleMemberDisplay(),toggleMapDisplay(),e("body").hasClass("simple-phpbb")||(addOnScroll("#page-header .navbar",".header-overlay","sticky"),addOnScroll(".quick-links",".site-description","quick-links-visible"),scrollOnPage(".scroll-to-top",100,0),scrollOnPage(".scroll-to-bottom",100,bottomDistance)),initializeDiscordList(),initializeDropdownMenu(".menu-trigger",".menu > li"),initializeMobileMenu({menu:"#page-header .navbar .wrapper > ul",menuContainer:"#page-header .navbar .wrapper",mobileButton:".mobile-menu-button",mobileMenu:"#mobile-menu",mobileContent:".mobile-menu-content",mobileOverlay:"#mobile-overlay",width:768}),updateProfileFields()});