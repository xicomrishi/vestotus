<?php $this->layout = false; ?>
      <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
            <h5 class="modal-title">Assessment </h5>          
          </div>
          <div class="modal-body">
          <?= $this->Form->create($session,['type'=>'file','id'=>'sessionform']) ?>
            <?= $this->Form->hidden('session_id',['id'=>'session_id','value'=>$session['id']]) ?>
            <?php $this->Form->templates($form_templates['frontForm']); ?>
            <div class="modal-container ">
            <div class="tab-first">
                            <ul class="nav nav-tabs" role="tablist">
                                <li role="presentation" class="active"><a href="#session1" role="tab" data-toggle="tab">Details</a></li>
                                <li role="presentation"><a href="#session2" role="tab" data-toggle="tab">Schedule</a></li>
                               
                                
                            </ul>

                            <div class="tab-content">
                              <div role="tabpanel" class="tab-pane active" id="session1" style="display:block;">
                                    <div class="tab-padding clearfix">
                                      <div class="form-group">
                                      <?= $this->Form->input('title',['class'=>'form-control']) ?>
                                      </div> 
                                      <div class="form-group">
                                      <label>Description</label>
                                      <?= $this->Form->textarea('description',['class'=>'form-control']) ?>
                                      </div> 
                                      <div class="form-group">
                                      <?= $this->Form->input('instructor_id',['class'=>'form-control','id'=>'instructor','empty'=>'Select Instructors','options'=>$instructors]) ?>
                                      </div> 
                                      <div class="form-group">
                                      <label>Change Log / Notes</label>
                                      <?= $this->Form->textarea('notes',['class'=>'form-control',]) ?>
                                      </div> 
                                      <div class="form-group">
                                      <?= $this->Form->submit('Save',['name'=>'sessionsave','class'=>'btn btn-primary']) ?>
                                      </div>
                                    </div>
                                </div>
                                <div role="tabpanel" class="tab-pane" id="session2" style="display:none;">
                                    <table class="classesdiv">
                                    <?php foreach($session['session_classes'] as $classes) { ?>
                                      <tr id="class_<?= $classes['id']?>">
                                      <td> <?= $classes['start_date'].' '.$classes['start_time']?> - <?= $classes['end_date'].' '.$classes['end_time']?>  </td>
                                      <td><?= $classes['durantion'] ?> </td>
                                      <td> <?= $this->Html->link('<i class="fa fa-trash"></i>','javascript:void(0);',['onclick'=>'del_class('.$classes['id'].')','escape'=>false]) ?></td>
                                      </tr>
                                    <?php } ?>
                                    </table>
                                    <div class="divwrapclass">
                                      <div class="form-group">
                                      <label>Class Start Date and Time</label>
                                      <div class="col-md-6 col-sm-6">
                                      <?= $this->Form->input('start_date',['label'=>false,'class'=>'form-control date',]) ?>
                                      </div>
                                      <div class="col-md-6 col-sm-6">
                                      <?= $this->Form->input('start_time',['label'=>false,'class'=>'form-control ',]) ?>
                                      </div>
                                      </div> 
                                    
                                      <div class="form-group">
                                      <label>Class End Date and Time</label>
                                      <div class="col-md-6 col-sm-6">
                                      <?= $this->Form->input('end_date',['label'=>false,'class'=>'form-control date',]) ?>
                                      </div>
                                      <div class="col-md-6 col-sm-6">
                                      <?= $this->Form->input('end_time',['label'=>false,'class'=>'form-control ',]) ?>
                                      </div>
                                    </div>

                                    <div class="form-group">
                                      <?= $this->Form->input('duration',['label'=>'Duration','class'=>'form-control',]) ?>
                                    </div>
                                    <div class="form-group">
                                      <?= $this->Form->input('venue_id',['label'=>'Venues','class'=>'form-control','empty'=>'Select Venues','options'=>$venues]) ?>
                                    </div>

                                </div>
                                <?= $this->Form->input('Add Class',['name'=>'saveclasses','escape'=>false,'label'=>false,'type'=>'submit','class'=>'button button--wayra','style'=>"width:100%;",'id'=>'add_classbtn']) ?>
                                
                            </div>
                        </div>

</div>
<?= $this->Form->end() ?>
 <div class="modal-footer">
            <button type="button" class="btn btn-primary" data-dismiss="modal"> Done <i class="fa fa-check" aria-hidden="true"></i> </button>
            
          </div>
</div>

          </div>

          </div>

  
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script>
  $( function() {
    $( ".date" ).datepicker();
  } );
  </script>
         