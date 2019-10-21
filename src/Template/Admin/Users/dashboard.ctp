<?php $this->assign('title','Dashboard'); ?>
<?php 
    use Cake\I18n\Time;
    ?>
<div class="row">
    <!-- top tiles -->
    <div class="row tile_count">
        <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
            <a href="<?= BASEURL.'admin/users' ?>">
                <span class="count_top"><i class="fa fa-user"></i> Total Users</span>
                <div class="count"><?= $userCount ?></div>
                <!--<span class="count_bottom"><i class="green">4% </i> From last Week</span> -->
            </a>
        </div>
        <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
            <a href="<?= BASEURL.'admin/users' ?>">
                <span class="count_top"><i class="fa fa-user"></i> Total Learners</span>
                <div class="count"><?= $learnerCount ?></div>
            </a>
        </div>
        <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
            <a href="<?= BASEURL.'admin/users/index/manager' ?>">
                <span class="count_top"><i class="fa fa-user"></i> Total Managers</span>
                <div class="count"><?= $managerCount ?></div>
            </a>
        </div>
        <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
            <a href="<?= BASEURL.'admin/users/index/instructor' ?>">
                <span class="count_top"><i class="fa fa-user"></i> Total Instructors</span>
                <div class="count"><?= $instructorCount ?>
                </div>
            </a>
        </div>
        <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
            <a href="<?= BASEURL.'admin/courses' ?>">
                <span class="count_top"><i class="fa fa-book"></i> Total Courses</span>
                <div class="count"><?= $courseCount ?></div>
            </a>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-4 col-sm-4 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>
                    Recent Messages <!-- <small>latest</small> -->
                </h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                    <li><a class="close-link"><i class="fa fa-close"></i></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="dashboard-widget-content">
                    <ul class="list-unstyled timeline widget">
                        <?php foreach($recent_messages as $msg) {
                            $timestamp = new Time($msg->modified);
                            $time = $timestamp->timeAgoInWords([
                                  'accuracy' => ['month' => 'month'],
                                  'end' => '1 year'
                              ]);
                            ?>
                        <li>
                            <div class="block">
                                <div class="block_content">
                                    <h2 class="title">
                                        <a><?= $msg->message ?></a>
                                    </h2>
                                    <div class="byline">
                                        <span>
                                            <?= $time ?> <!-- 13 hours ago -->
                                        </span>
                                        by <a><?= ucfirst($msg->sender->fname).' '.$msg->sender->lname ?></a>
                                    </div>
                                    <!-- <p class="excerpt">Film festivals used to be do-or-die moments for movie makers. They were where you met the producers that could fund your project, and if the buyers liked your flick, they’d pay to Fast-forward and… <a>Read&nbsp;More</a>
                                        </p> -->
                                </div>
                            </div>
                        </li>
                        <?php } ?>
                        <!-- <li>
                            <div class="block">
                              <div class="block_content">
                                <h2 class="title">
                                                  <a>Who Needs Sundance When You’ve Got&nbsp;Crowdfunding?</a>
                                              </h2>
                                <div class="byline">
                                  <span>13 hours ago</span> by <a>Jane Smith</a>
                                </div>
                                <p class="excerpt">Film festivals used to be do-or-die moments for movie makers. They were where you met the producers that could fund your project, and if the buyers liked your flick, they’d pay to Fast-forward and… <a>Read&nbsp;More</a>
                                </p>
                              </div>
                            </div>
                            </li> -->
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-8 col-sm-8 col-xs-12">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Latest Courses <small></small></h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>
                            <li><a class="close-link"><i class="fa fa-close"></i></a>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="dashboard-widget-content">
                            <div class="col-md-41 hidden-small">
                                <h2 class="line_30">  </h2>
                                <table class="countries_list">
                                    <thead>
                                        <tr>
                                            <td><b>Course Name</b></td>
                                            <td><b>Type</b></td>
                                            <td><b>Date</b></td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if(!empty($recentCourses)){ //pr($recentCourses);
                                            foreach($recentCourses as $rc):?>
                                        <tr>
                                            <td>
                                                <?php 
                                                    if($rc['type'] == 1){
                                                      $updatelink = ['controller'=>'courses','action'=>'update',$this->Common->myencode($rc['id'])];
                                                    } else if($rc['type'] == 2){
                                                      $updatelink = ['controller'=>'courses','action'=>'instructor_course',$this->Common->myencode($rc['id'])];
                                                    }
                                                    ?>
                                                <?= $this->Html->link(ucfirst($rc['title']),$updatelink) ?>
                                            </td>
                                            <td>
                                                <?php if($rc['type'] == 1) {
                                                    if($rc['online_course_type'] == 2) {
                                                      echo "Competence Course";
                                                    } else{
                                                      echo "Online Course";
                                                    }
                                                    } else { 
                                                    echo "Instructor Course";
                                                    }?>
                                            </td>
                                            <td><?= $rc['created']->format('M d, Y') ?></td>
                                            <?php endforeach;
                                                } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

