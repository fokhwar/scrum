function LoadTodo(url)
{
	$('#loader').hide();
	$('#show_label').hide();
	
	$('#dev').change(function(){
		if($('#dev').val() != null)
		{
			$('#show_todo').fadeOut();
			$('#loader').show();
			$.post(url, {
				dev_id: $('#dev').val(),
			}, function(response){
				setTimeout("finishAjax('show_todo', '"+escape(response)+"')", 400);
			});
			return false;
		}
	});
}

function finishAjax(id, response){
	$('#loader').hide();
	$('#show_label').show();
	$('#'+id).html(unescape(response));
	$('#'+id).fadeIn();
}

function LoadEditData(base_url)
{
	$('#add').click(function(e){
		e.preventDefault();
		$('#dialog-message').dialog('open');
		$('#result_form').attr('action',base_url+'user/result/addresult');
		$('#finish').val('');
		$('#todo').val('');
		$('#note').val('');
		$('#submit').attr('value','Add Result');
	});
	
	$('.edit').click(function(e){
		e.preventDefault();
		$('#dialog-message').dialog('open');
		var $id = $(this).attr('id').split(' ')[0];
		var $devId = $(this).attr('id').split(' ')[1];
		$.ajax({
			type: 'POST',
			url: base_url+'user/result/getdatabydev',
			data:{'id':$devId},
			success:function(html){
				$('#result_form').attr('action',base_url+'user/result/editresult/'+$id);
				$('#dev option[value='+$devId+']').attr('selected','selected');
				var data = html.split('#');
				$('#finish').val(data[0]);
				$('#todo').val(data[1]);
				$('#note').val(data[2]);
				$('#submit').attr('value','Update Result');
			}
		})
	});
}
