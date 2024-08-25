
$(document).ready(function(){
    // methos to set class active on the current link of page
    let takeUrl = window.location.href;
    let array = takeUrl.split('');
    let last = array.pop();
    if(last == '/'){
        takeUrl = array.join('');
    }
   let links = $('.nav-item .nav-link');
   links.each(function(link){
        console.log($(this).attr('href'));
        if($(this).attr('href') == takeUrl){
            $(this).parent().siblings().removeClass('active');
            $(this).parent().addClass('active')
        }
   })
})