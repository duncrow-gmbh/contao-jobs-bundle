$(function () {

    const $body = $('body');
    const $footer = $('#footer');

    const $joblist = $('.mod_joblist');

    const urlParams = new URLSearchParams(window.location.search);

    if (urlParams.get('action') === 'print') {
        window.print();
    }

    const $jobShort = $joblist.find('.job_short');
    $jobShort.each(function () {

        let $template = $(this);
        let $overlay = $template.find('.overlay');
        let $openOverlayButton = $template.find('button.open-overlay')
        let $closeOverlayButton = $template.find('button.close-overlay')

        $openOverlayButton.on('click', function () {
            $body.addClass('job-overlay-open');
            $overlay.addClass('open');
        });

        $closeOverlayButton.on('click', function () {
            $body.removeClass('job-overlay-open');
            $overlay.removeClass('open');
        });
    });


    const $jobApplicationBanner = $body.find('.mod_jobapplicationbanner');
    $jobApplicationBanner.each(function () {
        if ($(this).hasClass('fixed')) {

            $(this).scrollToFixed({
                bottom: 0,
                limit: $footer.offset().top
            })
        }
    });
});
