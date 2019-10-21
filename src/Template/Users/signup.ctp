<?php  $this->layout = 'no-header'; ?>
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  

<section class="section">
    <div class="container">
    <div class="row">
    <div class="col-md-8 col-md-offset-2">
    <div class="widget contentwidget">
    <div class="loginbox text-center register-sec">
    <figure>
    <a class="navbar-brand" href="<?= BASEURL?>"> <img src="<?= BASEURL?>images/logo-white.png" class="header-logo"> </a>
    </figure>
    <h3>Register</h3>
    <div class="loginform">
    <?= $this->Form->create($user,['class'=>'row','id'=>'signupForm','novalidate'=>true]) ?>
     <div class="col-md-12">
    <?php $this->Form->templates($form_templates['simpleForm']); ?>
    <?= $this->Form->input('fname',['class'=>'form-control','placeholder'=>'First Name']) ?>
    <?= $this->Form->input('lname',['class'=>'form-control','placeholder'=>'Last Name']) ?>
    <?= $this->Form->input('username',['id'=>'username','class'=>'form-control','placeholder'=>'Username']) ?>
    <?= $this->Form->input('email',['id'=>'email','class'=>'form-control','placeholder'=>'Email Address']) ?>
    <?= $this->Form->input('driver_licence',['id'=>'driver_licence','class'=>'form-control','placeholder'=>'Driver Licence']) ?>
     <div class="col-md-3">

    <?= $this->Form->input('expiry.month',['type'=>'number','maxLength'=>2,'style'=>'width:100%;','id'=>'expiry','class'=>'form-control','placeholder'=>'Licence Expiry (mm/yy)']) ?>
    </div>
    <div class="col-md-3">

    <?= $this->Form->input('expiry.year',['style'=>'width:100%;','id'=>'expiry','class'=>'form-control','placeholder'=>'Licence Expiry (mm/yy)']) ?>
    </div>
    <?= $this->Form->input('password',['id'=>'password','class'=>'form-control','placeholder'=>'Password']) ?>
    <?= $this->Form->input('confirm_password',['type'=>'password','class'=>'form-control','placeholder'=>'Confirm Password']) ?>
    <?= $this->Form->input('country',['class'=>'form-control','options'=>$this->Common->getCountry(),'placeholder'=>'Country']) ?>
    <?= $this->Form->input('state',['class'=>'form-control','empty'=>'Select State','options'=>[]]) ?>
    <?= $this->Form->input('street',['class'=>'form-control','placeholder'=>'Address']) ?>
    <?= $this->Form->input('city',['class'=>'form-control','placeholder'=>'City']) ?>
    <?= $this->Form->input('zip',['class'=>'form-control','placeholder'=>'Postal Code']) ?>
    <?= $this->Form->submit('Register',['class'=>'btn btn-primary btn-block btn-lg'])?>
     </div>
    <?= $this->Form->end() ?>
    </div>        
    </div><!-- end newsletter -->
    </div><!-- end widget -->
    </div>
    <div>
    </div>
</section>
<?= $this->Html->script('../plugins/validation/lib/jquery.js') ?>
<?= $this->Html->script('../plugins/validation/dist/jquery.validate.js') ?>

<script type="text/javascript">
    $(document).ready(function(){
       $("#signupForm").validate({
            rules: {
                fname: "required",
                lname: "required",
                username: {
                    required: true,
                    minlength: 2
                },
                password: {
                    required: true,
                    minlength: 5
                },
                confirm_password: {
                    required: true,
                    minlength: 5,
                    equalTo: "#password"
                },
                email: {
                    required: true,
                    email: true
                },
               
            },
            messages: {
                fname: "Please enter your firstname",
                lname: "Please enter your lastname",
                username: {
                    required: "Please enter a username",
                    minlength: "Your username must consist of at least 2 characters"
                },
                password: {
                    required: "Please provide a password",
                    minlength: "Your password must be at least 5 characters long"
                },
                confirm_password: {
                    required: "Please provide a password",
                    minlength: "Your password must be at least 5 characters long",
                    equalTo: "Please enter the same password as above"
                },
                email: "Please enter a valid email address",
                
            }
        });
    });
</script>