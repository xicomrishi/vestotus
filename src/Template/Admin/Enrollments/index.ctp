<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
<script>
    $(document).ready(function(){
        var date_input=$('.date');
        var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
        date_input.datepicker({
            format: 'd M, yyyy',
            container: container,
            todayHighlight: true,
            autoclose: true,
        })
    })
</script>
<?php $arrow = $this->Paginator->sortDir() === 'asc' ? 'up' : 'down'; ?>
<?= $this->Html->css('../admin/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css')?>
<?= $this->Html->css('../admin/vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css')?>
<?= $this->Html->css('../admin/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css')?>
<?php
    $controller=new App\Controller\AppController();
    $departments=$controller->departments();
    $courses=$controller->courses();
    ?>
<div class="">
    <div class="row">
        <div class="x_panel">
            <div class="row col-md-12">
                <div class="x_title">
                    <h2>Filter Enrollments <small></small></h2>
                    <div class="clearfix"></div>
                </div>
                <?= $this->Form->create('filters',['type'=>'get']) ?>
                <div class="col-md-12 date-picker">
                    <div class="form-group col-md-3 date" id="datetimepicker1">
                        <input type="text" class="form-control" placeholder="Start Date" name="start_date">
                        <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                    <div class="form-group col-md-3 date" id="datetimepicker2">
                        <input type="text" class="form-control" placeholder="End Date" name="end_date">
                        <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                    <div class="form-group col-md-3">
                        <input type="text" class="form-control" placeholder="Search Title..." name="search_text">
                    </div>
                    <div class="form-group col-md-3">
                        <input type="submit" value="Search" class="btn  btn-primary" name="">
                    </div>
                </div>
                <?= $this->Form->end() ?>
            </div>
        </div>
        <div class="x_panel">
            <div class="x_title">
                <h2>Enrollments<small></small></h2>
                <?= $this->Form->create('Users',['type'=>'file','id'=>'uploadForm']) ?>
                <ul class="nav navbar-right panel_toolbox">
                    <li> <?= $this->Html->link('<i class="fa fa-plus"></i> Add New',['action'=>'enrollUsers'],['escape'=>false,'class'=>'btn btn-primary','style'=>'color:#fff;']) ?></li>
                    <li>
                        <?php if($archieved == 'true'){ ?>
                            <a href="?archieved=false" class="btn btn-primary" style="color:#fff;"><i class="fa fa-check-circle"></i> View Regular Users</a>
                        <?php } else { ?>
                            <a href="?archieved=true" class="btn btn-primary" style="color:#fff;"><i class="fa fa-trash"></i> View Archieved</a>
                        <?php } ?>
                    </li>
                </ul>
                <?= $this->Form->end() ?>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div id="datatable-buttons_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                    <table id="datatable-buttons" class="table table-striped table-bordered dataTable no-footer dtr-inline" role="grid" >
                        <thead>
                            <tr>
                                <th>Course Name </th>
                                <th>Learner Name </th>
                                <th>Username </th>
                                <th>Progress(%)</th>
                                <th>Enrolled Date</th>
                                <th>Enroll Method</th>
                                <th>Actions </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(count($list)>0) { 
                                foreach ($list as $list) {
                                        //pr($list);exit;
                                        $progress = $this->Common->getCourseProgress($list['course_id'],$list['user_id']);
                                ?>
                            <tr>
                                <td>
                                    <?= ucwords($list['course']['title']) ?>
                                </td>
                                <td><?= $list['user']['fname'].' '.$list['user']['lname'] ?></td>
                                <td> <?= $list['user']['username'] ?></td>
                                <td>
                                    <div class="skills text-left">
                                        <div class="progress">
                                            <div class="progress-bar" role="progressbar" data-transitiongoal="<?= $progress ?>" aria-valuenow="<?= $progress ?>" style="width:<?= $progress ?>%;"><span><?= $progress ?>%</span></div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <?= $list['created']->format('d M, Y'); ?>
                                </td>
                                <td>
                                    <?php if($list['enroll_method'] == 1){
                                        echo 'Direct Enrollment';
                                        } else if($list['enroll_method'] == 2){
                                        echo 'Key Enrollment';
                                        }else{
                                        echo 'Rule of course';
                                        } 
                                        ?>
                                </td>
                                <td> 
                                    <?= $this->Html->link('<i class="fa fa-trash-o" aria-hidden="true"></i>',['action'=>'delenrollment',$this->Common->myencode($list['id'])],['class'=>'delete','confirm'=>'Do you really want to delete it?','escape'=>false]) ?>
                                    <!-- $this->Html->link('<i class="fa fa-clock-o" aria-hidden="true"></i>',['action'=>'viewAttendance',$this->Common->myencode($list['course_id']),$this->Common->myencode($list['user_id']) ],['escape'=>false])  -->
                            </tr>
                            <?php } } else { ?>
                            <tr>
                                <td colspan="5"> No Records Found! </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                <?= $this->element('paginator') ?>
            </div>
        </div>
    </div>
</div>
<?= $this->Html->script('../admin/vendors/datatables.net/js/jquery.dataTables.min.js')?>
<script>
    $(function(){
       $('#upload').change(function(){
          $('#uploadForm').submit(); 
       });
    });
</script>     
<style>
    .upload-btn-wrapper {
    position: relative;
    overflow: hidden;
    display: inline-block;
    }
    .upload-btn-wrapper input[type=file] {
    font-size: 100px;
    position: absolute;
    left: 0;
    top: 0;
    opacity: 0;
    }
    .input-group-addon {
    background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
    border: medium none;
    display: ruby;
    position: absolute;
    right: 13px !important;
    top: 3px;
    width: 10px;
</style>

