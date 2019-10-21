<div class="col-md-3 left_col">
    <div class="left_col scroll-view">
        <div class="navbar nav_title" style="border: 0;">
            <a href="<?= BASEURL?>admin/users/dashboard" class="site_title"> <span>Administration</span></a>
        </div>
        <div class="clearfix"></div>
        <!-- menu profile quick info -->
        <div class="profile clearfix">
            <div class="profile_pic">
                <img src="<?= BASEURL?>admin/images/user.png" alt="..." class="img-circle profile_img">
            </div>
            <div class="profile_info">
                <span>Welcome,</span>
                <h2>
                    <?= $activeuser['fullname'] ?>
                </h2>
            </div>
        </div>
        <!-- /menu profile quick info -->
        <br />
        <!-- sidebar menu -->
        <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
            <div class="menu_section">
                <h3>General</h3>
                <ul class="nav side-menu">
                    <li>
                        <a><i class="fa fa-home"></i> Home <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li id="dashboard"><a href="<?= BASEURL?>admin/users/dashboard">Dashboard</a></li>
                        </ul>
                    </li>
                    <li id="courses">
                        <a><i class="fa fa-book"></i> Courses <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li id="index"><a href="<?= BASEURL?>admin/courses/">Manage Courses</a></li>
                            <li id="index"><a href="<?= BASEURL?>admin/courses/chapters">Manage Chapter</a></li>
                            <li id="venues"><a href="<?= BASEURL?>admin/venues/">Manage Venues</a></li>
                            <li id="sessions"><a href="<?= BASEURL?>admin/sessions/">Manage Sessions</a></li>
                            <li id="resources"><a href="<?= BASEURL?>admin/resources/">Global Resources</a></li>
                            <li id="tags"><a href="<?= BASEURL?>admin/tags/">Tags</a></li>
                            <li id="reviews"><a href="<?= BASEURL?>admin/courses/manageReviews/">Reviews</a></li>
                        </ul>
                    </li>
                    <li id="users">
                        <a><i class="fa fa-user"></i> Users <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li id="index"><a href="<?= BASEURL?>admin/users/">Manage Learners</a></li>
                            <li id ="instructor"><a href="<?= BASEURL?>admin/users/index/instructor">Manage Instructors</a></li>
                            <li id="managers"><a href="<?= BASEURL?>admin/users/index/manager">Manage Managers</a></li>
                        </ul>
                    </li>
                    <li id="companies">
                        <a><i class="fa fa-building"></i> Companies <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li id="companies"><a href="<?= BASEURL?>admin/companies/form">Add Company</a></li>
                            <li id="companies"><a href="<?= BASEURL?>admin/companies/">Company List</a></li>
                        </ul>
                    </li>
                    <li id="departments">
                        <a><i class="fa fa-home"></i> Departments <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li id="departments"><a href="<?= BASEURL?>admin/departments/form">Add Departments</a></li>
                            <li id="departments"><a href="<?= BASEURL?>admin/departments/">Departments List</a></li>
                        </ul>
                    </li>
                    <li id="enrollments">
                        <a><i class="fa fa-file"></i> Enrollments <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li id="departments"><a href="<?= BASEURL?>admin/enrollments/enrollUsers">Enroll Users</a></li>
                            <li id="departments"><a href="<?= BASEURL?>admin/enrollments/">Enrollments</a></li>
                        </ul>
                    </li>
                    <li id="enrollkeys">
                        <a><i class="fa fa-key"></i> Enrollment Keys <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li id="departments"><a href="<?= BASEURL?>admin/enrollKeys/">List Key</a></li>
                        </ul>
                    </li>
                    <li id="courses">
                        <a><i class="fa fa-file"></i> Quiz <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li id="index"><a href="<?= BASEURL?>admin/quiz/comCourses">Quiz List</a></li> <!-- Competence Courses -->
                        </ul>
                    </li>
                    <li id="ecommerce">
                        <a><i class="fa fa-laptop"></i> Ecommerce  Courses <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><?= $this->Html->link('Manage Courses',['controller'=>'courses','action'=>'ecommerce']) ?></li>
                            <li><?= $this->Html->link('Purchase History',['controller'=>'Purchase','action'=>'index'],['id'=>'purchased_history']) ?></li>
                        </ul>
                    </li>
                    <li id="ecommerce">
                        <a><i class="fa fa-clock-o"></i> Attendance <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><?= $this->Html->link('Learners Attendance',['controller'=>'Attendance','action'=>'index', $this->Common->myencode(4)]) ?></li>
                        </ul>
                    </li>
                    <li id="ecommerce">
                        <a><i class="fa fa-envelope"></i> Communicate <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><?= $this->Html->link('Message',['controller'=>'message','action'=>'index']) ?></li>
                            <li><?= $this->Html->link('SMS',['controller'=>'sms','action'=>'index'],['id'=>'purchased_history']) ?></li>
                        </ul>
                    </li>
                    <li id="cms">
                        <a><i class="fa fa-bar-chart-o"></i>CMS <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu" >
                            <li><a href="<?= BASEURL?>admin/pages/">Manage Static Pages</a></li>
                            <li><a href="<?= BASEURL?>admin/contacts/">Manage Contact Requests</a></li>
                            <li><a href="<?= BASEURL?>admin/pages/settings">Website Settings</a></li>
                            <!-- <li><a href="<?= BASEURL?>admin/pages/addTestimonials">Add Testimonials</a></li> -->
                            <li><a href="<?= BASEURL?>admin/pages/manageTestimonials">Testimonials</a></li>
                            <!-- <li><a href="<?= BASEURL?>admin/pages/addFaq">Add Faqs</a></li> -->
                            <li><a href="<?= BASEURL?>admin/pages/manageFaqs">Faqs</a></li>
                            <li id="et"><a href="<?= BASEURL?>admin/emailTemplates/">Email Templates</a></li>
                            <li><a href="<?= BASEURL?>admin/pages/cms">Others</a></li>
                        </ul>
                    </li>
                    <li id="others">
                        <a><i class="fa fa-cog"></i>Others<span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><?= $this->Html->link('Learner side options',['controller'=>'learnersideoptions','action'=>'index']) ?></li>
                            <li><?= $this->Html->link('Course Reports',['controller'=>'coursereports','action'=>'index']) ?></li>
                            <li id="sales"><?= $this->Html->link('Sales',['controller'=>'sales','action'=>'index']) ?></li>
                            <!-- <li><?= $this->Html->link('Sales and Marketing',['controller'=>'salesmarketing','action'=>'index']) ?></li> -->
                            <li><?= $this->Html->link('Activity stream',['controller'=>'activitystream','action'=>'index']) ?></li>
                            <li><?= $this->Html->link('Generated Reports',['controller'=>'generatereport','action'=>'index']) ?></li>
                            <li><?= $this->Html->link('Saved Reports',['controller'=>'savedreport','action'=>'index']) ?></li>
                        </ul>
                    </li>
                    <li id="ecommerce">
                    </li>
                </ul>
            </div>
        </div>
        <!-- /sidebar menu -->
        <!-- /menu footer buttons -->
        <div class="sidebar-footer hidden-small">
            <a href="<?= BASEURL?>admin/users/profile" data-placement="top" title="My Account">
            <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
            </a>
            <a href="<?= BASEURL?>admin/users/logout" title="Logout">
            <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
            </a>
        </div>
        <!-- /menu footer buttons -->
    </div>
