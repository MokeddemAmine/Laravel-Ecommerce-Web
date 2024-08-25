$(document).ready(function(){
    // set active link to the current active page
    
    let links = $('#sidebar #sidebar-links-icons li a');
    let takeUrl = window.location.href;
    links.each(function(link){
        if($(this).attr('href') == takeUrl){
            $(this).parent('li').addClass('active');
        }
    })
})