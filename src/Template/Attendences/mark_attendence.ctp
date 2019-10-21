<div id="main">
    <div class="visible-md visible-xs visible-sm mobile-menu">
        <button type="button" data-toggle="offcanvas"><i class="fa fa-bars"></i></button>
    </div>
    <section class="bgw clearfix course-detail-master">
        <div class="page-title bgg">
            <div class="container-fluid clearfix">
                <div class="title-area pull-left">
                    <h2>Courses List <small></small></h2>
                </div>
                <!-- /.pull-right -->
                <div class="pull-right hidden-xs">
                    <div class="bread">
                        <ol class="breadcrumb">
                            <li><a href="<?= BASEURL?>users/dashboard">Home</a></li>
                            <li><a href="<?= BASEURL?>courses/">Courses</a></li>
                            <li><a href="<?= BASEURL?>sessions/index/<?= $this->Common->myencode($session['course_id']) ?>">Sessions</a></li>
                            <li class="active">Attendence</li>
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
                                    <span>Attendence</span>
                                </h2>
                            </div>
                            <!-- end big-title -->
                            <?= $this->Form->create('attendence',['class'=>'','id'=>'dsds'])  ?>
                            <table class="attendencetable">
                                <tr>
                                    <th> Learner </th>
                                    <?php
                                        foreach($session['session_classes'] as $classes) { ?>
                                    <th> <?= $classes['start_date']->format('M d, Y') ?> <?= $classes['start_time']?>  </th>
                                    <?php } ?>
                                </tr>
                                <?php 
                                    $i = 1;
                                    
                                    foreach($getusers as $user) { 
                                    	//pr($user);exit;
                                    	?>
                                <tr>
                                    <td> <?= ucfirst($user['user']['fullname']) ?></td>
                                    <?php 
                                        $j = 0;
                                        foreach($session['session_classes'] as $classes) { 
                                        $pusers = $this->Common->getAttendenceByUser($classes['id'],$user['user']['id']);
                                        if(date('Y-m-d',strtotime($classes['end_date'])) > date('Y-m-d')) {
                                        $check = "disabled='disabled'";
                                        }
                                        else
                                        {
                                        $check = "";
                                        }
                                        ?>
                                    <input type="hidden"  name="attendence[<?= $i.$j ?>][class_id]" value = "<?= $classes['id'] ?>">
                                    <input type="hidden"  name="attendence[<?= $i.$j ?>][user_id]" value = "<?= $user['user']['id'] ?>">
                                    <td>
                                        <div class="form-group">
                                            <input id="attendence[<?= $i.$j ?>][status]" class="switch" <?php if($pusers==1) { echo "checked='checked'"; } ?> type="checkbox" value="present" <?= $check ?> name="attendence[<?= $i.$j ?>][status]">
                                            <label for="attendence[<?= $i.$j ?>][status]" class="checkbox-switch"> </label>
                                        </div>
                                    </td>
                                    <?php $j++;} ?>
                                </tr>
                                <?php  $i++;} ?>
                            </table>
                            <button type="submit" class="btn btn-primary">Update</button>
                            <button type="button" class="btn btn-secondary" onclick="window.location.href = '<?= BASEURL?>sessions/index/<?= $this->Common->myencode($user['course_id']) ?>'; ">Back</button>
                            <?= $this->Form->end() ?>
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