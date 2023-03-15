// Custome theme code

if ($('.clean-gallery').length > 0) {
    baguetteBox.run('.clean-gallery', { animation: 'slideIn' });
}

if ($('.clean-product').length > 0) {
    $(window).on("load", function() {
        $('.sp-wrap').smoothproducts();
    });
}

function copyToClipboard(element) {
    var $temp = $("<input>");
    $("body").append($temp);
    $temp.val($(element).text()).select();
    document.execCommand("copy");
    $temp.remove();
}


$(document).ready(function() {
    $(".firstmenu").hover(function() {
        var dropdownMenu = $(this).children(".dropdown-menu-firstmenu");
        var dropdownSubMenu = dropdownMenu.children(".dropdown-menu-secondmenu");
        if (dropdownMenu.is(":visible")) {
            dropdownMenu.parent().toggleClass("open");
        }
        if (dropdownSubMenu.is(":visible")) {
            dropdownMenu.parent().toggleClass("open");
        }
    });



});