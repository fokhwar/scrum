function Initialize()
{
	//operation for each result
	$('#tabs p .operation').hide();
	$('#tabs p .show_note').hide();
	$('#tabs p').hover(function(){
		$(this).find('.operation').show();
	},function(){
		$(this).find('.operation').hide();
	});
	$('a.note').click(function(){
		$(this).parent().parent().find('.show_note').toggle();
	});
	
	//Create Result Operation
	$( "#dialog-message" ).dialog({
		autoOpen: false,
		modal: true,
		width: 650
	});
	
	//validation(
	$('.check_info').hide();
	$('#submit').click(function(e){
		if($('#dev_id').val() == 0 || $('#finish').val() == "" || $('#todo').val() == "")
		{
			e.preventDefault();
			$('.check_info').fadeIn(1000);
		}
	});
}

