$('#chapter_type_button').ready(function(){
	var url = '/vestotus/';
	$(document).on('click','#sessionModel ul.nav li a',function(){
        var getattr = $(this).attr('href');
        var getid = getattr.replace('#','');
        $('#sessionModel .tab-pane').hide();
        $('#sessionModel #'+getid).fadeIn();
    });
$(document).on('submit','#sessionform',function(){
    var formdata = new FormData($(this)[0]);
    $('label.error').remove();
    $.ajax({
        type:'post',
        url:url+'courses/sessionadd/',
        data: formdata, 
        contentType: false,       
        cache: false,             
        processData:false, 
        success:function(response)
        {
            //console.log(response);

            var response = $.parseJSON(response);
            if(response.record && response.record == "new")
            {
                content = '<tr id="tr_'+response.session_id+'" class="ui-sortable-handle"><td><a href="#">'+response.title+'</a></td><td class="actions"><a href="javascript:void(0);" class="delete delete_chapter" onclick="edit_session(hashid)"> <i class="fa fa-edit" aria-hidden="true"></i> </a><a href="javascript:void(0);" class="delete delete_chapter" onclick="delete_session('+response.session_id+')"> <i class="fa fa-trash-o" aria-hidden="true"></i> </a></td></tr>';
                 var content = content.replace(/hashid/g,"'"+response.hashid+"'");
                 $('#chapterstbl').append(content);
                 $('#chapterstbl tr#nosession').remove();
            }   
            if(response.data)
            {
                //console.log(response.data);
                $('#session2 #start-date').val('');
                $('#session2 #end-date').val('');
                $('#session2 #start-time').val('');
                $('#session2 #end-time').val('');
                $('#session2 #duration').val('');
                $('#session2 #venue-id').val('');
                var content = "<tr id='class_"+response.data.class_id+"'><td>"+response.data.start_date+" - "+response.data.end_date+"</td><td>("+response.data.duration+")</td><td> <a href='javascript:void(0)' onclick='del_class("+response.data.class_id+")'><i class='fa fa-trash'> </i></a></td></tr>"
                $('.classesdiv').append(content);
            }
            if(response.session_id)
            {
                $('#session_id').val(response.session_id);
            }
            if(response.status == 'error')
            {
                $.each(response.error,function(key,val){
                    if(key == 'session_id')
                    {
                        $('#sessionModel  li:nth-child(1) a').trigger('click');
                    }
                    $('input[name="'+key+'"]').after('<label class="error">'+val+'</label>');
                    $('textarea[name="'+key+'"]').after('<label class="error">'+val+'</label>');
                    $('select[name="'+key+'"]').after('<label class="error">'+val+'</label>');
                });
            }
            else if(response.status=='success')
            {
                 $('.modal .tab-pane').hide();
                 $('.modal .nav-tabs li').removeClass('active');
                 $('.modal li:nth-child(2)').addClass('active');
                 $('.modal #session2').show();
            }
        }
    });
    //console.log(formdata);
    return false;
});
$('#olcourse').on('submit',function(){
    var formdata = new FormData($(this)[0]);
    $('label.error').remove();
    $.ajax({
        type:'post',
        url:url+'courses/ajaxolcourse/',
        data: formdata, 
        contentType: false,       
        cache: false,             
        processData:false, 
        success:function(response)
        {
            console.log(response);
            var response = $.parseJSON(response);
            if(response.status == 'error')
            {
                $.each(response.error,function(key,val){
                    $('input[name="'+key+'"]').after('<label class="error">'+val+'</label>');
                    $('textarea[name="'+key+'"]').after('<label class="error">'+val+'</label>');
                    $('select[name="'+key+'"]').after('<label class="error">'+val+'</label>');
                });
            }
            else if(response.status=='success')
            {
                 //$('#tab2').tabs('select', 2);
                 $('.tab-pane').hide();
                 $('.nav-tabs li').removeClass('active');
                 $('li:nth-child(2)').addClass('active');
                 $('#syllabus').show();
                 

                //$('#tab2').trigger('click');
            }
        }
    });
    //console.log(formdata);
    return false;
});

$('#olcourse2').on('submit',function(){
    var formdata = new FormData($(this)[0]);
    $('label.error').remove();
    $.ajax({
        type:'post',
        url:url+'courses/ajaxolcourse/',
        data: formdata, 
        contentType: false,       
        cache: false,             
        processData:false, 
        success:function(response)
        {
            console.log(response);
            // return false;
            var response = $.parseJSON(response);
            if(response.status == 'error')
            {
                $.each(response.error,function(key,val){
                    $('input[name="'+key+'"]').after('<label class="error">'+val+'</label>');
                    $('textarea[name="'+key+'"]').after('<label class="error">'+val+'</label>');
                    $('select[name="'+key+'"]').after('<label class="error">'+val+'</label>');
                });
            }
            else if(response.status=='success')
            {
                 $('.tab-pane').hide();
                 $('.nav-tabs li').removeClass('active');
                 $('li:nth-child(3)').addClass('active');
                 $('#availability').show();
                //$('#tab2').trigger('click');
            }
        }
    });
    //console.log(formdata);
    return false;
});

$('#olcourse3').on('submit',function(){
    var formdata = new FormData($(this)[0]);
    $('label.error').remove();
    $.ajax({
        type:'post',
        url:url+'courses/ajaxolcourse/',
        data: formdata, 
        contentType: false,       
        cache: false,             
        processData:false, 
        success:function(response)
        {
            var response = $.parseJSON(response);
            if(response.status == 'error')
            {
                $.each(response.error,function(key,val){
                    $('input[name="'+key+'"]').after('<label class="error">'+val+'</label>');
                    $('textarea[name="'+key+'"]').after('<label class="error">'+val+'</label>');
                    $('select[name="'+key+'"]').after('<label class="error">'+val+'</label>');
                });
            }
            else if(response.status=='success')
            {
                 $('.tab-pane').hide();
                 $('.nav-tabs li').removeClass('active');
                 $('li:nth-child(4)').addClass('active');
                 $('#competetion').show();
                 $('#tab4').trigger('click');
            }
        }
    });
    //console.log(formdata);
    return false;
});

$(document).on('submit','#assessmentedit',function(){

    var formdata = new FormData($(this)[0]);
    $('#assessmentedit .error').remove();
    $.ajax({
        type:'post',
        url:url+'courses/addChapter/',
        data: formdata, 
        contentType: false,       
        cache: false,             
        processData:false, 
        success:function(response)
        {
            console.log(response);
            var response = $.parseJSON(response);
            if(response.status=='error')
            {
            $.each(response.error,function(key,val){
                    $('#assessmentedit #'+key).after('<label class="error">'+val+'</label>');
                });
            }
            else if(response.status=='success')
            {
                var content = '<li id="liass_'+response.ass_id+'"><label>'+response.data.question+'</label><a href="javascript:void(0);" onclick="del_assessment('+response.ass_id+');"><i class="fa fa-trash"> </i></a></li>';
             //var content = "<li>Question: "+response.data.question+" <a href='javascript:void(0);' onclick='delete_questions'><i class='fa fa-cross'> </i> </a></li>";
             $('.add_assessments').append(content);
             $('#assessmentbasic').hide();
             $('#assessmentedit #question').val('');
             $('#assessmentedit #answer').val('');
             $('#assessmentedit input[name="options[]"]').val('');
             $('#assessmentedit textarea').val('');
             if(response.data.title !=='')
             {
                if($('#chapterstbl tr.assesmenttr').length > 0)
                {
                    $('#chapterstbl tr.assesmenttr td:nth-child(1)').html(response.data.title);
                }
                else
                {
                    var rowno = $('#chapterstbl tr').length;
                      rowno = parseInt(rowno) + 1;
                      var content = '<tr id="tr_'+response.id+'" class="assesmenttr"><td><a href="#">'+response.data.title+'</a></td><td class="actions"><a href="javascript:void(0);" class="delete delete_chapter" onclick="delete_chapter('+response.id+')"> <i class="fa fa-trash-o" aria-hidden="true"></i> </a></td></tr>';
                      $('#chapterstbl').append(content);
                }
             }
            }

        }
    });

    return false;
});
$('#olcourse4').on('submit',function(){
    var formdata = new FormData($(this)[0]);
    $('label.error').remove();
    $.ajax({
        type:'post',
        url:url+'courses/ajaxolcourse/',
        data: formdata, 
        contentType: false,       
        cache: false,             
        processData:false, 
        success:function(response)
        {
            console.log(response);
            var response = $.parseJSON(response);
            if(response.status == 'error')
            {
                $.each(response.error,function(key,val){
                    $('input[name="'+key+'"]').after('<label class="error">'+val+'</label>');
                    $('textarea[name="'+key+'"]').after('<label class="error">'+val+'</label>');
                    $('select[name="'+key+'"]').after('<label class="error">'+val+'</label>');
                });
            }
            else if(response.status=='success')
            {
                 $('.tab-pane').hide();
                 $('.nav-tabs li').removeClass('active');
                 $('li:nth-child(5)').addClass('active');
                 $('#messages').show();
            }
        }
    });
    //console.log(formdata);
    return false;
});

$('#olcourse5').on('submit',function(){
    var formdata = new FormData($(this)[0]);
    $('label.error').remove();
    $.ajax({
        type:'post',
        url:url+'courses/ajaxolcourse/',
        data: formdata, 
        contentType: false,       
        cache: false,             
        processData:false, 
        success:function(response)
        {
            console.log(response);
            //return false;
            var response = $.parseJSON(response);
            if(response.status == 'error')
            {
                $.each(response.error,function(key,val){
                    $('input[name="'+key+'"]').after('<label class="error">'+val+'</label>');
                    $('textarea[name="'+key+'"]').after('<label class="error">'+val+'</label>');
                    $('select[name="'+key+'"]').after('<label class="error">'+val+'</label>');
                });
            }
            else if(response.status=='success')
            {
                 $('.tab-pane').hide();
                 $('.nav-tabs li').removeClass('active');
                 $('li:nth-child(6)').addClass('active');
                 $('#resources').show();
            }
        }
    });
    //console.log(formdata);
    return false;
});

$('#olcourse6').on('submit',function(){
    var formdata = new FormData($(this)[0]);
    $('label.error').remove();
    $.ajax({
        type:'post',
        url:url+'courses/ajaxolcourse/',
        data: formdata, 
        contentType: false,       
        cache: false,             
        processData:false, 
        success:function(response)
        {
            console.log(response);
            var response = $.parseJSON(response);
            if(response.status == 'error')
            {
                $.each(response.error,function(key,val){
                    $('input[name="'+key+'"]').after('<label class="error">'+val+'</label>');
                    $('textarea[name="'+key+'"]').after('<label class="error">'+val+'</label>');
                    $('select[name="'+key+'"]').after('<label class="error">'+val+'</label>');
                });
            }
            else if(response.status=='success')
            {
                var content = response.content;
                $('.rsdiv').append(content);
                $('#resource-name').val('');
                $('input[name="resource_file"]').val('');
            }
        }
    });
    //console.log(formdata);
    return false;
});


$('#nextavailability').on('click',function(){
    //$('#tab3').trigger('click');
     $('.tab-pane').hide();
     $('.nav-tabs li').removeClass('active');
     $('li:nth-child(3)').addClass('active');
     $('#availability').show();
});

$('.backchaptertype').on('click',function()
{
    $('.modal').modal('hide');
    $('#myModal').modal('show');

});

$('#enable_ecommerce').click(function(){
    if($(this).is(':checked')==true)
    {
        $('#ecommerce_innersection').fadeIn();
    }
    else
    {
        $('#ecommerce_innersection').fadeOut();
    }
});
$('#email_notify').click(function(){
    if($(this).is(':checked')==true)
    {
        $('#notificationinner').fadeIn();
    }
    else
    {
        $('#notificationinner').fadeOut();
    }
});
$('#completion_email_custom').click(function(){
    if($(this).is(':checked')==true)
    {
        $('#completion_email_custom_inner').fadeIn();
    }
    else
    {
        $('#completion_email_custom_inner').fadeOut();
    }
});
$('#enrollment_email_custom').click(function(){
    if($(this).is(':checked')==true)
    {
        $('#enrollment_email_custom_inner').fadeIn();
    }
    else
    {
        $('#enrollment_email_custom_inner').fadeOut();
    }
});
$('#enrollment_email').click(function(){
    if($(this).is(':checked')==true)
    {
        $('#enrollment_email_inner').fadeIn();
    }
    else
    {
        $('#enrollment_email_inner').fadeOut();
    }
});
$('#completion_email').click(function(){
    if($(this).is(':checked')==true)
    {
        $('#completion_email_inner').fadeIn();
    }
    else
    {
        $('#completion_email_inner').fadeOut();
    }
});
$('#allow_reenrollment').click(function(){
    if($(this).is(':checked')==true)
    {
        $('#reenrollment_inner').fadeIn();
    }
    else
    {
        $('#reenrollment_inner').fadeOut();
    }
});

$('#automatic_enrollment').click(function(){
    if($(this).is(':checked')==true)
    {
        $('#enrollment_inner').fadeIn();
    }
    else
    {
        $('#enrollment_inner').fadeOut();
    }
});

$('#receive_certificate').click(function(){
    if($(this).is(':checked')==true)
    {
        $('#collapse11').removeClass('collapse');
        $('#collapse11').addClass('expand');
    }
    else
    {
        $('#collapse11').addClass('collapse');
        $('#collapse11').removeClass('expand');
    }
});

$('#add_rule').on('click',function(){
    var addnewrule = '<li id="rulediv_lastid"><div class="form-group inner-box" ><select name="EnrollRules[fields][]" class="form-control" id="enrollrules-fields"><option value="firstname">First Name</option><option value="lastname">Last Name</option><option value="fullname">Full Name</option><option value="username">Username</option><option value="department">Department</option><option value="group">Group</option><option value="location">Location</option><option value="email">Email Address</option></select><select name="EnrollRules[rules][]" class="form-control" id="enrollrules-rules"><option value="starts">Starts With</option><option value="contains">Contains</option><option value="equals">Equals</option><option value="ends">Ends With</option></select><input type="text" name="EnrollRules[value][]" class="form-control" placeholder="Value" id="enrollrules-value"><a href="javascript:void(0);" id="rule_lastid" class="delete_rule delete-btn" onclick="del_li(lastid);"> <i class="fa fa-trash-o" aria-hidden="true"></i> </a></div></li>';
    var getlast = $('.all_rules li:last').attr('id');
    getlast = getlast.split('_');
    getlast = parseInt(getlast[1]) + parseInt(1);
    var content = addnewrule.replace(/lastid/g, getlast);
    //console.log(content);
    $('.all_rules').append(content);
});

$('#laststepcontinue').on('click',function(){
    //$('#tab7').trigger('click');
     $('.tab-pane').hide();
     $('.nav-tabs li').removeClass('active');
     $('li:nth-child(7)').addClass('active');
     $('#complete').show();
});

$('.previous_button').on('click',function(){
    getid = $(this).attr('id');
    if(getid=='back1')
    {
     $('.tab-pane').hide();
     $('.nav-tabs li').removeClass('active');
     $('li:nth-child(1)').addClass('active');
     $('#general').show();
    }
    if(getid=='back2')
    {
     $('.tab-pane').hide();
     $('.nav-tabs li').removeClass('active');
     $('li:nth-child(2)').addClass('active');
     $('#syllabus').show();
    }
    if(getid=='back3')
    {
     $('.tab-pane').hide();
     $('.nav-tabs li').removeClass('active');
     $('li:nth-child(3)').addClass('active');
     $('#availability').show();
    }
    if(getid=='back4')
    {
     $('.tab-pane').hide();
     $('.nav-tabs li').removeClass('active');
     $('li:nth-child(4)').addClass('active');
     $('#competetion').show();
    }
    if(getid=='back5')
    {
     $('.tab-pane').hide();
     $('.nav-tabs li').removeClass('active');
     $('li:nth-child(5)').addClass('active');
     $('#messages').show();
    }
    if(getid=='back6')
    {
     $('.tab-pane').hide();
     $('.nav-tabs li').removeClass('active');
     $('li:nth-child(6)').addClass('active');
     $('#resources').show();
    }
});

$('.add_question').on('click',function(){
    var getlastdiv = $('.assessments_div:last').attr('id');
    var getid = getlastdiv.split('_');
    getid = parseInt(getid[1]) + 1;
    var content = '<div id="assessment_lastid" class="assessments_div"><div class="form-group"><label for="question">Question</label><input type="text" name="question[lastid][]" placeholder="Question" class="form-control" id="question"></div><div class="form-group optionsdiv"><a href="javascript:void(0);" onclick="add_options_link(lastid)" ><i class="fa fa-plus"> </i>  Add Option</a><input type="text" name="options[lastid][]" placeholder="Options" class="form-control" id="lastid_1"><input type="text" name="options[lastid][]" placeholder="Options" class="form-control" id="lastid_2"><input type="text" name="options[lastid][]" placeholder="Options" class="form-control" id="lastid_3"><input type="text" name="options[lastid][]" placeholder="Options" class="form-control" id="lastid_4"></div></div><div class="form-group correctdiv"><label for="answer1">Answer</label><input type="text" name="answer[lastid][]" placeholder="Answer" class="form-control" id="answerlastid"></div>';
    var content = content.replace(/lastid/g, getid);
    
    $('#'+getlastdiv).after(content);
});


});

