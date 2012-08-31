$(document).ready(function(){
	
	/*** ADD PHOTO FORM DATEPICKER ***/
	$("#newphoto_photodate").datepicker({
		dateFormat: 'yy-mm-dd'
	});
	
	
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
	$('div.day').append('<a href="#" class="nextphotolink">Next</a><a href="#" class="prevphotolink">Prev</a>');
	$('.nextphotolink').click(function(){
		scrollDay($(this).parent().next('.day'));
		return false;
	});
	$('.prevphotolink').click(function(){
		scrollDay($(this).parent().prev('.day'));
		return false;
	});
});

/*** SKIP TO NEXT PICTURE IN STACK ***/
function nextPicInStack(currentphoto)
{
	if(currentphoto.is(':last-of-type') && currentphoto.css('opacity') == '1')
	{
		currentphoto.css('opacity',0);
	
		setTimeout(function(){
			currentphoto.parent().find('article.photo:first-of-type').before(currentphoto);
			currentphoto.css('opacity','');
		},500);
	}
}

/*** SCROLL TO A NEW DAY ON THE PAGE ***/
function scrollDay(newday)
{
	if(newday.length == 1)
	{
		$.scrollTo(newday,300,{
			axis: 'y',
			offset: {
				top:-35
			}
		});
	}
}