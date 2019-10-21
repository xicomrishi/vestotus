<div id="main">
    <div class="visible-md visible-xs visible-sm mobile-menu">
        <button type="button" data-toggle="offcanvas"><i class="fa fa-bars"></i></button>
    </div>
    <section class="bgw clearfix course-detail-master">
        <div class="page-title bgg">
            <div class="container-fluid clearfix">
                <div class="title-area pull-left">
                    <h2>Quiz  Details<small></small></h2> <!-- lesson -->
                </div>
                <!-- /.pull-right -->
                <div class="pull-right hidden-xs">
                    <div class="bread">
                        <ol class="breadcrumb">
                            <li><a href="<?= BASEURL?>users/dashboard">Home</a></li>
                            <li><a href="<?= BASEURL?>courses">Courses</a></li>
                            <li><a href="<?= BASEURL?>courses/view/<?= $this->Common->myencode(@$chapter['course']['id']) ?>"><?= ucwords(@$chapter['course']['title']) ?></a></li>
                            <li class="active"><?= ucfirst(@$chapter['title']) ?> </li>
                        </ol>
                    </div>
                    <!-- end bread -->
                </div>
                <!-- /.pull-right -->
            </div>
        </div>
        <!-- end page-title -->
        <section class="section bgw">
            <div class="container-fluid">
                <div class="row">
                    <div id="post-content" class="col-md-12 col-sm-12 single-course">
                        <div class="course-single-quiz">
                            <!--<small>Quiz for : <span><a href="course-single.html">Learning Web Design in 22 Days</a></span></small><br>
                                <small>Quiz Status: <span>Not Finished</span> </small> -->
                            <hr>
                            <div class="quiz-wrapper">
                                <div class="big-title">
                                    <h2 class="related-title">
                                        <span><?= ucfirst($chapter['title']) ?></span>
                                    </h2>
                                </div>
                                
                                <div class="single-course-title text-center">
                                    <p><?= ucwords(@$chapter->notes) ?></p>

                                    <div class="post-sharing">
                                        <ul class="list-inline">
                                            <li><a href="#" class="fb-button btn btn-primary"><i class="fa fa-facebook"></i> <span class="hidden-xs">Share on Facebook</span></a></li>
                                            <li><a href="#" class="tw-button btn btn-primary"><i class="fa fa-twitter"></i> <span class="hidden-xs">Tweet on Twitter</span></a></li>
                                        <li><a href="#" class="gp-button btn btn-primary"><i class="fa fa-google-plus"></i><span class="hidden-xs">Share on Google+</span></a></li>
                                        </ul>
                                    </div>
                                </div>
                                <!-- end single-course-title -->

                                <hr class="invis">
                                <div class="course-single-desc clearfix pp-0">
                                    <div class="big-title">
                                        <h2 class="related-title">
                                            <span>Description</span>
                                        </h2>
                                    </div>
                                    <!-- end big-title -->
                                    <p><?= ucfirst($chapter->description) ?></p>
                                    <p> Pass Mark : <?= (int)$chapter->pass_percent ?>%</p>
                                    <p> Test Type : <?= ($chapter->test_type == 1) ? 'Time limited' : 'Time not limited' ?></p>
                                    <?php 
                                        if($chapter->test_type == 1) { //echo 'chapter->time_limit = '.$chapter->time_limit; die;
                                            $chapter->time_limit = (int)$chapter->time_limit;
                                    ?>
                                    <p> Test Time : <?= ($chapter->time_limit/60) ?> Minutes</p>
                                    <?php } ?>
                                </div>

                                <div class="big-title m-t-30">
                                    <h2 class="related-title">
                                        <span>Questions</span>
                                    </h2>
                                </div>
                                <!-- <h3> Questions </h3> -->
                                <table class="resulttbl view">
                                    <tr>
                                        <td><b>Sr. No</b></td>
                                        <td><b>Question </b></td>
                                        <td><b>Options </b></td>
                                        <td><b>Answer </b></td>
                                    </tr>

                                    <?php 
                                        if(!empty($chapter['assessments'])){
                                            foreach($chapter['assessments'] as $key => $ques) { ?>
                                            <tr>
                                                <td><?= ++$key ?> </td>
                                                <td><?= ucfirst($ques['question']) ?> </td>
                                                <td>
                                                    <?php $opts = json_decode($ques['options']);
                                                    foreach($opts as $key1 => $opt){
                                                        echo ' ('.++$key1.') <span>'.ucfirst($opt).'</span> ';
                                                    } 
                                                    ?> 
                                                </td>
                                                <td><?= ucfirst($ques['answer']) ?> </td>
                                            </tr>

                                        <?php }
                                    } else{ ?>
                                        <tr>
                                            <td colspan="4" class="text-center1">No questions found </td>
                                        </tr>
                                    <?php } ?>
                                </table>
                            </div>
                            <!-- end quiz wrapper -->
                        </div>
                    </div>
                    <!-- end col -->
                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </section>
        <!-- end section -->
    </section>
    <!-- end section -->
</div>
</div><!-- end main -->