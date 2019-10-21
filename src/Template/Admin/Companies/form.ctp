<?php $this->assign('title',"Manage Companies") ?>
<div class="">
            <!-- <div class="page-title">
              <div class="title_left">
                <h3><?= $title ; ?></h3>
              </div>

            
            </div>
            <div class="clearfix"></div> -->

            <!-- <div class="row"> -->
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <!-- <h2>Manage Companies<small> <?= $title ; ?></small></h2> -->
                    <h2><?= $title ; ?> Company</h2>
                    <!-- <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                     
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul> -->
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <?= $this->Form->create($company,['type' =>'file','novalidate'=>'novalidate','class'=>'form-horizontal form-label-left']); ?>
                    <?php $this->Form->templates($form_templates['fullForm']); ?>
                     
                    <div class="item form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12"> Logo </label>
                    <div class="col-md-3 col-sm-3 col-xs-12">
                      <?= $this->Form->file('image',['id'=>'logo','class'=>'','placeholder'=>'Logo']) ?>
                      </div>
                      <div class="col-md-3 col-sm-3 col-xs-12">
                      <?php if($company['logo']){ $img = BASEURL.'uploads/'.$company['logo']; } else { $img = BASEURL."images/imgplaceholder.jpg"; } ?>
                      <?= $this->Html->image($img,['height'=>"100px",'class'=>'img_preview']) ?>
                      </div>
                      </div>

                      <div class="item form-group">
                      <?= $this->Form->input('company_name',['label'=>'Company Name','class'=>'form-control','placeholder'=>'Company Name']) ?>
                      </div>

                      <div class="item form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12"> Description </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <?= $this->Form->textarea('description',['label'=>'Description','class'=>'form-control']) ?>
                        </div>
                      </div>


                      <div class="item form-group">
                        <?= $this->Form->input('is_whitelabel',['label'=>'Enable White Labelling?','empty'=>false,'options'=>['1'=>'Yes','0'=>'No'],'class'=>'form-control col-md-7 col-xs-12']) ?>
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
		   

    $('#logo').change(function(){
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
        //$('.img_preview').fadeOut();
      }
    });  
  });
	</script>
				

		