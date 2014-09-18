jQuery(function($){
/* ================= 首页设置 ================= */
    var indexSettings = {
        // 首页顶部大屏设置
        header: {
            domName: '#header',
            fullScreen: true,
            fadeIn: true,
            fadeDelay: 500
        }
    };

/* ================= 逻辑处理 ================= */
    var $window = $(window),
        $body = $('body'),
        $header = $(indexSettings.header.domName),
        _IEVersion = (navigator.userAgent.match(/MSIE ([0-9]+)\./) ? parseInt(RegExp.$1) : 99),
        _isTouch = !!('ontouchstart' in window),
        _isMobile = !!(navigator.userAgent.match(/(iPod|iPhone|iPad|Android|IEMobile)/));

    /**
     * 首页顶部大屏逻辑
     */
    if (_isMobile) {
        $header.css('background-attachment', 'scroll');
        indexSettings.header.fullScreen = false;
    }
    if (indexSettings.header.fullScreen) {
        $window.bind('resize.helios', function() {
            window.setTimeout(function() {
                var s = $header.children('.inner');
                var sh = s.outerHeight(), hh = $window.height(), h = Math.ceil((hh - sh) / 2) + 1;

                $header
                    .css('padding-top', h)
                    .css('padding-bottom', h);
            }, 0);
        }).trigger('resize');
    }
    if (indexSettings.header.fadeIn) {
        $('<div class="overlay" />').appendTo($header);
        $window.load(function() {
            var imageURL = $header.css('background-image').replace(/"/g,"").replace(/url\(|\)$/ig, "");
//            $.n33_preloadImage(imageURL, function() {
//                if (_IEVersion < 10) {
//                    $header.children('.overlay').fadeOut(2000);
//                } else {
//                    window.setTimeout(function() {
//                        $header.addClass('ready');
//                    }, helios_settings.header.fadeDelay);
//                }
//            });
        });
    }
});