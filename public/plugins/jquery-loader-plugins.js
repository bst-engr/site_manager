/*
 * $("element").viewPortWidth(widthInPercentageOfViewPort):
 * */
(function($) {
    $.fn.viewPortWidth = function(width) {
        var element = $(this);
        var newWidth =  $(window).width() * width / 100;
        element.css({ width: newWidth+"px" });
        $(window).resize( function() {
            var newWidth =  $(window).width() * width / 100;
            element.css({ width: newWidth+"px" });
        });
        return this;
    };
}(jQuery));
/*
 * $("element").viewPortHeight(heightInPercentageOfViewPort):
 * */
(function ( $ ) {
    $.fn.viewPortHeight = function(height) {
        var element = $(this);
        var newHeight =  $(window).height() * height / 100;
        element.css({ height: newHeight+"px" });
        $(window).resize( function() {
            var newHeight =  $(window).height() * height / 100;
            element.css({ height: newHeight+"px" });
        });
        return this;
    };
}( jQuery ));
/*
* $("element").showLoader:
* shows the loader inside the element
* $("element").hideLoader:
* hides the loader
* */
(function ( $ ) {
    //var loaderMarkup = '<span class="loader"><i class="fa fa-cog fa-spin spinner"></i></span>';
    var loaderMarkup = '<div class="loader-wrapper">';
    loaderMarkup += '<div class="loader">';
    loaderMarkup += '<img src="/images/loader.gif">';
    loaderMarkup += '<span> Loading</span>';
    loaderMarkup += '</div>';
    loaderMarkup += '</div>';
    $.fn.showLoader = function() {
        return this.each(function () {
            // show loader
            $(this).append(loaderMarkup);

            // vars
            var elem = $(this),
                loaderWrapper = elem.children(".loader-wrapper"),
                loader = loaderWrapper.children(".loader"),
                height = elem.height();
            //console.log("elemHeight: "+height);
            // height should not be too large
            var winHeight = $(window).height();
            if( height > winHeight ) height = winHeight;
            //console.log("winHeight: "+winHeight);
            //console.log("elemHeight: "+height);
            //console.log("loaderWrapper.height: "+loaderWrapper.height());
            var marginTop = 0.1*height,
                loaderSize = height - (marginTop * 2);
            //console.log("marginTop: "+marginTop);
            //console.log("loaderSize: "+loaderSize);

            // adjust css
            elem.css({
                position: "relative"
            });
            loaderWrapper.css({
                position: "absolute",
                left: 0,
                top: 0,
                width: "100%",
                height: "100%",
                //backgroundColor: "rgba(0,0,0,0)",
                zIndex: 9999
            });
            loader.css({
                width: '310px',
                padding: '25px 5px',
                textAlign: 'center',
                zIndex: 9999,
                'border-radius': '5px',
                '-moz-box-shadow': '0 5px 75px rgba(0, 0, 0, 0.5)',
                '-webkit-box-shadow': '0 75px 15px rgba(0, 0, 0, 0.5)',
                'box-shadow': '0 5px 75px rgba(0, 0, 0, 0.5)',
                'background-color': '#fff'
            });
            loader.css({
                position: "absolute",
                top: ((loaderWrapper.outerHeight() - 90)/2)+"px",
                left: ((loaderWrapper.outerWidth() - loader.outerWidth())/2)+"px"
            });

            // disable event propagation when loader is present
            loaderWrapper.click(function () {
                return false;
            });

            // for chaining purpose
            return this;
        });

    };

    $.fn.hideLoader = function() {
        $(this).children(".loader-wrapper").remove();
        return this;
    };

}( jQuery ));
/*
 * $("element").makeBackdrop():
 * makes the element full width and height as the view-port
 * and adds a semitransparent background
 * */
(function ( $ ) {
    $.fn.makeBackdrop = function() {
        $(this).css({
            position: 'fixed',
            zIndex: 9999,
            top: 0,
            width: "100%",
            height: "100%",
            backgroundColor: "rgba(0,0,0,0.7)"
        });
        return this;
    };
}( jQuery ));

/*
 * $("element").viewPortCenter():
 * positions the element to the center of the screen
 * */
(function ( $ ) {
    $.fn.viewPortCenter = function() {
        var elemHeight = $(this).height(),
            elemWidth = $(this).width(),
            parent = $(window),
            parentHeight = parent.height(),
            parentWidth = parent.width(),
            top = (parentHeight - elemHeight) / 2,
            left = (parentWidth - elemWidth) / 2;
        $(this).css({
            position: 'fixed',
            zIndex: 9999,
            top: top+"px",
            left: left+"px"
        });
        return this;
    };
}( jQuery ));
/*
 * $.showLoader:
 * shows the loader on the whole screen
 * $.hideLoader:
 * hides the loader
 * */

(function($){
    $.showLoader = function () {
        var markup = '<div id="processing" style="display: none;">';
        markup += '<div class="popup-login loading-popup">';
        markup += '<img src="/images/loader.gif">';
        markup += '<span>Loading</span>';
        markup += '</div>';
        markup += '</div>';
        $("body").prepend(markup);

        var wrapper = $("#loader-wrapper");
        var loader = $("#spinner");

        function resizeLoader(){
            var parent = $(window),
                parentHeight = parent.height(),
                parentWidth = parent.width(),
                maxSize = parentHeight > parentWidth ? parentWidth : parentHeight,
                fontSize = maxSize * 0.6;
            loader.css({ fontSize: fontSize+"px" });
        }

        wrapper.makeBackdrop();
        resizeLoader();
        loader.viewPortCenter();
        $(window).resize( function() {
            wrapper.makeBackdrop();
            resizeLoader();
            loader.viewPortCenter();
        });
    };

    $.hideLoader = function() {
        $("#loader-wrapper").remove();
        return this;
    };

})(jQuery);
/*
 * $.showMessage:
 * shows an animated, dismiss-able message on the center of the screen
 * $.hideMessage:
 * hides the message
 * */
(function($){
    $.showMessage = function (msg,type) {
        type = type || "info";
        var markup =
            "<div id='message-wrapper'>" +
            "<div id='message' " +
            "class='alert alert-"+type+"'>" +
            msg+"<i class='fa fa-remove'></i>" +
            "</div>" +
            "</div>";

        $("body").prepend(markup);

        var wrapper = $("#message-wrapper");
        var msgDiv = $("#message");
        wrapper.makeBackdrop();
        msgDiv.css({
            position: 'absolute',
            margin: 0,
            width: '80%',
            left: '10%',
            top: '-10%',
            cursor: "pointer"
        });

        msgDiv.find(".fa").css({
            position: 'absolute',
            right: '0.5em',
            top: '0.5em'
        });

        var elemHeight = msgDiv.height(),
            parent = $(window),
            parentHeight = parent.height(),
            top = (parentHeight - elemHeight) / 2;
        msgDiv.animate({
            top: top+'px'
        }, 500, 'easeOutCirc', function() {
            msgDiv.click(function () {
                wrapper.remove();
            });
        });
        $(window).resize( function() {
            wrapper.makeBackdrop();
            msgDiv.viewPortCenter();
        });
    };
})(jQuery);