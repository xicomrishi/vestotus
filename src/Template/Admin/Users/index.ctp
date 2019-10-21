<?php $this->assign('title','Manage Users') ?>
<?php $arrow = $this->Paginator->sortDir() === 'asc' ? 'up' : 'down'; ?>
<?= $this->Html->css('../admin/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css')?>
<?= $this->Html->css('../admin/vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css')?>
<?= $this->Html->css('../admin/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css')?>
<?php
    $controller=new App\Controller\AppController();
    $departments=$controller->departments();
    $courses=$controller->courses();
    // echo BASEURL.'/admin/users/generate_learner_credentials';
     // echo '1'; die; -->
?>
<div class="">
    <div class="row">
        <div class="x_panel">
            <div class="row col-md-12">
                <div class="x_title">
                    <h2>Search Users <small></small></h2> <!-- ucfirst($type).'s' -->
                    <div class="clearfix"></div>
                </div>
                <?= $this->Form->create('Search') ?>
                <div class="form-group col-md-3">
                    <?= $this->Form->input('Search.fullname',['label'=>false,'required'=>'required','style'=>'width:300px;','class'=>'form-control','placeholder'=>'Search Text']) ?>
                </div>
                <div class="form-group col-md-3">
                    <?= $this->Form->input('Search.search_by',['label'=>false,'style'=>'width:300px;','class'=>'form-control','options'=>['empty'=>'Search By','name'=>'By Name','email'=>'Email']]) ?>
                </div>
                <div class="form-group col-md-3">
                    <input type="submit" value="Search" class="btn  btn-primary" name="">
                </div>
                <?= $this->Form->end() ?>
            </div>
        </div>
        <div class="x_panel">
            <div class="x_title">
                <h2>Users List <small></small></h2>
                <?= $this->Form->create('Users',['type'=>'file','id'=>'uploadForm']) ?>
                <ul class="nav navbar-right panel_toolbox">
                    <li> <?= $this->Html->link('<i class="fa fa-plus"></i> Add New',['action'=>'update'],['escape'=>false,'class'=>'btn btn-primary','style'=>'color:#fff;']) ?></li>
                    <li>
                        <?php if($archieved == 'true'){ ?>
                            <a href="?archieved=false" class="btn btn-primary" style="color:#fff;"><i class="fa fa-check-circle"></i> View Regular Users</a>
                        <?php } else { ?>
                            <a href="?archieved=true" class="btn btn-primary" style="color:#fff;"><i class="fa fa-trash"></i> View Archieved</a>
                        <?php } ?>
                    </li>
                    <li>
                        <div class="upload-btn-wrapper">
                            <button class="btn"><i class="fa fa-user"></i> Import Users</button>
                            <input id="upload" type="file" name="file" />
                        </div>
                    </li>
                    <li>
                        <a href="<?= $this->request->webroot ;?>sample.csv">Sample File</a>
                    </li>
                    <li>
                        <div class="page-toolbar">
                            <div class="btn-group pull-right m-t-20 m-r-20">
                                <button class="btn btn-primary dropdown-toggle m-t-b-5" data-toggle="dropdown" type="button">
                                Reports
                                <i class="fa fa-angle-down"></i>
                                </button>
                                <ul class="dropdown-menu pull-right" role="menu">
                                    
                                    <li>
                                        <?= $this->Html->link('Active Users', BASEURL.'admin/users/export_users?Users.status=1') ?>
                                    </li>
                                    <li>
                                        <?= $this->Html->link('Inactive Users', BASEURL.'admin/users/export_users?Users.status=0') ?>
                                    </li>
                                    <li>
                                        <?= $this->Html->link('All Users', BASEURL.'admin/users/export_users') ?>
                                    </li>
                                    <li>
                                        <?= $this->Html->link('Users login logs', BASEURL.'admin/users/export_login_logs') ?>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </li>
                </ul>
                <?= $this->Form->end() ?>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div id="datatable-buttons_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                    <table id="datatable-buttons" class="table table-striped table-bordered dataTable no-footer dtr-inline" role="grid" >
                        <thead>
                            <tr role="row">
                                <th class="" >Picture</th>
                                <th class="" ><?= $this->Paginator->sort('lname',__('Last Name <i class="fa fa-arrow-'.$arrow.' aria-hidden="true"></i>'),['escape'=>false]) ?></th>
                                <th class="" ><?= $this->Paginator->sort('fname',__('First Name <i class="fa fa-arrow-'.$arrow.' aria-hidden="true"></i>'),['escape'=>false]) ?></th>
                                <th class="" ><?= $this->Paginator->sort('email',__('Email <i class="fa fa-arrow-'.$arrow.' aria-hidden="true"></i>'),['escape'=>false]) ?></th>
                                <th class="" ><?= $this->Paginator->sort('username',__('Username <i class="fa fa-arrow-'.$arrow.' aria-hidden="true"></i>'),['escape'=>false]) ?></th>
                                <th class="" ><?= $this->Paginator->sort('role',__('Type <i class="fa fa-arrow-'.$arrow.' aria-hidden="true"></i>'),['escape'=>false]) ?></th>
                                <th class="" > <?= $this->Paginator->sort('Company.company_name',__('Company <i class="fa fa-arrow-'.$arrow.' aria-hidden="true"></i>'),['escape'=>false]) ?> </th>
                                <th class="" > Departments</th>
                                <!-- <th class="" >Courses</th> -->
                                <th class="" ><?= $this->Paginator->sort('created',__('Date <i class="fa fa-arrow-'.$arrow.' aria-hidden="true"></i>'),['escape'=>false]) ?></th>
                                <th>Actions </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                $i = 1;
                                 foreach($list as $list) {
                                   if($i % 2 == 0)
                                   {
                                     $cl = 'even';
                                   }
                                   else
                                   {
                                     $cl = 'odd';
                                   }
                                
                                  ?>
                            <tr role="row" class="<?= $cl ?>">
                                <td align="center"> <?php if($list['avatar']) { echo $this->Html->image(BASEURL.'uploads/user_data/'.$list['avatar'],['width'=>'50px']); } else { echo '<i class="fa fa-user" aria-hidden="true" style="font-size:45px;"></i>';} ?> </td>

                                <!-- <td tabindex="0" class="sorting_1"><?= ucfirst($list['fullname']) ?></td> -->
                                <td ><?= ucfirst($list['lname']) ?></td>
                                <td ><?= ucfirst($list['fname']) ?></td>
                                <td><?= $list['email'] ?></td>
                                <td class="username"><?= $list['username'] ?></td>
                                <td> <?= $this->Common->get_user_type($list['role']) ?></td>
                                <td> <?= $list['company']['company_name'] ?></td>
                                <td> <?php 
                                    $userDepart=[];
                                    if(!empty($list['user_departments'])){
                                        foreach($list['user_departments'] as $dp):
                                            
                                            $userDepart[]=$departments[$dp['department_id']];
                                        endforeach;
                                    ?> 
                                    <?php } 
                                        if(!empty($userDepart))
                                            echo implode(',',$userDepart);
                                        else {
                                            echo 'N/a';
                                        }
                                        ?>
                                </td>
                                <!-- <td> <?php 
                                    $userDepart=[];
                                    if(!empty($list['user_courses'])){
                                        foreach($list['user_courses'] as $dp):
                                            $userDepart[]=$courses[$dp['course_id']];
                                        endforeach;
                                    ?> 
                                    <?php } 
                                        if(!empty($userDepart))
                                              echo implode(',',$userDepart);
                                          else {
                                              echo 'N/a';
                                          }
                                          ?>
                                </td> -->
                                <td><?= $list['created']->format('M d, Y') ?></td>
                                <td>
                                    <?= $this->Html->link('<i class="fa fa-key"></i> Access Logs',[ 'action'=>'logs',$list['id']],['escape'=>false,'class'=>'btn btn-success btn-xs']); ?>
                                    
                                    <?php if($list['role']==4){ //user record
                                        echo $this->Html->link('<i class="fa fa-pencil"></i> Edit',[ 'action'=>'update_learner',$list['id']],['escape'=>false,'class'=>'btn btn-info btn-xs']);
                                        
                                            if($archieved != 'true'){ 
                                                echo $this->Html->link('<i class="fa fa-key"></i> Generate OTP','javascript:void(0)',['escape'=>false,'class'=>'btn btn-warning btn-xs gen-otp-btn', 'rel'=>$list['id']]);
                                            }

                                        }else{ ?>
                                    
                                    <?php if($list['role']==2){
                                        echo   $this->Html->link('<i class="fa fa-building"></i> Assign Department',[ 'action'=>'assign_department',$list['id']],['escape'=>false,'class'=>'btn btn-warning btn-xs']); 
                                        echo $this->Html->link('<i class="fa fa-user"></i> Assign Users',[ 'action'=>'assign_users',$list['id']],['escape'=>false,'class'=>'btn btn-success btn-xs']); ?>
                                    <?= $this->Html->link('<i class="fa fa-book"></i> Assign Courses',[ 'action'=>'assign_course',$list['id']],['escape'=>false,'class'=>'btn btn-warning btn-xs']); ?>
                                    <?php } ?> 

                                    <?php if($list['role']==3)
                                        // echo $this->Html->link('<i class="fa fa-book"></i> Assign Instructor Courses',[ 'action'=>'assign_courseins',$list['id']],['escape'=>false,'class'=>'btn btn-warning btn-xs']);
                                        echo $this->Html->link('<i class="fa fa-building"></i> Assign Venue',[ 'action'=>'assign_venue',$list['id']],['escape'=>false,'class'=>'btn btn-warning btn-xs']); 
                                        echo $this->Html->link('<i class="fa fa-pencil"></i> Edit',[ 'action'=>'update_learner',$list['id']],['escape'=>false,'class'=>'btn btn-info btn-xs']);           
                                    } ?>

                                    <?php if( ($list['status']==0) || ($list['status']==1) ){
                                        echo $this->Html->link('<i class="fa fa-trash"></i> Delete',['action'=>'delete',$list['id']],['escape'=>false,'class'=>'btn btn-danger btn-xs','confirm'=>'Do you want to delete '.$list['fullname']]);
                                    } ?>
                                </td>
                            </tr>
                            <?php $i++; } ?>
                        </tbody>
                    </table>
                </div>
                <?= $this->element('paginator') ?>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="OtpModal">
    <?= $this->Form->create('shareKey',['id'=>'shareKeyform','url'=>['action'=>'shareKey']]) ?>
    <?php $this->Form->templates($form_templates['frontForm']); ?>
    <?= $this->Form->hidden('id',['id'=>'keyid']) ?>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title">Please use the following credentials.</h5>
            </div>
            <div class="modal-body">
                <div class="modal-container">
                    <div class="form-group">
                        <label>User Name: <span class="username"></span></label>                        
                    </div>
                    <div class="form-group">
                        <label>Password: <span class="pass"></span></label>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel <i class="fa fa-ban" aria-hidden="true"></i> </button>
            </div>
        </div>
    </div>
    <?= $this->Form->end() ?>
</div>

<?= $this->Html->script('../admin/vendors/datatables.net/js/jquery.dataTables.min.js')?>
<script>
    $(function(){
       $('#upload').change(function(){
          $('#uploadForm').submit(); 
       });

       $('.gen-otp-btn').on('click', function(){ 
            var user_id = $(this).attr('rel');
            var username = $(this).closest('tr').find('.username').text();

            $.post("<?= BASEURL.'/admin/users/generate_learner_credentials' ?>",{ user_id: user_id }, function(resp){
                if(resp['status'] == true){

                    var otpModal = $('#OtpModal');
                    otpModal.find('.pass').text(resp['otp']);
                    otpModal.find('.username').text(resp['username']);
                    otpModal.modal('show');
                } else{ 
                    alert('Some error occured, please try again later');
                }
            });
            // return false;
       }) 

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
</style>