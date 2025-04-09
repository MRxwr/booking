$(document).ready(function () {
    // Navbar scroll effect
    $(window).scroll(function () {
        if ($(this).scrollTop() > 100) {
            $('.navbar').addClass('scrolled');
            $('#backToTop').addClass('active');
        } else {
            $('.navbar').removeClass('scrolled');
            $('#backToTop').removeClass('active');
        }
    });

    // Smooth scrolling for nav links
    $('.nav-link, .footer-links a').on('click', function (e) {
        if (this.hash !== '') {
            e.preventDefault();
            const hash = this.hash;
            $('html, body').animate({
                scrollTop: $(hash).offset().top - 100
            }, 800);
        }
    });

    // Back to top button
    $('#backToTop').on('click', function () {
        $('html, body').animate({ scrollTop: 0 }, 800);
    });

    // Animation on scroll
    $(window).scroll(function() {
        $('.fade-in').each(function() {
            const elementTop = $(this).offset().top;
            const elementBottom = elementTop + $(this).outerHeight();
            const viewportTop = $(window).scrollTop();
            const viewportBottom = viewportTop + $(window).height();

            if (elementBottom > viewportTop && elementTop < viewportBottom) {
                $(this).addClass('visible');
            }
        });
    });
});
