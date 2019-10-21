$(document).ready(function(){
	var url = "/vestotus/";
$('.courseselection').click(function(){
	$('.insarea').hide();
	$('.olarea').hide();
	var getid = $(this).attr('id');
	var getval = $(this).val();
	$('.courseselection').each(function(){
		var getval1 = $(this).val();
		if(getval !== getval1)
		{
			$(this).removeAttr('checked');
		}
	});
	if($(this).is(":checked")==true)
	{
		if(getid == 1)
		{
			$('.olarea').fadeIn();
			$sessionlink = url+'enrollments/courses/'+getval;
			$('.olarea .enrollments').attr('href',$sessionlink);
			$('.olarea a').attr('id',getval);
		}
		else if(getid == 2)
		{
			$('.insarea').fadeIn();
			$sessionlink = url+'sessions/index/'+getval;
			$gradeslink = url+'courses/manage/attendence/'+getval;
			$('.manage_sessions').attr('href',$sessionlink);
			$('.attendences').attr('href',$gradeslink);
		}
	}
	else
	{
		$('.olarea').fadeOut();
		$('.insarea').fadeOut();
	}

});

$('.checkselection').click(function(){
	$('.olarea').hide();
	var geturl = $(this).attr('id');
	var getval = $(this).val();
	$('.checkselection').each(function(){
		var getval1 = $(this).val();
		if(getval !== getval1)
		{
			$(this).removeAttr('checked');
		}
	});
	if($(this).is(":checked")==true)
	{
		$('.olarea').fadeIn();
		$('#mark_att').attr('href',url+'attendences/mark_attendence/'+geturl);
		$('#grades').attr('href',url+'attendences/grades/'+geturl);
	}
	else
	{
		$('.olarea').fadeOut();
		
	}

});

$(document).on('submit','#cform',function(){
	var getform = $(this).serialize();
	console.log(getform);
	$.post(url+'users/contactusform/',getform,function(response	){
		console.log(response);
		var response = $.parseJSON(response);
		if(response.status == "success")
		{
			$('#cform #name').val('');$('#cform #phone').val('');$('#cform textarea').val('');
			$('#cform .success').hide().show('slow').delay(2000).hide('slow');
		}
		else
		{
			$('.error').html(response.message);
			$('#cform .error').hide().show('slow').delay(5000).hide('slow');
		}
	});

	return false;
});


});