<div id="main">
    <div class="visible-md visible-xs visible-sm mobile-menu">
        <button type="button" data-toggle="offcanvas"><i class="fa fa-bars"></i></button>
    </div>
    <section class="bgw clearfix course-detail-master">
        <div class="page-title bgg">
            <div class="container-fluid clearfix">
                <div class="title-area pull-left">
                    <h2>Venue Details </h2>
                </div>
                <!-- /.pull-right -->
                <div class="pull-right hidden-xs">
                    <div class="bread">
                        <ol class="breadcrumb">
                            <li><a href="<?= BASEURL?>users/dashboard">Home</a></li>
                            <li ><a href="<?= BASEURL?>venues/">Venue</a></li>
                            <li class="active">update</li>
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
                                    <span> Venue Details </span>
                                </h2>
                            </div>
                            <!-- end big-title -->
                            <div class="loginform learners-form">
                                <?= $this->Form->create($venue,['class'=>'row']) ?>
                                <?php $this->Form->templates($form_templates['frontForm']); ?>
                                    <div class="form-group	col-md-6">
                                        <?= $this->Form->input('title',['label'=>'Venue Title','class'=>'form-control','placeholder'=>'Venue Title','readonly']) ?>
                                    </div>
                                    <div class="form-group	col-md-6">
                                        <?= $this->Form->input('max_class_size',['class'=>'form-control','placeholder'=>'Max Class Size','min'=>0,'readonly']) ?>
                                    </div>
                                    <div class="form-group	col-md-6">
                                        <?= $this->Form->input('type',['class'=>'form-control','disabled','empty'=>'Select','options'=>['Classrooms'=>'Classrooms','ConnectPro'=>'ConnectPro','WebEx'=>'WebEx','GoToMeeting'=>'GoToMeeting','Url'=>'Url']]) ?>
                                    </div>
                                    <div class="form-group	col-md-6">
                                        <?= $this->Form->input('address',['class'=>'form-control','placeholder'=>'Street','readonly']) ?>
                                    </div>
                                    <div class="form-group	col-md-6">
                                        <?= $this->Form->input('country_id',['id'=>'country','class'=>'form-control','placeholder'=>'Country','empty'=>'Select Country','options'=>$countries,'disabled']) ?>
                                    </div>
                                    <div class="form-group	col-md-6">
                                        <?= $this->Form->input('state_id',['id'=>'state','class'=>'form-control','empty'=>'Select State','options'=>$states,'disabled']) ?>
                                    </div>
                                    <div class="form-group	col-md-6">
                                        <?= $this->Form->input('city',['class'=>'form-control','placeholder'=>'City','disabled']) ?>
                                    </div>
                                    <div class="form-group	col-md-6">
                                        <?= $this->Form->input('postal_code',['class'=>'form-control','placeholder'=>'Postal Code','readonly']) ?>
                                    </div>
                                    <div class="form-group	col-md-6">
                                        <label> Description </label>
                                        <?= $this->Form->textarea('description',['class'=>'form-control','placeholder'=>'Description','readonly']) ?>
                                    </div>
                                </form> 
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end col -->
            </div>
            <!-- end row -->
</div>
<!-- end container -->
</section><!-- end section -->
</section><!-- end section -->
<?= $this->Html->script('myscript.js') ?>

