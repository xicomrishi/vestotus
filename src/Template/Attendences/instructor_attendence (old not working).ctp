<div id="sidebar1" class="col-md-9 col-sm-12">
<div class="widget clearfix">
<div class="member-profile">
<div class="big-title">
<h2 class="related-title">
<span>Manage Attendence </span>
</h2>
</div><!-- end big-title -->
        <?php $j=0; $i=0; ?>
<div class="edit-profile loginform">
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
                            <?= $class['start_date'] ?>
                              </small>
                            
                            <h4 class="short-heading"> End Time</h4>    
                            <span class="time-shift"><?= $class['end_time'] ?></span>
                            &nbsp; &nbsp; &nbsp; &nbsp; <small>  $class['end_date']->format('D M d, Y'); </small>
                            <div class="clearfix"></div>
                      
                        </sdiv><!-- end col -->
                        <div class="col-md-2 pull-right bigger">
                        <?php if($startdttime < time()) { ?>
                        <?= $this->Html->link('Attendence',['controller'=>'Attendences','action'=>'mark',$this->Common->myencode($session->course_id),$this->Common->myencode($session->id),$this->Common->myencode($class->id)],['class'=>'btn']) ?>
                        <?php } ?>
                         <p> <strong>Location: </strong> <?= ucfirst($class['venue']['Title']) ?> <br><?= ucfirst($class['venue']['description']) ?><br><?= ucfirst($class['venue']['address']) ?>,<?= ucfirst($class['venue']['city']) ?>,<?= ucfirst($class['venue']['postal_code']) ?></p></div> 
                    </div><!-- end row -->                                                                          
            </div>
        </div>
    </div>
                              
</div><!-- end edit profile -->
</div><!-- end team-member -->
</div>
</div>

