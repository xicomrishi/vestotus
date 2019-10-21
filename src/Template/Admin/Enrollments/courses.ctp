<div id="main">
<div class="visible-md visible-xs visible-sm mobile-menu">
<button type="button" data-toggle="offcanvas"><i class="fa fa-bars"></i></button>
</div>

<section class="bgw clearfix course-detail-master">           	

<div class="page-title bgg">
<div class="container-fluid clearfix">
<div class="title-area pull-left">
<h2>Enrollments</h2>
</div><!-- /.pull-right -->
<div class="pull-right hidden-xs">
<div class="bread">
<ol class="breadcrumb">
<li><a href="<?= BASEURL?>users/dashboard">Home</a></li>
<li class="active">Enrollments</li>
</ol>
</div><!-- end bread -->
</div><!-- /.pull-right -->
</div>
</div><!-- end page-title -->

<section class="section bgw">
<div class="container-fluid">
<div class="row">			                    
<div id="post-content" class="col-md-12 col-sm-12 single-course">

<hr class="invis">

<div class="leaners-table clearfix">
<?= $this->Html->link('Enroll Users',['action'=>'enrollUsers'],['class'=>'btn btn-info btn-square']) ?>
<div class="big-title">
<h2 class="related-title">
<span>Course Enrollments</span>
</h2>

</div><!-- end big-title -->
<div class="filter">
<h3>  Filters </h3>

<?= $this->Form->create('filters',['type'=>'get']) ?>
<div class="col-md-7 date-picker">
<div class="input-group date" id="datetimepicker1">
<input type="text" class="form-control" placeholder="Start Date" name="start_date">
<span class="input-group-addon">
<span class="glyphicon glyphicon-calendar"></span>
</span>
</div>
<div class="input-group date" id="datetimepicker2">
<input type="text" class="form-control" placeholder="End Date" name="end_date">
<span class="input-group-addon">
<span class="glyphicon glyphicon-calendar"></span>
</span>
</div>
</div> 
<ul class="dropdown-menu show-right visible col-md-5">
<li>
<div id="custom-search-input">
<div class="input-group col-md-12">
<input type="text" class="form-control input-lg" placeholder="Search Title..." name="search_text">
<span class="input-group-btn">
<button class="btn btn-primary btn-lg" type="submit">
<i class="fa fa-search"></i>
</button>
</span>
</div>
</div>
</li>
</ul>
<?= $this->Form->end() ?>
</div>

<table class="table">
<thead>
<tr>
<th> <i class="fa fa-list-ul" aria-hidden="true"></i> </th>
<th>Course Name </th>
<th>Last Name </th>
<th>First Name </th>
<th>Username </th>
<th>Progress(%)</th>
<th>Enrolled Date</th>
<th>Is Enrolled</th>
<th> </th>
</tr>
</thead>
<tbody>
<?php if(count($list)>0) {
$i = 1; 
	foreach ($list as $list) {
		//pr($list);exit;
		$progress = $this->Common->getCourseProgress($list['course_id'],$list['user_id']);
?>
<tr>
<td>  </td>
<td>
<?= ucwords($list['course']['title']) ?></td>
<td>
<?= $list['user']['lname'] ?>
</td>
<td>
	<?= $list['user']['fname'] ?>
</td>
<td> 
<?= $list['user']['username'] ?>
</td><td>
<div class="skills text-left">
<div class="progress">
<div class="progress-bar" role="progressbar" data-transitiongoal="<?= $progress ?>" aria-valuenow="<?= $progress ?>" style="width:<?= $progress ?>%;"><span><?= $progress ?>%</span></div>
</div>
</div> 
</td>
<td>
<?= $list['created']->format('d M, Y'); ?>
</td>
<td>Yes</td>
<td> 

<?= $this->Html->link('<i class="fa fa-trash-o" aria-hidden="true"></i>',['action'=>'delenrollment',$this->Common->myencode($list['id'])],['class'=>'delete','confirm'=>'Do you really want to delete it?','escape'=>false]) ?>
  
</tr>
<?php } } else { ?>
	<tr> <td colspan="5"> No Records Found! </td></tr>
	<?php } ?>
</tbody>
</table>


<?= $this->element('paginator') ?>
</div><!-- end course-table -->			
</div><!-- end col -->
</div><!-- end row -->
</div><!-- end container -->
</section><!-- end section -->
</section><!-- end section -->









</div>
</div><!-- end main -->