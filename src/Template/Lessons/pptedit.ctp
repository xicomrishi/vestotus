 <?= $this->Form->create($videoget,['type'=>'file','class'=>'chaptereditform','url'=>'#']) ?>
<?= $this->Form->hidden('id',['value'=>$videoget['id']])?>
            <?= $this->Form->hidden('type',['value'=>'video']) ?>
            <?php $this->Form->templates($form_templates['frontForm']); ?>
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
            <h5 class="modal-title">Please select a learning object type </h5>          
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
                <?= $this->Form->input('video_width',['class'=>'form-control value-set','placeholder'=>'200','Label'=>'Video Wisth']) ?>
                   <span class="value"> px </span>
                </div>
                <div class="form-group">
                    <label>PPT</label>
                    <ul class="files">
                    <?php foreach($videoget['course_files'] as $files) { ?>
                        <li id="li_<?= $files['id'] ?>"> <?= $files['filename']; ?> <?= $this->Html->link('<i class="fa fa-trash-o"> </i>','javascript:void(0);',['escape'=>false,'onclick'=>"del_course_file(".$files['id'].");"])  ?>
                        </li>
                        <?php
                        }?>

                        </ul>
                     <?php echo $this->Form->input('files[]', array('accept'=>".ppt, .pptx",'label'=>false,''=>'','type' => 'file', 'multiple','class'=>'btn btn-default')); ?>
                    <p class="help-block">Recommended .ppt,.pptx file  <a href="#" class="delete-btn"> <i class="fa fa-trash-o" aria-hidden="true"></i> </a></p>
                </div>
                                                
                <!--<button class="button button--wayra" data-toggle="modal" data-target="#myModal">Add Video <i class="fa fa-plus" aria-hidden="true"></i> </button> -->
              
            </div>
          
          <div class="modal-footer">
            <button type="button" class="btn btn-primary backchaptertype" id="back1"> Back <i class="fa fa-angle-left" aria-hidden="true"></i> </button>
            <button type="submit" class="btn btn-primary" id="chapteradd"> Continue <i class="fa fa-check" aria-hidden="true"></i> </button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel <i class="fa fa-ban" aria-hidden="true"></i> </button>
          </div>
  <?= $this->Form->end() ?>

          