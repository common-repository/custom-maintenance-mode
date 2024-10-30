function strtotime(e, t) {
    function n(e, t, n) {
        var a, r = i[t];
        "undefined" != typeof r && (a = r - u.getDay(), 0 === a ? a = 7 * n : a > 0 && "last" === e ? a -= 7 : 0 > a && "next" === e && (a += 7), u.setDate(u.getDate() + a))
    }

    function a(e) {
        var t = e.split(" "),
            a = t[0],
            r = t[1].substring(0, 3),
            s = /\d+/.test(a),
            o = "ago" === t[2],
            i = ("last" === a ? -1 : 1) * (o ? -1 : 1);
        if (s && (i *= parseInt(a, 10)), d.hasOwnProperty(r) && !t[1].match(/^mon(day|\.)?$/i)) return u["set" + d[r]](u["get" + d[r]]() + i);
        if ("wee" === r) return u.setDate(u.getDate() + 7 * i);
        if ("next" === a || "last" === a) n(a, r, i);
        else if (!s) return !1;
        return !0
    }
    var r, s, o, u, i, d, c, l, h, f;
    if (!e) return null;
    if (e = e.replace(/^\s+|\s+$/g, "").replace(/\s{2,}/g, " ").replace(/[\t\r\n]/g, "").toLowerCase(), "now" === e) return null === t || isNaN(t) ? (new Date).getTime() / 1e3 | 0 : 0 | t;
    if (!isNaN(r = Date.parse(e))) return r / 1e3 | 0;
    if ("now" === e) return (new Date).getTime() / 1e3;
    if (!isNaN(r = Date.parse(e))) return r / 1e3;
    if (s = e.match(/^(\d{2,4})-(\d{2})-(\d{2})(?:\s(\d{1,2}):(\d{2})(?::\d{2})?)?(?:\.(\d+)?)?$/)) return o = s[1] >= 0 && s[1] <= 69 ? +s[1] + 2e3 : s[1], new Date(o, parseInt(s[2], 10) - 1, s[3], s[4] || 0, s[5] || 0, s[6] || 0, s[7] || 0) / 1e3;
    if (u = t ? new Date(1e3 * t) : new Date, i = {
        sun: 0,
        mon: 1,
        tue: 2,
        wed: 3,
        thu: 4,
        fri: 5,
        sat: 6
    }, d = {
        yea: "FullYear",
        mon: "Month",
        day: "Date",
        hou: "Hours",
        min: "Minutes",
        sec: "Seconds"
    }, l = "(years?|months?|weeks?|days?|hours?|minutes?|min|seconds?|sec|sunday|sun\\.?|monday|mon\\.?|tuesday|tue\\.?|wednesday|wed\\.?|thursday|thu\\.?|friday|fri\\.?|saturday|sat\\.?)", h = "([+-]?\\d+\\s" + l + "|(last|next)\\s" + l + ")(\\sago)?", s = e.match(new RegExp(h, "gi")), !s) return !1;
    for (f = 0, c = s.length; c > f; f++)
        if (!a(s[f])) return !1;
    return u.getTime() / 1e3
}

function wpspandntcountdn(e) {
    function t(e) {
        return Math.PI / 180 * e - Math.PI / 180 * 90
    }

    function n() {
        var e = jQuery("#canvas_seconds").get(0),
            n = e.getContext("2d");
        n.clearRect(0, 0, e.width, e.height), n.beginPath(), n.strokeStyle = "#f27a4b", n.arc(83, 83, 72, t(0), t(6 * u.seconds)), n.lineWidth = 21, n.stroke(), jQuery(".wpspandnt_second .clockcounter").text(60 - u.seconds)
    }

    function a() {
        var e = jQuery("#canvas_minutes").get(0),
            n = e.getContext("2d");
        n.clearRect(0, 0, e.width, e.height), n.beginPath(), n.strokeStyle = "#f8dc6b", n.arc(83, 83, 72, t(0), t(6 * u.minutes)), n.lineWidth = 21, n.stroke(), jQuery(".wpspandnt_minute .clockcounter").text(60 - u.minutes)
    }

    function r() {
        var e = jQuery("#canvas_hours").get(0),
            n = e.getContext("2d");
        n.clearRect(0, 0, e.width, e.height), n.beginPath(), n.strokeStyle = "#82f876", n.arc(83, 83, 72, t(0), t(15 * u.hours)), n.lineWidth = 21, n.stroke(), jQuery(".wpspandnt_hour .clockcounter").text(24 - u.hours)
    }

    function s() {
        var e = jQuery("#canvas_days").get(0),
            n = e.getContext("2d");
        n.clearRect(0, 0, e.width, e.height), n.beginPath(), n.strokeStyle = "#cf86fd", n.arc(83, 83, 72, t(0), t(360 / u.total * (u.total - u.days))), n.lineWidth = 21, n.stroke(), jQuery(".wpspandnt_day .clockcounter").text(u.days)
    }

    function o() {
        var e = setInterval(function () {
            if (u.seconds > 59) {
                if (60 - u.seconds == 0 && 60 - u.minutes == 0 && 24 - u.hours == 0 && 0 == u.days) return clearInterval(e), window.location.href = u.original_url, void 0;
                u.seconds = 1, u.minutes > 59 ? (u.minutes = 1, a(), u.hours > 23 ? (u.hours = 1, u.days > 0 && (u.days--, s())) : u.hours++, r()) : u.minutes++, a()
            } else u.seconds++;
            n()
        }, 1e3)
    }
    var u = e,
        i = strtotime("+1 hours", u.installtime);
    i == u.expiredate && (u.value = u.expiredate - u.currentdate, u.total = Math.floor(u.value / 86400), u.days = Math.floor(u.value / 86400), u.hours = 24 - Math.floor(u.value % 86400 / 3600), u.minutes = 60 - Math.floor(u.value % 86400 % 3600 / 60), u.seconds = 60 - Math.floor(u.value % 86400 % 3600 % 60), n(), a(), r(), s(), o())
}