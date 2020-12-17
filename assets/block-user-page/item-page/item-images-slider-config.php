<script>
var slider = tns({
    container: '.slider-container',
    items: 1,

    controlsContainer: '.slider-control-main-container',
    prevButton: '.slider-control-prev',
    nextButton: '.slider-control-next',

    navContainer: '.slider-nav',
    navAsThumbnails: true,

    autoplay: true,
    autoplayHoverPause: true,
    autoplayButtonOutput: false,
});

// Start autoplay
slider.play();

var sliderNav = tns({
    container: '.slider-nav',

    controlsContainer: '.slider-control-nav-container',
    prevButton: '.slider-nav-control-prev',
    nextButton: '.slider-nav-control-next',

    nav: false,
    loop: false,
    mouseDrag: true,

    responsive: {
        992: {
            items: 5,
            slideBy: 4,
        },
        768: {
            items: 3,
            slideBy: 1,
        },
        576: {
            items: 4,
            slideBy: 1,
        },
        288: {
            items: 3,
            slideBy: 1,
        },
        100: {
            items: 2,
            slideBy: 1,
        }
    },
});
</script>
