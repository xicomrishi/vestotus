<div class="col-md-9 col-sm-12 page-left-sidebar wb-resouces" id="sidebar">
 <div class="widget clearfix">
                            <div class="member-profile">
                                <div class="big-title">
                                    <h2 class="related-title">
                                        <span>list of Courses</span>
                                    </h2>
                                </div><!-- end big-title -->

     
	 
	 <div class="member-friends messages panel">
                                    <div class="panel-body">
                                    <?php 
                                    if(count($completedc) == 0) { echo "No Completed Courses!"; }
                                    foreach($completedc as $c) { ?>
                                        <div class="form-group row wow fadeIn" style="visibility: visible; animation-name: fadeIn;">
                                            <div class="col-sm-9 col-xs-12">
                                                <div class="authorbox">
                                                    <div class="row">
                                                        <div class="col-sm-12 col-md-12">
                                                            <div class="clearfix">
                                                                <div class="avatar-author">
                                                                    <a href="author.html">
                                                                     <i class="fa fa-file-pdf-o" aria-hidden="true"></i>
                                                                    </a>
                                                                </div>
                                                                <div class="author-title desc">
                                                                    <h4><a href="member-profile.html"><?= $c['course']['title'] ?></a></h4>
                                                                    <a  class="authorlink">Status : completed </a>
                                                                  
                                
                                                                </div>
                                                            </div>
                                                        </div><!-- end col -->
                                                    </div><!-- end row -->
                                                </div><!-- end authorbox -->
                                            </div>
                                            <div class="col-sm-3 col-xs-12 text-center">
                                                <ul>
                                                    <li>
												<!--	<a class="btn btn-primary" title="Download"><i class="fa fa-download" aria-hidden="true"></i></a> -->
                        <?php if($c['test_result']) {?>
																<button type="button" onclick="window.location.href ='<?= BASEURL?>lessons/quizresult/<?= $this->Common->myencode($c['course']['id']) ?>'" class="btn btn-primary " data-toggle="modal" data-target="#transit" title="View">
<i class="fa fa-eye" aria-hidden="true"></i>
</button><?php } ?>
													</li>
										

<!-- Modal -->
                                             </ul>
                                            </div>
                                        </div><!-- end form-group -->       
 <hr>
 <?php } ?>
									      
       
										
										<div class="modal fade" id="transit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Course title</h4>
      </div>
      <div class="modal-body">
        Courses list
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
     
      </div>
    </div>
  </div>
</div>
   
                                       

                                  
                                      

                                 
                                 </div><!-- end panel body -->
                                </div>
								
								
                           
                            </div><!-- end team-member -->
                      

<?= $this->element('paginationnew') ?>


					  </div>
</div>
<style>
.modal-backdrop.fade.in {
  display: none;
}
#transit {
  background: rgba(0, 0, 0, 0.5);
  z-index: 999 !important;
}
body.modal-open .menu-button {
  display: none;
}
</style>