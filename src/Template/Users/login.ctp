<?php  $this->layout = 'no-header'; ?>
<section class="section">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="widget contentwidget">
                    <div class="loginbox text-center full-input">
                        <figure>
                            <a class="navbar-brand" href="<?= BASEURL?>"> <img src="<?= BASEURL?>images/logo-white.png" class="header-logo"> </a>
                        </figure>
                        <h3>Login</h3>
                        <p>Please login account in below. If no account please <a href="<?= BASEURL?>users/signup">create new one</a> here.</p>
                        <div class="loginform">
                        <?= $this->Form->create($user,['class'=>'row']) ?>
                            <div class="col-md-12">
                        <?php $this->Form->templates($form_templates['simpleForm']); ?>
                        <?= $this->Form->input('username',['id'=>'username','class'=>'form-control','value'=>$loginCookie['username'],'placeholder'=>'Username']) ?>
                        <?= $this->Form->input('password',['id'=>'password','class'=>'form-control','value'=>$loginCookie['password'],'placeholder'=>'Password']) ?>
                        <?= $this->Form->submit('Login',['class'=>'btn btn-primary btn-block btn-lg'])?>
                         </div>
                         <div class="checkbox checkbox-warning">
                            <input id="checkbox1" value='1' name="rememberme" type="checkbox" class="styled" checked>
                            <label for="checkbox1">
                                <small>Remember me</small>
                            </label>
                            <p class="forgot"><a href="<?= BASEURL ?>users/forgotPassword"> Forgot password </a> </p>                                       
                        </div>
                        <?= $this->Form->end() ?>
                    </div>        
                </div><!-- end newsletter -->
            </div><!-- end widget -->
        </div>
    </div>
</div>
</section>