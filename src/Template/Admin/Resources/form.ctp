
<?= $this->assign('title',"Manage Resources") ?>
<div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Manage Resources</h3>
              </div>

            
            </div>
            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Resources <small> </small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                     
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <?= $this->Form->create($resource,['class'=>'form-horizontal form-label-left','type'=>'file']) ?>
                  <?php $this->Form->templates($form_templates['fullForm']); ?>
                  <div class="col-md-12">
                   <div class="item form-group">
                  <?= $this->Form->input('course_id',['label'=>'Select Course','class'=>'form-control col-md-7 col-xs-12','options'=>$courses,'empty'=>'Select Course']) ?>
                  </div>
                  <div class="item form-group">
                  <?= $this->Form->input('name',['label'=>'Name','class'=>'form-control col-md-7 col-xs-12','placeholder'=>'Name']) ?>
                  </div>

                  <div class="item form-group">
                  <?php if($resource['files'] ) { 
                          echo $this->Html->link('<i class="fa fa-file-pdf-o" aria-hidden="true"></i>',COURSE_RESOURCE.$resource['files'],['escape'=>false,'style'=>'font-size:25px;','target'=>'_blank']) ;
                  } ?>
                  <?= $this->Form->input('files',['type'=>'File','label'=>'PDF','accept'=>'application/pdf']) ?>
                  </div>


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
		