$(function (){

'use strict';

//hide placeholder on form focus
$('[placeholder]').focus(function(){

$(this).attr('data-text', $(this).attr('placeholder'));

$(this).attr('placeholder','');

}).blur(function (){

    $(this).attr('placeholder',$(this).attr('data-text'));

});


// add asterisk on required field
 $('input').each( function (){

    if($(this).attr('required') === 'required'){
         $(this).after('<span class="asterisk">*</span>');
    }
 });

 // convert password into text on hover
 var passfield=$('.password');
 $('.show-pass').hover(function(){
    passfield.attr('type','text');
}, function(){

    passfield.attr('type','password');
 });

 // confirmation botton
 $('.confirm').click(function (){
    return confirm('are you sure?');
 });
 // catagory view option
 $('.cat h3').click(function(){
   $(this).next('.full-view').fadeToggle(200);
 });



 //show delete button on child cats
 $('.child-link').hover(function(){
   $(this).find('.show-delete').fadeIn(400);  
 },function(){
   $(this).find('.show-delete').fadeOut(400);
 });
});
