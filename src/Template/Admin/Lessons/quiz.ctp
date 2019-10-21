<?= $this->Form->hidden('lesson_id',['id'=>'lesson_id','value'=>$lesson['id']]) ?>
<?= $this->Form->hidden('time_limit',['id'=>'time_limit','value'=>$lesson['time_limit']]) ?>
<?= $this->Form->hidden('course_id',['id'=>'course_id','value'=>$lesson['course_id']]) ?>
<div id="post-content" class="col-md-9 col-sm-12 single-course pull-right">
<div class="page-title bgg">
    <div class="clearfix">
        <div class="title-area pull-left">
                    <h2> <?= ucwords($lesson['title']) ?> <small>Lesson <?= $lesson['lesson_no'] ?></small></h2>
        </div><!-- /.pull-right -->
        <div class="pull-right hidden-xs">
            <div class="bread">
                <ol class="breadcrumb">
                    <li><a href="<?= BASEURL ?>learners/dashboard">Home</a></li>
                    <li class=""><a href="<?= BASEURL?>courses/view/<?= $this->Common->myencode($lesson['course']['id']) ?>"><?= ucwords($lesson['course']['title']) ?></a></li>
                    <li class="active">Lesson <?= $lesson['lesson_no'] ?> </li>
                </ol>
            </div><!-- end bread -->
        </div><!-- /.pull-right -->
    </div>
</div>
        <div id="post-content" class="col-md-12 col-sm-12 single-course">
                        <div class="course-single-quiz">
                            <small>Quiz for : <span><a href="#"><?= ucwords($lesson['course']['title']) ?></a></span></small><br>
                            <small>Quiz Status: <span>Not Finished</span> </small> 
                            
                            <small>Total Questions : <?= $totalQuestions ?></small>
                            
                            <div class="timer" style="color:#3ca1db;float:right;">
                            <span id='timer'></span>
                            </div>
                            <hr>
                            <div class="error quizerror"> </div>
                            <div class="quizouterdiv">
                             <?= $this->Html->link('Start','javascript:void(0);',['class'=>'btn btn-primary start_quiz_btn']) ?>
                            </div>
                               
                            </div>
                           
                        </div><!-- end desc -->
                    </div>

                    </div>
<style type="text/css">
    .right_side_checkbox
    {
        float: right;
    }
</style>
<?= $this->Html->script('myscript.js') ?>
<?php if($teststatus == 1) { ?>
    <script type="text/javascript">
     $(document).ready(function(){
        getnextquestion();
        timedCount();
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
    </script>
<?php } ?>
