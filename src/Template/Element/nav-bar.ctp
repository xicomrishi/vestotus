<!-- fontend left bar -->
<div class="row-offcanvas row-offcanvas-left">
    <div id="sidebar-fix" class="sidebar-offcanvas menu-wrap">
        <header id="vertical" class="header header-style-1 menu">
            <nav class="navbar navbar-default yamm">
                <div class="container-f">
                    <div class="navbar-header">
                        <div class="site-logo text-center">
                            <a class="navbar-brand" href="">
                            <img src="<?= $activeuser->logo ?>" class="header-logo dash">
                            </a>
                        </div>
                    </div>
                    <div id="navbar">
                        <?php if($activeuser['role']==2) { //manager sidebar ?>
                            <ul class="nav navbar-nav top-menu">
                                <li><a href="<?= BASEURL?>users/dashboard"> <i class="fa fa-tachometer" aria-hidden="true"></i> Dashboard</a></li>
                                
                                <li class="dropdown hasmenu">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <i class="fa fa-book" aria-hidden="true"></i> Courses <span class="fa fa-angle-right"></span></a>
                                    <ul class="dropdown-menu vertical-menu">
                                        <li><a href="<?= BASEURL?>courses/">Courses</a></li>
                                        <li><a href="<?= BASEURL?>courses/mycourses">E-comm Courses</a></li>
                                        <li><a href="<?= BASEURL?>venues/">Venues</a></li>
                                        <li><a href="<?= BASEURL?>resources/">Resources</a></li>
                                        <li><a href="<?= BASEURL ?>tags/">Tags </a></li>
                                        <li><a href="<?= BASEURL ?>courses/manage-reviews">Reviews</a></li>
                                    </ul>
                                </li>
                                <li class="dropdown hasmenu">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <i class="fa fa-user" aria-hidden="true"></i> Users <span class="fa fa-angle-right"></span></a>
                                    <ul class="dropdown-menu vertical-menu">
                                        <li><a href="<?= BASEURL?>users/">Users</a></li>
                                        <!--  <li><a href="<?= BASEURL?>users/add">Add User</a></li>-->
                                        <li><a href="<?= BASEURL?>departments/">Departments</a></li>
                                        <li><a href="<?= BASEURL?>groups/">Groups</a></li>
                                        <li><a href="<?= BASEURL?>enrollments/">Enrollments</a></li>
                                        <li><a href="<?= BASEURL?>enrollKeys/">Enrollment Keys</a></li>
                                    </ul>
                                </li>
                                <li class="dropdown hasmenu">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <i class="fa fa-user" aria-hidden="true"></i> Communication <span class="fa fa-angle-right"></span></a>
                                    <ul class="dropdown-menu vertical-menu">
                                        <li><a href="<?= BASEURL?>message/">Messages</a></li>
                                        <!--  <li><a href="<?= BASEURL?>users/add">Add User</a></li>-->
                                        <li><a href="#">SMS</a></li>
                                    </ul>
                                </li>
                                <li class="dropdown hasmenu">
                                    <a href="<?= BASEURL?>courses/ecomcourses" > 
                                    <i class="fa fa-cart-arrow-down" aria-hidden="true"></i> E-Commerce </a>
                                </li>
                                <li><a href="<?= BASEURL?>users/contacttoadmin"><i class="fa fa-support" aria-hidden="true"></i>Help & Support</a></li>
                                <!-- <li class="dropdown hasmenu">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <i class="fa fa-file" aria-hidden="true"></i> Reports <span class="fa fa-angle-right"></span></a>
                                          
                                    </li> 
                                    <li class="dropdown hasmenu">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <i class="fa fa-gear" aria-hidden="true"></i> Setup <span class="fa fa-angle-right"></span></a>
                                          
                                    </li>-->
                            </ul>
                        <?php } else { ?>
                        <ul class="nav navbar-nav">
                            <li class="dropdown hasmenu">
                                <a href="<?= BASEURL ?>" role="button" aria-haspopup="true" aria-expanded="false">Home </a>
                                <!-- <ul class="dropdown-menu vertical-menu">
                                    <li><a href="#">Home Search Hero</a></li>
                                    <li><a href="#">Home Video Parallax</a></li>
                                    </ul> -->
                            </li>
                            <li><a href="<?= BASEURL?>about/">About</a></li>
                            <li><a href="<?= BASEURL?>faqs/">Faq's</a></li>
                            <li><a href="<?= BASEURL?>contact/">Contact Us</a></li>
                        <!--<li class="dropdown has-submenu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Courses <span class="fa fa-angle-right"></span></a>
                            <ul class="dropdown-menu vertical-menu">
                                <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Member Panel <span class="fa fa-angle-right"></span></a>
                                    <ul class="dropdown-menu show-left" role="menu">
                                        <li><a href="#">Member Login</a></li>
                                    </ul>
                                </li>
                            <li><a href="#">Courses List View</a></li>
                            <li><a href="#">Courses Grid View</a></li>
                            <li><a href="#">Courses Filterable 3 Col</a></li>
                            <li><a href="#">Courses Filterable 4 Col</a></li>
                            <li><a href="#">Courses With Sidebar</a></li>
                            <li><a href="#">Course Single</a></li>
                            <li><a href="#">Course Quiz</a></li>
                            <li><a href="#">Course Checkout</a></li>
                            </ul>
                            </li>
                            <li class="dropdown hasmenu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Pages <span class="fa fa-angle-right"></span></a>
                            <ul class="dropdown-menu vertical-menu">
                                <li><a href="#">About Company</a></li>
                                <li><a href="#">Pricing &amp; Plan</a></li>
                                <li><a href="#">Get In Touch</a></li>
                                <li><a href="#">Became a Teacher</a></li>
                                <li><a href="#">Team &amp; Instructors</a></li>
                                <li><a href="page-testimonials.html">Happy Testimonials</a></li>
                                <li><a href="page-not-found.html">Page Not Found</a></li>
                                <li><a href="page-right-sidebar.html">Page Right Sidebar</a></li>
                                <li><a href="page-left-sidebar.html">Page Left Sidebar</a></li>
                                <li><a href="page-no-sidebar.html">Page No Sidebar</a></li>
                            </ul>
                            </li>
                            <li class="dropdown hasmenu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Blog <span class="fa fa-angle-right"></span></a>
                            <ul class="dropdown-menu vertical-menu">
                                <li><a href="blog.html">Blog List Layout</a></li>
                                <li><a href="blog-1.html">Blog Normal Layout</a></li>
                                <li><a href="blog-2.html">Blog No Sidebar</a></li>
                                <li><a href="blog-3.html">Blog Grid Sidebar</a></li>
                                <li><a href="blog-4.html">Blog Grid Fullwidth</a></li>
                                <li><a href="single.html">Blog&nbsp;Single Sidebar</a></li>
                                <li><a href="single-1.html">Blog Single Fullwidth</a></li>
                            
                            </ul>
                            </li>
                            <li><a href="forums.html">Forums</a></li>
                            <li><a href="page-contact.html">Contact</a></li>
                            </ul> -->
                        <?php } ?>
                        <ul class="nav navbar-nav navbar-right">
                            <li class="dropdown cartmenu searchmenu hasmenu">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-search"></i> Site Search</a>
                                <ul class="dropdown-menu show-right">
                                    <li>
                                        <div id="custom-search-input">
                                            <div class="input-group col-md-12">
                                                <input type="text" class="form-control input-lg" placeholder="Search here..." />
                                                <span class="input-group-btn">
                                                <button class="btn btn-primary btn-lg" type="button">
                                                <i class="fa fa-search"></i>
                                                </button>
                                                </span>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                    <!--/.nav-collapse -->
                </div>
                <!--/.container-fluid -->
            </nav>
            <!-- end nav -->
        </header>
        <!-- end header -->
        <button class="close-button" id="close-button">Close Menu</button>
        <div class="morph-shape" id="morph-shape" data-morph-open="M-1,0h101c0,0,0-1,0,395c0,404,0,405,0,405H-1V0z">
            <svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" viewBox="0 0 100 800" preserveAspectRatio="none">
                <path d="M-1,0h101c0,0-97.833,153.603-97.833,396.167C2.167,627.579,100,800,100,800H-1V0z"/>
            </svg>
        </div>
    </div>
</div>