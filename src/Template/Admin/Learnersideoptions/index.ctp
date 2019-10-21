<?php $this->assign('title','Manage Users') ?>
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
                      <h2>Search Users <small></small></h2>
                     
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
              <div class="x_content">
                  <div id="datatable-buttons_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                      <table id="datatable-buttons" class="table table-striped table-bordered dataTable no-footer dtr-inline" role="grid" >
                          <thead>
                              <tr role="row">
                                  <th class="" >Picture</th>
                                  <th class="" ><?= $this->Paginator->sort('fullname',__('name <i class="fa fa-arrow-'.$arrow.' aria-hidden="true"></i>'),['escape'=>false]) ?></th>
                                  <th class="" ><?= $this->Paginator->sort('email',__('Email <i class="fa fa-arrow-'.$arrow.' aria-hidden="true"></i>'),['escape'=>false]) ?></th>
                                  <th class="" ><?= $this->Paginator->sort('username',__('Username <i class="fa fa-arrow-'.$arrow.' aria-hidden="true"></i>'),['escape'=>false]) ?></th>
                                  <th class="" ><?= $this->Paginator->sort('created',__('Date <i class="fa fa-arrow-'.$arrow.' aria-hidden="true"></i>'),['escape'=>false]) ?></th>
                                  <th>Actions </th>
                              </tr>
                          </thead>
                          <tbody>
                          <?php 
                          $i = 1;
                          foreach($learners as $list) {
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
                                  <td tabindex="0" class="sorting_1"><?= ucfirst($list['fullname']) ?></td>
                                  <td><?= $list['email'] ?></td>
                                  <td><?= $list['username'] ?></td>
                                  <td><?= $list['created']->format('M d, Y') ?></td>
                                  <td>
                                      <a href="javascript:void(0)" class="btn btn-default approveexam" data-id="<?php echo $list['id']; ?>" >Approve exam</a>
                                      <a href="javascript:void(0)" class="btn btn-default completecourse"  data-id="<?php echo $list['id']; ?>">Complete a  course</a>
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
  <?= $this->Html->script('../admin/vendors/datatables.net/js/jquery.dataTables.min.js')?>

  <div class="modal fade" id="myModal" role="dialog">
      <div class="modal-dialog">
          <div class="modal-content">
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Modal Header</h4>
              </div>
              <div class="modal-body">
                  <p>Some text in the modal.</p>
              </div>
          </div>
      </div>
  </div>         
<script>
$(function(){
   $('#upload').change(function(){
      $('#uploadForm').submit(); 
   });
});
</script>  

<script>
$(document).ready(function(){
    $(".approveexam").on('click', function(){
        var learnerid=$(this).data('id');
        var url='<?php echo $this->request->webroot; ?>/admin/learnersideoption';
        //$("#myModal").modal('show');
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