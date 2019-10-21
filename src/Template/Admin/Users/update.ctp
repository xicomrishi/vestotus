<?php $this->assign('title',"Manage Users") ?>

<div class="">
    <!-- <div class="page-title">
        <div class="title_left">
            <h3>Manage Users</h3>
        </div>
    </div>
    <div class="clearfix"></div> -->
    <!-- <div class="row"> -->
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">

                    <h2>Users <small><?= (!isset($user->fname)) ? 'Add' : 'Update' ?> User</small></h2>
                    <!-- <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>
                        <li><a class="close-link"><i class="fa fa-close"></i></a>
                        </li>
                    </ul> -->
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <?= $this->Form->create($user,['type' =>'file','novalidate'=>'novalidate','class'=>'form-horizontal form-label-left']); ?>
                        <?php $this->Form->templates($form_templates['fullForm']); ?>
                        <div class="item form-group">
                            <?= $this->Form->input('fname',['label'=>'First Name *','class'=>'form-control col-md-7 col-xs-12']) ?>
                        </div>
                        <div class="item form-group">
                            <?= $this->Form->input('lname',['label'=>'Last Name *','class'=>'form-control col-md-7 col-xs-12']) ?>
                        </div>
                        <div class="item form-group">
                            <?= $this->Form->input('email',['label'=>'Email *','class'=>'form-control col-md-7 col-xs-12']) ?>
                        </div>
                        <div class="item form-group">
                            <?= $this->Form->input('username',['label'=>'Username *','class'=>'form-control col-md-7 col-xs-12']) ?>
                        </div>
                        <div class="item form-group">
                            <?= $this->Form->input('password',['required'=>false,'placeholder'=>'Leave if you dont want to set password.','label'=>'Password','value'=>'','class'=>'form-control col-md-7 col-xs-12']) ?>
                        </div>
                        <div class="item form-group">
                            <?= $this->Form->input('role',['label'=>'Type *','empty'=>'Select','options'=>['2'=>'Manager','3'=>'Instructor','4'=>'Learner'],'class'=>'form-control col-md-7 col-xs-12']) ?>
                        </div>
                        <div class="item form-group">
                            <?= $this->Form->input('company_id',['label'=>'Select Company','empty'=>'Select Company','options'=>$this->__getCompanyList(true),'class'=>'form-control col-md-7 col-xs-12']) ?>
                        </div>
                        <!-- <div class="item form-group whitelabeling" <?php if($user['role'] != 2) { echo "style='display:none'"; } ?>>
                            <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="role">White Label </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input type="checkbox" name="white_label" value="1" <?php if($user['white_label'] == 1) { echo "checked='checked'"; }?>>
                            </div></div>
                            </div> -->
                        <div class="item form-group">
                            <?= $this->Form->input('status',['label'=>'Status','empty'=>false,'options'=>['1'=>'Active','0'=>'In-active'],'class'=>'form-control col-md-7 col-xs-12']) ?>
                        </div>
                        <div class="ln_solid"></div>
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-3">
                                <?= $this->Form->submit('Save',['escape'=>false,'div'=>false,'class'=>'btn btn btn-success']) ?>
                                <?= $this->Form->button('Cancel',['type'=>'button','id'=>'cancelButton','class'=>'btn btn-primary','onClick'=>'window.history.back(-1);']) ?>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <!-- </div> -->
</div>
<?= $this->Html->script('../admin/vendors/ckeditor/ckeditor.js') ?>
<script>
    $(document).ready(function () {             
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