$(document).ready(function(){

// Remove empty a tags produced by Wordpress Image Uploader	
$('#image_scroller .container a').each(function() {
	 if ($(this).children().length == 0) {
	   $(this).remove();
	 }
});

// Remove empty p tags produced by Wordpress Image Uploader	
$('#image_scroller .container p').each(function() {
	 if ($(this).children().length == 0) {
	   $(this).remove();
	 }
});

// Tooltip
$('.tooltip').tipsy({
	gravity: $.fn.tipsy.autoNS,
	fade: true,
	html: true
});
$('.tooltip-e').tipsy({
	gravity: 'e',
	fade: true,
	html: true
});

// Scroll
jQuery.localScroll();

// Colorbox
$(".zoom").colorbox({maxWidth:"80%", maxHeight:"80%"});
$(".iframe").colorbox({width:"95%", height:"95%", iframe:true});

// Drop Menu
$("#nav ul ul").css({display: "none"});
$("#nav ul li").hover(function(){
$(this).find('ul:first').css({visibility: "visible",display: "none"}).slideDown(400);
},function(){
$(this).find('ul:first').css({visibility: "hidden"});
});

// Disable Parent li if has child items
$("#nav ul li:has(ul)").hover(function () {
$(this).children("a").click(function () {
return false;
});
});

// Validate
$("#contact_form").validate({
		rules: {
			name: { required: true, minlength: 3 },
			email: { required: true, email: true },
			message: { required: true, minlength: 4 }
		},
			
		messages: {
			name: { required: "Please enter your name", minlength: "Your name must consist of at least 3 characters" },
			email: "Please enter a valid email address",
			message: { required: "Please enter a message", minlength: "Your message must consist of at least 4 characters" }
		}
	});

// Form submit
$('#contact_form').ajaxForm(function() { 
   alert("Thank you. Your message was sent successfully!"); 
});

// Show / Hide
$("#show").click(function () {
	$("#hidden").show("slow");
});
$("#close").click(function () {
	$("#hidden").hide(1000);
});

// Accordion
$('.accordion .accordion_title').click(function() {
$(this).next().toggle('slow');
return false;
}).next().hide();

// Toggler

// choose text for the show/hide link - can contain HTML (e.g. an image)
var showText='Open';
var hideText='Close';

// initialise the visibility check
var is_visible = false;

// append show/hide links to the element directly preceding the element with a class of "toggle"
$('.toggle').prev().append(' <a href="#" class="toggleLink">'+showText+'</a>');

// hide all of the elements with a class of 'toggle'
$('.toggle').hide();

// capture clicks on the toggle links
$('a.toggleLink').click(function() {

// switch visibility
is_visible = !is_visible;

// change the link depending on whether the element is shown or hidden
$(this).html( (!is_visible) ? showText : hideText);

// toggle the display - uncomment the next line for a basic "accordion" style
//$('.toggle').hide();$('a.toggleLink').html(showText);
$(this).parent().next('.toggle').toggle('slow');

// return false so any link destination is not followed
return false;
});

// Preloader
QueryLoader.selectorPreload = "body";
QueryLoader.init();

});