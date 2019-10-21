<?= $this->Form->create('contact',['id'=>'contact','url'=>['action'=>'contactajax']]) ?>
<?php $this->Form->templates($form_templates['simpleForm']) ?>
            <p><div class="control-group warning">
              <div class="controls">
              <?= $this->Form->input('name',['placeholder'=>'Name'])?>
              
              
              </div>
            </div></p>
            
            <p><div class="control-group warning">
              <div class="controls">
              <?= $this->Form->input('email',['placeholder'=>'Email Address'])?>
              </div>
            </div></p>
            
            <p><div class="control-group warning">
              <div class="controls">
              <?= $this->Form->input('phone',['placeholder'=>'Phone'])?>
              </div>
            </div></p>
            
            <p><div class="control-group warning">
              <div class="controls">
               <?= $this->Form->input('job_title',['placeholder'=>'Job Title','id'=>'job_title'])?>
              </div>
            </div></p>
            
            <p><div class="control-group warning">
              <div class="controls">
              <?= $this->Form->input('industry',['placeholder'=>'Industry','id'=>'industry'])?>
              </div>
            </div></p>
            
            <p><div class="control-group warning">
              <div class="controls counter">
              <p class="counter-text">How Many Drivers</p>
              <input type='button' value='-' class='qtyminus' field='drivers' />
              <?= $this->Form->input('drivers',['value'=>'0','class'=>'qty','id'=>'drivers'])?>
              
              <input type='button' value='+' class='qtyplus' field='drivers' />
              <span class="help-inline">Something may have gone wrong</span>
              </div>
            </div></p>
            
            <a href="javascript:void(0);" id="contactsubmit" class="send-button-form-div">SEND</a>
        <?= $this->Form->end() ?>