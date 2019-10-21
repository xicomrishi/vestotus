<div id="main">
<div class="visible-md visible-xs visible-sm mobile-menu">
<button type="button" data-toggle="offcanvas"><i class="fa fa-bars"></i></button>
</div>

<section class="bgw clearfix course-detail-master">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
<div class="page-title bgg">
<div class="container-fluid clearfix">
<div class="title-area pull-left">
<h2>Users </h2>
</div>
<!-- /.pull-right -->
<div class="pull-right hidden-xs">
<div class="bread">
<ol class="breadcrumb">
<li><a href="<?= BASEURL?>users/dashboard">Home</a></li>
<li><a href="<?= BASEURL?>users/">Users</a></li>
<li class="active">update</li>
</ol>
</div>
<!-- end bread -->
</div>
<!-- /.pull-right -->
</div>
</div>
<!-- end page-title -->

<section class="section bgw">
<div class="container">
<div class="row">
<div class="col-md-12 col-sm-12">

<div class="tab-first">
<ul class="nav nav-tabs" role="tablist">
<li role="presentation" class="active"><a href="#tab1" role="tab" data-toggle="tab" aria-expanded="true"><i class="fa fa-info"></i> Info</a></li>
<li role="presentation"><a  href="#tab2"  role="tab" data-toggle="tab" aria-expanded="true"><i class="fa fa-lock"></i> Account </a></li>

</ul>
<?= $this->Form->create($newuser,['role'=>'form','id'=>'olcourse','novalidate'=>true]) ?>
<?php $this->Form->templates($form_templates['frontForm']); ?>
<div class="tab-content">
<div role="tabpanel" class="tab-pane active" id="tab1">
<div class="tab-padding clearfix">
<div class="loginform general-form">
<div class="form-group col-md-6">
<?= $this->Form->input('fname',['class'=>'form-control','label'=>'First Name']) ?>
</div>
<div class="form-group col-md-6">
<?= $this->Form->input('lname',['class'=>'form-control','label'=>'Last Name']) ?>
</div>

<div class="form-group col-md-6">
<?= $this->Form->input('email',['class'=>'form-control','label'=>'Email']) ?>
</div>

<div class="form-group col-md-6">
<?= $this->Form->input('username',['class'=>'form-control','label'=>'Username']) ?>
</div>
<div class="form-group col-md-4">
<?= $this->Form->input('country_id',['class'=>'form-control','label'=>'Country','options'=>$this->Common->getCountry(),'empty'=>'Select Country']) ?>
</div>
<div class="form-group col-md-4">

<?= $this->Form->input('state_id',['class'=>'form-control','label'=>'State','options'=>$this->Common->getStates($newuser['country_id']),'empty'=>'Select Country']) ?>
</div>
<div class="form-group col-md-4">
<?= $this->Form->input('city_id',['class'=>'form-control','options'=>$this->Common->getCities($newuser['state_id']),'label'=>'City']) ?>
</div>
<div class="form-group col-md-12">
<?= $this->Form->input('street',['class'=>'form-control','label'=>'Street']) ?>
</div>


<div class="form-group col-md-6">
<?= $this->Form->input('password',['class'=>'form-control','label'=>'Password','value'=>'','placeholder'=>'Leave blank if you do not want to change']) ?>
</div>

<div class="form-group col-md-6">
<?= $this->Form->input('confirm_password',['type'=>'password','class'=>'form-control','label'=>'Confirm Password']) ?>
</div>

<div class="form-group col-md-12">
<label>Is Active </label>
<input type="checkbox" name="status" checked='checked' id="active" class="switch" value="1">
<label for="active" class="checkbox-switch"> </label>

</div> 

</div>

</div>

</div>
<div role="tabpanel" class="tab-pane" id="tab2">

<div class="tab-padding clearfix">
<div class="top-sec form-group">

