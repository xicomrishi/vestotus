<?php $this->assign('title',"Manage Users") ?> 
<!-- <div class="">
    <div class="page-title">
        <div class="title_left">
            <h3>Manage Users</h3>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="row"> -->
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Users <small> Update Learner</small></h2>
                    <!-- <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>
                        <li><a class="close-link"><i class="fa fa-close"></i></a>
                        </li>
                    </ul> -->
                    <div class="clearfix"></div>
                </div>
                <ul class="nav nav-tabs nav-pills ">
                    <li id="1" class="active"><a data-toggle="tab" href="#home">General Information</a></li>
                    <li id="2"><a data-toggle="tab" href="#menu1">Details</a></li>
                    <li id="3"><a data-toggle="tab" href="#menu2">Account</a></li>
                    <li><a data-toggle="tab" href="#menu2">More</a></li>
                </ul>
                <div class="tab-content">
                    <div id="home" class="tab-pane fade in active panel-body">
                        <?= $this->Form->create($user,['type' =>'file','novalidate'=>'novalidate','class'=>'form-horizontal form-label-left']); ?>
                        <?php $this->Form->templates($form_templates['fullForm']); ?>
                        <div class="item form-group">
                            <?= $this->Form->input('fname',['label'=>'First Name *','class'=>'form-control','style'=>'width:450px']) ?>
                        </div>
                        <div class="item form-group">
                            <?= $this->Form->input('lname',['label'=>'Last Name *','class'=>'form-control','style'=>'width:450px']) ?>
                        </div>
                        <div class="item form-group">
                            <?= $this->Form->input('goes_by_name',['label'=>'Nick Name','class'=>'form-control','style'=>'width:450px']) ?>
                        </div>
                        <div class="item form-group">
                            <?= $this->Form->input('email',['label'=>'Email *','class'=>'form-control','style'=>'width:450px']) ?>
                        </div>
                        <div class="item form-group">
                            <?= $this->Form->input('username',['label'=>'Username *','class'=>'form-control','style'=>'width:450px']) ?>
                        </div>
                        <div class="item form-group">
                            <?= $this->Form->input('password',['required'=>false,'placeholder'=>'Leave if you dont want to set password.','label'=>'Password','value'=>'','class'=>'form-control','style'=>'width:450px']) ?>
                        </div>
                        <div class="item form-group hidden">
                            <?= $this->Form->input('role',['label'=>'Type *','value'=>4,'type'=>'hidden']) ?>
                        </div>
                        <div class="item form-group">
                            <?= $this->Form->input('company_id',['label'=>'Select Company','empty'=>'Select Company','options'=>$this->__getCompanyList(true),'class'=>'form-control','style'=>'width:450px']) ?>
                        </div>
                        <!-- <div class="item form-group">
                            <label>White Label?</label>
                            <input type="checkbox" name="white_label" value="1" <?php if($user['white_label'] == 1) { echo "checked='checked'"; }?>>
                            </div> -->
                        <div class="item form-group">
                            <?= $this->Form->input('status',['label'=>'Status','empty'=>false,'options'=>['1'=>'Active','0'=>'In-active'],'class'=>'form-control','style'=>'width:450px']) ?>
                            <?= $this->Form->input('step',['type'=>'hidden','value'=>1]) ?>
                        </div>
                        <div class="ln_solid"></div>
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-3">
                                <?= $this->Form->submit('Next',['escape'=>false,'div'=>false,'class'=>'btn btn btn-success']) ?>
                                <a href="<?php echo $this->request->webroot; ?>admin/users" class="btn btn-primary">Exit</a>
                            </div>
                        </div>
                        </form>
                    </div>
                    <div id="menu1" class="tab-pane fade panel-body">
                        <?= $this->Form->create($user,['type' =>'file','novalidate'=>'novalidate','class'=>'form-horizontal form-label-left']); ?>
                        <?php $this->Form->templates($form_templates['fullForm']); ?>
                        <div class="item form-group">
                            <?= $this->Form->input('driver_licence',['label'=>'Driving Licence','class'=>'form-control','required'=>true,'class'=>'form-control','style'=>'width:450px']) ?>
                        </div>
                        <div class="item form-group licence-date dmy-controls">
                            <?= $this->Form->input('expiry',['label'=>'Licence Exipry Date','class'=>'form-control','type'=>'date','style'=>'width:450px' , 'empty' => true,
                                'minYear' => date('Y'),
                                'maxYear' => date('Y')+10,
                                'options' => array('1','2')]) ?> 
                        </div>
                        <div class="item form-group">
                            <?= $this->Form->input('country_id',['class'=>'form-control','style'=>'width:450px','label'=>'Country','options'=>$this->Common->getCountry(),'empty'=>'Select Country *']) ?>
                        </div>
                        <div class="item form-group">
                            <?= $this->Form->input('state_id',['class'=>'form-control','style'=>'width:450px','label'=>'State *','options'=>$this->Common->getStates($user['country_id']),'empty'=>'Select Country']) ?>
                        </div>
                        <div class="item form-group">
                            <?= $this->Form->input('city_id',['class'=>'form-control','style'=>'width:450px','options'=>$this->Common->getCities($user['state_id']),'label'=>'City *']) ?>
                        </div>
                        <div class="item form-group">
                            <?= $this->Form->input('address',['label'=>'Home Adress *','class'=>'form-control','style'=>'width:450px']) ?>
                        </div>
                        <div class="item form-group">
                            <?= $this->Form->input('street',['class'=>'form-control','style'=>'width:450px','label'=>'Street']) ?>
                        </div>
                        <div class="item form-group">
                            <?= $this->Form->input('zip',['label'=>'Zip Code *','class'=>'form-control','style'=>'width:450px']) ?>
                        </div>
                        <div class="item form-group dmy-controls">
                            <?= $this->Form->input('birthday',['label'=>'Date of Birth','class'=>'form-control','type'=>'date','style'=>'width:450px' , 'empty' => true,
                                'minYear' => date('Y')-130,
                                'maxYear' => date('Y'),
                                'options' => array('1','2')]) ?>
                        </div>
                        <div class="item form-group dmy-controls">
                            <?= $this->Form->input('date_of_hire',['label'=>'Date of hire','class'=>'form-control',  'empty' => true,
                                'minYear' => date('Y')-130,
                                'maxYear' => date('Y'),
                                'options' => array('1','2'),'type'=>'date' ,'required'=>true,'style'=>'width:450px']) ?>
                        </div>
                        <div class="item form-group">
                            <?= $this->Form->input('education_level',['label'=>'Education Level','class'=>'form-control','style'=>'width:450px']) ?>
                        </div>
                        <div class="item form-group">
                            <?= $this->Form->input('language_spoken',['label'=>'Languages Spoken','class'=>'form-control','placeholder'=>'comma separated','style'=>'width:450px']) ?>
                        </div>
                        <?= $this->Form->input('step',['type'=>'hidden','value'=>2]) ?>
                        <?= $this->Form->submit('Next',['escape'=>false,'div'=>false,'class'=>'btn btn btn-success']) ?>
                        <a href="<?php echo $this->request->webroot; ?>admin/users" class="btn btn-primary">Exit</a>
                        </form>
                    </div>
                    <div id="menu2" class="tab-pane fade">
                        <p>No content</p>
                    </div>
                </div>
            </div>
        </div>
    <!-- </div>
