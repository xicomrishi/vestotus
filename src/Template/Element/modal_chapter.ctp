
<div class="modal fade" id="myModal-shareKey">
    <?= $this->Form->create('shareKey',['id'=>'shareKeyform','url'=>['action'=>'shareKey']]) ?>
    <?php $this->Form->templates($form_templates['frontForm']); ?>
    <?= $this->Form->hidden('id',['id'=>'keyid']) ?>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title">Please enter email Addresses seperated with commas.</h5>
            </div>
            <div class="modal-body">
                <div class="modal-container">
                    <div class="form-group">
                        <label>Emails</label>
                        <?= $this->Form->textarea('emails',['class'=>'form-control','label'=>false]) ?>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary"> Share <i class="fa fa-check" aria-hidden="true"></i> </button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel <i class="fa fa-ban" aria-hidden="true"></i> </button>
            </div>
        </div>
    </div>
    <?= $this->Form->end() ?>
</div>

<div class="modal fade" id="myModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title">Please select a lesson type<!-- learning object type --> </h5>
            </div>
            <div class="modal-body">
                <div class="modal-container center">
                    <a class="circle-select">
                        <i class="fa fa-file-text" aria-hidden="true"></i>
                        <input type="radio" name="chapter_type" value="ppt" checked="checked" class="radio-hide" id="test1" />
                        <label for="test1" class="square-radio"></label>
                        <p>PPT</p>
                    </a>
                    <a class="circle-select">
                        <i class="fa fa-volume-up" aria-hidden="true"></i>
                        <input type="radio" name="chapter_type" value="audio" class="radio-hide" id="test2" />
                        <label for="test2" class="square-radio"></label>
                        <p>Audio</p>                        
                    </a>
                    <a class="circle-select">
                        <i class="fa fa-video-camera" aria-hidden="true"></i>
                        <input type="radio" name="chapter_type" value="video" class="radio-hide" id="test3" />
                        <label for="test3" class="square-radio"></label>
                        <p>Video</p>                        
                    </a>
                    <a class="circle-select assessmentlink">
                        <i class="fa fa-folder" aria-hidden="true"></i>
                        <input type="radio" name="chapter_type" value="assessment" class="radio-hide" id="test4" />
                        <label for="test4" class="square-radio"></label>
                        <p>Assessment</p>
                    </a>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="chapter_type_button"> Next <i class="fa fa-angle-right" aria-hidden="true"></i> </button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel <i class="fa fa-ban" aria-hidden="true"></i> </button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="myModal-video">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title">Video Lesson</h5>
            </div>
            <div class="modal-body">
                <?= $this->Form->create('chapter',['type'=>'file','id'=>'chapteraddform','url'=>'#']) ?>
                <?= $this->Form->hidden('type',['value'=>'video']) ?>
                <?php $this->Form->templates($form_templates['frontForm']); ?>
                <div class="modal-container">
                    <div class="form-group">
                        <?= $this->Form->input('title',['placeholder'=>'Title','class'=>'form-control']) ?>
                    </div>
                    <div class="form-group">
                        <?= $this->Form->input('lesson_no',['placeholder'=>'Lesson Number','class'=>'form-control','label'=>'Lesson Number','type'=>'number']) ?>
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
                        <label>Video</label>
                        <?php echo $this->Form->input('files[]', array('accept'=>"video/mp4",'label'=>false,'type' => 'file', 'multiple','class'=>'btn btn-default')); ?>
                        <p class="help-block">Recommended mp4 <a href="#" class="delete-btn"> <i class="fa fa-trash-o" aria-hidden="true"></i> </a></p>
                    </div>
                    <!--<button class="button button--wayra" data-toggle="modal" data-target="#myModal">Add Video <i class="fa fa-plus" aria-hidden="true"></i> </button> -->
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="course_id" value="<?= $course_id ?>" >
                    <button type="button" class="btn btn-primary backchaptertype" id="back1"> Back <i class="fa fa-angle-left" aria-hidden="true"></i> </button>
                    <button type="submit" class="btn btn-primary" id="chapteradd"> Continue <i class="fa fa-check" aria-hidden="true"></i> </button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel <i class="fa fa-ban" aria-hidden="true"></i> </button>
                </div>
                <?= $this->Form->end() ?>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="myModal-audio">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title">Audio Lesson</h5>
            </div>
            <div class="modal-body">
                <?= $this->Form->create('chapter',['type'=>'file','id'=>'chapteraddform2']) ?>
                <?= $this->Form->hidden('type',['value'=>'audio']) ?>
                <?php $this->Form->templates($form_templates['frontForm']); ?>
                <div class="modal-container">
                    <div class="form-group">
                        <?= $this->Form->input('title',['placeholder'=>'Title','class'=>'form-control']) ?>
                    </div>
                    <div class="form-group">
                        <?= $this->Form->input('lesson_no',['placeholder'=>'Lesson Number','class'=>'form-control','label'=>'Lesson Number','type'=>'number']) ?>
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
                        <?php echo $this->Form->input('files[]', array('accept'=>"audio/mp3",'label'=>false,''=>'','type' => 'file', 'multiple','class'=>'btn btn-default')); ?>
                        <p class="help-block">Recommended mp3 audio  <a href="#" class="delete-btn"> <i class="fa fa-trash-o" aria-hidden="true"></i> </a></p>
                    </div>
                    <!-- <button class="button button--wayra" data-toggle="modal" data-target="#myModal">Add Audio <i class="fa fa-plus" aria-hidden="true"></i> </button>-->
                </div>
            </div>
            <div class="modal-footer">
                <input type="hidden" name="course_id" value="<?= $course_id ?>" >
                <button type="button" class="btn btn-primary backchaptertype"> Back <i class="fa fa-angle-left" aria-hidden="true"></i> </button>
                <button type="submit" class="btn btn-primary"> Continue <i class="fa fa-check" aria-hidden="true"></i> </button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel <i class="fa fa-ban" aria-hidden="true"></i> </button>
            </div>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
