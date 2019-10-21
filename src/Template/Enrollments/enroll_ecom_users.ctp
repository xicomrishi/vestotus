<div id="main">
<div class="visible-md visible-xs visible-sm mobile-menu">
    <button type="button" data-toggle="offcanvas"><i class="fa fa-bars"></i></button>
</div>
<section class="bgw clearfix course-detail-master">
    <div class="page-title bgg">
        <div class="container-fluid clearfix">
            <div class="title-area pull-left">
                <h2>Enroll Users</h2>
            </div>
            <!-- /.pull-right -->
            <div class="pull-right hidden-xs">
                <div class="bread">
                    <ol class="breadcrumb">
                        <li><a href="<?= BASEURL?>users/dashboard">Home</a></li>
                        <li ><a href="<?= BASEURL?>courses/mycourses">E-Com Courses</a></li>
                        <li class="active">Enroll Users</li>
                    </ol>
                </div>
                <!-- end bread -->
            </div>
            <!-- /.pull-right -->
        </div>
    </div>
    <!-- end page-title -->
    <section class="section bgw">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-sm-12">
                    <div class="custom-form clearfix">
                        <div class="loginform ">
                            <?= $this->Form->create($enrollment,['class'=>'row','id'=>'formsubmit']) ?>
                            <?php $this->Form->templates($form_templates['frontForm']); ?>
                            <?= $this->Form->hidden('quantity',['value'=>$course['quantity'],'id'=>'quantity']) ?>
                            <div class="col-md-12">
                                <div class="big-title">
                                    <h2 class="related-title">
                                        <span>Course</span>
                                    </h2>
                                </div>
                                <div class="form-group">
                                    <!-- <label>sfsdf</label> -->
                                    <?= $this->Form->input('courses',['readonly'=>true,'value'=>$course['course']['title'],'label'=>false,'class'=>'form-control','placeholder'=>'Courses','id'=>'courses']) ?>
                                </div>
                                <div class="big-title">
                                    <h2 class="related-title">
                                        <span>Users</span>
                                    </h2>
                                </div>
                                <!-- end big-title -->
                                <div class="form-group">
                                    <select name="users[]" id="users" class="form-control" multiple="">
                                        <option value="">Select Users</option>
                                        <?php foreach($enroll_users_opts as $value){ ?>
                                            <option value="<?= $value['id'] ?>"
                                                <?= (in_array($value['id'],$enrolled_users)) ? 'selected' : '' ?>
                                                ><?php echo ucfirst($value['fname']).$value['lname']; ?></option>
                                        <?php } ?>
                                    </select>
                                    <!-- $this->Form->input('users',['value'=>$enrolled_users['uids'],'label'=>false,'class'=>'form-control','placeholder'=>'Username'])  -->

                                </div>
                                <input type="hidden" name="purchased_course_id" value="<?= $course->id ?>">
                                <?= $this->Form->button('SAVE',['type'=>'button','class'=>'button button--wayra btn-block btn-square btn-lg','id'=>'clickbutton']) ?>
                            </div>
                            </form> 
                        </div>
                    </div>
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

<section class="section bgw"></section>
<?= $this->Html->script('../plugins/select2/dist/js/select2.full.js') ?>
<?= $this->Html->css('../plugins/select2/dist/css/select2.css') ?>
<script type="text/javascript">
    
    $(document).ready(function(){

        var limit_qty = $('#quantity').val();

        // $("#users").select2({multiple:true, tags : true});
        $("#users").select2({multiple:true, maximumSelectionLength : limit_qty, tags : true});
      
        $('#clickbutton').click(function(){ 

            var getusers = $('#users').val();
            var sel_qty = getusers.length;

            if(sel_qty > limit_qty) {
                alert('You cannot select more than '+limit_qty+' users.');
            } else {
                $('#formsubmit').submit();
            }
            // var u = getusers.split(',');
            // u = $.unique(u);
            // var count = u.length;
        });

        // $.ajax({
        //     url: "<?= BASEURL?>enrollments/getenrollmentusers/<?= $course['course_id'] ?>",
        //     dataType: 'json',
        //     type: "GET",
        //     async: false,
        //     success: function (response) {
        //         var response = JSON.stringify(response);
        //         var jsondata  = $.parseJSON(response);
        //         $("#users").select2({maximumSelectionLength : 1 , data : jsondata , multiple:true , tags : true});
        //     }
        // });
      
    
    
    });
</script>