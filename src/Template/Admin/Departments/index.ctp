<?php $this->assign('title','Manage Departments') ?>
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
                    <h2>Manage Departments  <small> List</small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    
                    <div id="datatable-buttons_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">


                    <table id="datatable-buttons" class="table table-striped table-bordered dataTable no-footer dtr-inline" role="grid" >
                      <thead>
                        <tr role="row">
                        <th class="" ><?= $this->Paginator->sort('title',__('Title <i class="fa fa-arrow-'.$arrow.' aria-hidden="true"></i>'),['escape'=>false]) ?></th>
                        <th class="" ><?= $this->Paginator->sort('parent_id',__('Parent  <i class="fa fa-arrow-'.$arrow.' aria-hidden="true"></i>'),['escape'=>false]) ?></th>
                        <th class="" ><?= $this->Paginator->sort('status',__('Status <i class="fa fa-arrow-'.$arrow.' aria-hidden="true"></i>'),['escape'=>false]) ?></th>
                        <th class="" ><?= $this->Paginator->sort('modified',__('Date <i class="fa fa-arrow-'.$arrow.' aria-hidden="true"></i>'),['escape'=>false]) ?></th>
                        <th class="" ><?= $this->Paginator->sort('Users.fname',__('Owner <i class="fa fa-arrow-'.$arrow.' aria-hidden="true"></i>'),['escape'=>false]) ?></th>
                        <th>Actions </th></tr>
                      </thead>


                      <tbody>
                 <?php 
                 $i = 1;
                  foreach($list as $list) {

                    $lid = $this->Common->myencode($list['id']);
                    if($i % 2 == 0)
                    {
                      $cl = 'even';
                    }
                    else
                    {
                      $cl = 'odd';
                    }

                   ?>
                  <tr role="row" class="<?= $cl ?>" id="<?= $list['id']?>">
                          <td tabindex="0" class="sorting_1"><?= ucfirst($list['title']) ?></td>
                          <td><?= $list['parent_category']['title'] ?></td>
                          <td><?= $status = $list['status'] ? "Active" : "De-Active" ?></td>
                          <td><?= $list['modified']->format('M d, Y') ?></td>
                          <td><?= ucfirst($list['user']['fullname']) ?></td>
                          <td>
                            <?php echo $this->Html->link('<i class="fa fa-pencil"></i> Edit',['action'=>'form',$list['id']],['escape'=>false,'class'=>'btn btn-info btn-xs']) ?>
                            <?= $this->Html->link('<i class="fa fa-trash"></i> Delete',['action'=>'delete',$lid],['escape'=>false,'class'=>'btn btn-danger btn-xs','confirm'=>'Do you want to delete course '.strtoupper($list['title'])]) ?>
                          </td>
                          

                        </tr>
                  <?php $i++; } ?>
                    </tbody>
                    </table></div>
                  <?= $this->element('paginator') ?>
                </div>
              </div>

               <?= $this->Html->script('../admin/vendors/datatables.net/js/jquery.dataTables.min.js')?>
               <?= $this->Html->script('../admin/vendors/datatables.net/js/dataTables.bootstrap.min.js')?>
               <?= $this->Html->script('../admin/vendors/datatables.net/js/dataTables.responsive.min.js')?>
               <?= $this->Html->script('../admin/vendors/datatables.net/js/responsive.bootstrap.js')?>
 
   
           