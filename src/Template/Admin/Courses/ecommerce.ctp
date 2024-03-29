<?php $this->assign('title','Purchased Courses') ?>
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
                    <h2> Ecommerce Courses  <small></small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <!-- <li> <?= $this->Html->link('<i class="fa fa-plus"></i> Add Online Course',['action'=>'update'],['escape'=>false,'class'=>'btn btn-primary','style'=>'color:#fff;']) ?></li>
                      <li> <?= $this->Html->link('<i class="fa fa-plus"></i> Add Instructor led Course',['action'=>'instructor_course'],['escape'=>false,'class'=>'btn btn-primary','style'=>'color:#fff;']) ?></li>
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li> -->
                      <?php if($deleted == 'true') { ?>
                      <li> <?= $this->Html->link('<i class="fa fa-check-circle"></i> View Regular Courses',BASEURL.'admin/courses/ecommerce',['escape'=>false,'class'=>'btn btn-primary','style'=>'color:#fff;']) ?></li>
                      <?php } else{ ?>
                      <li> <?= $this->Html->link('<i class="fa fa-trash"></i> View Archieved Courses',BASEURL.'admin/courses/ecommerce?deleted=true',['escape'=>false,'class'=>'btn btn-primary','style'=>'color:#fff;']) ?></li>
                      <?php } ?>

                      <!-- <li><a class="close-link"><i class="fa fa-close"></i></a></li> -->
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    
                    <div id="datatable-buttons_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">


                    <table id="datatable-buttons" class="table table-striped table-bordered dataTable no-footer dtr-inline" role="grid" >
                      <thead>
                        <tr role="row">
                        <th class=""> Image </th>
                        <th class="" ><?= $this->Paginator->sort('title',__('Title <i class="fa fa-arrow-'.$arrow.' aria-hidden="true"></i>'),['escape'=>false]) ?></th>
                        <th class="" ><?= $this->Paginator->sort('type',__('Type <i class="fa fa-arrow-'.$arrow.' aria-hidden="true"></i>'),['escape'=>false]) ?></th>
                        <th class="" ><?= $this->Paginator->sort('purchase_price',__('Price <i class="fa fa-arrow-'.$arrow.' aria-hidden="true"></i>'),['escape'=>false]) ?></th>
                        <th class="" ><?= $this->Paginator->sort('user_id',__('Manager <i class="fa fa-arrow-'.$arrow.' aria-hidden="true"></i>'),['escape'=>false]) ?></th>
                        <th class="" ><?= $this->Paginator->sort('created',__('Date <i class="fa fa-arrow-'.$arrow.' aria-hidden="true"></i>'),['escape'=>false]) ?></th>
                        <th class=""> Approved </th>
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
                          <td > <?php if($list['thumbnail']) { echo $this->Html->image(FILE_COURSE_THUMB.$list['thumbnail'],['width'=>'50px']); } else { echo '<i class="fa fa-user" aria-hidden="true" style="font-size:45px;"></i>';} ?> </td>
                          <td tabindex="0" class="sorting_1"><?= ucfirst($list['title']) ?></td>
                          <td><?php if($list['type'] == 1) {echo "Online Course";} else { echo "Instructor Course";}?></td>

                          <td>$ <?= $list['purchase_price'] ?> <br> <?= $this->Html->link('See Price',['action'=>'coursePrice',$this->Common->myencode($list['id'])],['id'=>$list['title'].'_'.$list['id'],'class'=>'cprice']) ?></td>
                          
                          <td><?= ucfirst($list['user']['fullname']) ?></td>
                          
                          <td><?= $list['created']->format('M d, Y') ?></td>
                          <td><?php
                              if($list['admin_approved'] == 1) {echo 'Approved';} 
                              else if($list['admin_approved'] == 2) {echo 'Un-Approved';} 
                              else if($list['admin_approved'] == 0) {echo 'Pending';} 
                              ?><?php //$this->Common->get_enrolled_users($list['id']) ?>
                          </td>
                            
                          <!-- <td>
                          <?php
                              if($list['admin_approved'] == 1) 
                              {
                                  echo '<a href="#" class="btn btn-success btn-xs  btn-block">Approved</a>';
                              } 
                              else if($list['admin_approved'] == 2) 
                              {
                                  echo '<a href="#" class="btn btn-danger btn-xs  btn-block">Un-Approved</a>';
                              } 
                              else if($list['admin_approved'] == 0) 
                              {
                                  echo '<a href="#" class="btn btn-warning btn-xs  btn-block">Pending</a>';
                              } 
                              $this->Common->get_enrolled_users($list['id']) ?></td> -->
                          <td>
                          <?php 
                          if($list['type'] == 1)
                          {
                            $updatelink = ['action'=>'update',$this->Common->myencode($list['id'])];
                          }
                          else if($list['type'] == 2)
                          {
                            $updatelink = ['action'=>'instructor_course',$this->Common->myencode($list['id'])];
                          }

                          ?>
                            <?= $this->Html->link('<i class="fa fa-pencil"></i> Edit',$updatelink,['escape'=>false,'class'=>'btn btn-info btn-xs']) ?>
                            
                            <?php if($deleted !== 'true') { ?>
                            <?= $this->Html->link('<i class="fa fa-trash"></i> Delete',['action'=>'delete',$lid],['escape'=>false,'class'=>'btn btn-danger btn-xs','confirm'=>'Do you want to delete course '.strtoupper($list['title'])]) ?>
                            <?php } ?>
                                                        
                            <?php
                            if($list['admin_approved'] == 1) 
                            { 
                              echo $this->Html->link('<i class="fa fa-ban"></i> Un-Approve',['action'=>'adminApproved',$list['id'],2],['class'=>'btn btn-danger btn-xs','escape'=>false]); 
                            } 
                            else if($list['admin_approved'] == 2) 
                            { 
                              echo $this->Html->link('<i class="fa fa-check"></i> Approve',['action'=>'adminApproved',$list['id'],1],['class'=>'btn btn-success btn-xs','escape'=>false]);
                            } 
                            else if($list['admin_approved'] == 0) 
                            {
                              echo $this->Html->link('<i class="fa fa-check"></i> Approve',['action'=>'adminApproved',$list['id'],1],['class'=>'btn btn-success btn-xs ','escape'=>false]);
                              echo $this->Html->link('<i class="fa fa-ban"></i> Un-Approve',['action'=>'adminApproved',$list['id'],2],['escape'=>false,'class'=>'btn btn-danger btn-xs']);
                            } 
                          ?>
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
 
   