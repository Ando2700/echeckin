$(document).ready(function () {
    let alert = $('.alert');

    alert.fadeIn(700);

    setTimeout(function () {
        alert.fadeOut(1000)
    }, 3000)
})
