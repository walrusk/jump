$(document).ready(function(){
	$("#newphoto_photodate").datepicker({
		dateFormat: 'yy-mm-dd'
	});
	
	
	
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
});