var url = siteUrl + 'admin/';
$('#chapter_type_button').ready(function() {

    var options = {
        url: url + "common/fileupload",
        maxFiles: 6,
        addRemoveLinks: true,

        paramName: "file",
        maxFilesize: 30,
        acceptedFiles: ".jpeg,.jpg,.png,.gif,.mp4,.mp3",
        clickable: true,
        init: function() {
            var myDropZone = this;
            myDropZone.on('maxfilesexceeded', function(file) {
                myDropZone.removeFile(file);
            });
            this.on("success", function(file, responseText) {
                console.log(responseText);
                file.previewTemplate.setAttribute('id', responseText[0].id);
                if ($.trim(responseText) == "error") {
                    $('#hide').show();
                    $("#hide").removeClass('skip');
                    $("#imagecount").removeClass('btn btn-default nxt-bg');
                    $("#imagecount").prop('disabled', true);
                } else {
                    $('#hide').show();
                    $('#imagecount').show();
                    $("#imagecount").prop('disabled', false);
                    $("#imagecount").addClass('btn btn-default nxt-bg');
                    $("#hide").addClass('skip');
                }
            });
            this.on("thumbnail", function(file, done) {
                if (file.width < 350 || file.height < 200) {
                    file.rejectDimensions = function() { done("Image width or height should be greater than 350*200"); };
                } else {
                    file.acceptDimensions = done;
                }
            });
            this.on("canceled", function(file, responseText) {
                $('#hide').show();
                $("#hide").removeClass('skip');
                $("#imagecount").removeClass('btn btn-default nxt-bg');
                $("#imagecount").prop('disabled', true);
            });
        },
        removedfile: function(file) {
            var name = file.name;
            $.ajax({
                type: 'POST',
                url: url + 'listing/deleteListingImage/' + name,
                dataType: 'html'
            });
            var _ref;
            $('#hide').show();
            $("#hide").removeClass('skip');
            $("#imagecount").removeClass('btn btn-default nxt-bg');
            $("#imagecount").prop('disabled', true);
            return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0;
        },
        dictDefaultMessage: "Drop your files to upload"
    }



    $('#chapter_type_button').click(function() {
        var gettype = $('input[name="chapter_type"]:checked').val();

        if (gettype == 'video') {
            $('.modal').modal('hide');
            /*$.get(url+'courses/addChapter',function(data){
            $('#myModal-video .modal-body').html(data);
        });*/
            $('#myModal-video').modal('show');
        } else if (gettype == 'audio') {
            $('.modal').modal('hide');
            $('#myModal-audio').modal('show');
        } else if (gettype == 'ppt') {
            $('.modal').modal('hide');
            $('#myModal-ppt').modal('show');
        } else if (gettype == 'assessment') {
            $('.modal').modal('hide');
            $('#myModal-assessment').modal('show');
        }
    });

    $('#chapteraddform').on('submit', function() {
        var formdata = new FormData($(this)[0]);
        $.ajax({
            type: 'post',
            url: url + 'courses/addChapter/',
            data: formdata,
            contentType: false,
            cache: false,
            processData: false,
            success: function(response) { 
                // console.log(response);
                //return false;
                var response = $.parseJSON(response);
                if (response.status == 'error') {
                    $.each(response.error, function(key, val) {
                        $('#chapteraddform input[name="' + key + '"]').after('<label class="error">' + val + '</label>');
                        $('#chapteraddform textarea[name="' + key + '"]').after('<label class="error">' + val + '</label>');
                        $('#chapteraddform select[name="' + key + '"]').after('<label class="error">' + val + '</label>');
                    });
                }else if (response.status == 'course_error') { 
                        alert('Please save course general details first.');
                } else if (response.status == 'success') {
                    //$('.model').modal('hide');
                    var rowno = $('#chapterstbl tr').length;
                    rowno = parseInt(rowno) + 1;
                    var type = 'video';
                    var content = '<tr id="tr_' + response.id + '"><td><a href="#">' + response.title + '</a></td><td class="actions"><a href="javascript:void(0);" class="delete delete_chapter" onclick="edit_chapter(' + response.id + ',\'' + type + '\')"> <i class="fa fa-edit" aria-hidden="true"></i> </a><a href="javascript:void(0);" class="delete delete_chapter" onclick="delete_chapter(' + response.id + ')"> <i class="fa fa-trash-o" aria-hidden="true"></i> </a></td></tr>';
                    $('#chapterstbl').append(content);
                    $('.modal').modal('hide');
                }

            }
        });

        return false;
    });

    $(document).on('submit', '.chaptereditform', function() {

        var formdata = new FormData($(this)[0]);
        var datajson = $(this);
        var datajson = getFormData(datajson);
        $.ajax({
            type: 'post',
            url: url + 'courses/addChapter/',
            data: formdata,
            contentType: false,
            cache: false,
            processData: false,
            success: function(response) {
                // console.log(response);
                var response = $.parseJSON(response);
                if (response.status == 'error') {
                    $.each(response.error, function(key, val) {
                        $('#chapteraddform input[name="' + key + '"]').after('<label class="error">' + val + '</label>');
                        $('#chapteraddform textarea[name="' + key + '"]').after('<label class="error">' + val + '</label>');
                        $('#chapteraddform select[name="' + key + '"]').after('<label class="error">' + val + '</label>');
                    });
                } else if (response.status == 'success') {
                    var rowno = $('#chapterstbl tr').length;
                    rowno = parseInt(rowno) + 1;
                    var content = '<td><a href="#">' + response.title + '</a></td><td class="actions"><a href="javascript:void(0);" class="delete delete_chapter" onclick="edit_chapter(' + response.id + ',\'' + datajson.type + '\')"> <i class="fa fa-edit" aria-hidden="true"></i> </a><a href="javascript:void(0);" class="delete delete_chapter" onclick="delete_chapter(' + response.id + ')"> <i class="fa fa-trash-o" aria-hidden="true"></i> </a></td>';
                    $('#chapterstbl tr#tr_' + datajson.id).html(content);
                    $('.modal').modal('hide');
                }

            }
        });

        return false;
    });

    $('#chapteraddform2').on('submit', function() {
        var formdata = new FormData($(this)[0]);
        $.ajax({
            type: 'post',
            url: url + 'courses/addChapter/',
            data: formdata,
            contentType: false,
            cache: false,
            processData: false,
            success: function(response) {
                // console.log(response);
                var response = $.parseJSON(response);
                if (response.status == 'error') {
                    $.each(response.error, function(key, val) {
                        $('#chapteraddform2 input[name="' + key + '"]').after('<label class="error">' + val + '</label>');
                        $('#chapteraddform2 textarea[name="' + key + '"]').after('<label class="error">' + val + '</label>');
                        $('#chapteraddform2 select[name="' + key + '"]').after('<label class="error">' + val + '</label>');
                    });
                }else if (response.status == 'course_error') { 
                        alert('Please save course general details first.');
                } else if (response.status == 'success') {
                    var rowno = $('#chapterstbl tr').length;
                    rowno = parseInt(rowno) + 1;
                    var type = 'audio';
                    var content = '<tr id="tr_' + response.id + '"><td><a href="#">' + response.title + '</a></td><td class="actions"><a href="javascript:void(0);" class=" " onclick="edit_chapter(' + response.id + ',\'' + type + '\')"> <i class="fa fa-edit" aria-hidden="true"></i> </a><a href="javascript:void(0);" class="delete delete_chapter" onclick="delete_chapter(' + response.id + ')"> <i class="fa fa-trash-o" aria-hidden="true"></i> </a></td></tr>';
                    $('#chapterstbl').append(content);
                    $('.modal').modal('hide');

                    //window.location.reload();
                }

            }
        });

        return false;
    });

    $('#chapteraddform3').on('submit', function() {
        var formdata = new FormData($(this)[0]);
        $.ajax({
            type: 'post',
            url: url + 'courses/addChapter/',
            data: formdata,
            contentType: false,
            cache: false,
            processData: false,
            success: function(response) {
                // console.log(response);
                var response = $.parseJSON(response);
                if (response.status == 'error') {
                    $.each(response.error, function(key, val) {
                        $('#chapteraddform3 input[name="' + key + '"]').after('<label class="error">' + val + '</label>');
                        $('#chapteraddform3 textarea[name="' + key + '"]').after('<label class="error">' + val + '</label>');
                        $('#chapteraddform3 select[name="' + key + '"]').after('<label class="error">' + val + '</label>');
                    });
                }else if (response.status == 'course_error') { 
                    alert('Please save course general details first.');
                } else if (response.status == 'success') {
                    var rowno = $('#chapterstbl tr').length;
                    rowno = parseInt(rowno) + 1;
                    var type = "ppt";
                    var content = '<tr id="tr_' + response.id + '"><td><a href="#">' + response.title + '</a></td><td class="actions"><a href="javascript:void(0);" class="delete delete_chapter" onclick="edit_chapter(' + response.id + ',\'' + type + '\')"> <i class="fa fa-edit" aria-hidden="true"></i> </a><a href="javascript:void(0);" class="delete delete_chapter" onclick="delete_chapter(' + response.id + ')"> <i class="fa fa-trash-o" aria-hidden="true"></i> </a></td></tr>';
                    $('#chapterstbl').append(content);
                    $('.modal').modal('hide');
                }

            }
        });

        return false;
    });
    $('#chapteraddform4').on('submit', function() {
        var formdata = new FormData($(this)[0]);
        $('#chapteraddform4 .error').remove();
        $.ajax({
            type: 'post',
            url: url + 'courses/addChapter/',
            data: formdata,
            contentType: false,
            cache: false,
            processData: false,
            success: function(response) { 
                // console.log(response);
                var response = $.parseJSON(response);
                if (response.status == 'error') {
                    $.each(response.error, function(key, val) {
                        $('#chapteraddform4 #' + key).after('<label class="error">' + val + '</label>');
                    });
                }else if (response.status == 'course_error') { 
                    alert('Please save course general details first.');
                } else if (response.status == 'success') {
                    var content = '<li id="liass_' + response.ass_id + '"><label>' + response.data.question + '</label><a href="javascript:void(0);" onclick="del_assessment(' + response.ass_id + ');"><i class="fa fa-trash"> </i></a></li>';
                    //var content = "<li>Question: "+response.data.question+" <a href='javascript:void(0);' onclick='delete_questions'><i class='fa fa-cross'> </i> </a></li>";
                    $('.add_assessments').append(content);
                    $('#assessmentbasic').hide();
                    $('#chapteraddform4 #question').val('');
                    $('#chapteraddform4 #answer').val('');
                    $('#chapteraddform4 input[name="options[]"]').val('');
                    $('#chapteraddform4 textarea').val('');
                    if (response.data.title !== '') {
                        if ($('#chapterstbl tr.assesmenttr').length > 0) {
                            $('#chapterstbl tr.assesmenttr td:nth-child(1)').html(response.data.title);
                        } else {
                            var rowno = $('#chapterstbl tr').length;
                            rowno = parseInt(rowno) + 1;
                            var type = "assessment";
                            var content = '<tr id="tr_' + response.id + '" class="assesmenttr"><td><a href="#">' + response.data.title + '</a></td><td class="actions"><a href="javascript:void(0);" class=" " onclick="edit_chapter(' + response.id + ',\'' + type + '\')"> <i class="fa fa-edit" aria-hidden="true"></i> </a><a href="javascript:void(0);" class="delete delete_chapter" onclick="delete_chapter(' + response.id + ')"> <i class="fa fa-trash-o" aria-hidden="true"></i> </a></td></tr>';
                            $('#chapterstbl').append(content);
                        }
                    }
                }

            }
        });

        return false;
    });
    $('.addlrobj').on('click', function() {
        var check = $('#chapterstbl tbody .assesmenttr').length;
        console.log(check);
        if (check > 0) {
            $(document).find('.assessmentlink').hide();
        } else {
            $(document).find('.assessmentlink').show();
        }

    });
    $('#olcourse').on('submit', function() {
        var formdata = new FormData($(this)[0]);
        $('label.error').remove();
        $.ajax({
            type: 'post',
            url: url + 'courses/ajaxolcourse/',
            data: formdata,
            contentType: false,
            cache: false,
            processData: false,
            success: function(response) {
                console.log(response);
                var response = $.parseJSON(response);
                if (response.status == 'error') {
                    $.each(response.error, function(key, val) {
                        $('input[name="' + key + '"]').after('<label class="error">' + val + '</label>');
                        $('textarea[name="' + key + '"]').after('<label class="error">' + val + '</label>');
                        $('select[name="' + key + '"]').after('<label class="error">' + val + '</label>');
                    });
                } else if (response.status == 'success') {
                    //$('#tab2').tabs('select', 2);
                    $('.tab-pane').hide();
                    $('.nav-tabs li').removeClass('active');
                    $('li:nth-child(2)').addClass('active');
                    $('#syllabus').show();
                    
                    $('input[name="course_id"]').val(response.course_id);
                    //$('#tab2').trigger('click');
                }
            }
        });
        //console.log(formdata);
        return false;
    });

    $('#olcourse2').on('submit', function() {
        var formdata = new FormData($(this)[0]);
        $('label.error').remove();
        $.ajax({
            type: 'post',
            url: url + 'courses/ajaxolcourse/',
            data: formdata,
            contentType: false,
            cache: false,
            processData: false,
            success: function(response) {
                console.log(response);
                return false;
                var response = $.parseJSON(response);
                if (response.status == 'error') {
                    $.each(response.error, function(key, val) {
                        $('input[name="' + key + '"]').after('<label class="error">' + val + '</label>');
                        $('textarea[name="' + key + '"]').after('<label class="error">' + val + '</label>');
                        $('select[name="' + key + '"]').after('<label class="error">' + val + '</label>');
                    });
                } else if (response.status == 'success') {
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

    $('#olcourse3').on('submit', function() {
        var formdata = new FormData($(this)[0]);
        $('label.error').remove();
        $.ajax({
            type: 'post',
            url: url + 'courses/ajaxolcourse/',
            data: formdata,
            contentType: false,
            cache: false,
            processData: false,
            success: function(response) {
                var response = $.parseJSON(response);
                if (response.status == 'error') {
                    $.each(response.error, function(key, val) {
                        $('input[name="' + key + '"]').after('<label class="error">' + val + '</label>');
                        $('textarea[name="' + key + '"]').after('<label class="error">' + val + '</label>');
                        $('select[name="' + key + '"]').after('<label class="error">' + val + '</label>');
                    });
                } else if (response.status == 'success') {
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

    $(document).on('submit', '#assessmentedit', function() {

        var formdata = new FormData($(this)[0]);
        $('#assessmentedit .error').remove();
        $.ajax({
            type: 'post',
            url: url + 'courses/addChapter/',
            data: formdata,
            contentType: false,
            cache: false,
            processData: false,
            success: function(response) { 
                //console.log(response);
                var response = $.parseJSON(response);
                if (response.status == 'error') { console.log('a');
                    $.each(response.error, function(key, val) {
                        $('#assessmentedit #' + key).after('<label class="error">' + val + '</label>');
                    });
                }else if (response.status == 'course_error') { console.log('b');

                    alert('Please save course general details first.');
                } else if (response.status == 'success') { console.log('c');
                    var content = '<li id="liass_' + response.ass_id + '"><label>' + response.data.question + '</label><a href="javascript:void(0);" onclick="del_assessment(' + response.ass_id + ');"><i class="fa fa-trash"> </i></a></li>';
                    //var content = "<li>Question: "+response.data.question+" <a href='javascript:void(0);' onclick='delete_questions'><i class='fa fa-cross'> </i> </a></li>";
                    $('.add_assessments').append(content);
                    $('#assessmentbasic').hide();
                    $('#assessmentedit #question').val('');
                    $('#assessmentedit #answer').val('');
                    $('#assessmentedit input[name="options[]"]').val('');
                    $('#assessmentedit textarea').val('');
                    if (response.data.title !== '') {
                        if ($('#chapterstbl tr.assesmenttr').length > 0) {
                            $('#chapterstbl tr.assesmenttr td:nth-child(1)').html(response.data.title);
                        } else {
                            var rowno = $('#chapterstbl tr').length;
                            rowno = parseInt(rowno) + 1;
                            var content = '<tr id="tr_' + response.id + '" class="assesmenttr"><td><a href="#">' + response.data.title + '</a></td><td class="actions"><a href="javascript:void(0);" class="delete delete_chapter" onclick="delete_chapter(' + response.id + ')"> <i class="fa fa-trash-o" aria-hidden="true"></i> </a></td></tr>';
                            $('#chapterstbl').append(content);
                        }
                    }
                }

            }
        });

        return false;
    });
    $('#olcourse4').on('submit', function() {
        var formdata = new FormData($(this)[0]);
        $('label.error').remove();
        $.ajax({
            type: 'post',
            url: url + 'courses/ajaxolcourse/',
            data: formdata,
            contentType: false,
            cache: false,
            processData: false,
            success: function(response) {
                console.log(response);
                var response = $.parseJSON(response);
                if (response.status == 'error') {
                    $.each(response.error, function(key, val) {
                        $('input[name="' + key + '"]').after('<label class="error">' + val + '</label>');
                        $('textarea[name="' + key + '"]').after('<label class="error">' + val + '</label>');
                        $('select[name="' + key + '"]').after('<label class="error">' + val + '</label>');
                    });
                } else if (response.status == 'success') {
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

    $('#olcourse5').on('submit', function() {
        var formdata = new FormData($(this)[0]);
        $('label.error').remove();
        $.ajax({
            type: 'post',
            url: url + 'courses/ajaxolcourse/',
            data: formdata,
            contentType: false,
            cache: false,
            processData: false,
            success: function(response) {
                console.log(response);
                //return false;
                var response = $.parseJSON(response);
                if (response.status == 'error') {
                    $.each(response.error, function(key, val) {
                        $('input[name="' + key + '"]').after('<label class="error">' + val + '</label>');
                        $('textarea[name="' + key + '"]').after('<label class="error">' + val + '</label>');
                        $('select[name="' + key + '"]').after('<label class="error">' + val + '</label>');
                    });
                } else if (response.status == 'success') {
                    $('.tab-pane').hide();
                    $('.nav-tabs li').removeClass('active');
                    $('li:nth-child(6)').addClass('active');
                    $('#resources1').show();
                }
            }
        });
        //console.log(formdata);
        return false;
    });

    $('#olcourse6').on('submit', function() {
        var formdata = new FormData($(this)[0]);
        $('label.error').remove();
        $.ajax({
            type: 'post',
            url: url + 'courses/ajaxolcourse/',
            data: formdata,
            contentType: false,
            cache: false,
            processData: false,
            success: function(response) {
                console.log(response);
                var response = $.parseJSON(response);
                if (response.status == 'error') {
                    $.each(response.error, function(key, val) {
                        $('input[name="' + key + '"]').after('<label class="error">' + val + '</label>');
                        $('textarea[name="' + key + '"]').after('<label class="error">' + val + '</label>');
                        $('select[name="' + key + '"]').after('<label class="error">' + val + '</label>');
                    });
                } else if (response.status == 'success') {
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


    $('#nextavailability').on('click', function() {
        //$('#tab3').trigger('click');
        $('.tab-pane').hide();
        $('.nav-tabs li').removeClass('active');
        $('li:nth-child(3)').addClass('active');
        $('#availability').show();
    });

    $('.backchaptertype').on('click', function() {
        $('.modal').modal('hide');
        $('#myModal').modal('show');

    });

    $('#enable_ecommerce').click(function() {
        if ($(this).is(':checked') == true) {
            $('#ecommerce_innersection').fadeIn();
        } else {
            $('#ecommerce_innersection').fadeOut();
        }
    });
    $('#email_notify').click(function() {
        if ($(this).is(':checked') == true) {
            $('#notificationinner').fadeIn();
        } else {
            $('#notificationinner').fadeOut();
        }
    });
    $('#completion_email_custom').click(function() {
        if ($(this).is(':checked') == true) {
            $('#completion_email_custom_inner').fadeIn();
        } else {
            $('#completion_email_custom_inner').fadeOut();
        }
    });
    $('#enrollment_email_custom').click(function() {
        if ($(this).is(':checked') == true) {
            $('#enrollment_email_custom_inner').fadeIn();
        } else {
            $('#enrollment_email_custom_inner').fadeOut();
        }
    });
    $('#enrollment_email').click(function() {
        if ($(this).is(':checked') == true) {
            $('#enrollment_email_inner').fadeIn();
        } else {
            $('#enrollment_email_inner').fadeOut();
        }
    });
    $('#completion_email').click(function() {
        if ($(this).is(':checked') == true) {
            $('#completion_email_inner').fadeIn();
        } else {
            $('#completion_email_inner').fadeOut();
        }
    });
    $('#allow_reenrollment').click(function() {
        if ($(this).is(':checked') == true) {
            $('#reenrollment_inner').fadeIn();
        } else {
            $('#reenrollment_inner').fadeOut();
        }
    });

    $('#automatic_enrollment').click(function() {
        if ($(this).is(':checked') == true) {
            $('#enrollment_inner').fadeIn();
        } else {
            $('#enrollment_inner').fadeOut();
        }
    });

    $('#receive_certificate').click(function() {
        if ($(this).is(':checked') == true) {
            $('#collapse11').removeClass('collapse');
            $('#collapse11').addClass('expand');
        } else {
            $('#collapse11').addClass('collapse');
            $('#collapse11').removeClass('expand');
        }
    });

    $('#add_rule').on('click', function() {
        var addnewrule = '<li id="rulediv_lastid"><div class="form-group inner-box" ><select name="EnrollRules[fields][]" class="form-control" id="enrollrules-fields"><option value="firstname">First Name</option><option value="lastname">Last Name</option><option value="fullname">Full Name</option><option value="username">Username</option><option value="department">Department</option><option value="group">Group</option><option value="location">Location</option><option value="email">Email Address</option></select><select name="EnrollRules[rules][]" class="form-control" id="enrollrules-rules"><option value="starts">Starts With</option><option value="contains">Contains</option><option value="equals">Equals</option><option value="ends">Ends With</option></select><input type="text" name="EnrollRules[value][]" class="form-control" placeholder="Value" id="enrollrules-value"><a href="javascript:void(0);" id="rule_lastid" class="delete_rule delete-btn" onclick="del_li(lastid);"> <i class="fa fa-trash-o" aria-hidden="true"></i> </a></div></li>';
        var getlast = $('.all_rules li:last').attr('id');
        getlast = getlast.split('_');
        getlast = parseInt(getlast[1]) + parseInt(1);
        var content = addnewrule.replace(/lastid/g, getlast);
        //console.log(content);
        $('.all_rules').append(content);
    });

    $('#laststepcontinue').on('click', function() {
        //$('#tab7').trigger('click');
        $('.tab-pane').hide();
        $('.nav-tabs li').removeClass('active');
        $('li:nth-child(7)').addClass('active');
        $('#complete').show();
    });

    $('.previous_button').on('click', function() {
        getid = $(this).attr('id');
        if (getid == 'back1') {
            $('.tab-pane').hide();
            $('.nav-tabs li').removeClass('active');
            $('li:nth-child(1)').addClass('active');
            $('#general').show();
        }
        if (getid == 'back2') {
            $('.tab-pane').hide();
            $('.nav-tabs li').removeClass('active');
            $('li:nth-child(2)').addClass('active');
            $('#syllabus').show();
        }
        if (getid == 'back3') {
            $('.tab-pane').hide();
            $('.nav-tabs li').removeClass('active');
            $('li:nth-child(3)').addClass('active');
            $('#availability').show();
        }
        if (getid == 'back4') {
            $('.tab-pane').hide();
            $('.nav-tabs li').removeClass('active');
            $('li:nth-child(4)').addClass('active');
            $('#competetion').show();
        }
        if (getid == 'back5') {
            $('.tab-pane').hide();
            $('.nav-tabs li').removeClass('active');
            $('li:nth-child(5)').addClass('active');
            $('#messages').show();
        }
        if (getid == 'back6') {
            $('.tab-pane').hide();
            $('.nav-tabs li').removeClass('active');
            $('li:nth-child(6)').addClass('active');
            $('#resources1').show();
        }
    });

    $('.add_question').on('click', function() {
        var getlastdiv = $('.assessments_div:last').attr('id');
        var getid = getlastdiv.split('_');
        getid = parseInt(getid[1]) + 1;
        var content = '<div id="assessment_lastid" class="assessments_div"><div class="form-group"><label for="question">Question</label><input type="text" name="question[lastid][]" placeholder="Question" class="form-control" id="question"></div><div class="form-group optionsdiv"><a href="javascript:void(0);" onclick="add_options_link(lastid)" ><i class="fa fa-plus"> </i>  Add Option</a><input type="text" name="options[lastid][]" placeholder="Options" class="form-control" id="lastid_1"><input type="text" name="options[lastid][]" placeholder="Options" class="form-control" id="lastid_2"><input type="text" name="options[lastid][]" placeholder="Options" class="form-control" id="lastid_3"><input type="text" name="options[lastid][]" placeholder="Options" class="form-control" id="lastid_4"></div></div><div class="form-group correctdiv"><label for="answer1">Answer</label><input type="text" name="answer[lastid][]" placeholder="Answer" class="form-control" id="answerlastid"></div>';
        var content = content.replace(/lastid/g, getid);

        $('#' + getlastdiv).after(content);
    });

    $().click(function() {

    });
});

function add_options_link(getid) {
    var getlastid = $('#assessment_' + getid + ' .form-group  input:last').attr('id');
    getlastid = getlastid.split('_');
    getlastid = parseInt(getlastid[1]) + 1;
    $('#assessment_' + getid + ' .optionsmaindiv ').append('<div class="optionsdiv"><input type="text" name="options[]" placeholder="Options" class="form-control options" id="' + getid + '_' + getlastid + '"><a href="javascript:void(0);" onclick="del_option(' + getid + ',' + getlastid + ')"><i class="fa fa-trash"> </i></a></div>');
}

function del_li(val) {
    $('ul.all_rules li#rulediv_' + val).remove();
}

function del_option(id, id2) {
    $('#' + id + '_' + id2).next('a').remove();
    $('#' + id + '_' + id2).remove();
}

function del_li_db(val) {
    var url = '/vestotus/admin/';
    $.get(url + 'courses/del_enrollrule/' + val, function(response) {
        if (response == 'success') {
            $('ul.all_rules li#rulediv_' + val).remove();
        }
    });
}

function del_resource(val, db = 0) {
    var url = '/vestotus/admin/';
    //alert('delete-'+val+'-'+db);

    $.get(url + 'courses/del_resource/' + val, function(response) {
        if (response == 'success') {
            $('#resourcediv_' + val).remove();
        } else {
            alert('Error! Please try again');
        }
    });
}

function finalstep(val) {
    if (val == 1) {
        $.get(url + 'courses/activateCourse/', function(response) {
            if (response == 'success') {
                window.location.href = url + "courses/";
            } else {
                console.log(response);
            }
        });
    } else if (val == 0); {
        window.location.href = url + "courses/";
    }
}


function delete_chapter(id = null) {
    $.post(url + 'courses/delChapter', { 'id': id }, function(response) {
        // console.log(response);
        if (response == 'success') {
            $('tr#tr_' + id).remove();
        }
    });
}

function edit_chapter(id = null, type = null) {
    console.log(type);
    if (type == 'assessment') {
        $.get(url + 'lessons/assessmentedit/' + id, function(response) { 
    // console.log(response);
            $('#edit-video .modal-content').html(response);
            $('#edit-video').modal('show');
        });
    } else if (type == 'video') {
        $.get(url + 'lessons/videoedit/' + id, function(response) {
            $('#edit-video .modal-content').html(response);
            $('#edit-video').modal('show');
        });
    } else if (type == 'audio') {
        $.get(url + 'lessons/audioedit/' + id, function(response) {
            $('#edit-audio .modal-content').html(response);
            $('#edit-audio').modal('show');
        });
    } else if (type == 'ppt') {
        $.get(url + 'lessons/pptedit/' + id, function(response) {
            $('#edit-ppt .modal-content').html(response);
            $('#edit-ppt').modal('show');
        });
    }
}

function del_course_file(id) {
    $.get(url + 'lessons/del_file/' + id, function(response) {
        if (response == 'success') {
            $('#li_' + id).remove();
        }

    });


}

function getFormData($form) {
    var unindexed_array = $form.serializeArray();
    var indexed_array = {};

    $.map(unindexed_array, function(n, i) {
        indexed_array[n['name']] = n['value'];
    });

    return indexed_array;
}

function del_assessment(id = null) {
    if (id) {
        $.get(url + 'lessons/del_assessment/' + id, function(response) {
            // console.log(response);
            if (response == 'success') {
                //console.log('hi');
                $(document).find('.add_assessments #liass_' + id).remove();

            }

        });
    }
}

function saveorderchapters() {
    var arr = [];
    $('#chapterstbl tbody tr').each(function(key, val) {
        var getid = $(this).attr('id');
        getid = getid.split('_');
        getid = getid[1];
        arr.push(getid);
    });
    $.post(url + 'lessons/reorder/', { 'data': arr }, function() {
        //console.log();
    });
}

function showtab(tabname = null) {
    $('.tab-pane').hide();
    $('.nav-tabs li').removeClass('active');
    $('li.class-' + tabname).addClass('active');
    $('#' + tabname).show();
}