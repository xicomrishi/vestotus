<?php use Cake\I18n\Time; ?>
<div id="post-content" class="col-md-9 col-sm-12 single-course pull-right">
    <div class="big-title">
        <h2 class="related-title">
            <span> Sessions</span>
        </h2>
    </div>
    <?php   $j = 1;
        foreach($course as $session) { 
        ?>
    <div class="single-course-title">
        <h3><a href="" title="">Session <?= $j ?> : <?= ucfirst($session['title']) ?> </a></h3>
        <div class="post-sharing">
            <?= ucfirst($session['description']) ?>
            <?= (!empty($session['notes'])) ? '<br><strong>Notes: </strong>'.ucfirst($session['notes']) : '' ?>
            <!--<ul class="">
                <li> This is my session description </li>
                <li> Instructor: Sample Instructor </li>
                </ul> -->
        </div>
        <!-- end post-sharing --> 
    </div>
    <!-- end single-course-title -->
    <!-- <hr class="invis"> -->
    <section class="bgw clearfix">
        <div class="col-md-12 no-pd">
            <div class="content-widget">
                <div class="accordion-widget">
                    <div class="accordion-toggle-2">
                        <div class="panel-group" id="accordion<?= $j ?>">
                            <?php 
                                $i = 1;
                                foreach($session['session_classes'] as $class) { 
                                    $startdttime= $class['start_date']->format('Y-m-d').' '.$class['start_time'];
                                    $startdttime = strtotime($startdttime);
                                
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
                                            </div>
                                            <!-- end col -->
                                            <div class="col-md-5 pull-right bigger">
                                                <?php if($startdttime < time()) {
                                                    //if session has beeen started then show its attendance option
                                                ?>
                                                    <?= $this->Html->link('Attendence',['controller'=>'Attendences','action'=>'mark',$this->Common->myencode($session->course_id),$this->Common->myencode($session->id),$this->Common->myencode($class->id)],['class'=>'btn btn-primary']) ?>
                                                <?php } ?>
                                                <p> <strong>Location: </strong> <?= ucfirst($class['venue']['Title']) ?> <br><?= ucfirst($class['venue']['description']) ?><br><?= ucfirst($class['venue']['address']) ?>,<?= ucfirst($class['venue']['city']) ?>,<?= ucfirst($class['venue']['postal_code']) ?></p>
                                            </div>
                                        </div>
                                        <!-- end row -->                                                                          
                                    </div>
                                </div>
                            </div>
                            <?php $i++;} ?>
                        </div>
                    </div>
                    <!-- accordion -->
                </div>
                <!-- end accordion-widget -->     
            </div>
            <!-- end content-widget -->
        </div>
        <!-- end col -->
    </section>
    <!-- end section -->
    <?php $j++; } ?>
    <hr class="invis1">
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

