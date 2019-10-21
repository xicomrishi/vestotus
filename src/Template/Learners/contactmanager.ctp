<div id="sidebar1" class="col-md-9 col-sm-12">
    <div class="widget clearfix">
        <div class="member-profile">
            <div class="big-title">
                <h2 class="related-title">
                    <span>Contact your Manager</span>
                </h2>
            </div>
            <!-- end big-title -->
            <div class="edit-profile loginform">
                <?= $this->Form->create(@$contactmanager,['class'=>'','type'=>'file']) ?>
                <div class="form-group">
                    <?= $this->Form->input('fname',['label'=>'First Name','class'=>'form-control','readonly'=>true , 'value'=>$this->request->session()->read('Auth.User.fname')])?>
                </div>
                <div class="form-group">
                    <?= $this->Form->input('lname',['label'=>'Last Name','class'=>'form-control','readonly'=>true , 'value'=>$this->request->session()->read('Auth.User.lname')])?>
                </div>
                <div class="form-group">
                    <?= $this->Form->input('email',['readonly'=>'readonly','class'=>'form-control' ,'required'=>true, 'value'=>$this->request->session()->read('Auth.User.email')])?>
                </div>
                <div class="form-group">
                    <?= $this->Form->input('phone',['type'=>'number','minLength'=>10,'class'=>'form-control','required'=>true, 'value'=>$this->request->session()->read('Auth.User.phone')])?>
                </div>
                <div class="form-group">
                    <label> Message </label>
                    <?= $this->Form->textarea('message',['placeholder'=>'Type Here..','required'=>true,'class'=>'form-control'])?>
                </div>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Send Message</button>
            <?= $this->Form->end() ?>
        </div>
        <!-- end edit profile -->
    </div>
    <!-- end team-member -->
</div>
</div>
<?= $this->Html->script('myscript') ?>