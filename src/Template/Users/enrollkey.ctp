<div class="page-title bgg">
            <div class="container clearfix">
                <div class="title-area pull-left">
                    <h2>EnrollMent Key Resgistration </h2>
                </div><!-- /.pull-right -->
                <div class="pull-right hidden-xs">
                    <div class="bread">
                        <ol class="breadcrumb">
                            <li><a href="<?= BASEURL?>">Home</a></li>
                            <li class="active">Enrollment By Key</li>
                        </ol>
                    </div><!-- end bread -->
                </div><!-- /.pull-right -->
            </div>
        </div>
        <section class="section bgw">
            <div class="container">
                <div class="row">
                    <div id="post-content" class="col-md-12 col-sm-12">
                        <div class="single-content">
                            <div class="row clearfix">
                                <div class="col-md-12">
                                    

                                    <div class="post-padding clearfix">
                                        <div class="col-md-12 col-sm-12">
                        <div class="big-title">
                            <h2 class="related-title">
                                <span>ENROLLMENT FORM</span>
                            </h2>
                        </div><!-- end big-title -->
                        <div class="contact_form">
                        <?= $this->Form->create($user,['class'=>'row','novalidate'=>true]) ?>
                            <?php $this->Form->templates($form_templates['frontForm']); ?>
                            <?= $this->Form->hidden('enrollment_id',['value'=>$getkey['id']]) ?>
                                <div class="col-md-12">
                                <div class="col-md-6 col-sm-12">
                              <?= $this->Form->input('enroll_key',['readonly'=>'readonly','class'=>'form-control','value'=>$getkey['key_name']]) ?>
                              </div>
                               <div class="col-md-6 col-sm-12">
                                <?= $this->Form->input('enroll_password',['readonly'=>'readonly','type'=>'text','class'=>'form-control','value'=>$getkey['password']]) ?>
                                </div>
                                 <div class="col-md-6 col-sm-12">
                              <?= $this->Form->input('fname',['label'=>'First Name','class'=>'form-control','placeholder'=>'First Name']) ?>
                              </div>
                               <div class="col-md-6 col-sm-12">
                                <?= $this->Form->input('lname',['label'=>'Last Name','class'=>'form-control','placeholder'=>'Last Name']) ?>
                                </div>
                                   <div class="col-md-6 col-sm-12">
                                <?= $this->Form->input('username',['id'=>'username','class'=>'form-control','placeholder'=>'Username']) ?>
                                </div>
                                   <div class="col-md-6 col-sm-12">
                                <?= $this->Form->input('email',['id'=>'email','class'=>'form-control','placeholder'=>'Email Address']) ?>
                                </div>
                                   <div class="col-md-6 col-sm-12">
                                <?= $this->Form->input('password',['id'=>'password','class'=>'form-control','placeholder'=>'Password']) ?>
                                </div>
                                   <div class="col-md-6 col-sm-12">
                                <?= $this->Form->input('confirm_password',['type'=>'password','class'=>'form-control','placeholder'=>'Confirm Password']) ?>
                                </div>
                                 <div class="col-md-6 col-sm-12">
                                   
                                <?= $this->Form->input('country',['class'=>'form-control select2','options'=>$this->Common->getCountry(),'placeholder'=>'Country']) ?>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                <?= $this->Form->input('state',['class'=>'form-control','empty'=>'Select State','options'=>[]]) ?>
                                </div>
                                 <div class="col-md-6 col-sm-12">
                                <?= $this->Form->input('city',['class'=>'form-control','placeholder'=>'City']) ?>
                                </div>
                                 <div class="col-md-6 col-sm-12">
                                <?= $this->Form->input('zip',['class'=>'form-control','placeholder'=>'Postal Code']) ?>
                                </div>
                                   <div class="col-md-6 col-sm-12">
                                <?= $this->Form->input('street',['class'=>'form-control','placeholder'=>'Address']) ?>
                                </div>
                                  
                                   
                                  
                                  
                                <div class="clear"></div>
                              <?= $this->Form->submit('Submit',['class'=>'btn btn-primary']) ?>
                                </div>
                            <?= $this->Form->end() ?>
                        </div>
                    </div>
                                    </div><!-- end post-padding -->
                                </div><!-- end col -->
                            </div><!-- end post-padding -->
                        </div><!-- end content -->
                    </div><!-- end col -->
                </div><!-- end row -->
            </div><!-- end container -->
        </section>
<?= $this->Html->script('myscript') ?>