function add_options_link(getid)
{
    var getlastid = $('#assessment_'+getid+' .form-group  input:last').attr('id');
    getlastid = getlastid.split('_');
    getlastid = parseInt(getlastid[1])+1;
    $('#assessment_'+getid+' .optionsmaindiv ').append('<div class="optionsdiv"><input type="text" name="options[]" placeholder="Options" class="form-control options" id="'+getid+'_'+getlastid+'"><a href="javascript:void(0);" onclick="del_option('+getid+','+getlastid+')"><i class="fa fa-trash"> </i></a></div>');
}
function del_li(val)
{
    $('ul.all_rules li#rulediv_'+val).remove();
}
function del_option(id,id2)
{
    $('#'+id+'_'+id2).next('a').remove();
    $('#'+id+'_'+id2).remove();
}
function del_li_db(val)
{
    var url = '/vestotus/';
    $.get(url+'courses/del_enrollrule/'+val,function(response){
        if(response=='success')
        {
            $('ul.all_rules li#rulediv_'+val).remove();
        }
    });
}
var url = '/vestotus/';
function del_resource(val,db=0)
{
    var url = '/vestotus/';
    //alert('delete-'+val+'-'+db);
    
    $.get(url+'courses/del_resource/'+val,function(response){
        if(response=='success')
        {
            $('#resourcediv_'+val).remove();
        }
        else
        {
            alert('Error! Please try again');
        }
    });
}

