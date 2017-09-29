$(function(){
    $(".accordion>a").click(function(){
        $(this).parent().addClass('active')
        .siblings().removeClass('active');
        console.log("a");
        $(this).siblings("ul").slideDown('slow').parent().siblings().find('ul').slideUp('slow');
    })
})