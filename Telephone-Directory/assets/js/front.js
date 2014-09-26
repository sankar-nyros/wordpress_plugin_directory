
function Delete(id,name)
{
	
	$.confirm({
		text: "Are you sure you want to delete <b>"+ name +"</b> ..?",
		title: "Delete confirmation",
		confirmButton: "Delete",
    		cancelButton: "No",
    		confirmButtonClass: "btn-danger",
    		cancelButtonClass : "btn-inverse",
    		confirm: function(button) 
			{
	    		home = $('#home_url').val();
				$.ajax({
				type: "POST",
				dataType : 'json',
				url: home + "/wp-content/plugins/Telephone-Directory/delete.php",
				data: { id:id },
				success:function(data)
				{		
					if(data == 1)
					{
						$('#contact_'+id).hide('slow');	
					}
				}
			});
		},
		cancel: function(button) {},
	});

}

function Update(id)
{
$('#update_msg').html('');
	if($('#update_name').val().trim().length == 0)
	{
		$('#update_msg').append('<div class="alert alert-error">Please enter name.</div>');
	}
	else if($('#update_contact').val().length == 0)
	{
		$('#update_msg').append('<div class="alert alert-error">Please enter contact number</div>');
	}
	else
	{
		home = $('#up_home_url').val();
		$.ajax({
			type: "POST",
			dataType : 'json',
			url: home + "/wp-content/plugins/Telephone-Directory/update.php",
			data: { name:$('#update_name').val(), contact:$('#update_contact').val(), id:$('#update_id').val() },
			success:function(data)
			{		
				 if(data.success === true)
				 {
				 	$('#lbl_name_'+$('#update_id').val()).html($('#update_name').val());
				 	$('#lbl_contact_'+$('#update_id').val()).html($('#update_contact').val());
				 	$('#myModal').modal('hide');
				 	
				 	window.location.reload(true);
				 	
				 }
				 else
				 {
				 	$('#update_msg').append('<div class="alert alert-error">'+ data.Message +'</div>');
				 }  
			}
		});
	}
	return false;
}
