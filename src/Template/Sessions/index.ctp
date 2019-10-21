<div id="main">
<div class="visible-md visible-xs visible-sm mobile-menu">
<button type="button" data-toggle="offcanvas"><i class="fa fa-bars"></i></button>
</div>
<section class="bgw clearfix course-detail-master">           	
<div class="page-title bgg">
<div class="container-fluid clearfix">
<div class="title-area pull-left">
<h2>Manage Sessions<small></small></h2>
</div><!-- /.pull-right -->
<div class="pull-right hidden-xs">
<div class="bread">
<ol class="breadcrumb">
<li><a href="<?= BASEURL?>users/dashboard">Home</a></li>
<li><a href="<?= BASEURL?>courses/">Courses</a></li>
<li class="active">Sessions</li>
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
<div class="big-title">
<h2 class="related-title">
<span>Manage Sessions</span>
</h2>
</div><!-- end big-title -->

<table class="table">
<thead>
<tr>
<th> <i class="fa fa-list-ul" aria-hidden="true"></i> </th>
<th>Course </th>
<th>Session </th>
<th>Instructor</th>
<th>Venue </th>
<th>Start Date</th>
<th>End Date</th>
</tr>
</thead>
<tbody>
<?php if(count(@$getClasses)>0) { 
	foreach ($getClasses as $list) {
		$rnd = rand(0,10);
?>
<tr>
<td><input class="checkbox checkselection" type="checkbox" name="checkuser" id="<?= $this->Common->myencode($list['course_id']) ?>/<?= $this->Common->myencode($list['session_id']) ?>" value="<?= $this->Common->myencode($list['id']) ?>"/> 
</td>
<td>
<a href="#"><?= ucfirst($list['course']['title']) ?></a>
</td>
<td> 
<a href="#"><?= ucfirst($list['session']['title']) ?></a>
</td>
<td>
<?= ucfirst($list['session']['instructor']['fullname']) ?>
</td>
<td> <?= $list['venue']['address'] ?></td>
<td><?= $list['start_date']->format('d M, Y') ?> <?= $list['start_time'] ?> </td>
<td><?= $list['end_date']->format('d M, Y') ?> <?= $list['end_time'] ?></td>
<td> 
<?php if($list['type']==1) { ?>
<?= $this->Html->link('<i class="fa fa-pencil-square-o" aria-hidden="true"></i>',['action'=>'onlineCourse',$list['id']],['class'=>'edit','escape'=>false]) ?> &nbsp;
<?php } else if($list['type']==2) { ?>
<?= $this->Html->link('<i class="fa fa-pencil-square-o" aria-hidden="true"></i>',['action'=>'instructorCourse',$list['id']],['class'=>'edit','escape'=>false]) ?> &nbsp;
<?php } ?>
<?= $this->Html->link('<i class="fa fa-trash-o" aria-hidden="true"></i>','#',['class'=>'delete','escape'=>false]) ?>
  
</tr>
<?php } } else { ?>
	<tr> <td colspan="6"> No Records Found! </td></tr>
	<?php } ?>
</tbody>
</table>
</div><!-- end course-table -->			
</div><!-- end col -->
</div><!-- end row -->
<div class="extrarow">
<div class="olarea">
<ul>
<li>
<?= $this->Html->link('Mark Attendence','',['class'=>'btn btn-primary','id'=>'mark_att']) ?>
</li>
<li>
<?= $this->Html->link('Manage Grades','',['class'=>'btn btn-warning','id'=>'grades']) ?>
</li>

</ul>
</div>

</div>

</div><!-- end container -->
</section><!-- end section -->
</section><!-- end section -->
</div>
</div><!-- end main -->
<?= $this->Html->script('common.js') ?>
<style type="text/css">
.container-fluid {max-width:1300px !important;margin-right:0px;}
.container-fluid .row { width : 88%;float: left }
.extrarow {float: left; width: 10%; padding-left: 33px;}
.extrarow ul li { list-style: none; padding:  10px 0; }
.extrarow .btn { width:145px;font-size: 13px; white-space : normal;}
.olarea,.insarea { display: none; }
</style>