function finalstep(val)
{
    
    if(val==1)
    {
    $.get(url+'courses/activateCourse/',function(response){
        if(response=='success')
        {
            window.location.href = url+"courses/";
        }
        else
        {
            
        }
    });
    }
    else if(val==0);
    {
        window.location.href = url+"courses/";
    }   
}


function delete_chapter(id=null)
{
    $.post(url+'courses/delChapter',{'id' : id},function(response){
       // console.log(response);
       if(response=='success')
       {
        $('tr#tr_'+id).remove();
       }
    });
}

function edit_chapter(id=null,type=null)
{
    console.log(type);
    if(type=='assessment')
    {
        $.get(url+'lessons/assessmentedit/'+id,function(response){
            $('#edit-video .modal-content').html(response);
            $('#edit-video').modal('show');
        });
    }
    else if(type=='video')
    {
        $.get(url+'lessons/videoedit/'+id,function(response){
            $('#edit-video .modal-content').html(response);
            $('#edit-video').modal('show');
        });
    }
    else if(type=='audio')
    {
        $.get(url+'lessons/audioedit/'+id,function(response){
            $('#edit-audio .modal-content').html(response);
            $('#edit-audio').modal('show');
        });
    }
    else if(type=='ppt')
    {
         $.get(url+'lessons/pptedit/'+id,function(response){
            $('#edit-ppt .modal-content').html(response);
            $('#edit-ppt').modal('show');
        });
    }
}

