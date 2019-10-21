
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
                    <h2>Quiz List<small></small></h2> <!-- Competence Courses -->
                   
                   
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
              
                        <th class="" ><?= $this->Paginator->sort('created',__('Date <i class="fa fa-arrow-'.$arrow.' aria-hidden="true"></i>'),['escape'=>false]) ?></th>
                 
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
                        
                          <td><?= $list['created']->format('M d, Y') ?></td>
                         
                          <td>
                         
                                
                            <?= $this->Html->link('<i class="fa fa-eye"></i> Assessments',['action'=>'assessments',$list['id']],['escape'=>false,'class'=>'btn btn-info btn-xs']) ?>
                               <?= $this->Html->link('<i class="fa fa-eye"></i> Assessment Results',['action'=>'results',$list['id']],['escape'=>false,'class'=>'btn btn-info btn-xs']) ?>
                          
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
 
   
           