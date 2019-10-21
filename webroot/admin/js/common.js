var url  = siteUrl;
$(document).ready(function(){

	var country_id = $('#country-id').val();
	var state_id = $('#state-id').val();
	var city_id = $('#city-id').val();

	if(country_id && !state_id)
	{
		getstates(country_id);
	}
	if(state_id && !city_id)
	{
		getcities(state_id);
	}
	$('#country-id').change(function(){
		var country_id = $(this).val();
		getstates(country_id);
	});
	$('#state-id').change(function(){
		var country_id = $(this).val();
		getcities(country_id);
	});




function  getstates(country_id = null)
{
	if(country_id)
	{
		var sel = "<option value=''> Select State </option>";
		$('#state-id').html(sel);
		$.get(url+'common/getStates/'+country_id,function(result){
			var jsondata = $.parseJSON(result);
			$.each(jsondata,function(k,v){
				var opt = "<option value='"+k+"'>"+v+"</option>"
				$('#state-id').append(opt);
			});
		});
		
	}
}

function  getcities(state_id = null)
{
	if(state_id)
	{
		var sel = "<option value=''> Select City </option>";
		$('#city-id').html(sel);
		$.get(url+'common/getCities/'+state_id,function(result){

			var jsondata = $.parseJSON(result);
			$.each(jsondata,function(k,v){
				var opt = "<option value='"+k+"'>"+v+"</option>"
				$('#city-id').append(opt);
			});
		});
		
	}
}

});
