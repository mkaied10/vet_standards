// custom.js
$(document).ready(function() {
    // Smooth Scroll
    $('.nav-link, .dropdown-item').on('click', function(e) {
        if (this.hash !== '') {
            e.preventDefault();
            const hash = this.hash;
            $('html, body').animate({
                scrollTop: $(hash).offset().top - 70
            }, 800);
        }
    });

    // Navbar Collapse on Mobile
    $('.navbar-nav>li>a').on('click', function(){
        $('.navbar-collapse').collapse('hide');
    });

    // Export Table to PDF
    $('.export-pdf').on('click', function() {
        const table = $(this).data('table');
        const doc = new jsPDF();
        doc.autoTable({ html: `#${table}` });
        doc.save('specifications.pdf');
    });

    // Nested Dropdowns
    $('.dropdown-submenu').on('click', function(e) {
        e.stopPropagation();
        $(this).find('.dropdown-menu').toggle();
    });
});