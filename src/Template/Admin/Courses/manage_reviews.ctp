<?php $this->assign('title','Manage Reviews') ?>
<?php $arrow = $this->Paginator->sortDir() === 'asc' ? 'up' : 'down'; ?>
<?= $this->Html->css('../admin/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css')?>
<?= $this->Html->css('../admin/vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css')?>
<?= $this->Html->css('../admin/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css')?>
<!--  <div class="row mtop15">
    <table width="100%" cellspacing="0" cellpadding="0" border="0" align="center">
                 <tr valign="top">
                   <td align="left" class="searchbox">
                     <div class="floatleft">
                     <?= $this->Form->create('Search') ?>
                           <table cellspacing="0" cellpadding="4" border="0">
                           <tr valign="top">
                               <td valign="middle" align="left" >
                               <?= $this->Form->input('Search.fullname',['label'=>false,'required'=>'required','style'=>'width:300px;','class'=>'input',]) ?>
                              </td>
                               <td valign="middle" align="left" >
                               <?= $this->Form->input('Search.search_by',['style'=>'width:300px;','class'=>'select','empty'=>false,'options'=>['name'=>'By Name','email'=>'Email']]) ?>
                             </td>
                               <td valign="middle" align="left"><div class="black_btn2"><span class="upper"><input type="submit" value="Search Chef" name=""></span></div></td>
                             </tr>
                         </table>
                         <?= $this->Form->end() ?>
                     </div>
                   </td>
               </tr>
    </table>
    </div>  -->
<div class="col-md-12 col-sm-12 col-xs-12">
<div class="x_panel">
    <div class="x_title">
        <h2>Manage Courses Reviews <small></small></h2>
        <!-- <ul class="nav navbar-right panel_toolbox">
            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
            </li>
            <li><a class="close-link"><i class="fa fa-close"></i></a>
            </li>
        </ul> -->
        <div class="clearfix"></div>
    </div>
    <div class="x_content">
        <div id="datatable-buttons_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
            <table id="datatable-buttons" class="table table-striped table-bordered dataTable no-footer dtr-inline" role="grid" >
                <thead>
                    <tr role="row">
                        <th class=""> Image </th>
                        <th class="" ><?= $this->Paginator->sort('Course.title',__('Course Name <i class="fa fa-arrow-'.$arrow.' aria-hidden="true"></i>'),['escape'=>false]) ?></th>
                        <th class="" ><?= $this->Paginator->sort('User.fullname',__('Review by <i class="fa fa-arrow-'.$arrow.' aria-hidden="true"></i>'),['escape'=>false]) ?></th>
                        <th class="" ><?= $this->Paginator->sort('message',__('Message by <i class="fa fa-arrow-'.$arrow.' aria-hidden="true"></i>'),['escape'=>false]) ?></th>
                        <th class="" ><?= $this->Paginator->sort('created',__('Created <i class="fa fa-arrow-'.$arrow.' aria-hidden="true"></i>'),['escape'=>false]) ?></th>
                        <th class="" ><?= $this->Paginator->sort('modified',__('Modified <i class="fa fa-arrow-'.$arrow.' aria-hidden="true"></i>'),['escape'=>false]) ?></th>
                        <th class="" ><?= $this->Paginator->sort('status',__('Status <i class="fa fa-arrow-'.$arrow.' aria-hidden="true"></i>'),['escape'=>false]) ?></th>
                        <th>Actions </th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(count(@$reviews)>0) { 
                        foreach ($reviews as $list) {
                          //$rnd = rand(0,10);
                        ?>
                    <tr>
                        <td> <input class="checkbox" type="checkbox" name="checkuser" value="<?= $list['id'] ?>"/> </td>
                        <td>
                            <a href="#"><?= ucfirst($list['course']['title']) ?></a>
                        </td>
                        <td> 
                            <a href="#"><?= ucfirst($list['user']['fullname']) ?></a>
                        </td>
                        <td>
                            <?= $list['message'] ?> <br>
                            <a href="<?= $list['website'] ?>" target="_blank"><?= $list['website'] ?> </a>
                        </td>
                        <td><?= $list['created']->format('d M, Y') ?> </td>
                        <td><?= $list['modified']->format('d M, Y') ?> </td>
                        <td><?php if($list['status']==0) { echo "pending"; } else if($list['status'] == 1){  echo "Approved"; } ?> </td>
                        <td> 
                            <?php if($list['status']==0) { ?>
                            <?= $this->Html->link('<i class="fa fa-check-circle" aria-hidden="true"></i> Approve',['action'=>'reviewup',$this->Common->myencode($list['id']),1],['class'=>'btn btn-success btn-xs','escape'=>false]) ?> 
                            <?php } else { ?>
                            <?= $this->Html->link('<i class="fa fa-times-circle" aria-hidden="true"></i> Reject',['action'=>'reviewup',$this->Common->myencode($list['id']),0],['class'=>'btn btn-danger btn-xs','escape'=>false]) ?> 
                            <?php } ?>
                            <?= $this->Html->link('<i class="fa fa-trash-o" aria-hidden="true"></i> Delete',['action'=>'reviewup',$this->Common->myencode($list['id']),'del'],['confirm'=>'Do you really want to delete this ?','class'=>'btn btn-danger btn-xs','escape'=>false]) ?>
                    </tr>
                    <?php } } else { ?>
                    <tr>
                        <td colspan="6"> No Records Found! </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <?= $this->element('paginator') ?>
    </div>
</div>
<?= $this->Html->script('../admin/vendors/datatables.net/js/jquery.dataTables.min.js')?>
<?= $this->Html->script('../admin/vendors/datatables.net/js/dataTables.bootstrap.min.js')?>
<?= $this->Html->script('../admin/vendors/datatables.net/js/dataTables.responsive.min.js')?>
<?= $this->Html->script('../admin/vendors/datatables.net/js/responsive.bootstrap.js')?>