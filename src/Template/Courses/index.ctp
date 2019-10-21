<!-- <link href="https://use.fontawesome.com/releases/v5.0.7/css/all.css" rel="stylesheet"> -->

<div id="main">
    <div class="visible-md visible-xs visible-sm mobile-menu">
        <button type="button" data-toggle="offcanvas"><i class="fa fa-bars"></i></button>
    </div>
    <section class="bgw clearfix course-detail-master">
        <div class="page-title bgg">
            <div class="container-fluid clearfix">
                <div class="title-area pull-left">
                    <h2>Courses List<small></small></h2>
                </div>
                <!-- /.pull-right -->
                <div class="pull-right hidden-xs">
                    <div class="bread">
                        <ol class="breadcrumb">
                            <li><a href="<?= BASEURL?>users/dashboard">Home</a></li>
                            <li class="active">Courses</li>
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
                                    <span>Courses Details</span>
                                </h2>
                            </div> -->
                            <!-- end big-title -->
                            <!--<div> $this->Html->link('Online Course',['action'=>'onlineCourse'],['class'=>'btn btn-info btn-square']) ?>
                                &nbsp;
                                 $this->Html->link('Instructor Led Course',['action'=>'InstructorCourse'],['class'=>'btn btn-primary btn-square']) ?>
                                <br><br></div>-->
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th> <i class="fa fa-list-ul" aria-hidden="true"></i> </th>
                                        <th>Course Image </th>
                                        <th>Course Name </th>
                                        <th>Notes </th>
                                        <th>Type </th>
                                        <th>Created</th>
                                        <?php /*
                                        <th>Modified</th> */ ?>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if(count(@$courses)>0) {
                                        foreach ($courses as $key => $list) {
                                        	$rnd = rand(0,10);
                                        ?>
                                    <tr>
                                        <td><?= ++$key ?></td>
                                        <td>
                                            <?php 
                                                $encryptid = $this->Common->myencode($list['id']);
                                                if($list['type']==1) {
                                                    $url = BASEURL.'courses/view/'.$encryptid;
                                                } else if($list['type'] == 2) { 
                                                    $url = BASEURL.'courses/viewIled/'.$encryptid;
                                                }

                                                if($list['thumbnail']){ 
                                                    $img = FILE_COURSE_THUMB.$list['thumbnail'];
                                                } else{
                                                    $img = FILE_COURSE_THUMB_DEFAULT;
                                                } 
                                            ?>
                                            <a href="<?= $url ?>"><img src="<?= $img ?>" alt="" class="img-responsive thumb-50"></a>
                                        </td>
                                        <!--<td> <input class="checkbox courseselection" type="checkbox" name="checkuser" id="<?= $list['type'] ?>"  value="<?= $this->Common->myencode($list['id']) ?>"/> </td>-->
                                        <td>
                                            <a href="<?= $url ?>"><?= ucfirst($this->Text->truncate($list['title'],35)) ?></a>
                                        </td>
                                        <td><?= ucfirst($this->Text->truncate($list['notes'],30)) ?></td>
                                        <td>
                                            <?php if($list['type'] == 1) {
                                                if($list['online_course_type'] == 2) {
                                                  echo "Competence Course";
                                                } else{
                                                  echo "Online Course";
                                                }
                                            } else { 
                                                echo "Instructor Led Course";
                                            }?>
                                            <?php //if($list['type']==1) { echo "Online Course"; } else if ($list['type']==2){ echo "Instruction Led Course"; } ?>
                                        </td>
                                        <td><?= $list['created']->format('d M, Y') ?> </td>
                                        <?php /* <td><?= $list['modified']->format('d M, Y') ?> </td> */ ?>
                                        <td class="action1">

                                            <a href="<?= $url ?>" title="View Course Details" class="action_links btn-primary btn-sm"><i class="fa fa-file-text-o" aria-hidden="true"></i></a>
                                            
                                            <a href="<?= BASEURL?>/enrollments/?search_text=<?= $list['title'] ?>" title="See Enrolled Drivers" class="action_links btn-success btn-sm"><i class="fa fa-sign-in" aria-hidden="true"></i></a>

                                            <!-- <a href="" title="Manage Grades & Attendences"><i class="fa fa-clock-o" aria-hidden="true"></i></a> View Enrollments-->
                                            <?php /*if($list['type']==1) { ?>
                                                <?= $this->Html->link('<i class="fa fa-pencil-square-o" aria-hidden="true"></i>',['action'=>'onlineCourse',$list['id']],['class'=>'edit','escape'=>false]) ?> &nbsp;
                                                <?php } else if($list['type']==2) { ?>
                                                <?= $this->Html->link('<i class="fa fa-pencil-square-o" aria-hidden="true"></i>',['action'=>'instructorCourse',$list['id']],['class'=>'edit','escape'=>false]) ?> &nbsp;
                                                <?php } ?>
                                                <?= $this->Html->link('<i class="fa fa-trash-o" aria-hidden="true"></i>','#',['class'=>'delete','escape'=>false]) ?> */ ?>
                                        </td>
                                    </tr>
                                    <?php } } else { ?>
                                    <tr>
                                        <td class="text-center" colspan="6"> No Records Found! </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                            <?php if(count(@$courses)>0) {  ?>
                            <?= $this->element('paginator') ?>
                            <?php } ?>
                        </div>
                        <!-- end course-table -->
                    </div>
                    <!-- end col -->
                </div>
                <!-- end row -->

                <?php /*
                <div class="extrarow">
                    <div class="olarea">
                        <ul>
                            <!--<li>
                                <?= $this->Html->link('View','',['class'=>'btn btn-primary']) ?>
                                </li> -->
                            <li>
                                <?= $this->Html->link('Enrollments',[],['class'=>'btn btn-default enrollments']) ?>
                            </li>
                            <!-- <li>
                                <?= $this->Html->link('demo','',['class'=>'btn btn-warning ']) ?>
                                </li>
                                <li>
                                <?= $this->Html->link('demo','',['class'=>'btn btn-success']) ?>
                                </li> -->
                        </ul>
                    </div>
                    <div class="insarea">
                        <ul>
                            <li>
                                <?= $this->Html->link('Manage Sessions','#',['class'=>'btn btn-primary manage_sessions','id'=>'']) ?>
                            </li>
                            <li>
                                <?= $this->Html->link('Manage Grades & Attendences','',['class'=>'btn btn-warning attendences']) ?>
                            </li>
                            <!--<li>
                                <?php $this->Html->link('demo','',['class'=>'btn btn-warning']) ?>
                                </li>
                                <li>
                                <?php $this->Html->link('demo','',['class'=>'btn btn-success']) ?>
                                </li>-->
                        </ul>
                    </div>
                </div> */ ?>

            </div>
            <!-- end container -->
        </section>
        <!-- end section -->
    </section>
    <!-- end section -->
</div>
</div><!-- end main -->
<?= $this->Html->script('common.js') ?>
<style type="text/css">
    /*.container-fluid {max-width:1300px !important;margin-right:0px;}
    .container-fluid .row { width : 88%;float: left }
    .extrarow {float: left; width: 10%; padding-left: 33px;}
    .extrarow ul li { list-style: none; padding:  10px 0; }
    .extrarow .btn { width:145px;font-size: 13px; white-space : normal;}
    .olarea,.insarea { display: none; }*/
</style>