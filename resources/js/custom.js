// custom.js
$(document).ready(function() {
    // Smooth Scroll for Navbar Links
    $('.nav-link, .dropdown-item').on('click', function(e) {
        if (this.hash !== '') {
            e.preventDefault();
            const hash = this.hash;
            $('html, body').animate({
                scrollTop: $(hash).offset().top - 70
            }, 800);
        }
    });

    // Fade In Animation for Cards
    $('.card').each(function(index) {
        $(this).delay(200 * index).fadeIn(500);
    });

    // Navbar Collapse on Mobile
    $('.navbar-nav>li>a').on('click', function(){
        $('.navbar-collapse').collapse('hide');
    });

    // Search Form Validation
    $('.search-form').on('submit', function(e) {
        const query = $(this).find('input[name="query"]').val().trim();
        if (!query) {
            e.preventDefault();
            alert('يرجى إدخال كلمة بحث');
        }
    });

    // Back to Top Button
    const backToTop = $('<button>', {
        text: '⬆',
        class: 'btn btn-primary back-to-top',
        css: {
            position: 'fixed',
            bottom: '20px',
            right: '20px',
            display: 'none',
            zIndex: 1000
        }
    }).appendTo('body');

    $(window).scroll(function() {
        if ($(this).scrollTop() > 300) {
            backToTop.fadeIn();
        } else {
            backToTop.fadeOut();
        }
    });

    backToTop.click(function() {
        $('html, body').animate({ scrollTop: 0 }, 600);
    });
});