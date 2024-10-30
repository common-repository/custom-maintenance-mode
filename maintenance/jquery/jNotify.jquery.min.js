/************************************************************************
*************************************************************************
@Name :       	jNotify - jQuery Plugin
@Revison :    	2.1
@Date : 		18/01/2011
@Author:     	 ALPIXEL (www.myjqueryplugins.com - www.alpixel.fr)
@Support:    	 FF, IE7, IE8, MAC Firefox, MAC Safari
@License :		 Open Source - MIT License : http://www.opensource.org/licenses/mit-license.php
 
**************************************************************************
*************************************************************************/
(function ($) {
    jQuery.jNotify = {
        defaults: {
            autoHide: true,
            clickOverlay: false,
            MinWidth: 200,
            TimeShown: 2500,
            ShowTimeEffect: 200,
            HideTimeEffect: 200,
            LongTrip: 15,
            HorizontalPosition: 'center',
            VerticalPosition: 'top',
            ShowOverlay: true,
            ColorOverlay: '#000',
            OpacityOverlay: 0.3,
            onClosed: null,
            onCompleted: null
        },
        init: function (msg, options, id) {
            opts = jQuery.extend({}, jQuery.jNotify.defaults, options);
            if (jQuery("#" + id).length == 0) $Div = jQuery.jNotify._construct(id, msg);
            WidthDoc = parseInt(jQuery(window).width());
            HeightDoc = parseInt(jQuery(window).height());
            ScrollTop = parseInt(jQuery(window).scrollTop());
            ScrollLeft = parseInt(jQuery(window).scrollLeft());
            posTop = jQuery.jNotify.vPos(opts.VerticalPosition);
            posLeft = jQuery.jNotify.hPos(opts.HorizontalPosition);
            if (opts.ShowOverlay && jQuery("#jOverlay").length == 0) jQuery.jNotify._showOverlay($Div);
            jQuery.jNotify._show(msg)
        },
        _construct: function (id, msg) {
            $Div = jQuery('<div id="' + id + '"/>').css({
                opacity: 0,
                minWidth: opts.MinWidth
            }).html(msg).appendTo('body');
            return $Div
        },
        vPos: function (pos) {
            switch (pos) {
            case 'top':
                var vPos = ScrollTop + parseInt($Div.outerHeight(true) / 2);
                break;
            case 'center':
                var vPos = ScrollTop + (HeightDoc / 2) - (parseInt($Div.outerHeight(true)) / 2);
                break;
            case 'bottom':
                var vPos = ScrollTop + HeightDoc - parseInt($Div.outerHeight(true));
                break
            }
            return vPos
        },
        hPos: function (pos) {
            switch (pos) {
            case 'left':
                var hPos = ScrollLeft;
                break;
            case 'center':
                var hPos = ScrollLeft + (WidthDoc / 2) - (parseInt($Div.outerWidth(true)) / 2);
                break;
            case 'right':
                var hPos = ScrollLeft + WidthDoc - parseInt($Div.outerWidth(true));
                break
            }
            return hPos
        },
        _show: function (msg) {
            $Div.css({
                top: posTop,
                left: posLeft
            });
            switch (opts.VerticalPosition) {
            case 'top':
                $Div.animate({
                    top: posTop + opts.LongTrip,
                    opacity: 1
                }, opts.ShowTimeEffect, function () {
                    if (opts.onCompleted) opts.onCompleted()
                });
                if (opts.autoHide) jQuery.jNotify._close();
                else $Div.css('cursor', 'pointer').click(function (e) {
                    jQuery.jNotify._close()
                });
                break;
            case 'center':
                $Div.animate({
                    opacity: 1
                }, opts.ShowTimeEffect, function () {
                    if (opts.onCompleted) opts.onCompleted()
                });
                if (opts.autoHide) jQuery.jNotify._close();
                else $Div.css('cursor', 'pointer').click(function (e) {
                    jQuery.jNotify._close()
                });
                break;
            case 'bottom':
                $Div.animate({
                    top: posTop - opts.LongTrip,
                    opacity: 1
                }, opts.ShowTimeEffect, function () {
                    if (opts.onCompleted) opts.onCompleted()
                });
                if (opts.autoHide) jQuery.jNotify._close();
                else $Div.css('cursor', 'pointer').click(function (e) {
                    jQuery.jNotify._close()
                });
                break
            }
        },
        _showOverlay: function (el) {
            var overlay = jQuery('<div id="jOverlay" />').css({
                backgroundColor: opts.ColorOverlay,
                opacity: opts.OpacityOverlay
            }).appendTo('body').show();
            if (opts.clickOverlay) overlay.click(function (e) {
                e.preventDefault();
                opts.TimeShown = 0;
                jQuery.jNotify._close()
            })
        },
        _close: function () {
            switch (opts.VerticalPosition) {
            case 'top':
                if (!opts.autoHide) opts.TimeShown = 0;
                $Div.stop(true, true).delay(opts.TimeShown).animate({
                    top: posTop - opts.LongTrip,
                    opacity: 0
                }, opts.HideTimeEffect, function () {
                    jQuery(this).remove();
                    if (opts.ShowOverlay && jQuery("#jOverlay").length > 0) jQuery("#jOverlay").remove();
                    if (opts.onClosed) opts.onClosed()
                });
                break;
            case 'center':
                if (!opts.autoHide) opts.TimeShown = 0;
                $Div.stop(true, true).delay(opts.TimeShown).animate({
                    opacity: 0
                }, opts.HideTimeEffect, function () {
                    jQuery(this).remove();
                    if (opts.ShowOverlay && jQuery("#jOverlay").length > 0) jQuery("#jOverlay").remove();
                    if (opts.onClosed) opts.onClosed()
                });
                break;
            case 'bottom':
                if (!opts.autoHide) opts.TimeShown = 0;
                $Div.stop(true, true).delay(opts.TimeShown).animate({
                    top: posTop + opts.LongTrip,
                    opacity: 0
                }, opts.HideTimeEffect, function () {
                    jQuery(this).remove();
                    if (opts.ShowOverlay && jQuery("#jOverlay").length > 0) jQuery("#jOverlay").remove();
                    if (opts.onClosed) opts.onClosed()
                });
                break
            }
        },
        _isReadable: function (id) {
            if (jQuery('#' + id).length > 0) return false;
            else return true
        }
    };
    jNotify = function (msg, options) {
        if (jQuery.jNotify._isReadable('jNotify')) jQuery.jNotify.init(msg, options, 'jNotify')
    };
    jSuccess = function (msg, options) {
        if (jQuery.jNotify._isReadable('jSuccess')) jQuery.jNotify.init(msg, options, 'jSuccess')
    };
    jError = function (msg, options) {
        if (jQuery.jNotify._isReadable('jError')) jQuery.jNotify.init(msg, options, 'jError')
    }
})(jQuery);