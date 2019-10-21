<?php $this->assign('title', "Manage Companies") ?>
<div class="" style="display: inline-block;width: 100%">
    <!-- <div class="page-title">
        <div class="title_left">
          <h3><?=$title; ?></h3>
        </div>
        </div>
        <div class="clearfix"></div> -->
    <!-- <div class="row"> -->
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <!-- <h2>Manage Companies<small> <?=$title; ?></small></h2> -->
                <h2>Company Profile</h2>
                <!-- <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                    
                    <li><a class="close-link"><i class="fa fa-close"></i></a>
                    </li>
                    </ul> -->
                <div class="clearfix"></div>
            </div>
            <div class="x_content" >
                <div class="" style="border:0px red solid; width: 100%; ">
                    <div style=" " class="col-md-2">                       
                        <?php 
                            if ($company['logo']) {
                                $img = BASEURL . 'uploads/' . $company['logo'];
                            } else {
                                $img = BASEURL . "images/imgplaceholder.jpg";
                            } 
                        ?>
                        <?=$this->Html->image($img, ['height' => "100px", 'class' => 'img_preview']) ?>
                    </div>
                    <div style="" class="col-md-10">
                        <!-- <label><?= ucfirst($company->company_name) ?></label> -->
                        <h2><?= ucfirst($company->company_name) ?></h2>
                        <p><b>Description: </b> <?= ucfirst($company->description) ?></p>
                        <p><b>White Labelling: </b> <?= ($company->is_whitelabel == 1) ? 'Enabled':'Disabled' ?></p>
                        <p><b>Date: </b> <?= $company['created']->format('M d, Y') ?></p>
                    </div>
                </div>

                <!-- <h2>Courses</h2> -->

                <div class="col-md-12 col-sm-12 col-xs-12 profile-block">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Courses List <small>( Total: <?= count($courses) ?> Courses )</small></h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-down"></i></a>
                                </li>
                                <li><a class="close-link"><i class="fa fa-close"></i></a>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div> 
                        <div class="x_content" style="display: none;">
                            <div class="dashboard-widget-content">
                                <div class="col-md-41 hidden-small">
                                    <h2 class="line_30">  </h2>
                                    <table class="countries_list">
                                        <thead>
                                            <tr>
                                                <td><b>Course Name</b></td>
                                                <td><b>Type</b></td>
                                                <td><b>Date</b></td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            if(!empty($courses)){ //pr($courses);
                                                foreach($courses as $value):?>
                                                <tr>
                                                    <td>
                                                        <?php 
                                                            if($value['type'] == 1){
                                                              $updatelink = ['controller'=>'courses','action'=>'update',$this->Common->myencode($value['id'])];
                                                            } else if($value['type'] == 2){
                                                              $updatelink = ['controller'=>'courses','action'=>'instructor_course',$this->Common->myencode($value['id'])];
                                                            }
                                                        ?>
                                                        <?= $this->Html->link(ucfirst($value['title']),$updatelink) ?>
                                                    </td>
                                                    <td>
                                                        <?php 
                                                        if($value['type'] == 1) {
                                                            if($value['online_course_type'] == 2) {
                                                                echo "Competence Course";
                                                            } else{
                                                                echo "Online Course";
                                                            }
                                                        } else { 
                                                            echo "Instructor Course";
                                                        }?>
                                                    </td>
                                                    <td><?= $value['created']->format('M d, Y') ?></td>
                                                </tr>
                                            <?php endforeach;
                                            } else{ ?>
                                            <tr>
                                                <td colspan="2">No courses found</td>
                                            </tr>
                                            <?php } ?>
                                            </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 col-sm-12 col-xs-12 profile-block">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Managers List <small>( Total: <?= count($managers) ?> Managers )</small></h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-down"></i></a>
                                </li>
                                <li><a class="close-link"><i class="fa fa-close"></i></a>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content" style="display: none;">
                            <div class="dashboard-widget-content">
                                <div class="col-md-41 hidden-small">
                                    <h2 class="line_30">  </h2>
                                    <table class="countries_list">
                                        <thead>
                                            <tr>
                                                <td class="w-20"><b>Name</b></td>
                                                <td class="w-20"><b>User Name</b></td>
                                                <td class="w-20"><b>Email</b></td>
                                                <td class="w-20"><b>Phone</b></td>
                                                <td class="w-20"><b>Date</b></td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            if(!empty($managers)){ //pr($managers);
                                                foreach($managers as $value):?>
                                                <tr>
                                                    <td>
                                                        <?= $this->Html->link(ucfirst($value['fname']).' '.$value['lname'],['controller'=>'Users','action'=>'update',$value['id'] ]) ?>
                                                    </td>
                                                    <td><?= $value['username'] ?></td>
                                                    <td><?= $value['email'] ?></td>
                                                    <td><?= $value['phone'] ?></td>
                                                    <td><?= $value['created']->format('M d, Y') ?></td>
                                                </tr>
                                            <?php endforeach;
                                            } else{ ?>
                                            <tr>
                                                <td colspan="2">No Managers Found</td>
                                            </tr>
                                            <?php } ?>
                                            </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 col-sm-12 col-xs-12 profile-block">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Instructors List <small>( Total: <?= count($instructors) ?> Instructors )</small></h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-down"></i></a>
                                </li>
                                <li><a class="close-link"><i class="fa fa-close"></i></a>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content" style="display: none;">
                            <div class="dashboard-widget-content">
                                <div class="col-md-41 hidden-small">
                                    <h2 class="line_30">  </h2>
                                    <table class="countries_list">
                                        <thead>
                                            <tr>
                                                <td class="w-20"><b>Name</b></td>
                                                <td class="w-20"><b>User Name</b></td>
                                                <td class="w-20"><b>Email</b></td>
                                                <td class="w-20"><b>Phone</b></td>
                                                <td class="w-20"><b>Date</b></td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            if(!empty($instructors)){ 
                                                foreach($instructors as $value):?>
                                                <tr>
                                                    <td>
                                                        <?= $this->Html->link(ucfirst($value['fname']).' '.$value['lname'],['controller'=>'Users','action'=>'update',$value['id'] ]) ?>
                                                    </td>
                                                    <td><?= $value['username'] ?></td>
                                                    <td><?= $value['email'] ?></td>
                                                    <td><?= $value['phone'] ?></td>
                                                    <td><?= $value['created']->format('M d, Y') ?></td>
                                                </tr>
                                            <?php endforeach;
                                            } else{ ?>
                                            <tr>
                                                <td colspan="4">No Instructors Found</td>
                                            </tr>
                                            <?php } ?>
                                            </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 col-sm-12 col-xs-12 profile-block">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Learners List <small>( Total: <?= count($learners) ?> Learners )</small></h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-down"></i></a>
                                </li>
                                <li><a class="close-link"><i class="fa fa-close"></i></a>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content" style="display: none;">
                            <div class="dashboard-widget-content">
                                <div class="col-md-41 hidden-small">
                                    <h2 class="line_30">  </h2>
                                    <table class="countries_list">
                                        <thead>
                                            <tr>
                                                <td class="w-20"><b>Name</b></td>
                                                <td class="w-20"><b>User Name</b></td>
                                                <td class="w-20"><b>Email</b></td>
                                                <td class="w-20"><b>Phone</b></td>
                                                <td class="w-20"><b>Date</b></td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            if(!empty($learners)){ //pr($learners);
                                                foreach($learners as $value):?>
                                                <tr>
                                                    <td>
                                                        <?= $this->Html->link(ucfirst($value['fname']).' '.$value['lname'],['controller'=>'Users','action'=>'update_learner',$value['id'] ]) ?>
                                                    </td>
                                                    <td><?= $value['username'] ?></td>
                                                    <td><?= $value['email'] ?></td>
                                                    <td><?= $value['phone'] ?></td>
                                                    <td><?= $value['created']->format('M d, Y') ?></td>
                                                </tr>
                                            <?php endforeach;
                                            } else{ ?>
                                            <tr>
                                                <td colspan="4">No Learners Found</td>
                                            </tr>
                                            <?php } ?>
                                            </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 col-sm-12 col-xs-12 profile-block">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Enrollments List <small>( Total: <?= count($enrollments) ?> Enrollments )</small></h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-down"></i></a>
                                </li>
                                <li><a class="close-link"><i class="fa fa-close"></i></a>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content" style="display: none;">
                            <div class="dashboard-widget-content">
                                <div class="col-md-41 hidden-small">
                                    <h2 class="line_30">  </h2>
                                    <table class="countries_list" style="table-layout: fixed;">
                                        <thead>
                                            <tr>
                                                <td><b>Course Name</b></td>
                                                <td><b>Learner Name</b></td>
                                                <td><b>Username</b></td>
                                                <td><b>Progress(%)</b></td>
                                                <td><b>Enroll Method</b></td>
                                                <td><b>Enrolled Date</b></td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            if(!empty($enrollments)){ //pr($enrollments);
                                                foreach($enrollments as $value):?>
                                                <tr>
                                                    <td><?php 
                                                            if($value['course']['type'] == 1){
                                                              $updatelink = ['controller'=>'courses','action'=>'update',$this->Common->myencode($value['course']['id'])];
                                                            } else if($value['course']['type'] == 2){
                                                              $updatelink = ['controller'=>'courses','action'=>'instructor_course',$this->Common->myencode($value['course']['id'])];
                                                            }
                                                        ?>
                                                        <?= $this->Html->link(ucfirst($value['course']['title']),$updatelink) ?>
                                                    </td>
                                                    <td><?= $this->Html->link(ucfirst($value['user']['fname']).' '.$value['user']['lname'],['controller'=>'Users','action'=>'update_learner',$value['user']['id'] ]) ?></td>
                                                    <td><?= $value['user']['username'] ?></td>
                                                    <td>
                                                        <div class="skills text-left">
                                                            <div class="progress">
                                                                <?php $progress = $this->Common->getCourseProgress($value['course_id'],$value['user_id']); ?>
                                                                <div class="progress-bar" role="progressbar" data-transitiongoal="<?= $progress ?>" aria-valuenow="<?= $progress ?>" style="width:<?= $progress ?>%;"><span><?= $progress ?>%</span></div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <?php if($value['enroll_method'] == 1){
                                                                echo 'Direct Enrollment';
                                                            } else if($value['enroll_method'] == 2){
                                                                echo 'Key Enrollment';
                                                            }else{
                                                                echo 'Rule of course';
                                                            } 
                                                        ?>
                                                    </td>
                                                    <td><?= $value['created']->format('d M, Y'); ?></td>
                                                </tr>
                                            <?php endforeach;
                                            } else{ ?>
                                            <tr>
                                                <td colspan="4">No Enrollments Found</td>
                                            </tr>
                                            <?php } ?>
                                            </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- </div> -->
</div>
<?=$this->Html->script('../admin/vendors/ckeditor/ckeditor.js') ?>
<script>
    $(document).ready(function () {             
        $('#role').change(function(){
        var getrole = $(this).val();
      
        if(getrole == 2)
        {
          $('.whitelabeling').fadeIn();
        }
        else
        {
          $('.whitelabeling').hide();
        }
    
      });        
         
    
      $('#logo').change(function(){
        var reader = new FileReader();
        var ext = $(this).val().split('.').pop();
        ext = ext.toLowerCase();
        if(ext=='jpg' || ext=='jpeg'   || ext=='png' || ext=='gif')
        {
                 reader.onload = function (e) {
    
                  $('.img_preview').attr('src',e.target.result);
                  $('.img_preview').fadeIn();
                
                   
              }
              reader.readAsDataURL(this.files[0]);
        }
        else
        {
          //$('.img_preview').fadeOut();
        }
      });  
    });
</script>
