$(document).ready(function(){
	var url = "/stop/";
	$("#demosMenu").change(function(){
	  window.location.href = $(this).find("option:selected").attr("id") + '.html';
	});

	$('#contactsubmit').click(function(){
		$('.contacterr').remove();
		var form = $('#contact').serialize();
		$.ajax({
			type:'post',
			url: url+'pages/contactajax/',
			data: form,
			success:function(response){
				
				var err = $.parseJSON(response);
				if(err.status == 'success')
				{
					alert('Thanks for contacting us .');
					$('#contact')[0].reset();
				}
				else if(err.status == 'error')
				{
					var jsonerr = $.parseJSON(err.errors);
					$.each(jsonerr,function(key,val){
						
						$('#'+val.id).after('<span class="error contacterr"> '+val.message+'</span>');
					});
				}
			}
		});
	});
});