  <?= $this->Form->create($videoget,['type'=>'file','class'=>'chaptereditform']) ?>
            <?= $this->Form->hidden('type',['value'=>'audio']) ?>
            <?= $this->Form->hidden('id',['value'=>$videoget['id']])?>
            <?php $this->Form->templates($form_templates['frontForm']); ?>
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
            
          </div>
          <div class="modal-body">
        
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
                    <label>Audio</label>
                    <ul class="files">
                    <?php foreach($videoget['course_files'] as $files) { ?>
                        <li id="li_<?= $files['id'] ?>"> <?= $files['filename']; ?> <?= $this->Html->link('<i class="fa fa-trash-o"> </i>','javascript:void(0);',['escape'=>false,'onclick'=>"del_course_file(".$files['id'].");"])  ?>
                        </li>
                        <?php
                        }?>

                        </ul>
                     <?php echo $this->Form->input('files[]', array('accept'=>"audio/mp3",'label'=>false,''=>'','type' => 'file', 'multiple','class'=>'btn btn-default')); ?>
                    <p class="help-block">Recommended mp3 audio  <a href="#" class="delete-btn"> <i class="fa fa-trash-o" aria-hidden="true"></i> </a></p>
                </div>
                 
            </div>
          </div>
          <div class="modal-footer">
            
            <button type="submit" class="btn btn-primary"> Save <i class="fa fa-check" aria-hidden="true"></i> </button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel <i class="fa fa-ban" aria-hidden="true"></i> </button>
          </div>
  <?= $this->Form->end() ?>
  
