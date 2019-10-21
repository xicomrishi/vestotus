<?php $this->assign('title','Manage Users') ?>
<?php $arrow = $this->Paginator->sortDir() === 'asc' ? 'up' : 'down'; ?>
<div class="">
    <div class="row">
        <div class="x_panel">
            <div class="x_title">
                <h2>Users Access List <small>Login Report</small></h2>
                <?= $this->Form->create('Users',['type'=>'file','id'=>'uploadForm']) ?>
                <!-- <ul class="nav navbar-right panel_toolbox">
                    <li> <?= $this->Html->link('<i class="fa fa-plus"></i> Add New',['action'=>'update'],['escape'=>false,'class'=>'btn btn-primary','style'=>'color:#fff;']) ?></li>
                    <li>
                        <div class="upload-btn-wrapper">
                            <button class="btn"><i class="fa fa-user"></i> Import Users</button>
                            <input id="upload" type="file" name="file" />
                        </div>
                    </li>
                    <li>
                        <a href="<?= $this->request->webroot ;?>sample.csv">Import Sample File</a>
                    </li>
                    
                </ul> -->

                
                <?= $this->Form->end() ?>

                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div id="datatable-buttons_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                    <table id="datatable-buttons" class="table table-striped table-bordered dataTable no-footer dtr-inline" role="grid" >
                        <thead>
                            <tr role="row">
                                <th>Full Name </th>
                                <th>Username </th>
                                <th>Login DateTime </th>
                                <th>Login IP </th>
                                <th>Logout DateTime</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(count($list)>0) { 
                                foreach ($list as $list) {
                                  $rnd = rand(0,10);
                                ?>
                            <tr>
                                <td>
                                    <a href="#"><?= $getuser['fname'].' '.$getuser['lname'] ?></a>
                                </td>
                                <td> <a href="#"><?= $getuser['username'] ?></a> </td>
                                <td> 
                                    <a href="#"><?= $list['login_time']->format('d M, Y h:i:s') ?></a>
                                </td>
                                <td> <a href="#"><?= $list['ip'] ?></a> </td>
                                <td> 
                                    <a href="#"><?= ($list['logout_time']) ? $list['logout_time']->format('d M, Y h:i:s') : 'Session Timeout' ?></a>
                                </td>
                                <?php } } else { ?>
                            <tr>
                                <td colspan="5"> No Record Found! </td>
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
</style>