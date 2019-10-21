<?php use Cake\I18n\Time; ?>
<div id="post-content" class="col-md-9 col-sm-12 single-course pull-right">
    <div class="big-title">
        <h2 class="related-title">
            <span> <?= $course->title ?></span>
        </h2>
    </div>
    <div class="post-media clearfix">
        <?php
            //echo $this->request->session()->read('Auth.User.addedby');exit;
            $img = $this->get_course_image($course['id'] , $this->request->session()->read('Auth.User.addedby'));
            if($img && $this->request->session()->read('Auth.User.addedby') > 1) {
                $image_link = FILE_COURSE.$img; 
            } else {
                 $image_link =  FILE_COURSE.$course->image;
            }
        ?>
        <img src="<?= $image_link ?>"> 
    </div>
    <!-- end media --> 
    <div class="single-course-title text-center">
        <h3><a href="single.html" title=""><?= ucwords($course->notes) ?></a></h3>
        <div class="post-sharing">
            <ul class="list-inline">
                <li><a href="#" class="fb-button btn btn-primary"><i class="fa fa-facebook"></i> <span class="hidden-xs">Share on Facebook</span></a></li>
                <li><a href="#" class="tw-button btn btn-primary"><i class="fa fa-twitter"></i> <span class="hidden-xs">Tweet on Twitter</span></a></li>
                <li><a href="#" class="gp-button btn btn-primary"><i class="fa fa-google-plus"></i></a></li>
            </ul>
        </div>
        <!-- end post-sharing --> 
    </div>
    <!-- end single-course-title -->
    <hr class="invis">
    <div class="course-single-desc clearfix">
        <div class="big-title">
            <h2 class="related-title">
                <span>Course Description</span>
            </h2>
        </div>
        <!-- end big-title -->
        <p><?= ucwords($course->description) ?></p>
        <?php if($course->hide_price != 1 ) { ?>
        <p> Price : <?= $course->purchase_price ?></p>
        <?php } ?>
    </div>
    <!-- end post-padding -->
    <hr class="invis">
    <div class="course-table clearfix">
        <div class="big-title">
            <h2 class="related-title">
                <span>Course Lessons</span>
            </h2>
        </div>
        <!-- end big-title -->
        <table class="table">
            <thead>
                <tr>
                    <th>Type</th>
                    <th>Lesson Title</th>
                    <th>Notes</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($course->course_chapters as $lesson) { ?>
                <tr>
                    <td>
                        <?php if($lesson->type=="audio") { ?>
                        <i class="fa fa-music"></i>
                        <?php } else if($lesson->type=="video") {?>
                        <i class="fa fa-play-circle"></i>
                        <?php  } else if($lesson->type=="ppt") {?>
                        <i class="fa fa-file"></i>
                        <?php } else if($lesson->type=="assessment") {?>
                        <i class="fa fa-question-circle"></i>
                        <?php } ?>
                    </td>
                    <td>
                        <?php if($lesson->type=="assessment" && $activeuser['role']!=2) 
                            { 
                            
                                $check = $this->Common->getResult($lesson['course_id'],$activeuser['id']);
                                if($check)
                                {
                                    $link = BASEURL."lessons/quizresult/".$this->Common->myencode($lesson['course_id']);
                                }
                                else if($testcheck=='invalid')
                                {
                                    $link = "#";
                                }
                                else 
                                {
                                    if($lesson['test_type']==1)
                                    {
                                        $link = ['controller'=>'quiz','action'=>'quizstart',$this->Common->myencode($lesson['course_id']  )];
                                    }
                                    else
                                    {
                                    $link = ['controller'=>'lessons','action'=>'quiz',$this->Common->myencode($lesson['course_id']  )];
                                    }
                                }
                                ?>
                        <?= $this->Html->link(ucwords($lesson->title),$link,['class'=>'']) ?>
                        <?php } else { ?>
                        <a href="<?= BASEURL?>lessons/view/<?= $this->Common->myencode($lesson['id']) ?>">
                        <?= ucwords($lesson->title) ?></a>
                        <?php } ?>
                    </td>
                    <td><?= substr(ucfirst($lesson->notes),0,100) ?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
        <!--  <a href="#" class="btn btn-primary btn-block btn-lg btn-square">Join the Course</a>
            -->
    </div>
    <!-- end course-table -->
    <?php if($activeuser['role']!=2){ ?>
    <hr class="invis1">
    <div class="single-content comment-wrapper clearfix">
        <div class="related-posts">
            <div class="big-title">
                <h2 class="related-title">
                    <span>Review</span>
                </h2>
            </div>
            <!-- end big-title -->
            <div class="row">
                <div class="col-md-12">
                    <div class="panel">
                        <div class="panel-body comments">
                            <ul class="media-list">
                                <?php if(count($course['course_reviews']) > 0)
                                    {
                                    foreach($course['course_reviews'] as $reviews)
                                        {
                                    ?>
                                <li class="media">
                                    <div class="comment">
                                        <a href="#" class="pull-left">
                                        <?php if($reviews['user']['avatar']) { ?>
                                        <img src="<?= BASEURL?>uploads/user_data/<?= $reviews['user']['avatar'] ?>" class="img-circle">
                                        <?php } else {?>
                                        <img src="<?= BASEURL?>upload/avatar_02.png" alt="" class="img-circle">
                                        <?php } ?>
                                        </a>
                                        <div class="media-body">
                                            <strong class="text-success"><?= ucfirst($reviews['user']['fullname']) ?></strong>
                                            <span class="text-muted">
                                            <small class="text-muted"><?php
                                                $time = new Time($reviews['created']);
                                                echo $time->timeAgoInWords(
                                                ['format' => 'MMM d, YYY', 'end' => '+1 year']
                                                );
                                                
                                                ?></small></span>
                                            <p>
                                                <?= ucfirst($reviews['message']) ?>
                                            </p>
                                            <!--<a href="#" class="btn btn-primary btn-sm">Reply</a> -->
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                </li>
                                <?php  } } ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end postpager -->
    </div>
    <!-- end content -->
    <div class="single-content comment-wrapper">
        <div class="clearfix">
            <div class="big-title">
                <h2 class="related-title">
                    <span>Leave a Review</span>
                </h2>
            </div>
            <!-- end big-title -->
            <div class="msg"> </div>
            <div class="contact_form">
                <?= $this->Form->create('course_review',['id'=>'course_review','class'=>'row']) ?>
                <?= $this->Form->hidden('course_id',['value'=>$course->id]) ?>
                <?php $this->Form->templates($form_templates['frontForm']); ?>      
                <div class="col-md-4 col-sm-12">
                    <?= $this->Form->input('name',['id'=>'name','class'=>'form-control','placeholder'=>'Name','value'=>$activeuser['fullname']]) ?>
                </div>
                <div class="col-md-4 col-sm-12">
                    <?= $this->Form->input('email',['id'=>'email','class'=>'form-control','placeholder'=>'Email','value'=>$activeuser['email'],'readonly'=>'readonly']) ?>
                </div>
                <div class="col-md-4 col-sm-12">
                    <?= $this->Form->input('website',['id'=>'website','class'=>'form-control','placeholder'=>'Website']) ?>
                </div>
                <div class="col-md-12 col-sm-12">
                    <?= $this->Form->textarea('message',['id'=>'messagetext','class'=>'form-control','placeholder'=>'Message goes here'])?>
                </div>
                <div class="col-md-12 col-sm-12">
                    <?= $this->Form->submit('Send Comment',['class'=>'btn btn-primary']) ?>
                </div>
                <?= $this->Form->end() ?>
            </div>
            <!-- end commentform -->
        </div>
        <!-- end postpager -->
    </div>
    <?php } ?>
    <!-- end content -->
</div>
<!-- end col -->
<script type="text/javascript">
    $(document).ready(function(){
        $('#course_review').submit(function(){
            var formdata =  new FormData($(this)[0]);
            $('label.error').remove();
            $.ajax({
                type:'post',
                url:'<?= BASEURL?>courses/commentsave/',
                data: formdata, 
                contentType: false,       
                cache: false,             
                processData:false, 
                success:function(response)
                {
                    console.log(response);
                   // return false;
                    var response = $.parseJSON(response);
                    if(response.status=='error')
                    {
                    $.each(response.error,function(key,val){
                            $('#course_review input[name="'+key+'"]').after('<label class="error">'+val+'</label>');
                            $('#course_review textarea[name="'+key+'"]').after('<label class="error">'+val+'</label>');
                            $('#course_review select[name="'+key+'"]').after('<label class="error">'+val+'</label>');
                        });
                    }
                    else if(response.status=='success')
                    {
                      // location.reload();
                      $('.msg').html('Thanks for your feedback.');
                      $('#website').val('');
                      $('#messagetext').val('');
                    }
            
                }
            });
            
            return false;
        });
    });
</script>

