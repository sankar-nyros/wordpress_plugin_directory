
$(document).ready(function(){

	$('#contact').bind("paste",function(e) {
          e.preventDefault();
    });
	
	

 
    // DataTable
    var table = $('#myTable').DataTable();
 	
 	
 	$("#myTable tfoot th").each( function ( i ) {
		name= this.innerHTML;
 		if(i == 1 || i == 3)
 		{	
		    var select = $('<select style="width:80%;margin-left:-80px;"><option value="">-select '+ name+' -</option></select>')
		        .appendTo( $(this).empty() )
		        .on( 'change', function () {
		            var val = $(this).val();
	 
		            table.column( i )
		                .search( val ? '^'+$(this).val()+'$' : val, true, false )
		                .draw();
		        } );
	 
		    table.column( i ).data().unique().sort().each( function ( d, j ) {
		        select.append( '<option value="'+d+'">'+d+'</option>' )
		    });
        }
    });


	$('#btn_save').click(function(){

		$('#msg').html('');
		if($('#name').val().trim().length == 0)
		{
			$('#msg').append('<div class="alert alert-error">Please enter name.</div>');
		}
		else if($('#contact').val().length == 0)
		{
			$('#msg').append('<div class="alert alert-error">Please enter contact number</div>');
		}
		else
		{
			home = $('#home_url').val();
			$.ajax({
				type: "POST",
				dataType : 'json',
				url: home+ "/wp-content/plugins/Telephone-Directory/contacts.php",
				data: { name:$('#name').val(), contact:$('#contact').val(), id:'<?= get_current_user_id();?>' },
				success:function(data)
				{		
					
					 if(data.success === true)
					 {
					 	//$('#msg').append('<div class="alert alert-success">'+ data.Message +'</div>');
					 	window.location.reload(true);
					 }
					 else
					 {
					 	$('#msg').append('<div class="alert alert-error">'+ data.Message +'</div>');
					 }  
				}
			});
		}
	});
	
	$('.numonly').keypress(function(evt){
	var charCode = (evt.which) ? evt.which : event.keyCode
	if (charCode > 31 && (charCode < 48 || charCode > 57))
		return false;
	return true;

});





$(document).on("click", ".edit", function () {
	 $('#update_msg').html('');
     $(".modal-body #update_name").val( $(this).data('name') );
     $(".modal-body #update_id").val( $(this).data('id') );
     $(".modal-body #update_contact").val( $(this).data('contact') );
});


$('.btn_update').click(function(e){

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
				 	/*
					 	$('#tr_'+$('#update_id').val()).addClass('invalid');
					 	
					 	setTimeout(function() {
							$('#tr_'+$('#update_id').val()).removeClass('invalid')
						}, 4000);
					 	
					 	$('#update_msg').append('<div class="alert alert-success">'+ data.Message +'</div>');
				 	*/
				 }
				 else
				 {
				 	$('#update_msg').append('<div class="alert alert-error">'+ data.Message +'</div>');
				 }  
			}
		});
	}
	return false;
});

	
});

function removes(id,name)
{
	msg = 'Are you sure to delete \"'+ name +'\".?';
	home = $('#up_home_url').val();

	if (confirm(msg)) { 
		 
    			$.ajax({
					type: "POST",
					dataType : 'json',
					url: home + "/wp-content/plugins/Telephone-Directory/delete.php",
					data: { id:id },
					success:function(data)
					{		
						if(data == 1)
						{
							
							$('.row_'+id).hide('slow');	
						}
					}
				});
			}
}

function deletes(id,name)
{
	//id = $(this).attr('id');
	//name = $(this).attr('name');
	$.confirm({
			text: "Are you sure you want to delete <b>"+ name +"</b> ..?",
			title: "Delete confirmation",
			confirmButton: "Delete",
    		cancelButton: "No",
    		confirmButtonClass: "btn-danger",
    		cancelButtonClass : "btn-inverse",
    		confirm: function(button) {
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
							window.location.reload(true);
							//$('#tr_'+id).hide('slow');	
						}
					}
				});
			},
			cancel: function(button) {},
		});
}

function edit(id)
{
	$('.span_name_'+id).addClass('hid').removeClass('shw');		
	$('.span_contact_'+id).addClass('hid').removeClass('shw');		
	$('.txt_name_'+id).addClass('shw').removeClass('hid');
	$('.txt_contact_'+id).addClass('shw').removeClass('hid');
	//$('.e_'+id).addClass('hid').removeClass('shw');
	//$('.d_'+id).addClass('hid').removeClass('shw');
	//$('.s_'+id).addClass('shw').removeClass('hid');
	$('.ee_'+id).addClass('hid').removeClass('shw');
	$('.cc_'+id).addClass('shw').removeClass('hid');
}


function cancel(id)
{
	$('.span_name_'+id).addClass('shw').removeClass('hid');		
	$('.span_contact_'+id).addClass('shw').removeClass('hid');		
	$('.txt_name_'+id).addClass('hid').removeClass('shw');
	$('.txt_contact_'+id).addClass('hid').removeClass('shw');
//	$('.e_'+id).addClass('shw').removeClass('hid');
//	$('.s_'+id).addClass('hid').removeClass('shw');
//	$('.c_'+id).addClass('hid').removeClass('shw');
//	$('.d_'+id).addClass('shw').removeClass('hid');
	$('.ee_'+id).addClass('shw').removeClass('hid');
	$('.cc_'+id).addClass('hid').removeClass('shw');


}


function save(id)
{
	home = $('#up_home_url').val();

		$.ajax({
			type: "POST",
			dataType : 'json',
			url: home + "/wp-content/plugins/Telephone-Directory/update.php",
			data: { name:$('.update_n_'+id).val(), contact:$('.update_c_'+id).val(), id:id },
			success:function(data)
			{		
				 if(data.success === true)
				 {
				 	$('.span_name_'+id).html($('.update_n_'+id).val());
				 	$('.span_contact_'+id).html($('.update_c_'+id).val());
				 	
					cancel(id);
				 	//window.location.reload(true);
				 	
				 }
				 else
				 {
				 	$('#update_msg').append('<div class="alert alert-error">'+ data.Message +'</div>');
				 }  
			}
		});
}

