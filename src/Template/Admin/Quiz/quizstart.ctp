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

    <script type="text/javascript">
     $(document).ready(function(){
        getnextquestion1();
        
     });
   
    </script>

