<?php $this->assign('title','My Profile') ?>
<div class="breadcrumbs">
             <a href="#">Admin</a> <span>&rtrif;</span>
              <a href="<?= BASEURL?>pages/">My profile</a> 
            </div>
        	<section id="inner-content">
            	<div class="section-titlebar">
                	<h2 class="section-title"> My Profile</h2>
                </div>
<div class="toggle-wrap">
    <div class="clear"></div>
    <div class="toggle-content pp_inline edited-sec">
<?= $this->Form->create($profile,['inputDefaults' => ['label' => false,'div' => false],'novalidate'=>'novalidate']); ?>
<div class="toggles-container">
                	<div class="toggle-wrap">
                	 <div class="toggle-title">My Profile</div>
                	   <div class="toggle-content">
						<div class="fm-fild">
						First Name
						 <div class="spacer-10"></div>
						<?= $this->Form->input('fname',['label'=>false]) ?>
						<div class="spacer-10"> </div>
						</div>

						<div class="fm-fild1">
						Last Name
						 <div class="spacer-10"></div>
						<?= $this->Form->input('lname',['label'=>false]) ?>
						<div class="spacer-10"> </div>
						</div>

						
						<div class="fm-fild1">
						Email
						 <div class="spacer-10"></div>
						<?= $this->Form->input('email',['label'=>false]) ?>

						 <div class="spacer-10"></div>
						 </div>

						 <div class="fm-fild">
						Password
						 <div class="spacer-10"></div>
							<?= $this->Form->input('passwrd',['type'=>'password','value'=>'','label'=>false,'placeholder'=>'Leave blank if you do not want to change password']) ?>
							<?= $this->Form->isFieldError('password') ? $this->Form->error('password') : ''; ?>
						 <div class="spacer-10"></div>
						 </div>

						 <div class="fm-fild1">
						 Confirm Password
						 <div class="spacer-10"></div>
							<?= $this->Form->input('cpassword',['type'=>'password','value'=>'','label'=>false,'placeholder'=>'Leave blank if you do not want to change password']) ?>
							<?= $this->Form->isFieldError('confirm_password') ? $this->Form->error('confirm_password') : ''; ?>
						 <div class="spacer-10"></div>
						 </div>

						 
						<div class="spacer-10"> </div>
						
						<div class="fm-fild1">
						
							<?= $this->Form->submit('Save',['escape'=>false,'div'=>false,'class'=>'btn simple-button margin-bttn']) ?>
							
						<?= $this->Form->button('Cancel',['type'=>'button','id'=>'cancelButton','class'=>'simple-button margin-bttn']) ?>
						<div class="spacer-10"> </div>
						</div>
						</div></div>
						<?= $this->Html->script('../ckeditor/ckeditor.js') ?>
 	<script>
	$(document).ready(function () {             
		//CKEDITOR.env.isCompatible = true;         
		CKEDITOR.replace('ContentHtml');       
  });
	</script>
	<style type="text/css">
		img.toggle-menu
		{
			display: none;
		}
	</style>
						
						

		