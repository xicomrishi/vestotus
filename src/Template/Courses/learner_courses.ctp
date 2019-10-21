<div id="sidebar" class="col-md-9 col-sm-12 page-left-sidebar">
    <div class="widget clearfix">
        <div class="member-profile">
            <div class="big-title">
                <h2 class="related-title">
                    <span>Active Courses</span>
                </h2>
            </div>
            <!-- end big-title -->
            <div class="postpager liststylepost membercourses">
                <ul class="pager">
                    <?php 
                        if($getActiveCourses)
                        {
                            // pr($getActiveCourses); die;
                        foreach($getActiveCourses as $courses) {
                            
                            $check = $this->Common->getResult($courses['course']['id'],$activeuser['id']);
                            if(!$check)
                            {
                            ?>
                    <li>
                        <div class="post">
                            <?php 
                                $encryptid = $this->Common->myencode($courses['course']['id']);
                                if($courses['course']['type']==1) {
                                    $url = BASEURL.'courses/view/'.$encryptid;
                                } else if($courses['course']['type'] == 2) { 
                                    $url = BASEURL.'courses/viewIled/'.$encryptid;
                                }

                                if(!empty(@$courses['course']['thumbnail'])) { 
                                    $img = FILE_COURSE_THUMB.$courses['course']['thumbnail'];
                                } else{
                                    $img = FILE_COURSE_THUMB_DEFAULT;
                                } 
                            ?>
                                <a href="<?= $url ?>"><img src="<?= $img ?>" alt="" class="img-responsive alignleft"></a>
                                <a href="<?= $url ?>"><h4><?= ucwords($courses['course']['title']) ?></h4></a>
        
                                <small>
                                <?php
                                    if($courses['course']['type'] == 1){
                                        if($courses['course']['online_course_type'] == 2){
                                            echo 'Competence Course';
                                        } else{
                                            echo 'Online Course';
                                        }
                                    } else{
                                        echo 'Instructor led course';
                                    }
                                 ?>
                                </small>
                                <?php /*
                                    $img = $this->get_course_image($courses['course']['id'] , $this->request->session()->read('Auth.User.addedby'));
                                    if($img && $this->request->session()->read('Auth.User.addedby') > 1){ 
                                        echo $this->Html->image(FILE_COURSE.$img,['width'=>100, 'alt'=>'Course Image']);  } 
                                    else if($courses['course']['thumbnail']) {
                                        echo $this->Html->image(FILE_COURSE_THUMB.$courses['course']['thumbnail'],['width'=>100, 'alt'=>'Course Image']);
                                    } else if($courses['course']['image']) {
                                        echo $this->Html->image(FILE_COURSE.$courses['course']['image'],['width'=>100, 'alt'=>'Course Image']);
                                    }else {
                                        echo "";
                                        // echo "No Image";
                                    }
                                     class="img-responsive alignleft"
                                */ ?>
                                <!-- <small>View Course</small> --> 
                            </a>
                            &nbsp;-&nbsp;
                            <small>Enrolled On : <?= $courses['created']->format('d M, Y') ?></small>
                        </div>
                    </li>
                    <?php } } } else {?>
                    <li> No Active Courses! </li>
                    <?php } ?>
                </ul>
            </div>
            <!-- end postpager -->
            <hr class="invis">
            <br>
            <div class="big-title">
                <h2 class="related-title">
                    <span>Completed Courses</span>
                </h2>
            </div>
            <!-- end big-title -->
            <div class="postpager liststylepost membercourses">
                <ul class="pager">
                    <?php 
                        if($getCompletedCourses)
                        {
                        foreach($getCompletedCourses as $courses) { 
                            $encryptid = $this->Common->myencode($courses['course']['id']);
                            ?>
                    <li>
                        <div class="post">
                            <a href="<?= BASEURL?>courses/view/<?= $encryptid ?>">
                                <?php if($courses['course']['thumbnail']) { ?>
                                <img alt="" src="<?= FILE_COURSE_THUMB.$courses['course']['thumbnail'] ?>" class="img-responsive alignleft">
                                <?php } ?>
                                <h4><?= ucwords($courses['course']['title']) ?></h4>
                                <small>
                                    <?php
                                        if($courses['course']['type'] == 1){
                                            if($courses['course']['online_course_type'] == 2){
                                                echo 'Competence Course';
                                            } else{
                                                echo 'Online Course';
                                            }
                                        } else{
                                            echo 'Instructor led course';
                                        }
                                     ?>
                                </small>
                                <!-- <small>View Course</small>  -->
                            </a>
                            &nbsp;-&nbsp;
                            <small>Enrolled On : <?= $courses['created']->format('d M, Y') ?></small>
                        </div>
                    </li>
                    <?php } } else {?>
                    <li> No Completed Courses! </li>
                    <?php } ?>
                </ul>
            </div>
            <!-- end postpager -->
        </div>
        <!-- end team-member -->
    </div>
</div>