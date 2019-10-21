<div id="main">
    <div class="visible-md visible-xs visible-sm mobile-menu">
        <button type="button" data-toggle="offcanvas"><i class="fa fa-bars"></i></button>
    </div>
    <section class="bgw clearfix course-detail-master">
        <div class="page-title bgg">
            <div class="container-fluid clearfix">
                <div class="title-area pull-left">
                    <h2>E-Commerse Courses List<small></small></h2>
                </div>
                <!-- /.pull-right -->
                <div class="pull-right hidden-xs">
                    <div class="bread">
                        <ol class="breadcrumb">
                            <li><a href="<?= BASEURL?>users/dashboard">Home</a></li>
                            <li class="active">My E-Commerse Courses</li>
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
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th> <i class="fa fa-list-ul" aria-hidden="true"></i> </th>
                                        <th> Course Image </th>
                                        <th> Course Name </th>
                                        <!-- <th style="width: 25%;"> Notes </th> -->
                                        <th> Type </th>
                                        <th> Enrollments Purchased </th>
                                        <th> Hide Price </th>
                                        <th> Purchased On </th>
                                        <th> Purchased By </th>
                                        <th> Enrolled Users </th>
                                        <th> Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if(count(@$list)>0) { 
                                        $i = 1;
                                        foreach ($list as $list) {
                                            // echo '<pre>'; print_r($list); die;
                                        	$course = $list['course'];
                                        	$rnd = rand(0,10);

                                            $encryptid = $this->Common->myencode($list['course']['id']);
                                            if($list['course']['type']==1) {
                                                $url = BASEURL.'courses/view/'.$encryptid;
                                            } else if($courses['course']['type'] == 2) { 
                                                $url = BASEURL.'courses/viewIled/'.$encryptid;
                                            }
                                        	//echo $course['hide_price'];
                                        ?>
                                    <tr>
                                        <td> <?= $i ?> </td>
                                        <td>
                                            <?php if($course['thumbnail']){ 
                                                $img = FILE_COURSE_THUMB.$course['thumbnail'];
                                            } else{
                                                $img = FILE_COURSE_THUMB_DEFAULT;
                                            } ?>
                                            <a href="<?= $url ?>"><img src="<?= $img ?>" alt="" class="img-responsive thumb-50"></a>
                                        </td>
                                        <td>
                                            <a href="<?= $url ?>"><?= ucfirst($course['title']) ?></a>
                                        </td>
                                        <!-- <td> 
                                            <a href="#"><?= $course['notes'] ?></a>
                                        </td> -->
                                        <td>
                                            <?php if($course['type']==1) { echo "Online Course"; } else if ($course['type']==2){ echo "Instruction Led Course"; } ?>
                                        </td>
                                        <td> <b> Purchased : </b> <?= $list['quantity'] ?><br><b> Available: </b> <?= (int)($list['quantity'] - $list['enrolled_users']) ?></td>
                                        <td><input type="checkbox" name="show_price_to_all" class="show_price_to_all" value="<?= $course['id']?>" <?php if($course['hide_price'] == 1){ echo "checked='checked'";} ?>  ></td>
                                        <td> <?= $list['created']->format('d M, Y') ?> </td>
                                        <td> <?= ($list['purchased_by'] == 'M') ? 'Manager':'Learner' ?> </td>
                                        <td><?= $list['enrolled_users'] ?></td>
                                        <td> 
                                            <a href="<?= $url ?>" title="View Course Details" class="action_links btn-primary btn-sm"><i class="fa fa-file-text-o" aria-hidden="true"></i></a>
                                            
                                            <?php //if($list['enrolled_users'] < $list['quantity']) {

                                                echo $this->Html->link('<i class="fa fa-eye"> </i>','javascript:void(0);',['title'=>'See Enrolled Users','id'=>$list['id'],'escape'=>false,'class'=>'action_links btn-success btn-sm view_enrolled_drivers']);
                                                
                                                if($list['purchased_by'] == 'M'){
                                                    echo $this->Html->link('<i class="fa fa-plus"> </i>',['controller'=>'enrollments','action'=>'enroll_ecom_users',$this->Common->myencode($list['id'])],['title'=>'Enroll Users','escape'=>false,'class'=>'action_links btn-primary btn-sm']);
                                                }
                                                
                                                // echo $this->Html->link('<i class="fa fa-eye"> </i>','javascript:void(0);',['title'=>'See Enrolled Users','id'=>$course['id'],'escape'=>false,'class'=>'action_links btn-success btn-sm view_enrolled_drivers']);
                                                

                                                if($this->is_white_labeled($this->request->session()->read('Auth.User.id')) == 1)
                                                {
                                                	echo $this->Html->link('<i class="fa fa-image"> </i>','javascript:void(0);',['title'=>'Change Logo','id'=>'cid_'.$course['id'],'escape'=>false,'class'=>'action_links btn-default btn-sm upload_image_link']);
                                                }
                                                //} ?>
                                        </td>
                                    </tr>
                                    <?php $i++;} } else { ?>
                                    <tr>
                                        <td colspan="8" class="text-center"> No Records Found! </td>
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
<?= $this->Html->script('common.js') ?>
<script type="text/javascript">
    $(document).ready(function(){
    	$('.show_price_to_all').click(function(){
    		var value = $(this).val();
    		var getid = $(this).attr('id');
    		if($(this).is(':checked') == true)
    		{
    			var status = 1;
    		}
    		else
    		{
    			var status = 2;
    		}
    		//console.log(status);
    		window.location.href = "<?= BASEURL ?>courses/hideprice/"+value+'/'+status;
    	});
    	$('.upload_image_link').click(function(){
    		var getid = $(this).attr('id');
    		var id = getid.split('_');
    		$('#upload_image #course_id').val(id[1]);
    		$('#upload_image').modal('show');
    	});
    	$('.view_enrolled_drivers').click(function(){
    		var id = $(this).attr('id');
    		$.get('<?= BASEURL ?>admin/courses/getenrolledusers/'+id,function(response){
    			var result = $.parseJSON(response);
    			$('.list_of_drivers li ').remove();
    			$.each(result,function(key,val){
    				$('#view_courses_modal .driver_name').html(val.title);
    				var cnt = "<li>"+val.fname+" "+val.lname+"    <span class='dateenrl'> Date Of Enrollment :  "+val.date+"</span></li>";
    				$('#view_courses_modal .list_of_drivers').append(cnt);
    			});
    			$('#view_courses_modal').modal('show');
    			
    		});
    	});
    })
</script>
<style type="text/css">
    .list_of_drivers li
    {
    text-align: left;
    }
    .list_of_drivers li span
    {
    color:#3ca1db;
    font-weight: 600;
    font-size: 10px;
    padding-left:20px;
    }
</style>

