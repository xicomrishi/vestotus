

<div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Generate Key</h3>
              </div>

            
            </div>
            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2> <small> </small></h2>
                   
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <?= $this->Form->create($enrollkey,['type' =>'file','novalidate'=>'novalidate','class'=>'form-horizontal form-label-left']); ?>
                    <?php $this->Form->templates($form_templates['frontForm']); ?>			
<div class="tab-content">

<div role="tabpanel" class="tab-pane active" id="general">
<div class="loginform ">

<div class="col-md-12">
<div class="form-group">
<?= $this->Form->input('name',['label'=>'Name','class'=>'form-control','placeholder'=>'Title']) ?>
</div>
<!--
<div class="form-group">
<?= $this->Form->input('department_id',['empty'=>'Select Department','class'=>'form-control','id'=>'department_id']) ?>
</div>
<div class="form-group">
<?= $this->Form->input('subdepartment_id',['id'=>'subdepartments','empty'=>'Select Sub-department','class'=>'form-control']) ?>
</div>-->

 <div class=" item form-group">
                      <label for="exampleInputPassword1">Courses</label>
                      <?php echo $this->Form->input('course_id', 
                                    array(
                                        'type' => 'select', 
                                        "multiple" => true, 
                                        'label' => false, 
                                        'class' => "form-control select2", 
                                        'placeholder' => "Please Select", 
                                        "options" => $course,
                                        "default"=>(!empty($defaultCourses)) ? explode(',' , $defaultCourses) : '',
                                        'error' => false, 
                                        "required" => true
                                        )
                                    ); 
                      ?>
                    </div>


<div class="item form-group">

	<div class="col-md-6 col-sm-12 no-pd">
<label>Key Name</label>
<div style="display:flex">
	<?= $this->Form->input('key_name',['class'=>'form-control','placeholder'=>'Key Name','label'=>false]) ?>
	<?= $this->Html->link('Generate','javascript:void(0);',['id'=>'generate_key','class'=>'btn btn-primary pull-right']) ?>
	</div>
</div>
	<div class="col-md-6 col-sm-12">
<label>Password</label>
<div style="display:flex">
	<?= $this->Form->input('password',['type'=>'text','label'=>'Password','class'=>'form-control','placeholder'=>'Password','label'=>false]) ?>
	<?= $this->Html->link('Generate','javascript:void(0);',['id'=>'generate_password','class'=>'btn btn-primary pull-right']) ?>
	</div>

</div>

</div>
<div class="form-group">
<label>Username</label>
<p>The key will create a username based on the selection </p>
<div class="col-md-12 col-sm-12">
<div class="col-md-4 col-sm-4">
<input type="radio" name="create_username" <?php if($enrollkey['create_username'] == 1 ) { echo 'checked="checked"'; } ?> checked="checked" class="radio-hide" value="email" id="email">
<label for="email" class="square-radio"></label>
<span class="label">Email Address</span>
</div>
<div class="col-md-4 col-sm-4">
<input type="radio" name="create_username" <?php if($enrollkey['create_username'] == 1 ) { echo 'checked="checked"'; } ?> class="radio-hide" value="email" id="firstlastname">
<label for="firstlastname" class="square-radio"></label>
<span class="label">First Name.Last Name</span>
</div>
<div class="col-md-4 col-sm-4">
<input type="radio" name="create_username" <?php if($enrollkey['create_username'] == 1 ) { echo 'checked="checked"'; } ?> class="radio-hide" value="email" id="userinput">
<label for="userinput" class="square-radio"></label>
<span class="label">User Input</span>
</div>
</div>
</div>
<br>
<div class="form-group">
<label>Start Date</label>
<?php
if($enrollkey['start_date'])
{
  $enrollkey['start_date'] = $enrollkey['start_date']->format('d M, Y');
}
if($enrollkey['end_date'])
{
  $enrollkey['end_date'] = $enrollkey['end_date']->format('d M, Y');
}
?>
<div class="input-group" id="">
  <?= $this->Form->input('start_date',['type'=>'text','label'=>false,'class'=>'date-set form-control form-control','id'=>'start_date']) ?>
  <span class="input-group-addon">
<span class="glyphicon glyphicon-calendar"></span>
</span>
</div>
</div>
<div class="form-group">
<label>End Date</label>
<div class="input-group" id="">
  <?= $this->Form->input('end_date',['type'=>'text','label'=>false,'class'=>'date-set form-control form-control' ,'id'=>'end_date']) ?>
  <span class="input-group-addon">
<span class="glyphicon glyphicon-calendar"></span>
</span>
</div>
</div>
<div class="form-group">
  <?= $this->Form->input('max_uses',['label'=>'Number of Uses','label'=>'Number of Uses','class'=>'form-control']) ?>
</div>
<div class="clear"> </div>
<div class="form-group">
<input type="submit" class="btn btn-primary">
<button class="btn"> Cancel </button>  
  
</div>
</div>
</div>
</div>
</div>           
</div>
<?= $this->Form->end() ?>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
<?= $this->Html->script('select2.full.min.js') ?>

<?= $this->Html->css('select2.min.css') ?>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
        <script>
            $(document).ready(function(){
                var date_input=$('.date');
                var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
                date_input.datepicker({
                    format: 'd M, yyyy',
                    container: container,
                    todayHighlight: true,
                    autoclose: true,
                })
            })
        </script>s
 <script type="text/javascript">
 $(function () {
        $(".select2").select2();
    });

 function generatekey()
{
    var text = "";
    var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

    for( var i=0; i < 10; i++ )
        text += possible.charAt(Math.floor(Math.random() * possible.length));

    return text;
}
  $(document).ready(function(){
    $('#generate_key').click(function(){
      var key = generatekey();
      $('#key-name').val(key);
    });
    $('#generate_password').click(function(){
      var key = generatekey();
      $('#password').val(key);
    });
    
    
    var start = new Date();
    var end = new Date(new Date().setYear(start.getFullYear()+10));
    $('#start_date').datepicker({
      format: 'M d, yy',
    startDate : start,
    endDate : end,
    autoclose: true,
    }).on('changeDate', function(){
        $('#end_date').datepicker('setStartDate', new Date($(this).val()));
       
    }); 
    $('#end_date').datepicker({
        format: 'M d, yy',
        startDate : start,
        endDate   : end,   
        autoclose: true,
    }).on('changeDate', function(){
        $('#start_date').datepicker('setEndDate', new Date($(this).val()));
        
    });
 
    function getDate( element ) {
      var date;
      try {
        date = $.datepicker.parseDate(dateFormat, element.value );
      } catch( error ) {
        date = null;
      }
 
      return date;
    }


   
  
  
  
    });
    ; 
    
  
</script>
 <style type="text/css">
   .modal-backdrop
   {
    display: none;
    opacity: 0;
   }
   span.label
   {
    color:#555;
   }
 </style>