<?php $arrow = $this->Paginator->sortDir() === 'asc' ? 'up' : 'down'; ?>


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

  <div>
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Manage Chapters  <small></small></h2>

                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">

                    <div id="datatable-buttons_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">


                    <table id="datatable-buttons" class="table table-striped table-bordered dataTable no-footer dtr-inline" role="grid" >
                      <thead>
                        <tr role="row">

                        <th class="" ><?= $this->Paginator->sort('title',__('Title <i class="fa fa-arrow-'.$arrow.' aria-hidden="true"></i>'),['escape'=>false]) ?></th>
                        <th class="" ><?= $this->Paginator->sort('description',__('Description <i class="fa fa-arrow-'.$arrow.' aria-hidden="true"></i>'),['escape'=>false]) ?></th>
                          <th class="" ><?= $this->Paginator->sort('type',__('Type <i class="fa fa-arrow-'.$arrow.' aria-hidden="true"></i>'),['escape'=>false]) ?></th>
                            <th class="" ><?= $this->Paginator->sort('file',__('File <i class="fa fa-arrow-'.$arrow.' aria-hidden="true"></i>'),['escape'=>false]) ?></th>
                              <th class="" ><?= $this->Paginator->sort('course',__('Course <i class="fa fa-arrow-'.$arrow.' aria-hidden="true"></i>'),['escape'=>false]) ?></th>
                              <th class="" ><?= $this->Paginator->sort('lesson_no',__('Lesson No <i class="fa fa-arrow-'.$arrow.' aria-hidden="true"></i>'),['escape'=>false]) ?></th>
                                <th class="" ><?= $this->Paginator->sort('pass_percent',__('Pass Percent <i class="fa fa-arrow-'.$arrow.' aria-hidden="true"></i>'),['escape'=>false]) ?></th>
                                  <th>Actions</th>

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
                          <td><?php echo (strlen($list['description']) > 100) ? substr($list['title'] , 0 , 100)  : $list['description']; ?></td>
                          <td><?= $list['type'] ?></td>
                          <td>
                            <?php if($list['type']=='ppt') { ?>
                                    <a href="<?= $this->request->webroot; ?>uploads/courses/ppt/<?= $list['files'] ?>"><?= $list['files'] ?></a>
                            <?php }else if($list['type']=='audio') { ?>
                                    <a href="<?= $this->request->webroot; ?>uploads/courses/audio/<?= $list['files'] ?>"><?= $list['files'] ?></a>
                            <?php }else if($list['type']=='video') { ?>
                                    <a href="<?= $this->request->webroot; ?>uploads/courses/videos/<?= $list['files'] ?>"><?= $list['files'] ?></a>
                            <?php }else{ echo 'n/a' ; } ?>
                          </td>
                            <td><?php if($list['course']['thumbnail']) {?>
                                  <img height="50" width="50" src="<?= $this->request->webroot; ?>uploads/courses/thumb/<?= $list['course']['thumbnail']; ?>">
                            <?php } ?><br/>
                              <?= $list['course']['title']; ?></td>
                            <td><?= $list['lesson_no'] ?></td>
                              <td><?= $list['pass_percent'] ?></td>
                              <td><?= $this->Html->link('<i class="fa fa-eye" aria-hidden="true"></i>',['action'=>'view_chapter',$list['id']],['class'=>'view','escape'=>false]) ?> &nbsp;</td>

                        </tr>
                  <?php $i++; } ?>
                    </tbody>
                    </table></div>
                  <?= $this->element('paginator') ?>
                </div>
              </div>
              </div>
