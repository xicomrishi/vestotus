<?php $this->assign('title','My Profile') ?>
<div class="">
  <div class="row">


            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="x_panel tile fixed_height_320">
                <div class="x_title">
                  <h2>My Profile</h2>
                  <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                    
                    <li><a class="close-link"><i class="fa fa-close"></i></a>
                    </li>
                  </ul>
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">
                 <?= $this->Form->create($profile,['type' =>'file','novalidate'=>'novalidate','class'=>'form-horizontal form-label-left']); ?>
                    <?php $this->Form->templates($form_templates['fullForm']); ?>
                      <div class="item form-group">
                        <?= $this->Form->input('fullname',['label'=>'Fullname *','class'=>'form-control col-md-7 col-xs-12']) ?>
                     </div>
                     <div class="item form-group">
                       <?= $this->Form->input('email',['label'=>'Email *','class'=>'form-control col-md-7 col-xs-12','disabled'=>'disabled']) ?>
                      </div>

                      <div class="item form-group">
                       
                          <?= $this->Form->input('password',['label'=>'Password *','class'=>'form-control col-md-7 col-xs-12','value'=>'','placeholder'=>'Leave blank if you do not want to change password ']) ?>
                       </div>

                      <div class="item form-group">
                     
                          <?= $this->Form->input('confirm_password',['type'=>'password','label'=>'Confirm Password *','class'=>'form-control col-md-7 col-xs-12','value'=>'','placeholder'=>'Leave blank if you do not want to change password ']) ?>
                       </div>

                   
                      <div class="form-group item">
                        <div class="col-md-6 col-md-offset-3">
                        <?= $this->Form->submit('Update',['label'=>false,'class'=>'btn btn btn-success']) ?>
                        <button class="btn btn btn-primary" onclick="javascript:window.history.back(-1);">Cancel</button>
            
                        </div>
                      </div>
                    <?= $this->Form->end() ?>
   <div class="ln_solid"></div>
                 </div>
                </div>
              </div>
            </div>
          </div>