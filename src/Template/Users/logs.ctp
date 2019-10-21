<div id="main">
    <div class="visible-md visible-xs visible-sm mobile-menu">
        <button type="button" data-toggle="offcanvas"><i class="fa fa-bars"></i></button>
    </div>
    <section class="bgw clearfix course-detail-master">
        <div class="page-title bgg">
            <div class="container-fluid clearfix">
                <div class="title-area pull-left">
                    <h2><?= ucfirst($getuser['username']) ?> Access Logs</h2>
                </div>
                <!-- /.pull-right -->
                <div class="pull-right hidden-xs">
                    <div class="bread">
                        <ol class="breadcrumb">
                            <li><a href="<?= BASEURL?>users/dashboard">Home</a></li>
                            <li><a href="<?= BASEURL?>users">Manage Users</a></li>
                            <li class="active">Access Logs</li>
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
                        <hr class="invis">
                        <div class="leaners-table clearfix">
                            <div class="big-title">
                                <h2 class="related-title">
                                    <span>Logs</span>
                                </h2>
                            </div>
                            <!-- end big-title -->
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Full Name </th>
                                        <th>Username </th>
                                        <th>Login DateTime </th>
                                        <th>Login IP </th>
                                        <th>Logout DateTime</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if(count($list)>0) { 
                                        foreach ($list as $list) {
                                        	$rnd = rand(0,10);
                                        ?>
                                    <tr>
                                        <td>
                                            <a href="#"><?= $getuser['fname'].' '.$getuser['lname'] ?></a>
                                        </td>
                                        <td> <a href="#"><?= $getuser['username'] ?></a> </td>
                                        <td> 
                                            <a href="#"><?= $list['login_time']->format('d M, Y h:i:s') ?></a>
                                        </td>
                                        <td> <a href="#"><?= $list['ip'] ?></a> </td>
                                        <td> 
                                            <a href="#"><?= ($list['logout_time']) ? $list['logout_time']->format('d M, Y h:i:s') : 'Session Timeout' ?></a>
                                        </td>
                                        <?php } } else { ?>
                                    <tr>
                                        <td colspan="5"> No Records Found! </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                            <?= $this->element('paginator') ?>
                        </div>
                        <!-- end course-table -->			
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