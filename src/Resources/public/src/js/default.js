$(function () {

    const $body = $('body');
    const $footer = $('#footer');

    const urlParams = new URLSearchParams(window.location.search);

    if (urlParams.get('action') === 'print') {
        window.print();
    }

    const $shareButton = $('.actions.job-actions > .share-job');
    $shareButton.on('click', function (e) {
        e.preventDefault();

        const $btn = $(this);

        let href = $(this).attr('href');
        let html = $(this).html();

        navigator.clipboard.writeText(href).then(() => {
            $btn.html('<span><span class="test">Link kopiert</span><span class="ms-2"><i class="far fa-check fa-fw" aria-hidden="true"></i></span></span>');

            setTimeout(function () {
                $btn.html(html);
            }, 3000);
        });
    });

    if($footer.length){
        const $jobApplicationBanner = $body.find('.mod_jobapplicationbanner');
        $jobApplicationBanner.each(function () {
            if ($(this).hasClass('fixed')) {
    
                $(this).scrollToFixed({
                    bottom: 0,
                    limit: $footer.offset().top
                })
            }
        });
    }
    
});
