<div class="front-footer">
    <div class="logo-wrapper background-color mt-set">
        <div class="container">
            <div class="row">
                <div class="col-md-4 col-sm-12 text-center">
                    <div class="site-logo">
                        <!-- <a class="navbar-brand" href="##"><img src="<?= BASEURL?>images//logo-gry.png" class="footer-logo" /></a> -->
                        <a class="navbar-brand" href="##"><img src="<?= $activeuser->logo ?>" class="footer-logo" /></a>
                        <!-- <a href="" class="bottom-logo"><?= $activeuser->logo ?></a> -->
                    </div>

                    <!-- <div style="color: #fff; border:1px red solid; text-align: left;">
                        <p ><a href="" style="color: #fff;">thias dfd fgh fghh</a></p> 
                        <p ><a href="" style="color: #fff;">thias dfd fgh fghh</a></p> 
                    </div> -->
                </div>
                <!-- end col -->
                <div class="col-md-8 text-right hidden-xs">
                    <div class="postpager">
                        <ul class="pager row-fluid">
                            <li class="col-md-4 col-sm-4 col-xs-12">
                                <div class="post">
                                    <a href="#course-single.html">
                                        <img alt="" src="<?= BASEURL?>uploads/pager_01.png" class="img-responsive alignleft">
                                        <h4>Learning Web Design & Development</h4>
                                        <small>View Course</small>
                                    </a>
                                </div>
                            </li>
                            <li class="col-md-4 col-sm-4 col-xs-12">
                                <div class="post">
                                    <a href="#course-single.html">
                                        <img alt="" src="<?= BASEURL?>uploads/pager_02.png" class="img-responsive alignleft">
                                        <h4>Graphic Design Introduction Course</h4>
                                        <small>View Course</small>
                                    </a>
                                </div>
                            </li>
                            <li class="col-md-4 col-sm-4 col-xs-12">
                                <div class="post">
                                    <a href="#course-single.html">
                                        <img alt="" src="<?= BASEURL?>uploads/pager_03.jpg" class="img-responsive alignleft">
                                        <h4>Social Media Marketing Strategy</h4>
                                        <small>View Course</small>
                                    </a>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <!-- end postpager -->
                </div>
                <!-- end col -->
            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </div>
    <!-- end logo-wrapper -->
    <div class="topbar copyrights">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-sm-12 text-left hidden-xs">
                    <div class="topmenu">
                        <span><i class="fa fa-home"></i> <a href="#index.html">Home</a></span>
                        <span><a href="#index.html">About us</a></span>
                        <span><a href="#index.html">Contact us</a></span>
                        <span><a href="#index.html">Terms of Usage</a></span>
                        <span><a href="#index.html">Site Copyrights</a></span>
                    </div>
                    <!-- end callus -->
                </div>
                <div class="col-md-6 col-sm-12 text-right">
                    <div class="social-icons">
                        <ul class="list-inline">
                            <li class="facebook"><a data-toggle="tooltip" data-placement="top" title="Facebook" href="##"><i class="fa fa-facebook"></i></a></li>
                            <li class="google"><a data-toggle="tooltip" data-placement="top" title="Google Plus" href="##"><i class="fa fa-google-plus"></i></a></li>
                            <li class="twitter"><a data-toggle="tooltip" data-placement="top" title="Twitter" href="##"><i class="fa fa-twitter"></i></a></li>
                            <li class="linkedin"><a data-toggle="tooltip" data-placement="top" title="Linkedin" href="##"><i class="fa fa-linkedin"></i></a></li>
                            <li class="pinterest"><a data-toggle="tooltip" data-placement="top" title="Pinterest" href="##"><i class="fa fa-pinterest"></i></a></li>
                            <li class="skype"><a data-toggle="tooltip" data-placement="top" title="Skype" href="##"><i class="fa fa-skype"></i></a></li>
                            <li class="vimeo"><a data-toggle="tooltip" data-placement="top" title="Vimeo" href="##"><i class="fa fa-vimeo"></i></a></li>
                            <li class="youtube"><a data-toggle="tooltip" data-placement="top" title="Youtube" href="##"><i class="fa fa-youtube"></i></a></li>
                        </ul>
                    </div>
                    <!-- end social icons -->
                </div>
                <!-- end col -->
            </div>
            <!-- end row -->
        </div>
        <!-- end topbar -->
    </div>
    <!-- end topbar -->
</div><!-- end wrapper -->
<div class="dmtop">Scroll to Top</div>
<!-- END SITE -->

<?php 
    //print "<pre>";print_r($this->request);
    if($this->request->params['controller'] == 'Courses' && ($this->request->params['action'] == 'onlineCourse' ||$this->request->params['action'] == 'instructorCourse' ) ) { echo $this->element('modal_chapter');} ?>    
    
    <?php if($this->request->params['controller'] == 'Courses' && ($this->request->params['action'] == 'mycourses')) { ?>

    <div class="modal fade" id="view_courses_modal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                    <h5 class="modal-title"> Enrolled Drivers in <span class="driver_name"> </span>  Course </h5>
                </div>
                <div class="modal-body">
                    <div class="modal-container center" >
                        <ol class="list_of_drivers">
                        </ol>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close <i class="fa fa-ban" aria-hidden="true"></i> </button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="upload_image">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <?= $this->Form->create('upload_images',['url'=>['action'=>'upload_logo'],'type'=>'file']) ?>
                <?= $this->Form->hidden('course_id',['id'=>'course_id']) ?>
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                    <h5 class="modal-title"> Enrolled Drivers in <span class="driver_name"> </span>  Course </h5>
                </div>
                <div class="modal-body">
                    <div class="modal-container center" >
                        <?= $this->Form->file('image',['accept'=>'image/*']) ?>
                    </div>
                </div>
                <div class="modal-footer">
                    <?= $this->Form->submit('Upload',['class'=>'btn btn-primary']) ?>
                </div>
                <?= $this->Form->end() ?>
            </div>
        </div>
    </div>
<?php } ?>