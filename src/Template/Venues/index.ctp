<div id="main">
    <div class="visible-md visible-xs visible-sm mobile-menu">
        <button type="button" data-toggle="offcanvas"><i class="fa fa-bars"></i></button>
    </div>
    <section class="bgw clearfix course-detail-master">
        <div class="page-title bgg">
            <div class="container-fluid clearfix">
                <div class="title-area pull-left">
                    <h2><!-- Courses --> Venues<small></small></h2>
                </div>
                <!-- /.pull-right -->
                <div class="pull-right hidden-xs">
                    <div class="bread">
                        <ol class="breadcrumb">
                            <li><a href="<?= BASEURL?>users/dashboard">Home</a></li>
                            <li class="active"><a href="<?= BASEURL?>venues/">Venues</a></li>
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
                            <!-- <div class="big-title">
                                <h2 class="related-title">
                                    <span>Venues</span>
                                </h2>
                            </div> -->
                            <!-- end big-title -->
                            <!--<?= $this->Html->link('Add Venue',['controller'=>'Venues','action'=>'form'],['class'=>'btn btn-primary btn-square']) ?>-->
                            <br><br>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th> <i class="fa fa-list-ul" aria-hidden="true"></i> </th>
                                        <th> Venue Title </th>
                                        <th> Type </th>
                                        <th> Max Class Size</th>
                                        <th>Modified Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if(count(@$list)>0) { 
                                        foreach ($list as $key => $list) {
                                        	
                                        	
                                        ?>
                                    <tr>
                                        <td> <?= ++$key ?> </td>
                                        <td>
                                            <a href="#"><?= ucfirst($list['title']) ?></a>
                                        </td>
                                        <td> <?= $list['type'] ?>
                                        </td>
                                        <td> <?= $list['max_class_size'] ?></td>
                                        <td><?= $list['modified']->format('d M, Y') ?> </td>
                                        <td> 
                                            <?= $this->Html->link('<i class="fa fa-eye" aria-hidden="true"></i>',['action'=>'form',$list['id']],['class'=>'edit1 action_links btn-primary btn-sm','escape'=>false]) ?> &nbsp;
                                    </tr>
                                    <?php } } else { ?>
                                    <tr>
                                        <td class="text-center" colspan="5"> No Records Found! </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                            <?php if(count(@$list)>0) {  ?>
                            <?= $this->element('paginator') ?>
                            <?php } ?>
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