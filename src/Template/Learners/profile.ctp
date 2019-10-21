<div id="sidebar1" class="col-md-9 col-sm-12">
    <div class="widget clearfix">
        <div class="member-profile">
            <div class="big-title">
                <h2 class="related-title">
                    <span>Edit Basic Profile</span>
                </h2>
            </div>
            <!-- end big-title -->
            <div class="edit-profile loginform">
                <?= $this->Form->create($profile,['class'=>'','type'=>'file']) ?>

                <div class="form-group">
                    <div class="col-md-6 col-sm-6">
                        <?= $this->Form->input('fname',['label'=>'First Name','class'=>'form-control','disabled'=>true])?>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <?= $this->Form->input('lname',['label'=>'Last Name','class'=>'form-control','disabled'=>true])?>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-6 col-sm-6">
                        <?= $this->Form->input('email',['disabled'=>'disabled','class'=>'form-control'])?>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <?= $this->Form->input('username',['disabled'=>'disabled','class'=>'form-control'])?>
                    </div>
                </div>
                <!-- <div class="form-group">
                    <div class="col-md-6 col-sm-6">
                    <?= $this->Form->input('password',['required'=>false,'value'=>'','placeholder'=>'Leave it blank if do not want to change.','class'=>'form-control'])?>
                    </div>
                    <div class="col-md-6 col-sm-6">
                    <?= $this->Form->input('confirm_password',['required'=>false,'label'=>'Re-Enter Password','placeholder'=>'Leave it blank if do not want to change.','class'=>'form-control'])?>
                    </div>
                    </div> -->
                <div class="form-group">
                    <div class="col-md-6 col-sm-6">
                        <?= $this->Form->input('street',['class'=>'form-control','disabled'=>true])?>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <?= $this->Form->input('city_id',['class'=>'form-control','options'=>$this->Common->getCities($profile['state_id']),'disabled'=>true])?>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-6 col-sm-6">
                        <?= $this->Form->input('country_id',['options'=>$this->Common->getCountry(),'class'=>'form-control' ,'disabled'=>true])?>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <?= $this->Form->input('state_id',['options'=>$this->Common->getStates($profile['country_id']),'class'=>'form-control','disabled'=>true])?>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-12 col-sm-12 m-b-20">
                    	<label>Upload Avatar</label>
	                    <?= $this->Form->file('avatar',['class'=>'btn btn-default','id'=>'avatar']) ?>
    	            </div>
    	        </div>
                <div class="form-group">
                    <div class="col-md-12 col-sm-12 m-b-20">
	                    <label>Upload Profile Cover</label>
	                    <?= $this->Form->file('profile_cover',['class'=>'btn btn-default','id'=>'profile_cover']) ?>
	                    <p class="help-block">Recommended size 2400x759 jpg or png</p>
	    	        </div>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Submit Changes</button>
                <?= $this->Form->end() ?>
            </div>
            <!-- end edit profile -->
        </div>
        <!-- end team-member -->
    </div>
</div>
<?= $this->Html->script('myscript') ?>