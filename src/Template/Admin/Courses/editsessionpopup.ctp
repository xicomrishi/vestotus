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
                  <li role="presentation" class="active"><a href="#editsession1" onClick="showtab('editsession1','editsession2')" role="tab" data-toggle="tab">Details</a></li>
                  <li role="presentation"><a href="#editsession2" onClick="showtab('editsession2','editsession1')" role="tab" data-toggle="tab">Schedule</a></li>
              </ul>

              <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="editsession1" style="display:block;">
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
                        <!-- <div class="form-group">
                        <label>Change Log / Notes</label>
                        <?= $this->Form->textarea('notes',['class'=>'form-control',]) ?>
                        </div>  -->
                        
                      </div>
                  </div>
                <div role="tabpanel" class="tab-pane" id="editsession2" style="display:none;">
                    
                    <?php $classes = $session['session_classes'][0]; ?>
                      
                    
                    
                    
                      <div class="form-group">
                      <label>Class Start Date and Time</label>
                      <div class="col-md-6 col-sm-6">
                      <?= $this->Form->input('start_date',['label'=>false,'class'=>'mydate form-control date','value'=>$classes['start_date']]) ?>
                      </div>
                      <div class="col-md-6 col-sm-6">
                      <?= $this->Form->input('start_time',['label'=>false,'class'=>'time form-control ','value'=>$classes['start_time']]) ?>
                      </div>
                      </div> 
                    
                      <div class="form-group">
                      <label>Class End Date and Time</label>
                      <div class="col-md-6 col-sm-6">
                      <?= $this->Form->input('end_date',['label'=>false,'class'=>'mydate form-control date','value'=>$classes['end_date']]) ?>
                      </div>
                      <div class="col-md-6 col-sm-6">
                      <?= $this->Form->input('end_time',['label'=>false,'class'=>'time form-control ','value'=>$classes['end_time']]) ?>
                      </div>
                    </div>
                    <div class="form-group"> <?= $this->Form->input('max_class_size',['id'=>'max_class_size','type'=>'number','label'=>'Max Class Size','class'=>'form-control','value'=>$classes['max_class_size']]) ?> </div>
                    
                    <div class="form-group">
                      <?= $this->Form->input('venue_id',['value'=>$classes['venue_id'],'label'=>'Venues','class'=>'form-control','empty'=>'Select Venues','options'=>$venues]) ?>
                    </div>
                                    
                    <div class="form-group">
                      <button type="submit" class="btn btn-primary" id="sessionsave" > Done <i class="fa fa-check" aria-hidden="true"></i> 
                      </button>
                    </div>
                  </div>
                        </div>
                        <input type="hidden" name="sessionsave" value="1">
                       
</div>

<?= $this->Form->end() ?>

</div>

          </div>

          </div>

  <?= $this->Html->css('bootstrap-material-datetimepicker.css') ?>
  <?= $this->Html->script('momentjs.js') ?>
  <?= $this->Html->script('bootstrap-material-datetimepicker.js') ?>
		<script type="text/javascript">
		$(document).ready(function()
		{
			$('.mydate').bootstrapMaterialDatePicker
			({
				time: false,
				clearButton: true
			});

			$('.time').bootstrapMaterialDatePicker
			({
				date: false,
				shortTime: true,
				format: 'HH:mm'
			});

			$('.date-format').bootstrapMaterialDatePicker
			({
				format: 'dddd DD MMMM YYYY - HH:mm',
				shortTime: true,
			});
			$('#date-fr').bootstrapMaterialDatePicker
			({
				format: 'DD/MM/YYYY HH:mm',
				lang: 'fr',
				weekStart: 1, 
				cancelText : 'ANNULER',
				nowButton : true,
				switchOnClick : true
			});

			$('#date-end').bootstrapMaterialDatePicker
			({
				weekStart: 0, format: 'DD/MM/YYYY HH:mm'
			});
			$('#date-start').bootstrapMaterialDatePicker
			({
				weekStart: 0, format: 'DD/MM/YYYY HH:mm', shortTime : true
			}).on('change', function(e, date)
			{
				$('#date-end').bootstrapMaterialDatePicker('setMinDate', date);
			});

			$('#min-date').bootstrapMaterialDatePicker({ format : 'DD/MM/YYYY HH:mm', minDate : new Date() });

			//$.material.init()
		});
		</script>