  <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
            <h5 class="modal-title">Please select a learning object type </h5>          
          </div>
          <div class="modal-body">
            <div class="modal-container">
            <?= $this->Form->create('chapter',['type'=>'file','id'=>'chaptereditform3']) ?>
            <?= $this->Form->hidden('type',['value'=>'ppt']) ?>
            <?php $this->Form->templates($form_templates['frontForm']); ?>
            <div class="modal-container">
                <div class="form-group">
                   <?= $this->Form->input('title',['placeholder'=>'Title','class'=>'form-control']) ?>
                </div>
                <div class="form-group">
                <label>Description</label>
                  <?= $this->Form->textarea('description',['class'=>'form-control','placeholder'=>'Description','Label'=>'Description']) ?>
                </div>
                <div class="form-group">
                    <label>Notes</label>
                    <?= $this->Form->textarea('notes',['rows'=>2,'class'=>'form-control','placeholder'=>'Notes','Label'=>'Notes']) ?>
                </div>
               
                <div class="form-group">
                    <label>PPT</label>
                     <?php echo $this->Form->input('files[]', array('accept'=>".ppt, .pptx",'label'=>false,''=>'','type' => 'file', 'multiple','class'=>'btn btn-default')); ?>
                    <p class="help-block">Recommended .ppt,.pptx file  <a href="#" class="delete-btn"> <i class="fa fa-trash-o" aria-hidden="true"></i> </a></p>
                </div>                         
                
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary backchaptertype" id=""> Back <i class="fa fa-angle-left" aria-hidden="true"></i> </button>
            <button type="submit" class="btn btn-primary"> Continue <i class="fa fa-check" aria-hidden="true"></i> </button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel <i class="fa fa-ban" aria-hidden="true"></i> </button>
          </div>
<?= $this->Form->end() ?>

          </div>