 <?php use Cake\I18n\Time; ?>
 <div class="page-title bgg">
            <div class="container clearfix">
                <div class="title-area pull-left">
                    <h2><?= $course->title ?><small></small></h2>
                </div><!-- /.pull-right -->
                <div class="pull-right hidden-xs">
                    <div class="bread">
                        <ol class="breadcrumb">
                            <li><a href="<?= BASEURL ?>users/dashboard">Home</a></li>
                            <li ><a href="<?= BASEURL ?>courses/ecomcourses">E-Commerce</a></li>
                        </ol>
                    </div><!-- end bread -->
                </div><!-- /.pull-right -->
            </div>
        </div><!-- end page-title -->
 <section class="section bgw">
            <div class="container">
    <div class="post-media clearfix">
        <img src="<?= FILE_COURSE.$course->image ?>"> 

    </div><!-- end media --> 

    <br><a href="<?= BASEURL ?>courses/addtocart/<?= $course->id ?>" class="btn btn-primary btn-block btn-lg btn-square">Buy now</a>

    <hr class="invis">

                        <div class="course-single-desc clearfix">
                            <div class="big-title">
                                <h2 class="related-title">
                                    <span>Course Description</span>
                                </h2>
                            </div><!-- end big-title -->
                            <p><?= ucwords($course->description) ?></p>
                            
                        </div><!-- end post-padding -->

                        
   <div class="pricediv"> Price : $ <?php if($p = $this->get_course_price($course['id'] , $this->request->session()->read('Auth.User.id'))) { echo $p; } else { echo $course['purchase_price']; } ?></div>
                                    <?php   $j = 1;
                                    foreach($course['sessions'] as $session) { ?>
                                    <div class="single-course-title">
                                        <h3><a href="" title="">Session <?= $j ?> : <?= ucfirst($session['title']) ?> </a></h3>
                                        <div class="post-sharing">
                                        <?= $session['description'] ?>
                                        <strong>Notes </strong>
                                        <?= $session['notes'] ?>
                                            <!--<ul class="">
                                                <li> This is my session description </li>
                                                <li> Instructor: Sample Instructor </li>
                                            </ul> -->
                                        </div><!-- end post-sharing --> 
                                    </div><!-- end single-course-title -->
            
                                    <hr class="invis">
                                    
<section class="bgw clearfix">
            <div class="col-md-12 no-pd">
                <div class="content-widget">
                    <div class="accordion-widget">
                        <div class="accordion-toggle-2">
                        <div class="panel-group" id="accordion<?= $j ?>">
                        <?php 
                        $i = 1;
                        foreach($session['session_classes'] as $class) { 
                          // pr($class);exit;
                            ?>
                            
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <div class="panel-title">
                                            <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion<?= $j ?>" href="#collapse<?= $j.$i ?>">
                                                <h3>Class <?= $i ?> <i class="indicator fa fa-minus"></i></h3>
                                            </a>
                                        </div>
                                    </div>
                                    <div id="collapse<?= $j.$i ?>" class="panel-collapse collapse in">
                                        <div class="panel-body">
                                                <div class="row">
                                                    <div class="col-md-7 col-sm-6 col-xs-12">
                                                        <h4 class="short-heading"> Start Time</h4>  
                                                        <span class="time-shift"><?= $class['start_time'] ?></span>
                                                        &nbsp; &nbsp; &nbsp; &nbsp; <small> 
                                                        <?= $class['start_date']->format('D M d, Y'); ?>
                                                          </small>
                                                        
                                                        <h4 class="short-heading"> End Time</h4>    
                                                        <span class="time-shift"><?= $class['end_time'] ?></span>
                                                        &nbsp; &nbsp; &nbsp; &nbsp; <small> <?= $class['end_date']->format('D M d, Y'); ?></small>
                                                    <div class="clearfix"></div>
                                                  
                                                    </div><!-- end col -->
                                                    <div class="col-md-2 pull-right bigger"><!--<i class="fa fa-calendar-o" aria-hidden="true"></i> <span class="date"> 25 </span> -->  <p> <strong>Location: </strong> <?= ucfirst($class['venue']['Title']) ?> <br><?= ucfirst($class['venue']['description']) ?><br><?= ucfirst($class['venue']['address']) ?>,<?= ucfirst($class['venue']['city']) ?>,<?= ucfirst($class['venue']['postal_code']) ?></p></div> 
                                                </div><!-- end row -->                                                                          
                                        </div>
                                    </div>
                                </div>
                              
                            
                        <?php $i++;} ?>
                        </div>
                        </div><!-- accordion -->
                    </div><!-- end accordion-widget -->     
                </div><!-- end content-widget -->
            </div><!-- end col -->
</section><!-- end section -->
            
                                 <?php $j++; } ?>
                                
<hr class="invis1">

                        <div class="single-content comment-wrapper clearfix">
                            <div class="related-posts">
                                <div class="big-title">
                                    <h2 class="related-title">
                                        <span>  Student Review</span>
                                    </h2>
                                </div><!-- end big-title -->

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
                            </div><!-- end postpager -->
                        </div><!-- end content -->

                        
                        <div class="single-content comment-wrapper">
                            <div class="clearfix">
                                <div class="big-title">
                                    <h2 class="related-title">
                                        <span>Leave a Review</span>
                                    </h2>
                                </div><!-- end big-title -->
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
                                </div><!-- end commentform -->
                            </div><!-- end postpager -->
                        </div><!-- end content -->
                    </div><!-- end col -->
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