<?php  $this->layout = 'no-header'; ?>

<section class="section">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 col-md-offset-3">
                        <div class="widget contentwidget">
                            <div class="loginbox text-center">
                                <figure>
                                    <a class="navbar-brand" href="<?= BASEURL?>"> <img src="<?= BASEURL?>images/logo-white.png" class="header-logo"> </a>
                                </figure>
                                <h3>Forgot Password</h3>
                                <div class="loginform">
                                   
                                    <?= $this->Form->create($user,['class'=>'row']) ?>
                                     <div class="col-md-12">
<?php $this->Form->templates($form_templates['simpleForm']); ?>
<?= $this->Form->input('email',['id'=>'email','class'=>'form-control','placeholder'=>'Email']) ?>

<?= $this->Form->submit('Submit',['class'=>'btn btn-primary btn-block btn-lg'])?>
 </div>

<?= $this->Form->end() ?>
                                        
                                        
                                       
                                       
                                
                                </div>        
                            </div><!-- end newsletter -->
                        </div><!-- end widget -->
                    </div>
                </div>
            </div>
        </section>