<?php use Cake\I18n\Time; ?>
<div class="page-title bgg">
    <div class="container clearfix">
        <div class="title-area pull-left">
            <h2><?= $course->title ?><small></small></h2>
        </div>
        <!-- /.pull-right -->
        <div class="pull-right hidden-xs">
            <div class="bread">
                <ol class="breadcrumb">
                    <li><a href="<?= BASEURL ?>users/dashboard">Home</a></li>
                    <li ><a href="<?= BASEURL ?>courses/ecomcourses">E-Commerce</a></li>
                </ol>
            </div>
            <!-- end bread -->
        </div>
        <!-- /.pull-right -->
    </div>
</div>
<!-- end page-title -->
<section class="section bgw">
    <div class="container">
        <div class="post-media clearfix">
            <?php
                if(!empty($course->image)){
                    $image_link =  FILE_COURSE.$course->image;
                }else{
                    $image_link =  FILE_COURSE_DEFAULT;
                }
            ?>
            <div class="media-iin" style="background-image:url('<?= $image_link ?>')"></div>
            <!-- <img src="<?= $image_link ?>"> --> 
        </div>
        <!-- end media --> 
        <div class="single-course-title text-center">
            <!-- <h3><a href="single.html" title=""><?= ucwords($course->notes) ?></a></h3> -->
            <p><?= ucwords($course->notes) ?></p>

            <div class="post-sharing">
                <ul class="list-inline">
                    <li><a href="#" class="fb-button btn btn-primary"><i class="fa fa-facebook"></i> <span class="hidden-xs">Share on Facebook</span></a></li>
                    <li><a href="#" class="tw-button btn btn-primary"><i class="fa fa-twitter"></i> <span class="hidden-xs">Tweet on Twitter</span></a></li>
                    <li><a href="#" class="gp-button btn btn-primary"><i class="fa fa-google-plus"></i><span class="hidden-xs">Share on Google+</span></a></li>
                </ul>
            </div>
            <!-- end post-sharing --> 
            <?php if($course->enable_ecommerce ==1) {?>
            <a href="<?= BASEURL ?>courses/addtocart/<?= $course->id ?>" class="btn btn-primary btn-block btn-lg btn-square">
            Buy now</a>
            <?php } ?>
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
                <p> Price : CAD <?= $course->purchase_price ?></p>
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
                            <?php 
                                $link = "javascript:void(0);";
                                if($lesson->type=="assessment") 
                                { 
                                
                                    $check = $this->Common->getResult($lesson['course_id'],$activeuser['id']);
                                    $link = "javascript:void(0);";
                                    ?>
                            <?= $this->Html->link(ucwords($lesson->title),$link,['class'=>'']) ?>
                            <?php } else { ?>
                            <a href="<?= $link ?>">
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
        <hr class="invis1">
        <div class="single-content comment-wrapper clearfix">
            <div class="related-posts">
                <div class="big-title">
                    <h2 class="related-title">
                        <span>  Student Review</span>
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
        <!-- end content -->
    </div>
    <!-- end col -->
</section>
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