<div class="form-group">
<label>Learner/Driver </label>
<input type="checkbox" name="role"  id="learnerrole" <?php if($newuser['role'] == 4) { echo "checked='checked'"; } ?>class="switch" value="4">
<label for="learnerrole" class="checkbox-switch"> </label>
<div class="inner-section" id="learner_innersection" <?php if($newuser['role'] == 4) { echo "style='display:block'"; } else { echo "style=display:none;float:left;";}?>>
<div class="form-group">
<label>Department</label>
<?= $this->Form->input('department_id',['label'=>false,'class'=>'form-control','empty'=>false,'options'=>$deplist]) ?>
</div>

<div class="form-group">
<label>Driver Licence</label>
<?= $this->Form->input('driver_licence',['label'=>false,'class'=>'form-control','required'=>true]) ?>
</div>

<div class="form-group">
<label>Date of Hiring</label>
<?= $this->Form->input('date_of_hire',['readonly'=>true,'label'=>false,'class'=>'datepicker form-control','required'=>true]) ?>
</div>


<div class="form-group">

<div class="col-sm-6">
<label>Expiry Month</label>
<?php 
$m = [];
for($i = 1; $i < 13 ; $i++)
{
  if($i < 10)
  {
    $i = "0".$i;
  }
  $m[$i] = $i;
}

$y = [];
for($j = date('Y'); $j < date('Y') + 21 ; $j++)
{
  $y[$j] = $j;
}

?>
<?= $this->Form->input('expiry.0',['options'=>$m,'label'=>false,'empty'=>'Select Month','class'=>'form-control','required'=>true]) ?>
</div>
<div class="col-sm-6">
<label>Expiry Year</label>
<?= $this->Form->input('expiry.1',['options'=>$y,'label'=>false,'empty'=>'Select Year','class'=>'form-control','required'=>true]) ?>
</div>

</div>


</div>

<!--<div class="form-group inner-box">
<label>Variable Price Groups </label>
<input class="form-control" placeholder="The course has no variable price group" type="text">
<button class="button button--wayra" data-toggle="modal" data-target="#myModal">Add Variable Price Groups <i class="fa fa-plus" aria-hidden="true"></i> </button>
</div>-->
</div>
</div> 

<div class="form-group">
<label> Instructor </label>
<input type="checkbox" name="role" id="adminrole" <?php if($newuser['role'] == 3) { echo "checked='checked'"; } ?> class="switch" value="3">
<label for="adminrole" class="checkbox-switch"> </label>

</div> 


</div>


<?= $this->Form->button('Back',['type'=>'button','class'=>'btn btn-primary btn-square','onclick'=>'window.history.back(-1);']) ?>
&nbsp; 
<?= $this->Form->button('Save',['class'=>'btn btn-primary btn-square']) ?>

</div>

</div>
<?= $this->Form->end() ?>

</div>
</div>
</div>
</div>
<!-- end col -->
</div>
<!-- end row -->
</div>
<!-- end container -->
</section>
<!-- end section -->
</section>
<!-- end section -->

<?= $this->Html->script('isotope.js'); ?>
<?= $this->Html->script('imagesloaded.pkgd.js'); ?>
<?= $this->Html->script('masonry-home-01.js'); ?>
<?= $this->Html->script('../plugins/ckeditor/ckeditor.js'); ?>

<?= $this->Html->css('https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/css/bootstrap-datepicker.standalone.css') ?>
<script type="text/javascript">
(function($) {
  $('.datepicker').datepicker();
	 var $tabs=$('#chapterstbl')
    $( "tbody.connectedSortable" )
        .sortable({
            connectWith: ".connectedSortable",
            
            appendTo: $tabs,
            helper:"clone",
            zIndex: 999990
        })
        .disableSelection()
    ;
    
    var $tab_items = $( ".nav-tabs > li", $tabs ).droppable({
      accept: ".connectedSortable tr",
      hoverClass: "ui-state-hover",
      
      drop: function( event, ui ) {
      	 return false;
      }
    });
	
"use strict";
$('[data-toggle=offcanvas]').click(function() {
$('.row-offcanvas').toggleClass('active');
});

$('#learnerrole').on('click',function(){
    if($(this).is(':checked')==true)
    {
      $('#learner_innersection').fadeIn();
    }
    else
    {
       $('#learner_innersection').fadeOut();
    }
});
})(jQuery);

</script>
 <?= $this->Html->script('../admin/js/common.js') ?>