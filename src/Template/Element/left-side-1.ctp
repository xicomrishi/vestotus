<!-- instructor left side bar -->
<div id="sidebar" class="col-md-3 col-sm-12 page-left-sidebar">
    <div class="widget clearfix">
        <div class="member-profile">
            <div class="big-title">
                <h2 class="related-title">
                    <span>Activity</span>
                </h2>
            </div>
            <div class="member-desc clearfix">
                <ul>
                    <li <?php if($this->request->action=='profile') { echo "class='active'"; } ?>>
                        <a href="<?= BASEURL?>instructors/profile">Edit Profile</a>
                    </li>
                    <li <?php if($this->request->action=='courses') { echo "class='active'"; } ?>><a href="<?= BASEURL?>instructors/courses">Courses <span><?= $this->Common->getactivecoursescount($activeuser['id']) ?></span></a></li>

                    <!-- <li><a href="#">Attendence <span>0</span></a></li> -->
                    <li><a href="#">Messages <span>0</span></a></li>
                    <li class="dropdown hasmenu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <i class="fa fa-user" aria-hidden="true"></i> Communication <span class="fa fa-angle-right"></span></a>
                          <ul class="dropdown-menu vertical-menu">
                            <li><a href="<?= BASEURL?>message/">Messages</a></li>
                          <!--  <li><a href="<?= BASEURL?>users/add">Add User</a></li>-->
                            <li><a href="#">SMS</a></li>
                        </ul>
                    </li>
                </ul><!-- end ul -->
                <hr>
                <button type="submit" value="SEND" class="button button--wayra btn-block btn-square"> Follow Me</button>
            </div><!-- end team-desc -->
        </div><!-- end team-member -->
    </div>
</div><!-- end right -->