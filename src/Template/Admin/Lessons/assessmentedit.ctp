<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
    </button>
    <h5 class="modal-title">Assessment </h5>
</div>
<div class="modal-body">
    <div class="modal-container" style="height:300px;overflow:scroll;">
        <ul class="add_assessments">
            <?php foreach($videoget['assessments'] as $assessment) { ?>
            <li id="liass_<?= $assessment['id'] ?>">
                <label><?= $assessment['question'] ?> : <?= $assessment['answer'] ?> </label>
                <?= $this->Html->link('<i class="fa fa-trash"> </i>','javascript:void(0);',['onclick'=>"del_assessment(".$assessment['id'].");",'escape'=>false]) ?>
            </li>
            <?php } ?>
        </ul>
        <?= $this->Form->create($videoget,['type'=>'file','id'=>'assessmentedit']) ?>
        <?= $this->Form->hidden('id',['value'=>$videoget['id']])?>
        <?= $this->Form->hidden('type',['value'=>'assessment']) ?>
        <?php $this->Form->templates($form_templates['frontForm']); ?>
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
            <?php 
                $pass_opts = [];
                for($i=0; $i<=100; $i++){ 
                    $pass_opts[$i] = $i.'%';
                } 
            ?>
            <div class="form-group">
                <label>Passing Percent</label>
                <?= $this->Form->input('pass_percent',['label'=>false,'class'=>'form-control','empty'=>false,'options'=>$pass_opts,'id'=>'pass_percent']) ?>
            </div>
        </div>
        <div id = "assessment_0" class="assessments_div" >
            <div class="form-group">
                <?= $this->Form->input('question',['placeholder'=>'Question','class'=>'form-control','label'=>'Question']) ?>
            </div>
            <div class="form-group optionsmaindiv">
                <!-- <div class="col-md-12">
                <?= $this->Html->link('<i class="fa fa-plus"> </i>Add Option','javascript:void(0);',['onclick'=>'add_options_link(0);','escape'=>false,'class'=>'btn btn-primary']) ?>
                <label>Options</label>
                </div>
                <div class="col-md-3">
                <?= $this->Form->input('options[]',['id'=>'0_1','placeholder'=>'Options','class'=>'form-control options','label'=>false]) ?>  
                </div>
                <div class="col-md-3">
                <?= $this->Form->input('options[]',['id'=>'0_2','placeholder'=>'Options','class'=>'form-control options','label'=>false]) ?>  
                </div>
                <div class="col-md-3">
                <?= $this->Form->input('options[]',['id'=>'0_3','placeholder'=>'Options','class'=>'form-control options','label'=>false]) ?>  
                </div>
                <div class="col-md-3">
                <?= $this->Form->input('options[]',['id'=>'0_4','placeholder'=>'Options','class'=>'form-control options','label'=>false]) ?>  
                </div> -->

                <?= $this->Html->link('<i class="fa fa-plus"> </i>Add Option','javascript:void(0);',['onclick'=>'add_options_link(0);','escape'=>false,'class'=>'btn btn-primary']) ?>
                <?= $this->Form->input('options[]',['id'=>'0_1','placeholder'=>'Options','class'=>'form-control options','label'=>'Options']) ?>  
                <?= $this->Form->input('options[]',['id'=>'0_2','placeholder'=>'Options','class'=>'form-control options','label'=>false]) ?>  
                <?= $this->Form->input('options[]',['id'=>'0_3','placeholder'=>'Options','class'=>'form-control options','label'=>false]) ?>  
                <?= $this->Form->input('options[]',['id'=>'0_4','placeholder'=>'Options','class'=>'form-control options','label'=>false]) ?> 
            </div>
            <div class="form-group correctdiv">
                <?= $this->Form->input('answer',['placeholder'=>'Answer','class'=>'form-control','label'=>'Answer']) ?>  
            </div>
            <?= $this->Form->submit('Save',['class'=>'btn btn-primary'])?>
        </div>
        <?= $this->Form->end() ?>  
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-primary" data-dismiss="modal"> Done <i class="fa fa-check" aria-hidden="true"></i> </button>
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel <i class="fa fa-ban" aria-hidden="true"></i> </button>
</div>