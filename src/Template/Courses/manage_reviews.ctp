<div id="main">
    <div class="visible-md visible-xs visible-sm mobile-menu">
        <button type="button" data-toggle="offcanvas"><i class="fa fa-bars"></i></button>
    </div>
    <section class="bgw clearfix course-detail-master">
        <div class="page-title bgg">
            <div class="container-fluid clearfix">
                <div class="title-area pull-left">
                    <h2>Courses Reviews<small></small></h2>
                </div>
                <!-- /.pull-right -->
                <div class="pull-right hidden-xs">
                    <div class="bread">
                        <ol class="breadcrumb">
                            <li><a href="<?= BASEURL?>users/dashboard">Home</a></li>
                            <li ><a href="<?= BASEURL?>courses/">Courses</a></li>
                            <li class="active">Reviews</li>
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
                                    <span>Reviews</span>
                                </h2>
                            </div> -->
                            <!-- end big-title -->
                            <br><br>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th> <i class="fa fa-list-ul" aria-hidden="true"></i> </th>
                                        <th>Course Name </th>
                                        <th style="width: 25%;">Review by </th>
                                        <th>Message </th>
                                        <th>Created</th>
                                        <th>Modified</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if(count(@$reviews)>0) { 
                                        foreach ($reviews as $list) {
                                        	//$rnd = rand(0,10);
                                        ?>
                                    <tr>
                                        <td> <input class="checkbox" type="checkbox" name="checkuser" value="<?= $list['id'] ?>"/> </td>
                                        <td>
                                            <a href="#"><?= ucfirst($list['course']['title']) ?></a>
                                        </td>
                                        <td> 
                                            <a href="#"><?= ucfirst($list['user']['fullname']) ?></a>
                                        </td>
                                        <td>
                                            <?= $list['message'] ?> <br>
                                            <a href="<?= $list['website'] ?>" target="_blank"><?= $list['website'] ?> </a>
                                        </td>
                                        <td><?= $list['created']->format('d M, Y') ?> </td>
                                        <td><?= $list['modified']->format('d M, Y') ?> </td>
                                        <td> 
                                            <?php if($list['status']==0) { ?>
                                            <?= $this->Html->link('<i class="fa fa-check-circle" aria-hidden="true"></i>',['action'=>'reviewup',$this->Common->myencode($list['id']),1],['class'=>'edit','escape'=>false]) ?> 
                                            <?php } else { ?>
                                            <?= $this->Html->link('<i class="fa fa-times-circle" aria-hidden="true"></i>',['action'=>'reviewup',$this->Common->myencode($list['id']),0],['class'=>'edit','escape'=>false]) ?> 
                                            <?php } ?>
                                            <?= $this->Html->link('<i class="fa fa-trash-o" aria-hidden="true"></i>',['action'=>'reviewup',$this->Common->myencode($list['id']),'del'],['confirm'=>'Do you really want to delete this ?','class'=>'delete','escape'=>false]) ?>
                                    </tr>
                                    <?php } } else { ?>
                                    <tr>
                                        <td colspan="6" class="text-center"> No Records Found! </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
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