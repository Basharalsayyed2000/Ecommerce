$(function (){

'use strict';
// switch between login and signup

$('.login-page h1 span').click(function(){
   
   $(this).addClass('selected').siblings().removeClass('selected');
   $('.login-page form').hide();
   $('.' + $(this).data('class')).fadeIn(100);
});


//hide placeholder on form focus
$('[placeholder]').focus(function(){

$(this).attr('data-text', $(this).attr('placeholder'));

$(this).attr('placeholder','');

}).blur(function (){

    $(this).attr('placeholder',$(this).attr('data-text'));

});
 
 // confirmation botton
 $('.confirm').click(function (){
    return confirm('are you sure?');
 });
 // catagory view option
 $('.cat h3').click(function(){
   $(this).next('.full-view').fadeToggle(200);
 });

//to print the title of item
 $('.live-name').keyup(function(){

     $('.live-preview .caption h4').text($(this).val());

 });

 //to print the description of item
 $('.live-Description').keyup(function(){

   $('.live-preview .caption p').text($(this).val());

});

 //to print the price of item
 $('.live-price').keyup(function(){

   $('.live-preview .price-tag').text($(this).val()+"$");

});


});
