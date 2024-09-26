
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
   // change attribute
   $('.attributes .form-check-label:not(.color)').click(function(){
    $(this).toggleClass('attribute-checked')
   })
   $('.attributes .form-check-label.color').click(function(){
    $(this).toggleClass('attribute-checked-color')
   })

   $('.filter-btn').click(function(){
    // change chevron
    let i_child = $(this).find('i.fa-solid');
    
    if(i_child.hasClass('fa-chevron-down')){
        i_child.removeClass('fa-chevron-down');
        i_child.addClass('fa-chevron-up');
    }else{
        i_child.removeClass('fa-chevron-up');
        i_child.addClass('fa-chevron-down');
    }
    $(this).siblings('.filter-values').slideToggle()
   })

   // hide and show filtering 
   $('#btn-filtering').click(function(){
    $('#filtering').css('left','0');
    $(this).css('left','-100%')
   })
   $('#hide-filtering').click(function(){
    $('#filtering').css('left','-200%');
    $('#btn-filtering').css('left','0')
   })
})