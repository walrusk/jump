$(document).ready(function(){
	
	/*** ADD PHOTO FORM DATEPICKER ***/
	if($.fn.datepicker)
	{
		$("#newphoto_photodate").datepicker({
			dateFormat: 'yy-mm-dd'
		});
	}
	
	
	/*** ADD PHOTO FORM HIDE/SHOW ***/
	$('#newphoto_link').click(function(){
		
		var tform = $(this).next('form');
		
		if(tform.is(':hidden'))
		{
			tform.slideDown();
			$(this).text('Close Form');
		}
		else
		{
			$(this).text('Add Photo');		
			tform.slideUp();
		}
		
		return false;
	});
	
	/*** SHUFFLE FANNED OUT PHOTOS ***/
	$('article.photo').click(function(){
		nextPicInStack($(this));
	});
	
	/*** NEXT/PREV PHOTO ARROWS ***/
	/*$('div.day').append('<a href="#" class="nextphotolink">Next</a><a href="#" class="prevphotolink">Prev</a>');
	
	$("div.day").on("click", ".nextphotolink", function(event){
		scrollToDay($(this).parent().next('.day'));
		return false;
	});
	
	$("div.day").on("click", ".prevphotolink", function(event){
		scrollToDay($(this).parent().prev('.day'));
		return false;
	});*/	
	
	
	/*** delete photo ***/
	$('a.deletephoto').click(function(){
		return confirm("Really?");
	});
	
});

/*** SKIP TO NEXT PICTURE IN STACK ***/
function nextPicInStack(currentphoto)
{
	if(currentphoto.is(':last-of-type') && !currentphoto.is(':first-of-type') && currentphoto.css('opacity') == '1')
	{
		currentphoto.css('opacity',0);
	
		setTimeout(function(){
			currentphoto.parent().find('article.photo:first-of-type').before(currentphoto);
			currentphoto.css('opacity','');
		},500);
	}
}

/*** SCROLL TO A NEW DAY ON THE PAGE ***/
function scrollToDay(newday)
{
	if(newday.length == 1)
	{
		$('html,body').animate({
			scrollTop: newday.offset().top-35
		}, 300);
	}
}
