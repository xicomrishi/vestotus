

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
                        <li ><a href="<?= BASEURL?>enrollments/">Enrollments</a></li>
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
                        <div class="big-title">
                            <h2 class="related-title">
                                <span>Users</span>
                            </h2>
                        </div>
                        <!-- end big-title -->
                        <div class="loginform ">
                            <?= $this->Form->create($enrollment,['class'=>'row']) ?>
                            <?php $this->Form->templates($form_templates['frontForm']); ?>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <?= $this->Form->input('users',['multiple'=>true,'options'=>[],'label'=>'Select Users','class'=>'form-control','placeholder'=>'Username']) ?>
                                </div>
                                <div class="big-title">
                                    <h2 class="related-title">
                                        <span>Courses</span>
                                    </h2>
                                </div>
                                <div class="form-group">
                                    <?= $this->Form->input('courses',['multiple'=>true,'options'=>[],'label'=>'Select Courses','class'=>'form-control','placeholder'=>'Courses','id'=>'courses']) ?>
                                </div>
                                <?= $this->Form->submit('SEND',['class'=>'button button--wayra btn-block btn-square btn-lg']) ?>
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
        $('#courses').select2({
            allowClear: true, 'placeholder' : "Select or input a Course.",
            minimumInputLength: 2 ,
            ajax: {
                url: "<?= BASEURL?>courses/getcourses/",
                dataType: 'json',
                quietMillis: 200,
                multiple : true,
                data: function (term, page) {
                  return {
                    term: term, //search term
                    flag: 'selectprogram',
                    page: page // page number
                  };
                },
                results: function (data) {
                  console.log(data);
                  return {results: data};
                }
            },
            dropdownCssClass: "bigdrop",
            escapeMarkup: function (m) { return m; }
        });  
      
        $('#users').select2({allowClear: true, 'placeholder' : "Select or input a Course.",
            minimumInputLength: 2 ,
            ajax: {
              url: "<?= BASEURL?>users/getlearners/",
              dataType: 'json',
              quietMillis: 200,
              multiple : true,
              data: function (term, page) {
                return {
                  term: term, //search term
                  flag: 'selectprogram',
                  page: page // page number
                };
              },
              results: function (data) {
                console.log(data);
                return {results: data};
              }
            },
            dropdownCssClass: "bigdrop",
            escapeMarkup: function (m) { return m; }
        });  
    });
</script>

