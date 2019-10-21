<div id="sidebar" class="col-md-3 col-sm-12 page-left-sidebar">
    <div class="widget clearfix">
        <div class="member-profile">
            <div class="big-title">
                <h2 class="related-title">
                    <span>Activity</span>
                </h2>
            </div><!-- end big-title -->
            <div class="member-desc clearfix">
                <ul> 
                    <li <?php if($this->request->action=='dashboard') { echo "class='active'"; } ?>><a href="<?= BASEURL?>learners/dashboard">Dashboard</a></li>
                    <li <?php if( ($this->request->controller=='Courses' && @$menu != 'ecommerce') || 
                                 ($this->request->controller=='Lessons' && ($this->request->action=='view' || $this->request->action=='quizresult') )
                             ) { 
                                    echo "class='active'".@$menu; 
                            } ?>
                        ><a href="<?= BASEURL?>courses/learnerCourses">Courses <!-- <span><?= $this->Common->getactivecoursescount($activeuser['id']) ?></span> --></a></li>

                    <li <?php if(@$menu=='catalog') { echo "class='active'"; } ?>><?= $this->Html->link('Catalog',['controller'=>'learners','action'=>'catalog']) ?> </li>
                    <li  <?php if(@$menu=='globalresources') { echo "class='active'"; } ?>>
                    <?= $this->Html->link('Resources',['controller'=>'learners','action'=>'globalresources']) ?></li>
                    <li <?php if(@$menu=='calendar') { echo "class='active'"; } ?>><?= $this->Html->link('Calendar',['controller'=>'learners','action'=>'calendar']) ?> </li>
                    <li <?php if(@$menu=='transcript') { echo "class='active'"; } ?>><?= $this->Html->link('Transcript',['controller'=>'learners','action'=>'transcript']) ?></li>
                     <li <?php if(@$menu=='ecommerce') { echo "class='active'"; } ?>><?= $this->Html->link('E-Commerce Courses',['controller'=>'courses','action'=>'ecomcourses']) ?></li>
                    <li <?php if($this->request->action=='profile') { echo "class='active'"; } ?>><a href="<?= BASEURL?>learners/profile">Edit Profile</a></li>

                    <li <?php if($this->request->action=='contactmanager') { echo "class='active'"; } ?>><a href="<?= BASEURL?>learners/contactmanager">Contact your Manager</a></li>
                    <li class="dropdown hasmenu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <i class="fa fa-user" aria-hidden="true"></i> Communication <span class="fa fa-angle-right"></span></a>
                          <ul class="dropdown-menu vertical-menu">
                            <li><a href="<?= BASEURL?>message/">Messages</a></li>
                          <!--  <li><a href="<?= BASEURL?>users/add">Add User</a></li>-->
                            <li><a href="#">SMS</a></li>
                        </ul>
                    </li>
                    <li><?= $this->Html->link('Logout',['controller'=>'users','action'=>'logout']) ?></li>
                </ul><!-- end ul -->
                <hr>
                <button type="submit" value="SEND" class="button button--wayra btn-block btn-square"> Follow Me </button>
            </div><!-- end team-desc -->
        </div><!-- end team-member -->
    </div>
</div><!-- end right -->