
  <div>
                <div class="x_panel">
                  <div class="x_title">
                    <h2> Chapter Details  <small></small></h2>

                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">

                    <div id="datatable-buttons_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">


                    <table id="datatable-buttons" class="table table-striped table-bordered dataTable no-footer dtr-inline" role="grid" >
                      <dl>
                     <dt>Title</dt>
                     <dd><?= $list['title']; ?></dd>
                      <dd>&nbsp;</dd>
                     <dt>Description</dt>
                     <dd><?= ($list['description']) ? $list['description'] : 'n/a'; ?></dd>
                     <dd>&nbsp;</dd>
                     <dt>Note</dt>
                     <dd><?= ($list['notes']) ? $list['notes'] : 'n/a'; ?></dd>
                     <dd>&nbsp;</dd>
                     <dt>Course</dt>
                     <dd><?= $list['course']['title']; ?></dd>
                     <dd>&nbsp;</dd>
                     <dt>Course Image</dt>
                     <dd><?php if($list['course']['thumbnail']) {?>
                           <img height="50" width="50" src="<?= $this->request->webroot; ?>uploads/courses/thumb/<?= $list['course']['thumbnail']; ?>">
                     <?php }else{ echo 'n/a' ; } ?></dd>

                     <dd>&nbsp;</dd>

                     <dt>Files</dt>
                     <dd>  <?php if($list['type']=='ppt') { ?>
                               <a href="<?= $this->request->webroot; ?>uploads/courses/ppt/<?= $list['files'] ?>"><?= $list['files'] ?></a>
                       <?php }else if($list['type']=='audio') { ?>
                               <a href="<?= $this->request->webroot; ?>uploads/courses/audio/<?= $list['files'] ?>"><?= $list['files'] ?></a>
                       <?php }else if($list['type']=='video') { ?>
                               <a href="<?= $this->request->webroot; ?>uploads/courses/videos/<?= $list['files'] ?>"><?= $list['files'] ?></a>
                       <?php }else{ echo 'n/a' ; } ?></dd>

                     <dd>&nbsp;</dd>
                     <dt>Lesson No</dt>
                     <dd><?= $list['lesson_no']; ?></dd>

                     <dd>&nbsp;</dd>
                     <dt>Pass Percent</dt>
                     <dd><?= $list['pass_percent']; ?></dd>

                     <dd>&nbsp;</dd>

                     <dt>Test Type</dt>
                     <dd><?= ($list['test_type'] ==1) ? 'No Time Limit' : 'Limit Limit'; ?></dd>

                     <dd>&nbsp;</dd>


                     <dt>Time</dt>
                     <dd><?= $list['time_limit'] ;  ?></dd>

                     <dd>&nbsp;</dd>



                    </dl>
                    </tbody>
                    </table></div>

                </div>
              </div>
              </div>