</div>
<!-- top navigation -->
<div class="top_nav">
    <div class="nav_menu">
        <nav>
            <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
            </div>
            <ul class="nav navbar-nav navbar-right">
                <li class="">
                    <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    <img src="<?= BASEURL?>admin/images/user.png" alt=""> <?= $activeuser['fullname'] ?>
                    <span class=" fa fa-angle-down"></span>
                    </a>
                    <ul class="dropdown-menu dropdown-usermenu pull-right">
                        <li><a href="<?= BASEURL?>admin/users/profile"> Profile</a></li>
                        <!--<li>
                            <a href="javascript:;">
                              <span class="badge bg-red pull-right">50%</span>
                              <span>Settings</span>
                            </a>
                            </li>
                            <li><a href="javascript:;">Help</a></li> -->
                        <li><a href="<?= BASEURL?>admin/users/logout"><i class="fa fa-sign-out pull-right"></i> Log Out</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
    </div>
</div>
<script>
    $(document).ready(function()
    { 
      var sidebar = '<?php echo isset($sidebar) ? $sidebar : ''?>';
      if(sidebar)
      {
          $('#'+sidebar).addClass('active');
          $('#' + sidebar + '').find('ul.child_menu').show();
          var submenu = '<?php echo isset($submenu) ? $submenu: ''?>';
          if(submenu)
          {
            $('#' + submenu + '').closest().addClass('current-page');
          }
      }
    })
</script>