function del_course_file(id)
{
    $.get(url+'lessons/del_file/'+id,function(response){
        if(response=='success')
        {
            $('#li_'+id).remove();
        }

    });
 

}

function getFormData($form){
    var unindexed_array = $form.serializeArray();
    var indexed_array = {};

    $.map(unindexed_array, function(n, i){
        indexed_array[n['name']] = n['value'];
    });

    return indexed_array;
}

function del_assessment(id=null)
{
    if(id)
    {
        $.get(url+'lessons/del_assessment/'+id,function(response){
           // console.log(response);
        if(response=='success')
        {
            //console.log('hi');
             $(document).find('.add_assessments #liass_'+id).remove();
            
        }

    });
    }
}

function saveorderchapters()
{
    var arr = [];
    $('#chapterstbl tbody tr').each(function(key,val){
        var getid = $(this).attr('id');
        getid = getid.split('_');
        getid = getid[1];
        arr.push(getid);
    });
    $.post(url+'lessons/reorder/',{'data':arr},function(){
        //console.log();
    });
}

function del_class(id=null)
{
    if(id)
    {
        $.post(url+'courses/delClass/',{'class_id':id },function(response){
            var response = $.parseJSON(response);
            if(response.status == "success")
            {
                $('tr#class_'+id).remove();
            }
            else
            {
                alert('Please try again!');
            }
        });
    }
}
function showsessionpopup()
{
    
     $('#sessionModel  li:nth-child(1) a').trigger('click');
      $('#sessionform')[0].reset();
      $('#sessionform table tr').remove();

}

function edit_session(id)
{
    $.get(url+'courses/editsessionpopup/'+id,function(response){
        console.log(response);
        $('#editsessionModel').html(response);
        $('#editsessionModel').modal('show');
    });
}

function delete_session(id)
{
    $.get(url+'courses/delSession/'+id,function(response){
       if(response=='success')
       {
        $('#chapterstbl tr#tr_'+id).remove();
       }
    }); 
}