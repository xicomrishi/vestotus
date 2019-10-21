
<?= $this->assign('title',"Manage Users") ?>
<div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Manage Email Templates</h3>
              </div>

            
            </div>
            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Email Teplates <small> </small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                     
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <?= $this->Form->create($template,['class'=>'form-horizontal form-label-left']) ?>
<?php $this->Form->templates($form_templates['fullForm']); ?>
<div class="col-md-12">
<div class="item form-group">
<?= $this->Form->input('template_name',['label'=>'Template Name','class'=>'form-control col-md-7 col-xs-12','placeholder'=>'Venue Title']) ?>
</div>

<div class="item form-group">
<?= $this->Form->input('subject',['class'=>'form-control col-md-7 col-xs-12','placeholder'=>'Subject']) ?>
</div>


<div class="item form-group">
<?= $this->Form->input('from_name',['class'=>'form-control col-md-7 col-xs-12','placeholder'=>'From Name']) ?>
</div>

<div class="item form-group">
<?= $this->Form->input('from_email',['class'=>'form-control col-md-7 col-xs-12','placeholder'=>'From Email']) ?>
</div>

<div class="item form-group">
<?= $this->Form->input('cc',['class'=>'form-control col-md-7 col-xs-12','placeholder'=>'CC']) ?>
</div>

<div class="item form-group">
<?= $this->Form->input('bcc',['class'=>'form-control col-md-7 col-xs-12','placeholder'=>'BCC']) ?>
</div>

<div class="clear"> </div>
<div class="item form-group">

<label class="control-label col-md-3 col-sm-3 col-xs-12" for="title">Body</label>
<div class="col-md-6 col-sm-6 col-xs-12">
<?= $this->Form->textarea('body',['type'=>'text','label'=>'Description','class'=>'form-control col-md-7 col-xs-12','placeholder'=>'Description']) ?>
</div>

</div>
<div class="clear"> </div>


<div class="clear"> </div>

 <div class="form-group">
                        <div class="col-md-6 col-md-offset-3">


<?= $this->Form->submit('Save',['class'=>'btn btn btn-success']) ?>
<?= $this->Form->button('Cancel',['type'=>'button','id'=>'cancelButton','class'=>'btn btn-primary','onClick'=>'window.history.back(-1);']) ?>


</div></div>
</div>
</form> 
                  </div>
                </div>
              </div>
            </div>
          </div>

						<?= $this->Html->script('../admin/vendors/ckeditor/ckeditor.js') ?>
 	<script>
	$(document).ready(function () {             
		         
		CKEDITOR.replace('body');     

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
				

 <?= $this->Html->script('myscript.js') ?>
		