</div> -->
<?= $this->Html->script('../admin/vendors/ckeditor/ckeditor.js') ?>
<?= $this->Html->script('../admin/js/common.js') ?>
<style>
    .dmy-controls .col-md-6.col-sm-6.col-xs-12 {
    width:12.5%
    }
    select {
    height: 43px;
    width: 100%;
    }
</style>
<script>
    $(document).ready(function () { 
               $('select[name="expiry[day]"]').hide();
               <?php if($step){ ?>
                      setTimeout(function(){
                          $('li#<?= $step ; ?> > a').trigger('click');
                      },200) ;
               <?php } ?>
               
             
       
           $('#role').change(function(){
         var getrole = $(this).val();
       
         if(getrole == 2)
         {
           $('.whitelabeling').fadeIn();
         }
         else
         {
           $('.whitelabeling').hide();
         }
    
       });        
         
    
       $('#banner').change(function(){
         var reader = new FileReader();
         var ext = $(this).val().split('.').pop();
         ext = ext.toLowerCase();
         if(ext=='jpg' || ext=='jpeg'   || ext=='png' || ext=='gif')
         {
                  reader.onload = function (e) {
    
                   $('.img_preview').attr('src',e.target.result);
                   $('.img_preview').fadeIn();
                 
                    
               }
               reader.readAsDataURL(this.files[0]);
         }
         else
         {
           $('.img_preview').fadeOut();
         }
       });  
     });
</script>

