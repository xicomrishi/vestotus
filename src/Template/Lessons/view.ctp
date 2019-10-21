<?= $this->Form->hidden('lesson_id',['id'=>'lesson_id','value'=>$lesson['id']]) ?>
<?= $this->Form->hidden('course_id',['id'=>'course_id','value'=>$lesson['course_id']]) ?>
<div id="main">
    <div class="visible-md visible-xs visible-sm mobile-menu">
        <button type="button" data-toggle="offcanvas"><i class="fa fa-bars"></i></button>
    </div>
    <section class="bgw clearfix course-detail-master">
        <div class="page-title bgg">
            <div class="container-fluid clearfix">
                <div class="title-area pull-left">
                    <h2>Lesson Details<small></small></h2>
                </div>
                <!-- /.pull-right -->
                <div class="pull-right hidden-xs">
                    <div class="bread">
                        <ol class="breadcrumb">
                            <li><a href="<?= BASEURL?>users/dashboard">Home</a></li>
                            <li><a href="<?= BASEURL?>courses">Courses</a></li>
                            <li><a href="<?= BASEURL?>courses/view/<?= $this->Common->myencode($lesson['course']['id']) ?>"><?= ucwords($lesson['course']['title']) ?></a></li>
                            <li class="active">Lesson <?= $lesson['lesson_no'] ?> </li>
                        </ol>
                    </div>
                    <!-- end bread -->
                </div>
                <!-- /.pull-right -->
            </div>
        </div>
        <!-- end page-title -->
        <section class="section bgw">
            <div class="container-fluid">
                <div class="row">
                    <div id="post-content" class="col-md-12 col-sm-12 single-course">
                        <!-- <hr class="invis">
                        <div class="leaners-table clearfix">
                            <div class="big-title">
                                <h2 class="related-title">
                                    <span><?= $course->title ?></span>
                                </h2>
                            </div>
                             content here 
                        </div> -->

                        <div class="course-single-quiz">
                            <!--<small>Quiz for : <span><a href="course-single.html">Learning Web Design in 22 Days</a></span></small><br>
                                <small>Quiz Status: <span>Not Finished</span> </small> -->
                            <hr>
                            <div class="quiz-wrapper">
                                <div class="big-title">
                                    <h2 class="related-title">
                                        <span>Lesson <?= $lesson['lesson_no'] ?></span>
                                    </h2>
                                </div>
                            
                                <!-- <h3>Lesson <?= $lesson['lesson_no'] ?> 
                                </h3> -->
                                <?php if($activeuser['role']!=2){ ?>
                                <div class="form-group right_side_checkbox">
                                    <label>Is completed </label>
                                    <?php $status = $this->Common->getLessonStatus($lesson['id'],$activeuser['id']) ?>
                                    <input type="checkbox" name="status" id="mark_completed" <?php if($status=="completed") { echo "checked='checked' disabled='disabled'"; } ?>class="switch" value="1">
                                    <label for="mark_completed" class="checkbox-switch"> </label>
                                </div>
                                <?php } ?>
                                <h4><?= ucfirst($lesson['title']) ?></h4>
                                <p><?= ucfirst($lesson['notes']) ?></p>
                                <p>
                                    Lesson <?= ucwords($lesson['description']) ?>
                                </p>
                                <div class="row">
                                    <div class="col-md-12">
                                        <?php 
                                            if($lesson['type']=='video') { ?>
                                        <video width="800" height="500" controls>
                                            <source src="<?= CHAPTER_VIDEO.$lesson['filename']?>" type="video/mp4">
                                        </video>
                                        <?php } else if($lesson['type']=='audio') { ?>
                                        <audio width="800" height="500" controls>
                                            <source src="<?= CHAPTER_AUDIO.$lesson['filename']?>" type="audio/mpeg">
                                        </audio>
                                        <?php } else if($lesson['type']=='ppt') {
                                            if(!empty($lesson['course_files'])){
                                                  foreach($lesson['course_files'] as $l){?>
                                        <?= $this->Html->link($this->Html->image('ppticon.png'),CHAPTER_PPT.$l['filename'],['escape'=>false,'target'=>'_blank'])?>
                                        <?php }
                                            }
                                                }else if($lesson['type']=='assesment') { ?>
                                        <?php } ?>
                                    </div>
                                </div>
                                <!--    <div class="row">
                                    <div class="col-md-12">
                                        <div class="panel course-quiz-panel">
                                            <div class="panel-body">
                                                <div class="checkbox checkbox-warning">
                                                    <input id="checkbox_qu_01" type="checkbox" class="styled">
                                                    <label for="checkbox_qu_01">
                                                        Lorem Ipsum has been the industry's standard dummy text ever since
                                                    </label>
                                                </div>
                                    
                                                <div class="checkbox checkbox-warning">
                                                    <input id="checkbox_qu_02" type="checkbox" class="styled">
                                                    <label for="checkbox_qu_02">
                                                        Of the printing and typesetting industry
                                                    </label>
                                                </div>
                                    
                                                <div class="checkbox checkbox-warning">
                                                    <input id="checkbox_qu_03" type="checkbox" class="styled">
                                                    <label for="checkbox_qu_03">
                                                        Dummy text ever since the, when an 
                                                    </label>
                                                </div>
                                    
                                                <div class="checkbox checkbox-warning">
                                                    <input id="checkbox_qu_04" type="checkbox" class="styled">
                                                    <label for="checkbox_qu_04">
                                                        Lopsum is simply dummy text of the printing and typesetting industry
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="panel-footer text-center">
                                                <a href="#" class="btn btn-primary " role="button">Confirm</a>
                                                <a href="#" class="btn btn-primary" role="button">Clear</a>
                                            </div>
                                        </div>
                                    
                                        <hr class="invis">
                                    
                                         <div class="skills course-complete text-left">
                                            <div class="progress">
                                                <div class="progress-bar" role="progressbar" data-transitiongoal="80" aria-valuenow="80" style="width: 80%;"><span>80</span></div>
                                            </div>
                                        </div>
                                    </div>
                                    </div>
                                    -->
                                <hr class="invis">
                                <div class="row">
                                    <?php if($prevchapter) : ?>
                                    <div class="col-md-6">
                                        <a href="<?= BASEURL?>lessons/view/<?= $prevchapter?>" class="btn btn-primary btn-square btn-block">Prev Lesson</a>
                                    </div>
                                    <?php endif; ?>
                                    <?php if($nextchapter) : ?>
                                    <div class="col-md-6">
                                        <a href="<?= BASEURL?>lessons/view/<?= $nextchapter?>" class="btn btn-primary btn-square btn-block">Next Lesson</a>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                <!-- end row -->
                            </div>
                            <!-- end quiz wrapper -->
                        </div>


                    </div>
                    <!-- end col -->
                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </section>
        <!-- end section -->
    </section>
    <!-- end section -->
</div>
</div><!-- end main -->
<style type="text/css">
    .right_side_checkbox
    {
    float: right;
    }
</style>

<script type="text/javascript">
    $(document).ready(function(){
        $('#mark_completed').click(function(){
            var lesson_id = $('#lesson_id').val();
            var course_id = $('#course_id').val();
            if($(this).is(':checked')== true)
            {
                var r = confirm('Do you really want to mark this course as completed .');
                if(r==true){
                    $.post('<?= BASEURL?>lessons/update',{'status':1,'lesson_id':lesson_id,'course_id':course_id},function(response){
                        if(response['status'] == 'true'){
                        } else{
                            $(this).attr('checked',false);       
                            alert('Some error occured, please try again later');
                        }
                        // console.log(response);
                    });
                }else{
                    $(this).attr('checked',false);       
                }
            }else{}
        });
    });
</script>
