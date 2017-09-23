! function($, Eles, localStorage, smoothScroll, particlesJS) {
    "use strict";
    Eles = {
        tooltips: !0,
        ripple_fx: !0,
        dom_inputs: !0,
        stick_nav: !0,
        back_to_top: !0,
        collapsible: !0,
        preloader: !0,
        smoothscroll: !0,
        header_vfx: !0,
        props: {
            headerVfx: {
                el: void 0,
                showSpeed: 450,
                configFile: void 0
            },
            oldScrollTop: 0
        },
        elements: {
            $navbar: $("#navbar-main"),
            $backToTop: $("#back2topMain")
        },
        _setPageHeight: function() {
            var contentHeight = $("#page-body").outerHeight(),
                sidebarHeight = $("#page-sidebar").outerHeight();
            $("#page-body-wrapper").css({
                "min-height": Math.max(contentHeight, sidebarHeight)
            })
        },
        _initHeaderVfx: function(containerElement) {
            var _self = this;
            containerElement.length && (_self.props.headerVfx.el = containerElement, particlesJS.load("header-vfx", _self.props.headerVfx.configFile, function() {
                containerElement.toggleClass("visible")
            }))
        },
        _initTooltips: function() {
            $("a.forumtitle, a.topictitle, .profile-contact .icon_contact").not(".attachment-filename").tooltip({
                placement: "right"
            }), $(".lastpost span a").tooltip({
                placement: "left"
            }), $(".back2top a").tooltip({
                placement: "top"
            }), $(".post-buttons > li > a").tooltip({
                placement: "bottom"
            })
        },
        _initAjaxShoutbox: function() {
            $("#ajaxshoutbox_post")
        },
        _initRippleFx: function() {
            $(".button, .button1, .button2").on("click", function(event) {
                if ("format-buttons" === $(this).parent().attr("id") && "mchat-buttons" === $(this).parent().attr("id")) {
                    var $div = $("<div/>"),
                        $wrapper = '<span class="ripple-wrapper"></span>',
                        $this = $(this),
                        btnOffset = $(this).offset(),
                        xPos = event.pageX - btnOffset.left,
                        yPos = event.pageY - btnOffset.top;
                    $(this).is("input") && ($wrapper = '<span class="ripple-wrapper input"></span>'), $div.css("height", $this.height()), $div.css("width", $this.height()), $this.wrap($wrapper), $div.addClass("ripple").css({
                        top: yPos - $div.height() / 2,
                        left: xPos - $div.width() / 2,
                        background: "#fff"
                    }).appendTo($(".ripple-wrapper")), window.setTimeout(function() {
                        $div.remove(), $(".ripple-wrapper").replaceWith($this)
                    }, 2e3)
                }
            })
        },
        _initDomInputs: function() {
            $('input[type="checkbox"], input[type="radio"]').not('[name="icon"]').each(function(index, el) {
                var wrapper = document.createElement("label"),
                    inner = document.createElement("span");
                $(wrapper).addClass("input-wrapper"), $(inner).addClass("input-view"), $(el).is('input[type="checkbox"]') && $(inner).addClass("type-checkbox"), $(el).is('input[type="radio"]') && $(inner).addClass("type-radio"), $(el).wrap(wrapper).after(inner)
            })
        },
        _onScroll_manageStickyNav: function(oldScrollTop, newScrollTop) {
            var _self = this,
                $nav = _self.elements.$navbar;
            newScrollTop > $("#page-header").height() ? ($nav.addClass("fixed").parent().css("paddingTop", $nav.height()), oldScrollTop > newScrollTop ? ($nav.css("top", -$nav.height()), $nav.css("opacity", 0)) : ($nav.css("top", 0), $nav.css("opacity", 1))) : newScrollTop < $nav.height() ? ($nav.css("top", 0), $nav.css("opacity", 1)) : $nav.removeClass("fixed").css("top", -$nav.height()).css("opacity", 1).parent().css("paddingTop", 0)
        },
        _onScroll_manageBackToTop: function(oldScrollTop, newScrollTop) {
            var _self = this,
                $nav = _self.elements.$navbar,
                $btnTop = _self.elements.$backToTop;
            newScrollTop < $("#page-header").height() + $nav.height() + 200 ? $btnTop.removeClass("active") : oldScrollTop < newScrollTop ? $btnTop.removeClass("active") : $btnTop.addClass("active")
        },
        _onScroll_manageHeaderVfx: function(oldScrollTop, newScrollTop) {
            var _self = this;
			if (_self.props.headerVfx.el) {
	            var $headerVfxEl = _self.props.headerVfx.el.find("canvas");
	            newScrollTop < _self.props.headerVfx.el.height() / 2 ? $headerVfxEl.slideDown(_self.props.headerVfx.showSpeed) : oldScrollTop < newScrollTop && $headerVfxEl.slideUp(_self.props.headerVfx.showSpeed)
			}
        },
        _initCollapsibleCategories: function() {
            var elKey, elKeyPrefix = "elState_",
                elState = !1;
            $(".forabg li.header").append('<div class="collapse-btn"><a href="#" title="Toggle Visibility"><i class="fa"></i></a></div>'), $(".forabg").on("click", ".collapse-btn a", function(event) {
                var $wrapper = $(this).parents(".forabg");
                event.preventDefault(), $wrapper.toggleClass("collapsed"), $wrapper.find("ul.topiclist.forums").collapse("toggle"), elKey = elKeyPrefix + $wrapper.attr("id"), elState = null === localStorage.getItem(elKey) ? !elState : !JSON.parse(localStorage.getItem(elKey)), localStorage.setItem(elKey, elState)
            });
            for (var key in localStorage)
                if (key.substr(0, 8) === elKeyPrefix && "true" === localStorage[key]) {
                    var $el = $("#" + key.substr(8));
                    $el.addClass("collapsed"), $el.find("ul.topiclist.forums").addClass("collapse")
                }
            $(".forabg").not(".collapsed").each(function(index, el) {
                $(el).find("ul.topiclist.forums").addClass("collapse in")
            })
        }
    }, Eles.init = function() {
        var _self = this;
        _self.header_vfx && _self._initHeaderVfx($("#header-vfx")), _self.tooltips && _self._initTooltips(), _self._initAjaxShoutbox(), _self._setPageHeight(), $(window).on("resize", function() {
            _self._setPageHeight()
        }), $(window).on("scroll", function() {
            var oldScrollTop = _self.props.oldScrollTop,
                newScrollTop = $(this).scrollTop();
            _self.stick_nav && _self._onScroll_manageStickyNav(oldScrollTop, newScrollTop), _self.back_to_top && _self._onScroll_manageBackToTop(oldScrollTop, newScrollTop), _self.header_vfx && _self._onScroll_manageHeaderVfx(oldScrollTop, newScrollTop), _self.props.oldScrollTop = newScrollTop
        })
    }, $(window).on("load", function() {
        Eles.init()
    }), $('.display-options input[type="submit"]').wrap('<label class="go"></label>'), $("select:not([multiple])").wrap('<span class="select-parent"></span>'), Eles.ripple_fx && Eles._initRippleFx(), Eles.dom_inputs && Eles._initDomInputs();
    var _supportsLocalStorage = !!window.localStorage && $.isFunction(localStorage.getItem) && $.isFunction(localStorage.setItem);
    Eles.collapsible && _supportsLocalStorage && Eles._initCollapsibleCategories(), Eles.preloader && $(document).ready(function() {
        $(window).load(function() {
            $("#preloader").fadeOut("400", function() {
                $(this).remove()
            })
        })
    }), Eles.smoothscroll && smoothScroll.init({
        selector: "[data-scroll]",
        selectorHeader: "[data-scroll-header]",
        speed: 500,
        easing: "easeInOutCubic",
        updateURL: !0,
        offset: 0
    }), window.Eles = Eles
}(window.jQuery, window.Eles, window.localStorage, window.smoothScroll, window.particlesJS);
