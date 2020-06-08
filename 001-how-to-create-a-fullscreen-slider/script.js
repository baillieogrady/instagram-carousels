$(function () {
    const $hero = $('.hero');

    $hero.slick({
        prevArrow: '<button class="slick-prev slick-arrow" aria-label="Previous" type="button" style=""><svg width="20" viewBox="0 0 20 35" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M1.10645 33.3658L17.1064 17.3658L1.10645 1.36578" stroke="#333333" stroke-width="4" /></svg></button>',
        nextArrow: '<button class="slick-next slick-arrow" aria-label="Next" type="button" style=""><svg width="20" viewBox="0 0 20 35" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M1.10645 33.3658L17.1064 17.3658L1.10645 1.36578" stroke="#333333" stroke-width="4" /></svg></button>'
    });
})