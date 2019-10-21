
<?php $this->assign('title',$page['title']) ?>
<div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Home Page Content</h3>
              </div>

            
            </div>
            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Content <small>Update </small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                     
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
<?= $this->Form->create($page,['type' =>'file','novalidate'=>'novalidate','class'=>'form-horizontal form-label-left']); ?>
                    
<?php $this->Form->templates($form_templates['fullForm']); ?>
                     
                      

                      <div class="item form-group">
                        
                          
                           <?= $this->Form->input('title',['label'=>'Title *','class'=>'form-control col-md-7 col-xs-12']) ?>
                       </div>
                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Content <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <?= $this->Form->textarea('content',['label'=>false,'id'=>'ContentHtml','class'=>'form-control col-md-7 col-xs-12']) ?>
                        </div>
                      </div>

                      
                     
                      <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-6 col-md-offset-3">
                        <?= $this->Form->submit('Save',['escape'=>false,'div'=>false,'class'=>'btn btn btn-success']) ?>
							
						<?= $this->Form->button('Cancel',['type'=>'button','id'=>'cancelButton','class'=>'btn btn-primary']) ?>
                        
                        </div>
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
    //CKEDITOR.env.isCompatible = true;         
   
    CKEDITOR.replace( 'ContentHtml', {
      // Define the toolbar groups as it is a more accessible solution.
      toolbarGroups: [
        {"name":"basicstyles","groups":["basicstyles"]},
    
        {"name":"paragraph","groups":["list"]},
        
      ],
      // Remove the redundant buttons from toolbar groups defined above.
      removeButtons: 'Underline,Strike,Subscript,Superscript,Anchor,Specialchar'
    } );
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
        