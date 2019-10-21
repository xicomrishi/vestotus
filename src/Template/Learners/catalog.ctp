<div class="col-md-9 col-sm-12 page-left-sidebar catalog" id="sidebar">
    <div class="widget clearfix">
        <div class="member-profile">
            <div class="big-title">
                <h2 class="related-title">
                    <span>Catalog</span>
                </h2>
            </div>
            <!-- end big-title -->
            <div class="search-sec">
                <form action="<?= BASEURL.'learners/catalog' ?>" class="revtp-searchform" id="searchform" method="get" role="search">
                    <input type="text" placeholder="What are you looking?" id="keyword" name="keyword" value="<?= @$keyword ?>">
                    <select name="course_type" id="type">
                        <option value=''>All Courses</option>
                        <option value="1" <?php if($course_type == 1) { echo "selected='selected'";} ?>>Online Course</option>
                        <option value="2" <?php if($course_type == 2) { echo "selected='selected'";} ?>>Instructor Led Course</option>
                    </select>
                    <input type="submit" value="Find Course" id="searchsubmit">
                </form>
            </div>
            <?php 
                if(!$list->isEmpty()) { 
                    foreach($list as $list){ 
                        $encryptid = $this->Common->myencode($list['id']);
                        if($list['type']==1) {
                            $url = BASEURL.'courses/view/'.$encryptid;
                        } else if($list['type'] == 2) { 
                            $url = BASEURL.'courses/viewIled/'.$encryptid;
                        }
                    ?>
                    <div class="row wow fadeIn" >
                        <div class="col-md-6 col-sm-12">
                            <div class="popular-courses">
                                <div class="post-media entry">
                                    <?= $this->Html->image(FILE_COURSE_THUMB.$list['thumbnail'],['class'=>'img-responsive']) ?>
                                    <div class="magnifier">
                                        <div class="shop-bottom clearfix">
                                            <?php if($list['enable_ecommerce'] == 1) {?>
                                            <a title="Add to Cart" href="#"><i class="fa fa-shopping-cart"></i></a>
                                            <?php } ?>
                                            <a title="Full Preview" href="<?= $url ?>"><i class="fa fa-search"></i></a> 
                                        </div>
                                        <!-- end shop-bottom -->
                                    </div>
                                    <!-- end magnifier -->
                                </div>
                                <!-- end post-media -->
                            </div>
                            <!-- end courses -->
                        </div>
                        <!-- end col -->
                        <div class="col-md-6 col-sm-12">
                            <div class="about-module">
                                <h3><a href="<?= $url ?>"><?= $list['title'] ?></a></h3>
                                <p><?= $this->Text->truncate(strip_tags($list['description']), 300,['ellipsis' => '...','exact' => false] ) ?></p>
                                <div class="large-post-meta">
                                    <span class="avatar"><a href="#">
                                    <?php if($list['user']['avatar']) {?>
                                    <?= $this->Html->image(BASEURL.'uploads/user_data/'.$list['user']['avatar'],['class'=>'img-circle']) ?>
                                    <?php } ?><?= ucfirst($list['user']['fname']).' '.$list['user']['lname'] ?></a></span>
                                    <!-- <small>|</small>
                                        <span><a href="course-single.html"><i class="fa fa-clock-o"></i> 1 Month</a></span> -->
                                    <small class="hidden-xs">|</small>
                                    <?php if($list['enable_ecommerce']== 1) { ?>
                                        <span class="hidden-xs"><a href="#"><i class="fa fa-dollar"></i> <?= $list['purchase_price'] ?></a></span>
                                        <small class="hidden-xs">|</small>
                                    <?php } ?>

                                    <span class="hidden-xs"><a href="#"><i class="fa fa-users"></i> <?= $this->Common->get_enrolled_users($list['id']) ?> Students</a></span>
                                </div>
                                <!-- end meta -->
                                 <!-- $this->Form->create('selfEnroll',['controller' => 'Enrollments','action' => 'userSelfEnrollment'], ['id' => ])  -->

                                <a class="btn btn-warning btn-square" href="<?= BASEURL.'enrollments/userSelfEnrollment/'.$encryptid ?>">Enroll Yourself</a>
                                <!--  $this->Form->end() -->
                            </div>
                            <!-- end about-module -->
                        </div>
                        <!-- end col -->
                    </div>
                    <?php } 
                } else{ ?>
                    <div class="text-center">No course found</div> 
                <?php } ?>           
            <?= $this->element('paginationnew') ?>
        </div>
        <!-- end team-member -->
    </div>
</div>