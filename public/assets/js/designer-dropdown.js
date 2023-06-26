! function(e) {
    "use strict";

    function n(n) {
        e(n).on("click" + u, this.toggle)
    }

    function t(e, n) {
        e.hasClass("pull-center") && e.css("margin-right", e.outerWidth() / -2), e.hasClass("pull-middle") && e.css("margin-top", e.outerHeight() / -2 - n.outerHeight() / 2)
    }

    function o(n, t) {
        if (i) {
            t || (t = [i]);
            var o;
            i[0] !== t[0][0] ? o = i : (o = t[t.length - 1], o.parent().hasClass(c) && (o = o.parent())), o.find("." + f).removeClass(f), o.hasClass(f) && o.removeClass(f), o === i && (i = null, e(s).remove())
        }
    }

    function a(e) {
        for (var n, t = [e]; !n || n.hasClass(p);) n = (n || e).parent(), n.hasClass(c) && (n = n.parent()), n.children(d) && t.unshift(n);
        return t
    }

    function r(n) {
        var t = n.attr("data-bs-target");
        t || (t = n.attr("href"), t = t && /#[A-Za-z]/.test(t) && t.replace(/.*(?=#[^\s]*$)/, ""));
        var o = t && e(t);
        return o && o.length ? o : n.parent()
    }
    var i, d = '[data-bs-toggle="dropdown"]',
        l = ".disabled, :disabled",
        s = ".dropdown-backdrop",
        c = "dropdown-menu",
        p = "dropdown-submenu",
        h = ".bs.dropdown.data-api",
        u = ".bs.dropdown",
        f = "open",
        g = "ontouchstart" in document.documentElement,
        v = n.prototype;
    v.toggle = function(n) {
        var d = e(this);
        if (!d.is(l)) {
            var h = r(d),
                u = h.hasClass(f),
                v = h.hasClass(p),
                m = v ? a(h) : null;
            if (o(n, m), !u) {
                m || (m = [h]), !g || h.closest(".navbar-nav").length || m[0].find(s).length || e('<div class="' + s.substr(1) + '"/>').appendTo(m[0]).on("click", o);
                for (var b = 0, w = m.length; w > b; b++) m[b].hasClass(f) || (m[b].addClass(f), t(m[b].children("." + c), m[b]));
                i = m[0]
            }
            return !1
        }
    }, v.keydown = function(n) {
        if (/(38|40|27)/.test(n.keyCode)) {
            var t = e(this);
            if (n.preventDefault(), n.stopPropagation(), !t.is(".disabled, :disabled")) {
                var o = r(t),
                    a = o.hasClass("open");
                if (!a || a && 27 == n.keyCode) return 27 == n.which && o.find(d).trigger("focus"), t.trigger("click");
                var i = " li:not(.divider):visible a",
                    l = "li:not(.divider):visible > input:not(disabled) ~ label",
                    s = o.find(l + ', [role="menu"]' + i + ', [role="listbox"]' + i);
                if (s.length) {
                    var c = s.index(s.filter(":focus"));
                    38 == n.keyCode && c > 0 && c--, 40 == n.keyCode && c < s.length - 1 && c++, ~c || (c = 0), s.eq(c).trigger("focus")
                }
            }
        }
    }, v.change = function(n) {
        var t, o, a, r = "";
        if (t = e(this).closest("." + c), o = t.parent().find("[data-label-placement]"), o && o.length || (o = t.parent().find(d)), o && o.length && o.data("placeholder") !== !1) {
            void 0 == o.data("placeholder") && o.data("placeholder", e.trim(o.text())), r = e.data(o[0], "placeholder"), a = t.find("li > input:checked"), a.length && (r = [], a.each(function() {
                var n = e(this).parent().find("label").eq(0),

                    t = n.find(".data-label");
                if (t.length) {
                    var o = e("<p></p>");
                    o.append(t.clone()), n = o.html()
                } else n = n.html();
                n && r.push(e.trim(n))
            }), r = r.length < 2 ? r.join(",") : r.length + " selected");
            var i = o.find(".caret");
            //console.log(o);
            o.html(r || "&nbsp;"), i.length && o.append(" ") && i.appendTo(o)
            o.siblings('label.label').addClass('label_add_top');
        }
    };
    var m = e.fn.dropdown;
    e.fn.dropdown = function(t) {
        return this.each(function() {
            var o = e(this),
                a = o.data("bs.dropdown");
            a || o.data("bs.dropdown", a = new n(this)), "string" == typeof t && a[t].call(o)
        })
    }, e.fn.dropdown.Constructor = n, e.fn.dropdown.clearMenus = function(n) {
        return e(s).remove(), e("." + f + " " + d).each(function() {
            var t = r(e(this)),
                o = {
                    relatedTarget: this
                };
            t.hasClass("open") && (t.trigger(n = e.Event("hide" + u, o)), n.isDefaultPrevented() || t.removeClass("open").trigger("hidden" + u, o))
        }), this
    }, e.fn.dropdown.noConflict = function() {
        return e.fn.dropdown = m, this
    }, e(document).off(h).on("click" + h, o).on("click" + h, d, v.toggle).on("click" + h, '.dropdown-menu > li > input[type="checkbox"] ~ label, .dropdown-menu > li > input[type="checkbox"], .dropdown-menu.noclose > li', function(e) {
        e.stopPropagation()
    }).on("change" + h, '.dropdown-menu > li > input[type="checkbox"], .dropdown-menu > li > input[type="radio"]', v.change).on("keydown" + h, d + ', [role="menu"], [role="listbox"]', v.keydown)
}(jQuery);