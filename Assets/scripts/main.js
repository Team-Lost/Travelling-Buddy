/*----------left sidebar---------------*/
$(document).on('click', '#sidebar li', function() {
    $(this).addClass('active').siblings().removeClass('active')
});
            
/*----------left sidebar dropdown menu toggle---------------*/
$('.sub-menu ul').hide();
$(".sub-menu a").click(function() {
    $(this).parent(".sub-menu").children("ul").slideToggle("100");
    $(this).find(".right").toggleClass("fa-caret-up fa-caret-down");
});

/*----------sidebar toggle---------------*/
$(document).ready(function() {
    $("#toogleSidebar").click(function() {
        $(".left-menu").toggleClass("hide");
        $(".content-wrapper").toggleClass("hide");
    });
});

/*-----------------data table------------------*/
$(document).ready(function() {
    var table = $('#tableNewUser').DataTable({
        pageLength : 5
    });
} );