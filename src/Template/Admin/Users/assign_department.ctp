<!-- <div class="">
    <div class="page-title">
        <div class="title_left">
            <h3>Assign Departments</h3>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="row"> -->
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Assign Departments <small> </small></h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <?= $this->Form->create($userdepartments,['type' =>'file','novalidate'=>'novalidate','class'=>'form-horizontal form-label-left']); ?>
                    <?php $this->Form->templates($form_templates['fullForm']); ?>
                    <div class=" item form-group">
                        <label for="exampleInputPassword1">Select Departments</label>
                        <?php echo $this->Form->input('department_id', 
                            array(
                                'type' => 'select', 
                                "multiple" => true, 
                                'label' => false, 
                                'class' => "form-control select2", 
                                'placeholder' => "Please Select", 
                                "options" => $departments, 
                                "default"=>$assignedIds,
                                'error' => false, 
                                "required" => true
                                )
                            ); 
                            ?>
                    </div>
                    <?php echo $this->Form->input('user_id', 
                        array(
                            'type' => 'hidden', 
                            'value'=>$this->request->pass[0]
                            )
                        ); 
                        ?>
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
    <!-- </div>
</div> -->
<?= $this->Html->script('select2.full.min.js') ?>
<?= $this->Html->css('select2.min.css') ?>          
<script>
    $(document).ready(function () {
                 $(function () {
           $(".select2").select2();
       });
       
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

