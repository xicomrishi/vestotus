var url  = siteUrl;
$(document).ready(function(){
	
	$('#country-id').change(function(){
		var country = $(this).val();
		var data = {
			'table': 'States',
			'conditions':{'country_id':country}
       	};

		$.post(url+'pages/getAjax/',data,function(response){
			//console.log(response);
			var response = $.parseJSON(response);
			var states = '<option value="">Select State</option>';
			$.each(response.data,function(i,val){
				states += '<option value="'+val.id+'">'+val.name+'</option>';
			});

			$('#state-id').html(states);
		});
	});

	$('#state-id').change(function(){
		var state_id = $(this).val();
		var data = {
			'table': 'Cities',
			'conditions':{'state_id':state_id}
       	};
		       
		$.post(url+'pages/getAjax/',data,function(response){
			//console.log(response);
			var response = $.parseJSON(response);
			var states = '<option value="">Select City</option>';
			$.each(response.data,function(i,val){
				states += '<option value="'+val.id+'">'+val.name+'</option>';
			});

			$('#city-id').html(states);
		});
	});

	$('.start_quiz_btn').click(function(){
		var course_id = $('#course_id').val();
		var data = {'course_id' : course_id };
		$.post(url+'quiz/testStart/',data,function(response){
				console.log(response);
		});
		var limit = $('#time_limit').val();
		getnextquestion();
		if(limit > 0)
		{
			timedCount();
		}

	});


	var c = $('#time_limit').val();
    var t;
    function timedCount()
    {
        var hours = parseInt( c / 3600 ) % 24;
        var minutes = parseInt( c / 60 ) % 60;
        var seconds = c % 60;
        var result = (hours < 10 ? "0" + hours : hours) + ":" + (minutes < 10 ? "0" + minutes : minutes) + ":" + (seconds  < 10 ? "0" + seconds : seconds);

        $('#timer').html(result);
        if(c == 0 )
        {
    		var cid = $('#course_id').val();
			var data = {'course_id': cid};
			$.post(url+'lessons/testsubmit/',data,function(response){
				var result = $.parseJSON(response);
				if(result.status=='success')
				{
					window.location.href = url+"lessons/quizresult/"+result.course_id;
				}
			});
        }
        c = c - 1;
        t = setTimeout(function()
        {
         timedCount()
        },
        1000);
    }	
});

	
	function getnextquestion()
	{
		var cid = $('#course_id').val();
		var lid = $('#lesson_id').val();
		var data = {'course_id':cid,'lesson_id':lid};
		$.post(url+'lessons/assessmentstart/',data,function(response){
				console.log(response);
				$('.quizouterdiv').html(response);
			
		});
	}

	function gotonext(id = null)
	{
		//console.log(id);
		//return false;
		var data = $('#quizform').serialize();
		//console.log(data);
		$.post(url+'lessons/saveQuiz/',data,function(response){
			console.log(response);
			var result = $.parseJSON(response);
			if(result.status==2)
			{
				$('.quizerror').html(result.msg);
			}
			else if(result.status==1)
			{
				var cid = $('#course_id').val();
				var lid = $('#lesson_id').val();
				var data = {'course_id':cid,'lesson_id':lid,'id':id};
				$.post(url+'lessons/assessmentstart/',data,function(response){
				console.log(response);
				$('.quizouterdiv').html(response);
			
		});
			}
		});
	}

	function gotoprev(id = null)
	{
		//console.log(id);
		var cid = $('#course_id').val();
		var lid = $('#lesson_id').val();
		var data = {'course_id':cid,'lesson_id':lid,'id':id};
		$.post(url+'lessons/assessmentstart/',data,function(response){
		//console.log(response);
		$('.quizouterdiv').html(response);
			
		});
	}

	function testsubmit(testid=null)
	{
		var data = $('#quizform').serialize();
		$.post(url+'lessons/saveQuiz/',data,function(response){
			console.log(response);
			var result = $.parseJSON(response);
			if(result.status==2)
			{
				$('.quizerror').html(result.msg);
			}
			else if(result.status==1)
			{
				var cid = $('#course_id').val();
				var data = {'testid': testid,'course_id': cid};
				$.post(url+'lessons/testsubmit/',data,function(response){
					var result = $.parseJSON(response);
					if(result.status=='success')
					{
						window.location.href = url+"lessons/quizresult/"+result.course_id;
					}
					//console.log(response);
					//$('.quizouterdiv').html(response);

				});
			}
		});
	}
	//No time limit
	function getnextquestion1()
	{
		var cid = $('#course_id').val();
		var lid = $('#lesson_id').val();
		
		var data = {'course_id':cid,'lesson_id':lid};
		$.post(url+'quiz/question/',data,function(response){
			console.log(response);
				$('.quizouterdiv').html(response);
			
		});
	}

	function gotonext1(id = null)
	{
		var data = $('#quizform').serialize();
		$.post(url+'quiz/saveQuiz/',data,function(response){
			var result = $.parseJSON(response);
			if(result.status==2)
			{
				$('.quizerror').html(result.msg);
			}
			else if(result.status==1)
			{
				var cid = $('#course_id').val();
				var lid = $('#lesson_id').val();
				var data = {'course_id':cid,'lesson_id':lid,'id':id};
				$.post(url+'quiz/question/',data,function(response){
				$('.quizouterdiv').html(response);
			
		});
			}
		});
	}

	function gotoprev1(id = null)
	{
		//console.log(id);
		var cid = $('#course_id').val();
		var lid = $('#lesson_id').val();
		var data = {'course_id':cid,'lesson_id':lid,'id':id};
		$.post(url+'quiz/question/',data,function(response){
		//console.log(response);
		$('.quizouterdiv').html(response);
			
		});
	}

	function testsubmit1(testid=null)
	{
		var data = $('#quizform').serialize();
		$.post(url+'quiz/saveQuiz/',data,function(response){
			console.log(response);
			var result = $.parseJSON(response);
			if(result.status==2)
			{
				$('.quizerror').html(result.msg);
			}
			else if(result.status==1)
			{
				var cid = $('#course_id').val();
				var data = {'testid': testid,'course_id': cid};
				$.post(url+'lessons/testsubmit/',data,function(response){
					var result = $.parseJSON(response);
					if(result.status=='success')
					{
						window.location.href = url+"lessons/quizresult/"+result.course_id;
					}
					

				});
			}
		});
	}