<div class="col-md-9 col-sm-12 page-left-sidebar wb-resouces" id="sidebar">
 <div class="widget clearfix">
                            <div class="member-profile">
                                <div class="big-title">
                                    <h2 class="related-title">
                                        <span>Resources</span>
                                    </h2>
                                </div><!-- end big-title -->
<div class="search-sec">
<form action="#" class="revtp-searchform" id="searchform" method="get" role="search">
<input type="text" placeholder="What are you looking?" id="s" name="keyword" value="<?= @$keyword ?>">
<!-- <select>
<option selected hidden disabled>Resources Name</option>
<option >Resources Name1</option>
<option >Resources Name2</option>
<option >Resources Name3</option>
</select> -->

<input type="submit" value="Find Resources" id="searchsubmit"></form>
</div>
     
	 
	 <div class="member-friends messages panel">
                                    <div class="panel-body">
                                    <?php foreach($list as $cr) { ?>
                                        <div class="form-group row wow fadeIn" style="visibility: visible; animation-name: fadeIn;">
                                            <div class="col-sm-9 col-xs-12">
                                                <div class="authorbox">
                                                    <div class="row">
                                                        <div class="col-sm-12 col-md-12">
                                                            <div class="clearfix">
                                                                <div class="avatar-author">
                                                                    <a href="<?= COURSE_RESOURCE.$cr['files'] ?>"  target="_blank">
                                                                     <i class="fa fa-file-pdf-o" aria-hidden="true"></i>
                                                                    </a>
                                                                </div>
                                                                <div class="author-title desc">
                                                                    <h4><?= $cr['name'] ?></h4>
                                                                    <a  class="authorlink"><?= ucfirst($cr['user']['fullname']) ?></a>
                                                                  <div class="large-post-meta">
                                                                        <span class="avatar"><a href="<?= COURSE_RESOURCE.$cr['files'] ?>" target="_blank"><i class="fa fa-file" aria-hidden="true"></i> <?= $cr['files'] ?></a></span>
                                                                        <small>|</small>
                                                                        <span><i class="fa fa-clock-o"></i> <?= $cr['created']->nice()?></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div><!-- end col -->
                                                    </div><!-- end row -->
                                                </div><!-- end authorbox -->
                                            </div>
                                            <div class="col-sm-3 col-xs-12 text-center">
                                                <ul>
                                                    <li>
													<a href="<?= COURSE_RESOURCE.$cr['files'] ?>" download class="btn btn-primary" title="Download"><i class="fa fa-download" aria-hidden="true"></i></a></li>
                                                </ul>
                                            </div>
                                        </div><!-- end form-group -->       

                                        <hr>
                                        <?php } ?>
                                    
                                 </div><!-- end panel body -->
                                </div>
								
								
                           
                            </div><!-- end team-member -->
                        </div>
</div>