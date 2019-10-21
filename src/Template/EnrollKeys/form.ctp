
<div id="main">
            <div class="visible-md visible-xs visible-sm mobile-menu">
                <button type="button" data-toggle="offcanvas"><i class="fa fa-bars"></i></button>
            </div>

            <section class="bgw clearfix course-detail-master">           	
			        
			         <div class="page-title bgg">
			            <div class="container-fluid clearfix">
			                <div class="title-area pull-left">
			                    <h2>Enroll Key </h2>
			                </div><!-- /.pull-right -->
			                <div class="pull-right hidden-xs">
			                    <div class="bread">
			                        <ol class="breadcrumb">
			                            <li><a href="<?= BASEURL?>users/dashboard">Home</a></li>
			                            <li ><a href="<?= BASEURL?>EnrollKeys/">Enrollment Keys</a></li>
			                            <li class="active">update</li>
			                        </ol>
			                    </div><!-- end bread -->
			                </div><!-- /.pull-right -->
			            </div>
			        </div><!-- end page-title -->
          
			            	<section class="section bgw">
					            <div class="container">
					                <div class="row">
					                    <div class="col-md-12 col-sm-12">
	<div class="tab-first">

<?= $this->Form->create($enrollkey,['class'=>'row','novalidate'=>true]) ?>
<?php $this->Form->templates($form_templates['frontForm']); ?>			
<div class="tab-content">

<div role="tabpanel" class="tab-pane active" id="general">
<div class="loginform ">

<div class="col-md-12">
<div class="form-group">
<?= $this->Form->input('name',['label'=>'Name','class'=>'form-control','placeholder'=>'Title']) ?>
</div>

<div class="form-group">
<?= $this->Form->input('department_id',['empty'=>'Select Department','class'=>'form-control','id'=>'department_id']) ?>
</div>
<div class="form-group">
<?= $this->Form->input('subdepartment_id',['id'=>'subdepartments','empty'=>'Select Sub-department','class'=>'form-control']) ?>
</div>
<div class="form-group">

<?= $this->Form->input('courses',['multiple'=>true,'options'=>[$enrollkey['courses']],'label'=>'Select Courses','class'=>'form-control','placeholder'=>'Courses','id'=>'courses']) ?>
</div>

<div class="form-group">
<div class="col-md-12 col-sm-12 no-pd key-word">
	<div class="col-md-6 col-sm-12 no-pd">
	<?= $this->Form->input('key_name',['class'=>'form-control','placeholder'=>'Key Name']) ?>
	<?= $this->Html->link('Generate','javascript:void(0);',['id'=>'generate_key','class'=>'btn btn-primary pull-right']) ?>
	</div>
	<div class="col-md-6 col-sm-12">
	<?= $this->Form->input('password',['type'=>'text','label'=>'Password','class'=>'form-control','placeholder'=>'Password']) ?>
	<?= $this->Html->link('Generate','javascript:void(0);',['id'=>'generate_password','class'=>'btn btn-primary pull-right']) ?>
	</div>
</div>
<div class="form-group">
<div class="col-md-12 col-sm-12">

<div class="col-md-6 col-sm-12">
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
</div><!-- end col -->
</div><!-- end row -->
</div><!-- end container -->
</section><!-- end section -->
</section><!-- end section -->


<?= $this->Html->css('../plugins/select2/dist/css/select2.css') ?>

<?= $this->Html->script("../plugins/select2/dist/js/select2.full.js") ?>

 <script type="text/javascript">
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


    var s2 = $('#courses').select2({allowClear: true, 'placeholder' : "Select or input a Course.",
  minimumInputLength: 2 ,
  ajax: {
    url: "<?= BASEURL?>courses/getcourses/",
    dataType: 'json',
    quietMillis: 200,
    multiple : true,
    
    data: function (term, page) {
      return {
        term: term, //search term
        flag: 'selectprogram',
        page: page // page number
      };
    },
    results: function (data) {
      console.log(data);
      return {results: data};
    }
  },
  dropdownCssClass: "bigdrop",
  escapeMarkup: function (m) { return m; }
    
    
  }); 
    <?php if($ckeys) { ?>
s2.val(<?= $ckeys ?>).trigger("change");
<?php } ?>
  $('#department_id').change(function(){
    var getvalue = $(this).val();
    if(getvalue)
    {
      $.get('<?= BASEURL?>/departments/getSubdpt/'+getvalue,function(response){
        var response = $.parseJSON(response);
        var content = '';
        $.each(response,function(key,val){
          content += '<option value="'+key+'">'+val+'</option>';
        });
        $('#subdepartments').html(content);
        
      });
    }
  });
		$('.selectall').on('click',function(){
      if($(this).is(':checked'))
      {
        $('.coursecheckbox').prop('checked','checked');
      }
      else
      {
        $('.coursecheckbox').removeAttr('checked','checked');
      }
    });
	});
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