/* Global */
(function ($, underfined) {
    //站点设置
    var settings = {
        modalTemplate: '' +
            '<div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">' +
                '<div class="modal-dialog">' +
                    '<div class="modal-content"></div>' +
                '</div>' +
            '</div>'
    };


    $(function() {
        // Scroll body to 0px on click
        var $topButton = $('[data-toggle^="backTop"]');
        $topButton.click(function (e) {
            $('body, html').animate({
                scrollTop: 0
            }, 800);
            e.preventDefault();
        });
        $(window).scroll(function () {
            var scrollTop = $(this).scrollTop();
            $topButton[scrollTop > 100 ? 'fadeIn' : 'fadeOut'](300);
        });

        // 自动为modal注册 remote 加载载体
        $('[data-toggle^="modal"]').each(function() {
            var $this = $(this),
                href = $this.attr('href'),
                target = $this.attr('data-target') || (href && href.replace(/.*(?=#[^\s]+$)/, '')),
                symbol = target.substr(0, 1);
            if (!href || !target || (symbol !== '.' && symbol !== '#')) return ;
            $(settings.modalTemplate)
                .attr((symbol == '#' ? 'id' : 'class'), target.substr(1, target.length))
                .appendTo('body');
        });

        //自动注册 tooltip 事件
        $('[data-toggle=tooltip]').tooltip()
    });
})(jQuery);