<div class="modal fade" id="myModal-ppt">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title">PPT Lesson </h5>
            </div>
            <div class="modal-body">
                <div class="modal-container">
                    <?= $this->Form->create('chapter',['type'=>'file','id'=>'chapteraddform3']) ?>
                    <?= $this->Form->hidden('type',['value'=>'ppt']) ?>
                    <?php $this->Form->templates($form_templates['frontForm']); ?>
                    <div class="modal-container">
                        <div class="form-group">
                            <?= $this->Form->input('title',['placeholder'=>'Title','class'=>'form-control']) ?>
                        </div>
                        <div class="form-group">
                            <?= $this->Form->input('lesson_no',['placeholder'=>'Lesson Number','class'=>'form-control','label'=>'Lesson Number','type'=>'number']) ?>
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
                    <input type="hidden" name="course_id" value="<?= $course_id ?>" >
                    <button type="button" class="btn btn-primary backchaptertype" id=""> Back <i class="fa fa-angle-left" aria-hidden="true"></i> </button>
                    <button type="submit" class="btn btn-primary"> Continue <i class="fa fa-check" aria-hidden="true"></i> </button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel <i class="fa fa-ban" aria-hidden="true"></i> </button>
                </div>
                <?= $this->Form->end() ?>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="myModal-assessment">
    <div class="modal-dialog bigger-popup" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title">Assessment </h5>
            </div>
            <div class="modal-body">
                <div class="modal-container assessment">
                    <ul class="add_assessments">
                    </ul>
                    <?= $this->Form->create('chapter',['type'=>'file','id'=>'chapteraddform4']) ?>
                    <?= $this->Form->hidden('type',['value'=>'assessment']) ?>
                    <?php $this->Form->templates($form_templates['frontForm']); ?>
                    <!-- <button class="button button--wayra add_question" type="button" >Add Questions <i class="fa fa-plus" aria-hidden="true"></i> </button>-->
                    <div id = "assessmentbasic" class="assessments_div">
                        <div class="form-group">
                            <?= $this->Form->input('title',['placeholder'=>'Title','class'=>'form-control','label'=>'Title']) ?>
                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <?= $this->Form->textarea('description',['class'=>'form-control','placeholder'=>'Description','Label'=>'Description','id'=>'description']) ?>
                        </div>
                        <div class="form-group">
                            <label>Notes</label>
                            <?= $this->Form->textarea('notes',['rows'=>2,'class'=>'form-control','placeholder'=>'Notes','Label'=>'Notes','id'=>'notes']) ?>
                        </div>
                        <div class="form-group">
                            <label>Type</label>
                            <?= $this->Form->input('test_type',['label'=>false,'class'=>'form-control','empty'=>false,'options'=>['1'=>'No Time','2'=>'Time'],'id'=>'test_type']) ?>
                        </div>
                        <div class="form-group">
                            <label>Time Limit</label>
                            <?= $this->Form->input('time_limit',['label'=>false,'class'=>'form-control','empty'=>false,'options'=>['3600'=>'1 Hour','7200'=>'2 Hour','10800'=>'3 Hour','14400'=>'4 Hour','18000'=>'5 Hour','21600'=>'6 Hour','25200'=>'7 Hour','28800'=>'8 Hour','32400'=>'9 Hour','36000'=>'10 Hour'],'id'=>'time_limit']) ?>
                        </div>
                        <div class="form-group">
                            <label>Passing Percent</label>
                            <select name="pass_percent" class='form-control'>
                                <?php for($i=0; $i<=100; $i++){ ?>
                                    <option value="<?= $i ?>"><?= $i ?>%</option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div id = "assessment_0" class="assessments_div" >
                        <div class="form-group">
                            <?= $this->Form->input('question',['placeholder'=>'Question','class'=>'form-control','label'=>'Question']) ?>
                        </div>
                        <div class="form-group optionsmaindiv">
                            <?php /*
                            <!-- ?= $this->Html->link('<i class="fa fa-plus"> </i> Add Option','javascript:void(0);',['onclick'=>'add_options_link(0);', 'class'=>'btn btn-primary', 'escape'=>false]) ?>
                            
                            <div class="col-md-3">
                                <?= $this->Form->input('options[]',['id'=>'0_1','placeholder'=>'Options','class'=>'form-control options','label'=>'Options']) ?>  
                            </div>
                            <div class="col-md-3">
                                <?= $this->Form->input('options[]',['id'=>'0_2','placeholder'=>'Options','class'=>'form-control options','label'=>false]) ?>  
                            </div>
                            <div class="col-md-3">
                                <?= $this->Form->input('options[]',['id'=>'0_3','placeholder'=>'Options','class'=>'form-control options','label'=>false]) ?>  
                            </div>
                            <div class="col-md-3">
                                <?= $this->Form->input('options[]',['id'=>'0_4','placeholder'=>'Options','class'=>'form-control options','label'=>false]) ?> 
                            </div> */ ?> 

                            <?= $this->Form->input('options[]',['id'=>'0_1','placeholder'=>'Options','class'=>'form-control options','label'=>'Options']) ?>  
                            <?= $this->Form->input('options[]',['id'=>'0_2','placeholder'=>'Options','class'=>'form-control options','label'=>false]) ?>  
                            <?= $this->Form->input('options[]',['id'=>'0_3','placeholder'=>'Options','class'=>'form-control options','label'=>false]) ?>  
                            <?= $this->Form->input('options[]',['id'=>'0_4','placeholder'=>'Options','class'=>'form-control options','label'=>false]) ?>  
                        </div>
                        <div class="form-group correctdiv">
                            <?= $this->Form->input('answer',['placeholder'=>'Answer','class'=>'form-control','label'=>'Answer']) ?>  
                        </div>
                        <input type="hidden" name="course_id" value="<?= $course_id ?>" >
                        <?= $this->Form->submit('Save',['class'=>'btn btn-primary'])?>
                    </div>
                    <?= $this->Form->end() ?>  
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal"> Done <i class="fa fa-check" aria-hidden="true"></i> </button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel <i class="fa fa-ban" aria-hidden="true"></i> </button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="edit-video">
    <div class="modal-dialog bigger-popup" role="document">
        <div class="modal-content">
        </div>
    </div>
</div>
<div class="modal fade" id="edit-audio">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        </div>
    </div>
</div>
<div class="modal fade" id="edit-ppt">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        </div>
    </div>
</div>
<div class="modal fade" id="edit-assessment">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        </div>
    </div>
</div>
<div class="modal fade" id="sessionModel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title">Assessment </h5>
            </div>
            <div class="modal-body">
                <?= $this->Form->create('chapter',['type'=>'file','id'=>'sessionform']) ?>
                <?= $this->Form->hidden('session_id',['id'=>'session_id']) ?>
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
                                    <!-- <div class="form-group">
                                        <label>Change Log / Notes</label>
                                        <?= $this->Form->textarea('notes',['class'=>'form-control',]) ?>
                                        </div>  -->
                                </div>
                            </div>
                            <div role="tabpanel" class="tab-pane" id="session2" style="display:none;">
                                <!-- <table class="classesdiv">
                                    </table> -->
                                <div class="form-group">
                                    <label>Session Start Date and Time</label>                                        
                                    <div class="form-control-wrapper">
                                        <input type="text" name="start_date" id="start-date" class="mydate form-control floating-label col-sm-6" placeholder="Date">
                                        <input type="text" name="start_time" id="start-time" class="time form-control floating-label col-sm-6" placeholder="Time">
                                        <!-- <input type="text" class="date-format form-control floating-label" placeholder="Begin Date Time"> -->
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Class End Date and Time</label>                                                                              
                                    <div class="form-control-wrapper">
                                        <input type="text" name="end_date" id="end-date" class="mydate form-control floating-label col-sm-6" placeholder="Date">
                                        <input type="text" name="end_time" id="end-time" class="time form-control floating-label col-sm-6" placeholder="Time">
                                        <!-- <input type="text" class="date-format form-control floating-label" placeholder="Begin Date Time"> -->
                                    </div>
                                </div>
                                <div class="form-group"> <?= $this->Form->input('max_class_size',['id'=>'max_class_size','type'=>'number','label'=>'Max Class Size','class'=>'form-control',]) ?> </div>
                                <div class="form-group">
                                    <?= $this->Form->input('venue_id',['label'=>'Venues','class'=>'form-control','empty'=>'Select Venues','options'=>$venues]) ?>
                                </div>
                                <div class="form-group">
                                    <input type="hidden" name="course_id" value="<?= $course_id ?>" >
                                    <button type="submit" class="btn btn-primary" id="sessionsave" > Done <i class="fa fa-check" aria-hidden="true"></i> 
                                    </button>
                                </div>
                                <?php //$this->Form->input('Add Class',['name'=>'saveclasses','escape'=>false,'label'=>false,'type'=>'submit','class'=>'button button--wayra','style'=>"width:100%;",'id'=>'add_classbtn']) ?>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="sessionsave" value="1">
                </div>
                <?= $this->Form->end() ?>
            </div>
        </div>
    </div>
</div>
</div>
<div class="modal fade" id="editsessionModel">
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

