/*----------left sidebar---------------*/

var lis = document.getElementById("navbar").getElementsByTagName("li");
function process(){
    alert('check');
     for (let i = 0; i < lis.length; i++) {
      lis[i].classList.remove('active');
      
    }
    this.classList.add('active');
   
}

for (let i = 0; i < lis.length; i++) {
     lis[i].addEventListener("click", process);
}
            
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

